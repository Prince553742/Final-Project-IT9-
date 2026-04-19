<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        {{-- Greeting --}}
        <div class="mb-6 relative">
            <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-blue-500 to-teal-500 rounded-full"></div>
            <div class="pl-4">
                <h1 class="text-2xl font-semibold text-gray-800">Welcome back, {{ auth()->user()->name }}!</h1>
                <p class="text-sm text-gray-500">Here is an overview of your current workload and upcoming deadlines.</p>
            </div>
        </div>

        {{-- Compact Stats Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3">
                <p class="text-[10px] font-medium text-gray-500 uppercase">Active Tasks</p>
                <p class="text-xl font-bold text-indigo-600">{{ $stats['active'] ?? 0 }}</p>
                <div class="text-[10px] text-gray-400">Pending / In Progress</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3">
                <p class="text-[10px] font-medium text-gray-500 uppercase">Completed To Date</p>
                <p class="text-xl font-bold text-teal-600">{{ $stats['completed'] ?? 0 }}</p>
                <div class="text-[10px] text-gray-400">Total done</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3">
                <p class="text-[10px] font-medium text-gray-500 uppercase">Urgent Tasks</p>
                <p class="text-xl font-bold text-amber-600">{{ $stats['urgent'] ?? 0 }}</p>
                <div class="text-[10px] text-gray-400">Due within 3 days</div>
            </div>
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3">
                <p class="text-[10px] font-medium text-gray-500 uppercase">Task Completion</p>
                <p class="text-xl font-bold text-gray-800">{{ $stats['completed'] ?? 0 }}/{{ ($stats['active'] ?? 0) + ($stats['completed'] ?? 0) }}</p>
                <div class="text-[10px] text-gray-400">Overall progress</div>
            </div>
        </div>

        {{-- Upcoming Deadlines (Urgent Tasks) --}}
        <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                <h3 class="text-sm font-semibold text-gray-700">⏰ Your Most Urgent Deadlines</h3>
            </div>
            <div class="divide-y divide-gray-100">
                @forelse($upcomingTasks ?? [] as $task)
                <a href="{{ route('tasks.show', $task->id) }}" class="block p-4 hover:bg-gray-50 transition-colors group">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <div class="flex items-center gap-3">
                            <div class="h-10 w-10 rounded-lg bg-amber-100 flex items-center justify-center text-amber-700">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-900 group-hover:text-indigo-600 transition">{{ $task->title }}</p>
                                <p class="text-xs text-gray-500">{{ $task->project->name ?? 'No Project' }}</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-4 pl-12 sm:pl-0">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Due {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                            </span>
                        </div>
                    </div>
                </a>
                @empty
                <div class="p-8 text-center text-gray-400">
                    No urgent deadlines. You're all caught up!
                </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>