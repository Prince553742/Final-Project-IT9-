<!DOCTYPE html>
<html>
<head>
    <title>New Task Assigned</title>
</head>
<body>
    <h2>Hello {{ $task->assignedUser->name }},</h2>
    <p>A new task has been assigned to you:</p>
    <ul>
        <li><strong>Task:</strong> {{ $task->title }}</li>
        <li><strong>Project:</strong> {{ $task->project->name ?? 'N/A' }}</li>
        <li><strong>Due Date:</strong> {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</li>
        <li><strong>Priority:</strong> {{ $task->priority }}</li>
    </ul>
    <p>Please log in to the system to view more details.</p>
    <p>Thank you.</p>
</body>
</html>