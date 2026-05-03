<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TaskStatusSummaryExport implements FromArray, WithHeadings
{
    public function array(): array
    {
        return [
            ['Pending', \App\Models\Task::where('status', 'Pending')->count()],
            ['In Progress', \App\Models\Task::where('status', 'In Progress')->count()],
            ['On Hold', \App\Models\Task::where('status', 'On Hold')->count()],
            ['Completed', \App\Models\Task::where('status', 'Completed')->count()],
            ['Cancelled', \App\Models\Task::where('status', 'Cancelled')->count()],
        ];
    }

    public function headings(): array
    {
        return ['Task Status', 'Number of Tasks'];
    }
}