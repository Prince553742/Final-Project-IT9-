<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="mb-8">
                {{-- FIXED: Changed 'projects.show' to 'manager.projects.show' --}}
                <a href="{{ route('manager.projects.show', $task->project_id) }}" class="inline-flex items-center text-sm font-semibold text-green-600 hover:text-green-700 transition-colors group">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 8.959 8.959 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3"></path></svg>
                    Back to Project
                </a>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-8 border-b border-gray-100 bg-gradient-to-r from-white to-gray-50">
                    <h2 class="text-3xl font-extrabold text-gray-900 tracking-tight">Edit Task</h2>
                    <p class="mt-2 text-gray-500">Update the details for this task.</p>
                </div>

                <div class="p-8">
                    <form action="{{ route('tasks.update', $task->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        <div>
                            <label for="title" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Task Details</label>
                            <input type="text" name="title" id="title" value="{{ $task->title }}" required
                                class="w-full rounded-lg border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-colors px-4 py-3 text-gray-800 font-medium">
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="assigned_user_id" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Team Member</label>
                                <select name="assigned_user_id" id="assigned_user_id" required
                                    class="w-full rounded-lg border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-colors px-4 py-3 text-gray-800 font-medium">
                                    <option value="" disabled>Select a member</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}" {{ $task->assigned_user_id == $user->id ? 'selected' : '' }}>
                                            {{ $user->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="due_date" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Deadline</label>
                                <input type="date" name="due_date" id="due_date" value="{{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '' }}"
                                    class="w-full rounded-lg border-gray-200 focus:border-green-500 focus:ring focus:ring-green-200 transition-colors px-4 py-3 text-gray-800 font-medium">
                            </div>
                        </div>

                        <div class="pt-6 flex items-center justify-end border-t border-gray-100 gap-4 mt-8">
                            {{-- FIXED: Changed 'projects.show' to 'manager.projects.show' --}}
                            <a href="{{ route('manager.projects.show', $task->project_id) }}" class="text-sm font-bold text-gray-400 hover:text-gray-600 uppercase tracking-wider transition-colors px-4 py-2">
                                Cancel
                            </a>
                            <button type="submit" class="bg-gray-900 text-white font-bold text-xs uppercase tracking-widest py-3 px-8 rounded-lg hover:bg-green-600 transition-colors shadow-sm">
                                Update Task
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>