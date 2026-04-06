<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="px-4 sm:px-0 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h3 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 tracking-tight mb-2">
                        Team Activity & System Logs
                    </h3>
                    <p class="text-gray-500 text-sm font-medium">Track all project and task changes across the team.</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                
                <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                <div class="p-6 sm:p-10 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider w-1/6">Time</th>
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider w-1/4">Team Member</th>
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider w-7/12">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            
                            @forelse($activities ?? [
                                ['time' => '10 minutes ago', 'user' => 'catayoc', 'action' => 'LOGGED IN', 'desc' => 'User signed in successfully.'],
                                ['time' => '10 minutes ago', 'user' => 'mizpakipot', 'action' => 'LOGGED OUT', 'desc' => 'User securely signed out.'],
                                ['time' => '1 hour ago', 'user' => 'carl', 'action' => 'TASK ASSIGNED', 'desc' => "Assigned 'make me a wallpaper' to catayoc"]
                            ] as $activity)
                            
                            @php
                                // Normalize variables for the dummy data
                                $time = is_array($activity) ? $activity['time'] : $activity->created_at->diffForHumans();
                                $userName = is_array($activity) ? $activity['user'] : $activity->user->name;
                                $userInitial = strtoupper(substr($userName, 0, 1));
                                $actionType = is_array($activity) ? $activity['action'] : $activity->action;
                                    $description = is_array($activity) ? $activity['desc'] : ($activity->description ?? 'No description available');

                                // Determine badge colors based on action text
                                $badgeClass = 'bg-gray-50 text-gray-600 border-gray-200'; // Default
                                if (str_contains(strtoupper($actionType), 'LOGGED IN')) {
                                    $badgeClass = 'bg-blue-50 text-blue-600 border-blue-200';
                                } elseif (str_contains(strtoupper($actionType), 'LOGGED OUT')) {
                                    $badgeClass = 'bg-stone-50 text-stone-500 border-stone-200';
                                } elseif (str_contains(strtoupper($actionType), 'TASK')) {
                                    $badgeClass = 'bg-indigo-50 text-indigo-600 border-indigo-200';
                                }
                            @endphp

                            <tr class="hover:bg-indigo-50/30 transition-colors group">
                                
                                <td class="py-4 px-4 align-middle whitespace-nowrap">
                                    <span class="text-sm font-bold text-gray-500 group-hover:text-indigo-500 transition-colors">
                                        {{ $time }}
                                    </span>
                                </td>
                                
                                <td class="py-4 px-4 align-middle whitespace-nowrap">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 border border-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-xs shadow-sm">
                                            {{ $userInitial }}
                                        </div>
                                        <span class="text-sm font-extrabold text-gray-900">
                                            {{ $userName }}
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="py-4 px-4 align-middle">
                                    <div class="flex items-center space-x-3">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] font-black uppercase tracking-wider border shadow-sm {{ $badgeClass }}">
                                            {{ $actionType }}
                                        </span>
                                        <span class="text-sm text-gray-600 font-medium">
                                            {{ $description }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-16 text-center">
                                    <div class="mx-auto h-20 w-20 bg-gray-50 rounded-full flex items-center justify-center mb-4 border border-gray-100">
                                        <svg class="h-10 w-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    </div>
                                    <h4 class="text-lg font-extrabold text-gray-900">No activity yet</h4>
                                    <p class="text-sm text-gray-500 mt-1 max-w-sm mx-auto">System logs and team activities will appear here once users start interacting with the platform.</p>
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>