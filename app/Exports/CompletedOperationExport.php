<?php

namespace App\Exports;

use App\Models\CatchingRecord;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class CompletedOperationExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected ?string $projectId;

    protected ?string $hospitalId;

    protected int $serialNumber = 0;

    public function __construct($projectId, $hospitalId)
    {
        $this->projectId = $projectId ?: null;
        $this->hospitalId = $hospitalId ?: null;
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
                'catching_records.hospital_id',
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
            ->whereIn('catching_records.status', ['Released', 'Returned to Owner', 'Expired']);

        if ($this->projectId) {
            $query->where('catching_records.project_id', $this->projectId);
        }

        if ($this->hospitalId) {
            $query->where('catching_records.hospital_id', $this->hospitalId);
        }

        return $query->orderByDesc('catching_records.catch_date')->orderByDesc('catching_records.id');
    }

    public function headings(): array
    {
        return ['S.No', 'Project Name', 'Hospital Name', 'Tag No', 'Dog Type', 'Gender', 'Status', 'Catch Date', 'Surgery Date', 'Doctor Name', 'Remarks'];
    }

    public function map($row): array
    {
        $this->serialNumber++;

        return [
            $this->serialNumber,
            $row->project_name ?? '-',
            $row->hospital_name ?? '-',
            $row->tag_no ?? '-',
            $row->dog_type ? ucfirst($row->dog_type) : '-',
            $row->gender ? ucfirst($row->gender) : '-',
            $row->status ?? '-',
            $row->catch_date ? Carbon::parse($row->catch_date)->format('d M Y') : '-',
            $row->operation_date ? Carbon::parse($row->operation_date)->format('d M Y') : '-',
            $row->doctor_name ?? '-',
            $row->remarks ?? '-',
        ];
    }
}
