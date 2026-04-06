<x-app-layout>
    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            {{-- Back link --}}
            <div class="mb-8 px-2">
                <a href="{{ route('manager.dashboard') }}" class="inline-flex items-center text-sm font-semibold text-green-600 transition-colors hover:text-green-700">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-5-5m0 0l5-5m-5 5h12"></path>
                    </svg>
                    Back to Manage Projects
                </a>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="p-12 border-b border-gray-100 bg-white">
                    <h2 class="text-3xl font-bold text-gray-900 tracking-tight">Assign New Task</h2>
                    <p class="text-base text-gray-500 mt-2">Set up a new task for your team member.</p>
                </div>

                <div class="p-12">
                    
                    {{-- GLOBAL ERROR CATCHER: This will reveal any hidden validation errors --}}
                    @if ($errors->any())
                        <div class="mb-8 bg-red-50 border-l-4 border-red-500 p-4 rounded-md">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Oops! We found some errors:</h3>
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('manager.tasks.store', $project->id ?? request()->query('project_id')) }}" method="POST">    
                        @csrf
                        
                        {{-- Hidden Project ID to ensure the Controller knows which project this belongs to --}}
                        <input type="hidden" name="project_id" value="{{ $project->id ?? request()->query('project_id') }}">
                                                
                        <div class="space-y-12">
                            {{-- TASK DETAILS --}}
                            <div class="max-w-5xl"> 
                                <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Task Details</label>
                                <input type="text" name="title" required placeholder="e.g. Buy some pearl" value="{{ old('title') }}"
                                    class="w-full rounded-xl shadow-sm py-4 px-6 text-gray-700 transition-colors @error('title') border-red-500 focus:border-red-500 focus:ring-red-200 @else border-gray-300 focus:border-green-500 focus:ring-green-500 @enderror">
                                
                                @error('title')
                                    <p class="text-red-500 text-xs font-bold mt-2 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-5xl">
                                {{-- TEAM MEMBER ASSIGNMENT --}}
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Team Member</label>
                                    <select name="assigned_user_id" required
                                        class="w-full rounded-xl shadow-sm py-4 px-6 text-gray-700 transition-colors @error('assigned_user_id') border-red-500 focus:border-red-500 focus:ring-red-200 @else border-gray-200 focus:border-green-500 focus:ring-green-500 @enderror">
                                        <option value="">Select a member</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" {{ old('assigned_user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @error('assigned_user_id')
                                        <p class="text-red-500 text-xs font-bold mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- PRIORITY --}}
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Priority</label>
                                    <select name="priority" required
                                        class="w-full rounded-xl shadow-sm py-4 px-6 text-gray-700 transition-colors @error('priority') border-red-500 focus:border-red-500 focus:ring-red-200 @else border-gray-200 focus:border-green-500 focus:ring-green-500 @enderror">
                                        <option value="">Select priority</option>
                                        <option value="Low" {{ old('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                                        <option value="Medium" {{ old('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="High" {{ old('priority') == 'High' ? 'selected' : '' }}>High</option>
                                    </select>

                                    @error('priority')
                                        <p class="text-red-500 text-xs font-bold mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- DEADLINE --}}
                                <div>
                                    <label class="block text-xs font-black text-gray-400 uppercase tracking-widest mb-4">Deadline</label>
                                    <input type="date" name="due_date" required value="{{ old('due_date') }}"
                                        class="w-full rounded-xl shadow-sm py-4 px-6 text-gray-700 transition-colors @error('due_date') border-red-500 focus:border-red-500 focus:ring-red-200 @else border-gray-200 focus:border-green-500 focus:ring-green-500 @enderror">
                                    
                                    @error('due_date')
                                        <p class="text-red-500 text-xs font-bold mt-2 flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-16 pt-10 border-t border-gray-100 flex items-center justify-start gap-8">
                            <button type="submit" 
                                class="bg-green-600 text-white font-black text-sm uppercase tracking-widest py-4 px-12 rounded-xl shadow-md transition-all hover:bg-green-700 hover:-translate-y-0.5">
                                Assign Task
                            </button>
                            
                            <a href="{{ route('manager.dashboard') }}" 
                                class="text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-gray-600 transition-colors">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>