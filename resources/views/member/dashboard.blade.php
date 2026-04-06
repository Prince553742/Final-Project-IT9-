<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="px-4 sm:px-0">
                <h3 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-1">
                    Welcome back, <span class="bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500">{{ auth()->user()->name ?? 'catayoc' }}</span>!
                </h3>
                <p class="text-gray-500 text-sm font-medium">Here is an overview of your current workload and upcoming deadlines.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 px-4 sm:px-0">
                
                <div class="bg-white rounded-3xl p-6 shadow-sm border border-orange-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-orange-50 to-orange-100 rounded-full z-0 group-hover:scale-150 transition-transform duration-500 ease-in-out"></div>
                    
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-wider mb-1">Active Tasks</p>
                            <h4 class="text-4xl font-extrabold text-orange-500">{{ $activeTasksCount ?? 1 }}</h4>
                        </div>
                        <div class="h-12 w-12 rounded-2xl bg-orange-50 flex items-center justify-center text-orange-500 border border-orange-100 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-3xl p-6 shadow-sm border border-emerald-100 relative overflow-hidden group hover:shadow-md transition-shadow">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-gradient-to-br from-emerald-50 to-emerald-100 rounded-full z-0 group-hover:scale-150 transition-transform duration-500 ease-in-out"></div>
                    
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-black text-gray-400 uppercase tracking-wider mb-1">Completed To Date</p>
                            <h4 class="text-4xl font-extrabold text-emerald-500">{{ $completedTasksCount ?? 2 }}</h4>
                        </div>
                        <div class="h-12 w-12 rounded-2xl bg-emerald-50 flex items-center justify-center text-emerald-500 border border-emerald-100 shadow-sm group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative px-4 sm:px-0 mx-4 sm:mx-0">
                
                <div class="px-6 py-5 border-b border-gray-50 bg-gray-50/50 flex justify-between items-center">
                    <h4 class="text-base font-extrabold text-gray-900 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Your Most Urgent Deadlines
                    </h4>
                </div>
                
                <div class="divide-y divide-gray-50">
                    
                    @forelse($urgentTasks ?? [['name' => 'make me a wallpaper', 'project' => 'PROJECT101', 'due_date' => 'Apr 01']] as $task)
                    <div class="p-6 hover:bg-red-50/30 transition-colors group flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                        
                        <div class="flex items-center space-x-4">
                            <div class="h-12 w-12 rounded-xl bg-red-50 flex items-center justify-center text-red-500 border border-red-100 group-hover:scale-105 transition-transform shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                            </div>
                            
                            <div>
                                <h5 class="text-lg font-bold text-gray-900 group-hover:text-red-600 transition-colors line-clamp-1">
                                    {{ is_array($task) ? $task['name'] : $task->name }}
                                </h5>
                                <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mt-1 flex items-center">
                                    <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path></svg>
                                    {{ is_array($task) ? $task['project'] : $task->project->title }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="sm:text-right pl-16 sm:pl-0">
                            <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-red-50 text-red-600 border border-red-100 shadow-sm whitespace-nowrap">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                Due {{ is_array($task) ? $task['due_date'] : \Carbon\Carbon::parse($task->due_date)->format('M d') }}
                            </span>
                        </div>
                        
                    </div>
                    @empty
                    <div class="p-12 text-center">
                        <svg class="mx-auto h-12 w-12 text-emerald-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        <h4 class="text-sm font-bold text-gray-900">You're all caught up!</h4>
                        <p class="text-sm text-gray-500 mt-1">You have no urgent tasks approaching their deadline right now.</p>
                    </div>
                    @endforelse

                </div>
            </div>

        </div>
    </div>
</x-app-layout>