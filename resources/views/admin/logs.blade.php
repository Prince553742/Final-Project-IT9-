<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="mb-8 px-4 sm:px-0">
                <h3 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 tracking-tight">
                    System Activity Logs
                </h3>
                <p class="text-gray-500 text-sm mt-1 font-medium">Monitor recent actions, updates, and security events across the platform.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800">Recent Activity</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Timestamp</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">User</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            
                            @forelse($logs as $log)
                            @php
                                // Split your action string (e.g., "Logged In | User signed in...") into two parts for styling
                                $actionText = $log->action ?? 'System | Update';
                                $actionParts = explode(' | ', $actionText);
                                $actionBadge = $actionParts[0] ?? 'Action';
                                $actionDesc = $actionParts[1] ?? $actionText;
                            @endphp
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150 group">
                                
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 font-medium">
                                    {{ $log->created_at ? $log->created_at->diffForHumans() : 'Just now' }}
                                </td>
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 border border-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-xs mr-3 shadow-sm uppercase">
                                            {{ substr($log->user->name ?? 'U', 0, 1) }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-700">
                                            {{ $log->user->name ?? 'Unknown User' }}
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="px-6 py-4 text-sm">
                                    <div class="flex items-center space-x-3">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-indigo-50 text-indigo-600 border border-indigo-100 whitespace-nowrap">
                                            {{ $actionBadge }}
                                        </span>
                                        <span class="text-gray-500 font-medium truncate max-w-md">
                                            {{ $actionDesc }}
                                        </span>
                                    </div>
                                </td>
                                
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-gray-400 italic">
                                    No activity logs found.
                                </td>
                            </tr>
                            @endforelse

                        </tbody>
                    </table>
                </div>
                
                {{-- 
                @if(isset($logs) && method_exists($logs, 'links'))
                <div class="px-6 py-4 border-t border-gray-100 bg-gray-50/50">
                    {{ $logs->links() }}
                </div>
                @endif 
                --}}
            </div>

        </div>
    </div>
</x-app-layout>