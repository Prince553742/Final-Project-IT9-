<x-app-layout>
    <div class="py-12 bg-gray-50/50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
            
            <div class="flex flex-col md:flex-row md:items-center justify-between px-4 sm:px-0 gap-6">
                <div class="flex items-center space-x-5">
                    <div class="h-20 w-20 rounded-2xl bg-gradient-to-br from-indigo-500 via-purple-500 to-pink-500 p-1 shadow-lg">
                        <div class="h-full w-full bg-white rounded-xl flex items-center justify-center text-2xl font-black text-indigo-600">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                    </div>
                    <div>
                        <h3 class="text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 tracking-tight">
                            {{ $user->name }}
                        </h3>
                        <p class="text-gray-500 font-medium flex items-center mt-1">
                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            {{ $user->email }}
                        </p>
                    </div>
                </div>

                <a href="{{ route('manager.team') }}" class="inline-flex items-center px-6 py-3 bg-white border border-gray-200 text-gray-700 font-bold rounded-2xl hover:bg-gray-50 hover:border-indigo-300 transition-all duration-300 shadow-sm group">
                    <svg class="w-5 h-5 mr-2 transform group-hover:-translate-x-1 transition-transform text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 15l-3-3m0 0l3-3m-3 3h8M3 12a9 9 0 1118 0 8.959 8.959 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3"></path></svg>
                    Back to Roster
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 px-4 sm:px-0">
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-black text-gray-400 uppercase tracking-widest mb-1">Total Assigned</p>
                    <p class="text-3xl font-black text-gray-900">{{ $tasks->count() }}</p>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-black text-orange-400 uppercase tracking-widest mb-1">Pending / Active</p>
                    <p class="text-3xl font-black text-gray-900">{{ $tasks->whereNotIn('status', ['Completed', 'Cancelled'])->count() }}</p>
                </div>
                <div class="bg-white p-6 rounded-3xl border border-gray-100 shadow-sm">
                    <p class="text-xs font-black text-emerald-400 uppercase tracking-widest mb-1">Completed</p>
                    <p class="text-3xl font-black text-gray-900">{{ $tasks->where('status', 'Completed')->count() }}</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative mx-4 sm:mx-0">
                <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>
                
                <div class="p-8">
                    <div class="flex items-center justify-between mb-8">
                        <h4 class="text-xl font-black text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            Detailed Task List
                        </h4>
                    </div>

                    @if($tasks->isEmpty())
                        <div class="text-center py-20 bg-gray-50/50 rounded-2xl border-2 border-dashed border-gray-200">
                            <h4 class="text-lg font-bold text-gray-400">No tasks assigned yet.</h4>
                        </div>
                    @else
                        <div class="overflow-x-auto">
                            <table class="w-full text-left border-separate border-spacing-y-2">
                                <thead>
                                    <tr class="text-xs font-black text-gray-400 uppercase tracking-widest">
                                        <th class="px-6 py-3">Project</th>
                                        <th class="px-6 py-3">Task Title</th>
                                        <th class="px-6 py-3 text-center">Status</th>
                                        <th class="px-6 py-3">Deadline</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tasks as $task)
                                        <tr class="bg-white hover:bg-indigo-50/30 transition-colors group">
                                            <td class="px-6 py-5 rounded-l-2xl border-y border-l border-gray-50">
                                                <span class="text-xs font-black px-3 py-1 bg-indigo-50 text-indigo-600 rounded-lg uppercase tracking-wider">
                                                    {{ $task->project->name }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 border-y border-gray-50">
                                                <span class="font-bold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                                    {{ $task->title }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 border-y border-gray-50 text-center">
                                                @php
                                                    $statusClasses = [
                                                        'Completed' => 'bg-emerald-50 text-emerald-600 border-emerald-100',
                                                        'In Progress' => 'bg-blue-50 text-blue-600 border-blue-100',
                                                        'Pending' => 'bg-orange-50 text-orange-600 border-orange-100',
                                                        'Cancelled' => 'bg-gray-100 text-gray-500 border-gray-200',
                                                    ];
                                                    $class = $statusClasses[$task->status] ?? 'bg-gray-50 text-gray-600 border-gray-100';
                                                @endphp
                                                <span class="px-4 py-1.5 rounded-full text-[10px] font-black uppercase tracking-widest border {{ $class }}">
                                                    {{ $task->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-5 rounded-r-2xl border-y border-r border-gray-50">
                                                <div class="flex items-center text-sm font-bold text-gray-500">
                                                    <svg class="w-4 h-4 mr-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                    {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('M d, Y') : 'No Date' }}
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