<?php

namespace App\Exports;

use App\Models\CatchingRecord;
use Illuminate\Database\Eloquent\Builder;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjectSummaryExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize
{
    protected int $serialNumber = 0;

    public function query(): Builder
    {
        return CatchingRecord::query()
            ->leftJoin('projects', 'projects.id', '=', 'catching_records.project_id')
            ->leftJoin('dog_operations', 'dog_operations.catching_record_id', '=', 'catching_records.id')
            ->selectRaw(
                'catching_records.project_id,
                COALESCE(projects.name, "Unassigned") as project_name,
                COUNT(DISTINCT catching_records.id) as total_caught,
                COUNT(DISTINCT dog_operations.id) as operated_count,
                SUM(CASE WHEN catching_records.status IN ("Released", "Returned to Owner") THEN 1 ELSE 0 END) as released_count,
                SUM(CASE WHEN catching_records.status = "Expired" THEN 1 ELSE 0 END) as expired_count'
            )
            ->groupBy('catching_records.project_id', 'projects.name')
            ->orderBy('project_name');
    }

    public function headings(): array
    {
        return ['S.No', 'Project Name', 'Total Caught', 'Operated', 'Released', 'Expired'];
    }

    public function map($row): array
    {
        $this->serialNumber++;

        return [
            $this->serialNumber,
            $row->project_name ?? '-',
            (int) ($row->total_caught ?? 0),
            (int) ($row->operated_count ?? 0),
            (int) ($row->released_count ?? 0),
            (int) ($row->expired_count ?? 0),
        ];
    }
}
