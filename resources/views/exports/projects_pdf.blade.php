<!DOCTYPE html>
<html>
<head>
    <title>Projects Export</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Projects List</h2>
    <table>
        <thead>
            <tr><th>ID</th><th>Name</th><th>Description</th><th>Manager</th><th>Tasks Count</th><th>Due Date</th></tr>
        </thead>
        <tbody>
            @foreach($projects as $project)
            <tr>
                <td>{{ $project->id }}</td>
                <td>{{ $project->name }}</td>
                <td>{{ $project->description }}</td>
                <td>{{ $project->manager->name ?? 'N/A' }}</td>
                <td>{{ $project->tasks_count }}</td>
                <td>{{ $project->due_date }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>