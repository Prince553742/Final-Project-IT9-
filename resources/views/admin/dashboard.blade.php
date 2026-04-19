<x-app-layout>
    <div class="py-6 px-6 sm:px-8 lg:px-12 max-w-7xl mx-auto">

        {{-- Greeting --}}
        <div class="mb-6 relative">
            <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-blue-500 to-teal-500 rounded-full"></div>
            <div class="pl-4">
                <h1 class="text-2xl font-semibold text-gray-800">Good morning, {{ auth()->user()->name }}!</h1>
                <p class="text-sm text-gray-500">Here's your project and task overview.</p>
            </div>
        </div>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl shadow-sm p-5 border border-blue-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-blue-700 uppercase">Total Projects</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalProjects ?? 4 }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-lg bg-blue-200 flex items-center justify-center text-blue-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21H5a2 2 0 01-2-2V5a2 2 0 012-2h11l5 5v11a2 2 0 01-2 2z"></path></svg>
                    </div>
                </div>
                <div class="mt-2"><span class="text-xs text-blue-600">Active projects</span></div>
            </div>

            <div class="bg-gradient-to-br from-teal-50 to-teal-100 rounded-xl shadow-sm p-5 border border-teal-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-teal-700 uppercase">Total Tasks</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $totalTasks ?? 3 }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-lg bg-teal-200 flex items-center justify-center text-teal-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                    </div>
                </div>
                <div class="mt-2"><span class="text-xs text-teal-600">Across all projects</span></div>
            </div>

            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl shadow-sm p-5 border border-purple-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-purple-700 uppercase">Completed Tasks</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $completedTasks ?? 0 }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-lg bg-purple-200 flex items-center justify-center text-purple-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-2"><span class="text-xs text-purple-600">{{ $completionRate ?? 0 }}% completion rate</span></div>
            </div>

            <div class="bg-gradient-to-br from-amber-50 to-amber-100 rounded-xl shadow-sm p-5 border border-amber-200">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-medium text-amber-700 uppercase">Overdue Tasks</p>
                        <p class="text-3xl font-bold text-gray-800 mt-1">{{ $overdueTasks ?? 0 }}</p>
                    </div>
                    <div class="h-10 w-10 rounded-lg bg-amber-200 flex items-center justify-center text-amber-700">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                </div>
                <div class="mt-2"><span class="text-xs text-amber-600">Need attention</span></div>
            </div>
        </div>

        {{-- Two Columns --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-stretch">
            {{-- LEFT COLUMN --}}
            <div class="lg:col-span-2 space-y-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-4">👥 User Role Distribution</h3>
                    <div class="grid grid-cols-3 gap-4">
                        <div class="text-center p-3 bg-blue-50 rounded-lg">
                            <p class="text-2xl font-bold text-blue-600">{{ $totalAdmins ?? 1 }}</p>
                            <p class="text-xs text-gray-500">Admins</p>
                        </div>
                        <div class="text-center p-3 bg-teal-50 rounded-lg">
                            <p class="text-2xl font-bold text-teal-600">{{ $totalManagers ?? 1 }}</p>
                            <p class="text-xs text-gray-500">Managers</p>
                        </div>
                        <div class="text-center p-3 bg-purple-50 rounded-lg">
                            <p class="text-2xl font-bold text-purple-600">{{ $totalMembers ?? 1 }}</p>
                            <p class="text-xs text-gray-500">Team Members</p>
                        </div>
                    </div>
                </div>

                {{-- User Management Table (static rows with trash icon) --}}
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-700">📋 User Management</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Email</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Role</th>
                                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">member 1</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">princecarlcatayoc2006@gmail.com</td>
                                    <td class="px-6 py-4 text-sm">Team Member</td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">member 2</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">princeappleid2006@gmail.com</td>
                                    <td class="px-6 py-4 text-sm">Team Member</td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                                <tr class="hover:bg-gray-50">
                                    <td class="px-6 py-4 text-sm font-medium text-gray-900">manager mizpakipot</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">mizpakipotthack@gmail.com</td>
                                    <td class="px-6 py-4 text-sm">Manager</td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="text-gray-400 hover:text-red-500 transition-colors" title="Delete">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            {{-- RIGHT COLUMN --}}
            <div class="flex flex-col gap-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">📈 Overall Progress</h3>
                    <div class="flex justify-between text-sm text-gray-600 mb-1">
                        <span>{{ $overallProgress ?? 67 }}% Complete</span>
                        <span class="text-xs text-gray-400">System Efficiency</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2.5 mb-2">
                        <div class="bg-gradient-to-r from-indigo-500 to-teal-500 h-2.5 rounded-full" style="width: {{ $overallProgress ?? 67 }}%"></div>
                    </div>
                    <div class="flex justify-between text-xs">
                        <span class="text-gray-400">Target: 100%</span>
                        <span class="text-teal-600 font-medium">{{ $completionRate ?? 0 }}% tasks done</span>
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">📊 Task Status Summary</h3>
                    <div class="grid grid-cols-2 gap-3">
                        @php
                            $statuses = [
                                'Pending' => \App\Models\Task::where('status', 'Pending')->count(),
                                'In Progress' => \App\Models\Task::where('status', 'In Progress')->count(),
                                'On Hold' => \App\Models\Task::where('status', 'On Hold')->count(),
                                'Completed' => \App\Models\Task::where('status', 'Completed')->count(),
                                'Cancelled' => \App\Models\Task::where('status', 'Cancelled')->count(),
                            ];
                        @endphp
                        @foreach($statuses as $label => $count)
                            <div class="flex justify-between items-center p-2 rounded-lg 
                                {{ $label == 'Pending' ? 'bg-amber-50' : ($label == 'In Progress' ? 'bg-blue-50' : ($label == 'On Hold' ? 'bg-gray-50' : ($label == 'Completed' ? 'bg-teal-50' : 'bg-red-50'))) }}">
                                <span class="text-xs font-medium text-gray-600">{{ $label }}</span>
                                <span class="text-sm font-bold 
                                    {{ $label == 'Pending' ? 'text-amber-600' : ($label == 'In Progress' ? 'text-blue-600' : ($label == 'On Hold' ? 'text-gray-600' : ($label == 'Completed' ? 'text-teal-600' : 'text-red-600'))) }}">
                                    {{ $count }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-3">🏆 Top Projects by Tasks</h3>
                    <div class="space-y-3">
                        @forelse($topProjects ?? [] as $index => $proj)
                        <div class="flex items-center justify-between border-b border-gray-100 pb-2">
                            <div class="flex items-center gap-2">
                                <span class="w-6 h-6 rounded-full flex items-center justify-center text-xs font-bold text-white 
                                    {{ $index % 4 == 0 ? 'bg-blue-500' : ($index % 4 == 1 ? 'bg-teal-500' : ($index % 4 == 2 ? 'bg-purple-500' : 'bg-amber-500')) }}">
                                    {{ $index + 1 }}
                                </span>
                                <div>
                                    <p class="text-sm font-medium text-gray-800">{{ $proj->name }}</p>
                                    <p class="text-xs text-gray-400">{{ $proj->tasks_count }} tasks</p>
                                </div>
                            </div>
                            <span class="text-xs font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded-full">{{ $proj->tasks_count }}</span>
                        </div>
                        @empty
                        <p class="text-sm text-gray-400 text-center py-2">No projects yet</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>