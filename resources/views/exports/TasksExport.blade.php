<?php

namespace App\Exports;

use App\Models\Task;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class TasksExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Task::with('project', 'assignedUser')->get();
    }

    public function headings(): array
    {
        return ['ID', 'Title', 'Description', 'Project', 'Assigned To', 'Status', 'Priority', 'Due Date', 'Created At'];
    }

    public function map($task): array
    {
        return [
            $task->id,
            $task->title,
            $task->description,
            $task->project->name ?? 'N/A',
            $task->assignedUser->name ?? 'Unassigned',
            $task->status,
            $task->priority,
            $task->due_date,
            $task->created_at,
        ];
    }
}