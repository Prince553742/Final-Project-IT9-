<x-app-layout>
    <div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8 bg-gray-100">
        <div class="max-w-7xl mx-auto">
            {{-- Header with user info --}}
            <div class="mb-6 relative">
                <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-blue-500 to-teal-500 rounded-full"></div>
                <div class="pl-4">
                    <div class="flex items-center gap-3">
                        <div class="h-12 w-12 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-lg">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div>
                            <h1 class="text-2xl font-semibold text-gray-800">{{ $user->name }}</h1>
                            <p class="text-sm text-gray-500">{{ $user->email }} • {{ $user->role }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Stats Cards --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3">
                    <p class="text-[10px] font-medium text-gray-500 uppercase">Total Assigned</p>
                    <p class="text-xl font-bold text-gray-800">{{ $tasks->count() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3">
                    <p class="text-[10px] font-medium text-gray-500 uppercase">Active Tasks</p>
                    <p class="text-xl font-bold text-amber-600">{{ $tasks->whereNotIn('status', ['Completed', 'Cancelled'])->count() }}</p>
                </div>
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-3">
                    <p class="text-[10px] font-medium text-gray-500 uppercase">Completed Tasks</p>
                    <p class="text-xl font-bold text-teal-600">{{ $tasks->where('status', 'Completed')->count() }}</p>
                </div>
            </div>

            {{-- Detailed Task List --}}
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-semibold text-gray-700">📋 Detailed Task List</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Project</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Task Title</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deadline</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            @forelse($tasks as $task)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-600">
                                    {{ $task->project->name ?? 'N/A' }}
                                </td>
                                <td class="px-4 py-3 text-sm font-medium text-gray-800">
                                    {{ $task->title }}
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'Pending' => 'bg-amber-100 text-amber-700',
                                            'In Progress' => 'bg-blue-100 text-blue-700',
                                            'On Hold' => 'bg-gray-100 text-gray-700',
                                            'Completed' => 'bg-teal-100 text-teal-700',
                                            'Cancelled' => 'bg-red-100 text-red-700',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $statusColors[$task->status] ?? 'bg-gray-100 text-gray-700' }}">
                                        {{ $task->status }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 whitespace-nowrap text-sm text-gray-500">
                                    {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="px-4 py-8 text-center text-gray-400">
                                    No tasks assigned to this team member.
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Back button --}}
            <div class="mt-6">
                <a href="{{ route('manager.team') }}" class="inline-flex items-center gap-1 text-sm font-medium text-indigo-600 hover:text-indigo-700 transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Team Roster
                </a>
            </div>
        </div>
    </div>
</x-app-layout>