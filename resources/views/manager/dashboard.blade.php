<x-app-layout>
    <div class="min-h-screen py-8 bg-gray-100">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            {{-- Header --}}
            <div class="px-4 sm:px-0">
                <h3 class="text-3xl font-extrabold text-gray-800 tracking-tight mb-2">
                    Manager Dashboard
                </h3>
                <p class="text-gray-500 text-sm font-medium">
                    Track active projects, assign tasks, and monitor your team's progress.
                </p>
            </div>

            {{-- Welcome Banner --}}
            <div class="bg-gradient-to-r from-blue-500 to-teal-500 rounded-2xl p-6 shadow-md flex items-center space-x-4 text-white">
                <div class="p-3 bg-white/20 rounded-xl">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                        d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                    </svg>
                </div>
                <div>
                    <h4 class="text-lg font-semibold">Welcome to your Dashboard!</h4>
                    <p class="text-blue-100 text-sm mt-1">
                        Manage your projects and keep your team on track.
                    </p>
                </div>
            </div>

            {{-- Projects Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                @forelse($projects ?? [
                    ['name' => 'boba', 'desc' => 'make me a shop', 'pending' => 0, 'completed' => 1, 'total' => 1],
                    ['name' => 'um', 'desc' => 'student', 'pending' => 0, 'completed' => 0, 'total' => 0],
                    ['name' => 'test1', 'desc' => 'test1', 'pending' => 0, 'completed' => 0, 'total' => 0],
                    ['name' => 'Project101', 'desc' => 'build me a website', 'pending' => 1, 'completed' => 1, 'total' => 2],
                ] as $project)
                
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition-all duration-300 flex flex-col group">
                    
                    <div class="p-5 flex-1">
                        <div class="flex justify-between items-start mb-3">
                            <a href="{{ route('projects.show', is_array($project) ? ($project['id'] ?? 1) : $project->id) }}">
                                <h4 class="text-lg font-semibold text-gray-800 group-hover:text-blue-600 transition-colors hover:underline">
                                    {{ is_array($project) ? $project['name'] : $project->name }}
                                </h4>
                            </a>

                            {{-- Progress Badge --}}
                            <span class="text-xs font-semibold bg-teal-50 text-teal-600 px-2 py-1 rounded-full">
                                {{ is_array($project) ? $project['completed'] : $project->completed_tasks_count }} 
                                / 
                                {{ is_array($project) ? $project['total'] : $project->total_tasks_count }}
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-500 mb-5 line-clamp-2">
                            {{ is_array($project) ? $project['desc'] : $project->description }}
                        </p>

                        {{-- Stats --}}
                        <div class="grid grid-cols-2 gap-4 border-t border-gray-100 pt-4">
                            <div class="text-center p-3 bg-amber-50 rounded-lg">
                                <span class="block text-xs font-medium text-amber-600">Pending</span>
                                <span class="text-xl font-bold text-amber-700">
                                    {{ is_array($project) ? $project['pending'] : $project->pending_tasks_count }}
                                </span>
                            </div>

                            <div class="text-center p-3 bg-teal-50 rounded-lg">
                                <span class="block text-xs font-medium text-teal-600">Completed</span>
                                <span class="text-xl font-bold text-teal-700">
                                    {{ is_array($project) ? $project['completed'] : $project->completed_tasks_count }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- Footer Actions --}}
                    <div class="bg-gray-50 px-5 py-3 border-t border-gray-100 flex justify-between items-center">

                        <div class="flex items-center space-x-2">

                            {{-- ADD TASK --}}
                            <a href="{{ route('manager.tasks.create', ['project_id' => is_array($project) ? $project['id'] : $project->id]) }}"
                            class="p-2 rounded-md bg-blue-50 text-blue-600 hover:bg-blue-100 transition"
                            title="Add Task">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v16m8-8H4"/>
                                </svg>
                            </a>

                            {{-- EDIT --}}
                            <a href="{{ route('manager.projects.edit', is_array($project) ? $project['id'] : $project->id) }}"
                            class="p-2 rounded-md bg-amber-50 text-amber-600 hover:bg-amber-100 transition"
                            title="Edit Project">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414
                                        a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </a>

                        </div>

                        {{-- DELETE --}}
                        <form action="{{ route('manager.projects.destroy', is_array($project) ? $project['id'] : $project->id) }}" 
                            method="POST" 
                            onsubmit="return confirm('Are you sure you want to delete this project?');">
                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                class="p-2 rounded-md bg-red-50 text-red-600 hover:bg-red-100 transition"
                                title="Delete Project">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                        a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                        m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                </svg>
                            </button>
                        </form>

                    </div>

                </div>

                @empty
                <div class="col-span-1 md:col-span-2 bg-white rounded-xl p-10 text-center border border-gray-100 shadow-sm">
                    <h3 class="text-sm font-semibold text-gray-800">No projects yet</h3>
                    <p class="text-sm text-gray-500 mt-1">Create your first project to get started.</p>
                </div>
                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>