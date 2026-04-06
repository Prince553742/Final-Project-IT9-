<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Back Navigation --}}
            <div class="mb-8">
                <a href="{{ route('manager.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-green-600 hover:text-green-700 transition-colors group">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 8.959 8.959 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3"></path>
                    </svg>
                    Back to Manager Dashboard
                </a>
            </div>

            {{-- SUCCESS ALERT MESSAGE --}}
            @if (session('success'))
                <div class="mb-8 p-4 bg-green-50 border border-green-200 rounded-xl shadow-sm flex items-center animate-fade-in-down">
                    <svg class="w-5 h-5 mr-3 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span class="text-sm font-bold text-green-700 tracking-wide">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                {{-- Project Header Section --}}
                <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-white to-gray-50">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                        <div>
                            <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">{{ $project->name }}</h2>
                            <p class="mt-2 text-gray-500 max-w-2xl leading-relaxed">{{ $project->description }}</p>
                        </div>
                        <div class="flex items-center space-x-3">
                            <span class="bg-green-100 text-green-700 text-xs font-bold px-4 py-2 rounded-lg uppercase tracking-wider">
                                {{ $project->tasks->where('status', 'Completed')->count() }} / {{ $project->tasks->count() }} Tasks Completed
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Tasks Section --}}
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h3 class="text-xl font-bold text-gray-800 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            Task Assignments
                        </h3>
                        <a href="{{ route('manager.tasks.create', $project->id) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-bold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 transition-all shadow-sm">
                            + Add New Task
                        </a>
                    </div>

                    @if($project->tasks->isEmpty())
                        <div class="text-center py-16 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                            <p class="text-gray-400 font-medium">No tasks found for this project.</p>
                        </div>
                    @else
                        <div class="overflow-hidden rounded-lg border border-gray-100">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 border-b border-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Task Details</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Team Member</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-center">Status</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest">Deadline</th>
                                        <th class="px-6 py-4 text-xs font-bold text-gray-400 uppercase tracking-widest text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-50">
                                    @foreach($project->tasks as $task)
                                        <tr class="hover:bg-gray-50/50 transition-colors">
                                            <td class="px-6 py-5">
                                                <a href="{{ route('tasks.show', $task->id) }}" class="block font-bold text-blue-600 hover:underline">
                                                    {{ $task->title }}
                                                </a>
                                            </td>
                                            <td class="px-6 py-5">
                                                <div class="flex items-center">
                                                    <div class="h-9 w-9 rounded-full bg-green-100 flex items-center justify-center text-green-700 font-bold text-sm shadow-sm">
                                                        {{ substr($task->assignedUser->name ?? 'U', 0, 1) }}
                                                    </div>
                                                    <span class="ml-3 font-semibold text-gray-700">{{ $task->assignedUser->name ?? 'Unassigned' }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 text-center">
                                                <span class="px-3 py-1.5 rounded-full text-[10px] font-black uppercase tracking-tighter inline-block
                                                    {{ strtolower($task->status) == 'completed' ? 'bg-green-100 text-green-700 border border-green-200' : 'bg-yellow-100 text-yellow-700 border border-yellow-200' }}">
                                                    {{ $task->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5">
                                                <div class="flex items-center text-sm font-medium text-gray-500">
                                                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'N/A' }}
                                                </div>
                                            </td>
                                            <td class="px-6 py-5 text-right">
                                                <div class="flex justify-end space-x-2">
                                                    
                                                    <a href="{{ route('tasks.edit', $task->id) }}" class="inline-flex items-center p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-100 transition-colors" title="Edit Task">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                                    </a>

                                                    <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this task?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="inline-flex items-center p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-100 transition-colors" title="Delete Task">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>