<?php

namespace App\Exports;

use App\Models\CatchingRecord;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;
use Carbon\Carbon;

class DailyRunningSheetExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    use Exportable;

    protected ?string $projectId;

    protected ?string $runningDate;

    protected int $serialNumber = 0;

    public function __construct($projectId, $runningDate)
    {
        $this->projectId = $projectId ?: null;
        $this->runningDate = $runningDate ?: null;
    }

    public function query(): Builder
    {
        $query = CatchingRecord::query()
            ->leftJoin('projects', 'projects.id', '=', 'catching_records.project_id')
            ->leftJoin('hospitals', 'hospitals.id', '=', 'catching_records.hospital_id')
            ->leftJoin('dog_operations', 'dog_operations.catching_record_id', '=', 'catching_records.id')
            ->leftJoin('doctors', 'doctors.id', '=', 'dog_operations.doctor_id')
            ->select([
                'catching_records.id',
                'catching_records.project_id',
                'catching_records.tag_no',
                'catching_records.dog_type',
                'catching_records.gender',
                'catching_records.catch_date',
                'catching_records.status',
                'projects.name as project_name',
                'hospitals.name as hospital_name',
                'dog_operations.operation_date',
                'dog_operations.remarks',
                'doctors.name as doctor_name',
            ])
            ->where(function ($builder) {
                $builder->whereIn('catching_records.status', ['Observation', 'Released'])
                    ->orWhereNotNull('dog_operations.id');
            });

        if ($this->projectId) {
            $query->where('catching_records.project_id', $this->projectId);
        }

        if ($this->runningDate) {
            $query->where(function ($dateBuilder) {
                $dateBuilder->whereDate('catching_records.catch_date', $this->runningDate)
                    ->orWhereDate('dog_operations.operation_date', $this->runningDate);
            });
        }

        return $query->orderByDesc('catching_records.catch_date')->orderByDesc('catching_records.id');
    }

    public function headings(): array
    {
        return ['S.No', 'Project Name', 'Tag No', 'Dog Type', 'Gender', 'Hospital Name', 'Catch Date', 'Surgery Date', 'Doctor Name', 'Remarks'];
    }

    public function map($row): array
    {
        $this->serialNumber++;

        return [
            $this->serialNumber,
            $row->project_name ?? '-',
            $row->tag_no ?? '-',
            $row->dog_type ? ucfirst($row->dog_type) : '-',
            $row->gender ? ucfirst($row->gender) : '-',
            $row->hospital_name ?? '-',
            $row->catch_date ? Carbon::parse($row->catch_date)->format('d M Y') : '-',
            $row->operation_date ? Carbon::parse($row->operation_date)->format('d M Y') : '-',
            $row->doctor_name ?? '-',
            $row->remarks ?? '-',
        ];
    }
}