<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row gap-6">
            
            <div class="w-full md:w-1/3">
                <div class="bg-white p-6 rounded-xl shadow-sm border border-gray-200 sticky top-6">
                    <div class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-1">{{ $task->project->title ?? 'Project' }}</div>
                    <h2 class="text-2xl font-black text-gray-900 mb-4">{{ $task->title }}</h2>
                    
                    <div class="space-y-4 text-sm">
                        <div class="flex flex-col border-b pb-4">
                            <span class="text-gray-500 mb-2">Update Status:</span>
                            {{-- STATUS DROPDOWN IN SIDEBAR --}}
                            <form action="{{ route('tasks.update-status', $task->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" onchange="this.form.submit()" class="w-full font-bold border-gray-200 rounded-lg {{ $task->isCompleted() ? 'bg-gray-100' : '' }}" {{ $task->isCompleted() ? 'disabled' : '' }}>
                                    <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>⏳ Pending</option>
                                    <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>🏃 In Progress</option>
                                    <option value="On Hold" {{ $task->status == 'On Hold' ? 'selected' : '' }}>⏸️ On Hold</option>
                                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>✅ Completed</option>
                                    <option value="Cancelled" {{ $task->status == 'Cancelled' ? 'selected' : '' }}>❌ Cancelled</option>
                                </select>
                            </form>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Deadline:</span>
                            <span class="font-bold text-gray-900">{{ \Carbon\Carbon::parse($task->due_date)->format('M d, Y') }}</span>
                        </div>
                        <div class="flex justify-between border-b pb-2">
                            <span class="text-gray-500">Assigned To:</span>
                            <span class="font-bold text-gray-900">{{ $task->assignedUser->name ?? 'Unknown' }}</span>
                        </div>
                    </div>
                    
                    <a href="{{ url()->previous() }}" class="mt-6 block text-center w-full bg-gray-100 text-gray-700 font-bold py-2 rounded-lg hover:bg-gray-200 transition">
                        &larr; Go Back
                    </a>
                </div>
            </div>

            {{-- Discussion Section remains the same --}}
            <div class="w-full md:w-2/3 bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden flex flex-col h-[600px]">
                <div class="p-4 bg-gray-900 text-white font-bold flex justify-between items-center">
                    <span>Discussion</span>
                    <span class="text-xs bg-gray-700 px-2 py-1 rounded">{{ $task->comments->count() }} Comments</span>
                </div>

                <div class="p-6 flex-1 overflow-y-auto bg-gray-50 space-y-6">
                    @forelse($task->comments as $comment)
                        <div class="flex flex-col {{ $comment->user_id === auth()->id() ? 'items-end' : 'items-start' }}">
                            <div class="text-xs text-gray-500 mb-1 mx-1">
                                <strong>{{ $comment->user->name }}</strong> &bull; {{ $comment->created_at->diffForHumans() }}
                            </div>
                            <div class="px-4 py-3 rounded-2xl max-w-[80%] {{ $comment->user_id === auth()->id() ? 'bg-blue-600 text-white rounded-tr-none' : 'bg-white border border-gray-200 text-gray-800 rounded-tl-none shadow-sm' }}">
                                {{ $comment->comment }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-400 italic mt-10">No comments yet. Start the conversation!</div>
                    @endforelse
                </div>

                <div class="p-4 bg-white border-t border-gray-200">
                    <form action="{{ route('tasks.comments.store', $task->id) }}" method="POST" class="flex gap-2">
                        @csrf
                        <input type="text" name="comment" placeholder="Type your comment here..." required class="flex-1 rounded-lg border-gray-300 focus:ring focus:ring-blue-200 focus:border-blue-500 shadow-sm">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-6 rounded-lg transition-colors">
                            Send
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>