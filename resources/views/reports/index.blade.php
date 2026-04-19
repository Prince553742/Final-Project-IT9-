<x-app-layout>
    <div class="min-h-screen bg-gray-50 py-8 px-6">

        {{-- PAGE WRAPPER --}}
        <div class="max-w-7xl mx-auto space-y-8">

            {{-- HEADER SECTION --}}
            <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">📊 System Reports</h1>
                    <p class="text-sm text-gray-500 mt-1">Performance metrics, analytics, and system overview</p>
                </div>

                <div class="flex gap-2">
                    <div class="text-xs px-3 py-2 bg-white border rounded-lg text-gray-500 shadow-sm">
                        Live Dashboard
                    </div>
                </div>
            </div>

            {{-- TOP STAT GRID --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-5">

                <div class="bg-white rounded-2xl shadow-sm border p-5 hover:shadow-md transition">
                    <p class="text-xs text-gray-500 uppercase">Total Tasks</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalTasks ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $completedTasks ?? 0 }} completed</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border p-5 hover:shadow-md transition">
                    <p class="text-xs text-gray-500 uppercase">Total Users</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalUsers ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-1">{{ $adminCount ?? 0 }} admins</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border p-5 hover:shadow-md transition">
                    <p class="text-xs text-red-500 uppercase">Overdue</p>
                    <p class="text-3xl font-bold text-red-500 mt-1">{{ $overdueTasks ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-1">Needs attention</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border p-5 hover:shadow-md transition">
                    <p class="text-xs text-teal-600 uppercase">Completion</p>
                    <p class="text-3xl font-bold text-teal-600 mt-1">{{ $completionRate ?? 0 }}%</p>
                    <p class="text-xs text-gray-400 mt-1">Overall progress</p>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border p-5 hover:shadow-md transition">
                    <p class="text-xs text-purple-600 uppercase">Activity</p>
                    <p class="text-3xl font-bold text-gray-800 mt-1">{{ $recentLogins ?? 0 }}</p>
                    <p class="text-xs text-gray-400 mt-1">Logs: {{ $totalLogs ?? 0 }}</p>
                </div>

            </div>

            {{-- MAIN GRID --}}
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                {{-- CHART LEFT (LARGE) --}}
                <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border p-6">

                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-sm font-semibold text-gray-700">Task Status Overview</h2>
                            <p class="text-xs text-gray-400">Distribution of tasks across statuses</p>
                        </div>
                    </div>

                    <div class="h-64">
                        <canvas id="taskStatusChart"></canvas>
                    </div>
                </div>

                {{-- INSIGHTS RIGHT --}}
                <div class="flex flex-col gap-5">

                    <div class="bg-white rounded-2xl border shadow-sm p-5">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">Quick Insight</h3>
                        <p class="text-sm text-gray-700">
                            {{ $overdueTasks ?? 0 }} tasks are overdue. Prioritize these items to improve workflow efficiency.
                        </p>
                    </div>

                    <div class="bg-white rounded-2xl border shadow-sm p-5">
                        <h3 class="text-xs font-semibold text-gray-500 uppercase mb-2">System Health</h3>
                        <p class="text-sm text-gray-700">
                            Completion rate is currently 
                            <span class="font-semibold text-teal-600">{{ $completionRate ?? 0 }}%</span>.
                        </p>
                    </div>

                    <div class="bg-gradient-to-br from-indigo-500 to-purple-600 text-white rounded-2xl p-5 shadow-md">
                        <h3 class="text-xs uppercase opacity-80">Tip</h3>
                        <p class="text-sm mt-2">
                            Monitor overdue tasks daily to maintain optimal performance.
                        </p>
                    </div>

                </div>

            </div>

            {{-- BOTTOM CHART --}}
            @if(isset($projectNames) && $projectNames->count() > 0)
            <div class="bg-white rounded-2xl shadow-sm border p-6">
                <div class="mb-4">
                    <h2 class="text-sm font-semibold text-gray-700">Top Projects by Task Count</h2>
                    <p class="text-xs text-gray-400">Project workload comparison</p>
                </div>

                <div class="h-56">
                    <canvas id="projectTasksChart"></canvas>
                </div>
            </div>
            @endif

        </div>
    </div>

    {{-- CHART JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const taskCtx = document.getElementById('taskStatusChart').getContext('2d');
            new Chart(taskCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode(array_keys($taskStatuses ?? [])) !!},
                    datasets: [{
                        data: {!! json_encode(array_values($taskStatuses ?? [])) !!},
                        backgroundColor: '#6366f1',
                        borderRadius: 10,
                        barPercentage: 0.6,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });

            @if(isset($projectNames) && $projectNames->count() > 0)
            const projectCtx = document.getElementById('projectTasksChart').getContext('2d');
            new Chart(projectCtx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($projectNames) !!},
                    datasets: [{
                        data: {!! json_encode($projectTaskCounts) !!},
                        backgroundColor: '#10b981',
                        borderRadius: 10,
                    }]
                },
                options: {
                    indexAxis: 'y',
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: { legend: { display: false } }
                }
            });
            @endif

        });
    </script>
</x-app-layout>
