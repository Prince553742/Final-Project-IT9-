<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="px-4 sm:px-0">
                <h3 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 tracking-tight mb-2">
                    Team Activity & System Logs
                </h3>
                <p class="text-gray-500 text-sm font-medium">Track all project and task changes across the team in real-time.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                
                <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                <div class="p-6 sm:p-10 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider w-40">Time</th>
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider w-64">Team Member</th>
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            
                            @forelse($activities ?? [
                                ['time' => '30 minutes ago', 'user' => 'mizpakipot', 'action' => 'LOGGED IN', 'desc' => 'User signed in successfully.'],
                                ['time' => '30 minutes ago', 'user' => 'carl', 'action' => 'LOGGED OUT', 'desc' => 'User securely signed out.'],
                                ['time' => '2 hours ago', 'user' => 'mizpakipot', 'action' => 'TASK ASSIGNED', 'desc' => "Assigned 'make me a wallpaper' to catayoc"]
                            ] as $activity)
                            
                            @php
                                // Normalize variables whether it's an object or an array for the dummy data
                                $time = is_array($activity) ? $activity['time'] : $activity->created_at->diffForHumans();
                                $userName = is_array($activity) ? $activity['user'] : $activity->user->name;
                                $action = is_array($activity) ? $activity['action'] : $activity->action_type;
                                $desc = is_array($activity) ? $activity['desc'] : $activity->description;
                            @endphp

                            <tr class="hover:bg-indigo-50/30 transition-colors group">
                                
                                <td class="py-4 px-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                    {{ $time }}
                                </td>
                                
                                <td class="py-4 px-4">
                                    <div class="flex items-center space-x-3">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 border border-indigo-200/50 flex items-center justify-center text-indigo-700 text-xs font-black shadow-sm group-hover:scale-110 transition-transform">
                                            {{ strtoupper(substr($userName, 0, 1)) }}
                                        </div>
                                        <span class="font-extrabold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                            {{ $userName }}
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="py-4 px-4">
                                    <div class="flex items-center space-x-3">
                                        
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold uppercase tracking-wider shadow-sm
                                            @if(str_contains(strtolower($action), 'in')) bg-emerald-50 text-emerald-600 border border-emerald-100/60
                                            @elseif(str_contains(strtolower($action), 'out')) bg-gray-50 text-gray-600 border border-gray-200/60
                                            @elseif(str_contains(strtolower($action), 'task')) bg-purple-50 text-purple-600 border border-purple-100/60
                                            @else bg-indigo-50 text-indigo-600 border border-indigo-100/60 @endif
                                        ">
                                            {{ $action }}
                                        </span>
                                        
                                        <span class="text-sm text-gray-600 font-medium">
                                            {{ $desc }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    <h4 class="text-sm font-bold text-gray-900">No recent activity</h4>
                                    <p class="text-sm text-gray-500 mt-1">System logs and team actions will appear here.</p>
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