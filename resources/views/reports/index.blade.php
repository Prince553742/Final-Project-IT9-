<x-app-layout>
    <div class="min-h-screen bg-gray-100 py-8 px-6">

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

                    {{-- Header --}}
                    <div class="flex justify-between items-center mb-4">
                        <div>
                            <h2 class="text-sm font-semibold text-gray-700">Task Status Overview</h2>
                            <p class="text-xs text-gray-400">Distribution of tasks across statuses</p>
                        </div>

                        <div class="flex gap-2">
                            <a href="{{ route('admin.export.task-status.excel') }}"
                            class="inline-flex items-center gap-1 text-xs font-medium bg-green-50 text-green-700 px-3 py-1.5 rounded-lg hover:bg-green-100">
                                Excel
                            </a>

                            <a href="{{ route('admin.export.task-status.pdf') }}"
                            class="inline-flex items-center gap-1 text-xs font-medium bg-red-50 text-red-700 px-3 py-1.5 rounded-lg hover:bg-red-100">
                                PDF
                            </a>
                        </div>
                    </div>

                    {{-- Perfectly centered content --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-8 items-center min-h-[420px] pt-6">

                        {{-- Chart --}}
                        <div class="flex items-center justify-center h-full">
                            <div class="relative w-[260px] h-[260px]">
                                <canvas id="taskStatusChart"></canvas>
                            </div>
                        </div>

                        {{-- Legend --}}
                        <div class="flex flex-col justify-center gap-5 h-full pr-4" id="taskStatusLegend"></div>

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
        document.addEventListener('DOMContentLoaded', function () {

            // ── Pie / Doughnut chart ──────────────────────────────────────
            const labels = {!! json_encode(array_keys($taskStatuses ?? [])) !!};
            const values = {!! json_encode(array_values($taskStatuses ?? [])) !!};

            const palette = ['#f59e0b', '#6366f1', '#94a3b8', '#10b981', '#ef4444'];

            const taskCtx = document.getElementById('taskStatusChart').getContext('2d');

            new Chart(taskCtx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: palette,
                        borderColor: '#fff',
                        borderWidth: 2,
                        hoverOffset: 6
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,

                    layout: {
                        padding: 0
                    },

                    cutout: '62%',
                    radius: '96%',

                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: ctx => `${ctx.label}: ${ctx.parsed} tasks`
                            }
                        }
                    }
                }
            });

            // Build custom legend
            const legendEl = document.getElementById('taskStatusLegend');
            labels.forEach((label, i) => {
                const total = values.reduce((a, b) => a + b, 0);
                const pct = total > 0 ? Math.round((values[i] / total) * 100) : 0;
                legendEl.innerHTML += `
                    <div class="flex items-center gap-2">
                        <span class="inline-block w-3 h-3 rounded-full shrink-0" style="background:${palette[i]}"></span>
                        <span class="text-gray-600">${label}</span>
                        <span class="ml-auto font-semibold text-gray-800">${values[i]}</span>
                        <span class="text-gray-400 text-xs">(${pct}%)</span>
                    </div>`;
            });

            // ── Project bar chart ─────────────────────────────────────────
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