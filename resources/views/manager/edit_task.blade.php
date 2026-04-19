<x-app-layout>
    <div class="py-12 bg-slate-50 min-h-screen font-sans">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('projects.show', $task->project_id) }}" class="inline-flex items-center text-sm font-bold text-purple-600 hover:text-purple-800 transition-colors group">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 8.959 8.959 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3"></path></svg>
                    Back to Project
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                
                <div class="p-8 bg-gradient-to-r from-purple-600 via-fuchsia-500 to-pink-500 relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-2xl"></div>
                    
                    <h2 class="text-3xl font-extrabold text-white tracking-tight relative z-10">Edit Task</h2>
                    <p class="mt-2 text-purple-100 font-medium relative z-10">Refine and update the details for this assignment.</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Task Details</label>
                            <input type="text" name="title" id="title" value="{{ $task->title }}" required
                                class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-purple-500 focus:ring focus:ring-purple-200 transition-all px-4 py-3 text-gray-800 font-semibold shadow-sm">
                        </div>

                        <div>
                            <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Description</label>
                            <textarea name="description" id="description" rows="3"
                                class="w-full rounded-xl border-gray-200 bg-gray-50 focus:bg-white focus:border-purple-500 focus:ring focus:ring-purple-200 transition-all px-4 py-3 text-gray-800 font-medium shadow-sm">{{ $task->description }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-50 p-6 rounded-xl border border-slate-100">
                            
                            <div>
                                <label for="assigned_user_id" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Team Member</label>
                                <select name="assigned_user_id" id="assigned_user_id" required
                                    class="w-full rounded-xl border-gray-200 bg-white focus:border-purple-500 focus:ring focus:ring-purple-200 transition-all px-4 py-3 text-gray-800 font-semibold shadow-sm cursor-pointer">
                                    <option value="" disabled>Select a member</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $task->assigned_user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="due_date" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Deadline</label>
                                <input type="date" name="due_date" id="due_date" value="{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '' }}" required
                                    class="w-full rounded-xl border-gray-200 bg-white focus:border-purple-500 focus:ring focus:ring-purple-200 transition-all px-4 py-3 text-gray-800 font-semibold shadow-sm cursor-pointer">
                            </div>
                            
                            <div>
                                <label for="priority" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Priority</label>
                                <select name="priority" id="priority" required
                                    class="w-full rounded-xl border-gray-200 bg-white focus:border-purple-500 focus:ring focus:ring-purple-200 transition-all px-4 py-3 text-gray-800 font-semibold shadow-sm cursor-pointer">
                                    <option value="Low" {{ $task->priority == 'Low' ? 'selected' : '' }}>Low</option>
                                    <option value="Medium" {{ $task->priority == 'Medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="High" {{ $task->priority == 'High' ? 'selected' : '' }}>High</option>
                                    <option value="Urgent" {{ $task->priority == 'Urgent' ? 'selected' : '' }}>Urgent</option>
                                </select>
                            </div>

                            <div>
                                <label for="status" class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-2">Status</label>
                                <select name="status" id="status" required
                                    class="w-full rounded-xl border-gray-200 bg-white focus:border-purple-500 focus:ring focus:ring-purple-200 transition-all px-4 py-3 text-gray-800 font-semibold shadow-sm cursor-pointer">
                                    <option value="Pending" {{ $task->status == 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="In Progress" {{ $task->status == 'In Progress' ? 'selected' : '' }}>In Progress</option>
                                    <option value="On Hold" {{ $task->status == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                    <option value="Completed" {{ $task->status == 'Completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="Cancelled" {{ $task->status == 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </div>
                        </div>

                        <div class="pt-6 flex items-center justify-end border-t border-gray-100 gap-4 mt-8">
                            <a href="{{ route('projects.show', $task->project_id) }}" class="text-sm font-bold text-gray-400 hover:text-gray-700 uppercase tracking-wider transition-colors px-4 py-2">
                                Cancel
                            </a>
                            <button type="submit" class="bg-gradient-to-r from-purple-600 to-pink-500 text-white font-bold text-sm uppercase tracking-widest py-3 px-8 rounded-xl hover:opacity-90 transform hover:-translate-y-0.5 transition-all shadow-md hover:shadow-lg">
                                Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>