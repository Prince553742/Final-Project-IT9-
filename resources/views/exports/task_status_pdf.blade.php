<!DOCTYPE html>
<html>
<head>
    <title>Task Status Summary</title>
    <style>
        body { font-family: sans-serif; }
        table { width: 50%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2>Task Status Summary</h2>
    <table>
        <thead><tr><th>Status</th><th>Number of Tasks</th></tr></thead>
        <tbody>
            @foreach($statuses as $status => $count)
            <tr><td>{{ $status }}</td><td>{{ $count }}</td></tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>