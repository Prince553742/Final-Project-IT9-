<!DOCTYPE html>
<html>
<head>
    <title>Task Status Changed</title>
</head>
<body>
    <h2>Hello,</h2>
    <p>The status of task <strong>{{ $task->title }}</strong> has been changed from <strong>{{ $oldStatus }}</strong> to <strong>{{ $newStatus }}</strong>.</p>
    <p>Project: {{ $task->project->name ?? 'N/A' }}</p>
    <p>Assigned to: {{ $task->assignedUser->name ?? 'Unassigned' }}</p>
    <p>Log in to the system for more information.</p>
</body>
</html>