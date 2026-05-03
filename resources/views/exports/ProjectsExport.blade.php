<?php

namespace App\Exports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ProjectsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Project::with('manager')->withCount('tasks')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Name', 'Description', 'Manager', 'Tasks Count', 'Due Date', 'Created At'];
    }

    public function map($project): array
    {
        return [
            $project->id,
            $project->name,
            $project->description,
            $project->manager->name ?? 'N/A',
            $project->tasks_count,
            $project->due_date,
            $project->created_at,
        ];
    }
}