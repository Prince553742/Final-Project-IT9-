<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            <div class="px-4 sm:px-0">
                <h3 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 tracking-tight mb-2">
                    {{ $pageTitle }}
                </h3>
                <p class="text-gray-500 text-sm font-medium">Keep track of your responsibilities and updates.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                <div class="p-6 sm:p-10 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider w-1/4">Project</th>
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider w-2/4">Task Details</th>
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider w-1/6">Deadline</th>
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider text-right">Status Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            @forelse($tasks as $task)
                            <tr class="hover:bg-indigo-50/30 transition-colors group">
                                <td class="py-5 px-4 align-middle">
                                    <span class="inline-flex items-center px-3 py-1 rounded-lg text-xs font-bold bg-gray-50 text-gray-600 border border-gray-200/60 shadow-sm whitespace-nowrap group-hover:bg-indigo-50 group-hover:text-indigo-600 group-hover:border-indigo-100 transition-colors">
                                        {{-- FIXED: Changed 'title' to 'name' --}}
                                        {{ $task->project->name }}
                                    </span>
                                </td>
                                <td class="py-5 px-4 align-middle">
                                    <a href="{{ route('tasks.show', $task->id) }}" class="text-base font-extrabold text-gray-900 group-hover:text-indigo-600 transition-colors line-clamp-2">
                                        {{ $task->title }}
                                    </a>
                                </td>
                                <td class="py-5 px-4 align-middle whitespace-nowrap">
                                    <span class="text-sm font-bold {{ \Carbon\Carbon::parse($task->due_date)->isPast() ? 'text-red-600' : 'text-gray-600' }}">
                                        {{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}
                                    </span>
                                </td>
                                <td class="py-5 px-4 text-right align-middle">
                                    <form action="{{ route('tasks.update-status', $task->id) }}" method="POST" class="inline-block">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" onchange="this.form.submit()" class="text-xs font-bold border-gray-200 rounded-xl focus:ring-indigo-500 focus:border-indigo-500">
                                            <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
                                            <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>🏃 In Progress</option>
                                            <option value="On Hold" {{ $task->status == 'On Hold' ? 'selected' : '' }}>⏸️ On Hold</option>
                                            <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>✅ Completed</option>
                                            <option value="Cancelled" {{ $task->status == 'Cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-16 text-center text-gray-500 italic">No tasks found in this section.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>