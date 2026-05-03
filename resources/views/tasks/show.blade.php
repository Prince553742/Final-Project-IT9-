<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto bg-gray-100">
        {{-- Back Navigation (fixed) --}}
        <div class="mb-4">
            <a href="{{ route('projects.show', $task->project_id) }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-indigo-600 transition-colors group">
                <svg class="w-4 h-4 mr-1 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 8.959 8.959 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3"></path>
                </svg>
                Back to Project
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column: Task Details (spans 2) --}}
            <div class="lg:col-span-2 space-y-8">
                {{-- Task Title & Status --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-3">
                        <div>
                            <h1 class="text-xl font-semibold text-gray-800">{{ $task->title }}</h1>
                            <p class="text-sm text-gray-500 mt-1">Project: {{ $task->project->name ?? 'N/A' }}</p>
                        </div>
                        <div>
                            <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PUT')
                                <select name="status" onchange="this.form.submit()" class="text-sm border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                                    <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="On Hold" {{ $task->status == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ $task->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </form>
                        </div>
                    </div>
                </div>

                {{-- Task Description --}}
                @if($task->description)
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-5">
                    <h3 class="text-sm font-semibold text-gray-700 mb-2">📄 Description</h3>
                    <p class="text-sm text-gray-600">{{ $task->description }}</p>
                </div>
                @endif

                {{-- Comments Section (Chat style) --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-5 py-3 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-700">💬 Discussion</h3>
                    </div>
                    <div class="p-5 space-y-4 max-h-96 overflow-y-auto">
                        @forelse($task->comments as $comment)
                            @php $isMine = $comment->user_id === Auth::id(); @endphp
                            <div class="flex {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                <div class="flex gap-2 max-w-[75%] {{ $isMine ? 'flex-row-reverse' : '' }}">
                                    {{-- Avatar --}}
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-xs shrink-0">
                                        {{ strtoupper(substr($comment->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    {{-- Bubble --}}
                                    <div class="flex flex-col">
                                        <div class="flex items-baseline gap-2 {{ $isMine ? 'justify-end' : 'justify-start' }}">
                                            <span class="text-xs font-medium text-gray-900">{{ $comment->user->name ?? 'Unknown' }}</span>
                                            <span class="text-xs text-gray-400">{{ $comment->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="mt-1 px-4 py-2 rounded-2xl {{ $isMine ? 'bg-indigo-600 text-white rounded-br-none' : 'bg-gray-100 text-gray-800 rounded-bl-none' }}">
                                            {{ $comment->comment }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @empty
                        <div class="text-center py-6 text-gray-400">
                            No comments yet. Start the discussion!
                        </div>
                        @endforelse
                    </div>
                    <div class="p-4 border-t border-gray-100 bg-gray-50">
                        <form action="{{ route('tasks.comments.store', $task->id) }}" method="POST" class="flex gap-3">
                            @csrf
                            <input type="text" name="comment" placeholder="Type your comment here..." required
                                class="flex-1 rounded-lg border-gray-300 focus:ring-indigo-500 focus:border-indigo-500 text-sm">
                            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-lg hover:bg-indigo-700 transition">
                                Send
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right Column: Metadata Cards --}}
            <div class="flex flex-col gap-8">
                {{-- Status Card --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h3 class="text-sm font-medium text-gray-700">Status</h3>
                    </div>
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
                </div>

                {{-- Priority Card --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"></path></svg>
                        <h3 class="text-sm font-medium text-gray-700">Priority</h3>
                    </div>
                    @php
                        $priorityColors = [
                            'Low' => 'bg-gray-100 text-gray-700',
                            'Medium' => 'bg-blue-100 text-blue-700',
                            'High' => 'bg-orange-100 text-orange-700',
                            'Urgent' => 'bg-red-100 text-red-700',
                        ];
                    @endphp
                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium {{ $priorityColors[$task->priority] ?? 'bg-gray-100 text-gray-700' }}">
                        {{ $task->priority }}
                    </span>
                </div>

                {{-- Due Date Card --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <h3 class="text-sm font-medium text-gray-700">Due Date</h3>
                    </div>
                    <p class="text-sm text-gray-800">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</p>
                </div>

                {{-- Assigned To Card --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4">
                    <div class="flex items-center gap-2 mb-3">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        <h3 class="text-sm font-medium text-gray-700">Assigned To</h3>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="h-6 w-6 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 text-xs font-bold">
                            {{ substr($task->assignedUser->name ?? 'U', 0, 1) }}
                        </div>
                        <span class="text-sm text-gray-800">{{ $task->assignedUser->name ?? 'Unassigned' }}</span>
                    </div>
                </div>

                {{-- File Attachments Card --}}
                <div class="bg-white rounded-lg shadow-sm border border-gray-100 overflow-hidden">
                    <div class="px-4 py-3 border-b border-gray-100 bg-gray-50">
                        <h3 class="text-sm font-semibold text-gray-700">📎 Attachments</h3>
                    </div>
                    <div class="p-4 space-y-3">
                        @forelse($task->attachments as $attachment)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path></svg>
                                <a href="{{ route('tasks.attachments.download', ['task' => $task, 'attachment' => $attachment]) }}" class="text-sm text-indigo-600 hover:underline">{{ $attachment->original_name }}</a>
                                <span class="text-xs text-gray-400">({{ round($attachment->size / 1024) }} KB)</span>
                            </div>
                            <form action="{{ route('tasks.attachments.destroy', ['task' => $task, 'attachment' => $attachment]) }}" method="POST" onsubmit="return confirm('Delete this file?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-gray-400 hover:text-red-600 transition">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </button>
                            </form>
                        </div>
                        @empty
                        <p class="text-sm text-gray-400 text-center">No attachments yet.</p>
                        @endforelse

                        <form action="{{ route('tasks.attachments.store', $task) }}" method="POST" enctype="multipart/form-data" class="mt-3">
                            @csrf
                            <div class="flex gap-2 items-center">
                                <input type="file" name="attachment" required
                                    class="flex-1 text-sm text-gray-500 file:mr-2 file:py-1 file:px-2 file:rounded file:border-0 file:text-sm file:bg-gray-100 file:text-gray-700 hover:file:bg-gray-200">
                                <button type="submit" class="px-3 py-1.5 bg-indigo-600 text-white text-sm rounded-lg hover:bg-indigo-700 transition">
                                    Upload
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>