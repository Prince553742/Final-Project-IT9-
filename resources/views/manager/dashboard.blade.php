<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="px-4 sm:px-0">
                <h3 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 tracking-tight mb-2">
                    Manager Dashboard
                </h3>
                <p class="text-gray-500 text-sm font-medium">Track active projects, assign tasks, and monitor your team's progress.</p>
            </div>

            <div class="bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-2xl p-6 shadow-lg shadow-purple-200/50 flex items-center space-x-4 text-white">
                <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                </div>
                <div>
                    <h4 class="text-lg font-bold">Welcome to your Dashboard!</h4>
                    <p class="text-indigo-50 text-sm mt-1">This is your command center. Manage your active projects and keep your team on track below.</p>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                @forelse($projects ?? [
                    ['name' => 'boba', 'desc' => 'make me a shop', 'pending' => 0, 'completed' => 1, 'total' => 1],
                    ['name' => 'um', 'desc' => 'student', 'pending' => 0, 'completed' => 0, 'total' => 0],
                    ['name' => 'test1', 'desc' => 'test1', 'pending' => 0, 'completed' => 0, 'total' => 0],
                    ['name' => 'Project101', 'desc' => 'build me a website', 'pending' => 1, 'completed' => 1, 'total' => 2],
                ] as $project)
                
                <div class="bg-white rounded-2xl shadow-sm border-t-4 border-t-indigo-500 border-x border-b border-gray-100 overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1 flex flex-col group">
                    
                    <div class="p-6 flex-1">
                        <div class="flex justify-between items-start mb-3">
                            <h4 class="text-xl font-extrabold text-gray-800 group-hover:text-indigo-600 transition-colors">{{ is_array($project) ? $project['name'] : $project->name }}</h4>
                            
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gradient-to-r from-emerald-50 to-teal-50 text-emerald-600 border border-emerald-100 shadow-sm">
                                {{ is_array($project) ? $project['completed'] : $project->completed_tasks_count }} / {{ is_array($project) ? $project['total'] : $project->total_tasks_count }} Done
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-500 mb-6 font-medium line-clamp-2">
                            {{ is_array($project) ? $project['desc'] : $project->description }}
                        </p>

                        <div class="grid grid-cols-2 gap-4 border-t border-gray-100 pt-5 mt-auto">
                            <div class="text-center bg-orange-50/50 rounded-xl py-3 border border-orange-100/50">
                                <span class="block text-[10px] font-black text-orange-400 uppercase tracking-wider mb-1">Pending</span>
                                <span class="text-2xl font-black text-orange-500">{{ is_array($project) ? $project['pending'] : $project->pending_tasks_count }}</span>
                            </div>
                            <div class="text-center bg-emerald-50/50 rounded-xl py-3 border border-emerald-100/50">
                                <span class="block text-[10px] font-black text-emerald-400 uppercase tracking-wider mb-1">Completed</span>
                                <span class="text-2xl font-black text-emerald-500">{{ is_array($project) ? $project['completed'] : $project->completed_tasks_count }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50/80 px-6 py-4 border-t border-gray-100 flex justify-between items-center">
                        <a href="#" class="inline-flex items-center text-xs font-bold text-indigo-600 bg-indigo-50 hover:bg-indigo-500 hover:text-white px-3 py-1.5 rounded-lg transition-all duration-200">
                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            ADD TASK
                        </a>
                        
                        <form action="#" method="POST" class="m-0">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="inline-flex items-center text-xs font-bold text-red-500 bg-red-50 hover:bg-red-500 hover:text-white px-3 py-1.5 rounded-lg transition-all duration-200">
                                DELETE
                            </button>
                        </form>
                    </div>

                </div>
                @empty
                <div class="col-span-1 md:col-span-2 bg-white rounded-2xl p-12 text-center border border-gray-100 shadow-sm">
                    <svg class="mx-auto h-12 w-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                    <h3 class="mt-2 text-sm font-bold text-gray-900">No projects yet</h3>
                    <p class="mt-1 text-sm text-gray-500">Get started by creating a new project for your team.</p>
                </div>
                @endforelse

            </div>

        </div>
    </div>
</x-app-layout>