<x-app-layout>
    <div class="py-6 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-6 relative">
            <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-blue-500 to-teal-500 rounded-full"></div>
            <div class="pl-4">
                <h1 class="text-2xl font-semibold text-gray-800">System Activity Logs</h1>
                <p class="text-sm text-gray-500">Monitor recent actions, updates, and security events across the platform.</p>
            </div>
        </div>

        {{-- Logs Table Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-base font-semibold text-gray-700">Recent Activity</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Timestamp</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @forelse($logs ?? [] as $log)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $log->created_at ? $log->created_at->diffForHumans() : 'Just now' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    <div class="h-8 w-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-sm">
                                        {{ strtoupper(substr($log->user->name ?? 'U', 0, 1)) }}
                                    </div>
                                    <span class="text-sm font-medium text-gray-900">{{ $log->user->name ?? 'Unknown User' }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $actionColor = match(strtolower($log->action)) {
                                        'logged in' => 'bg-green-100 text-green-700',
                                        'logged out' => 'bg-gray-100 text-gray-600',
                                        'task created', 'task assigned', 'task updated' => 'bg-blue-100 text-blue-700',
                                        'project created', 'project updated', 'project deleted' => 'bg-purple-100 text-purple-700',
                                        default => 'bg-indigo-100 text-indigo-700',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-semibold {{ $actionColor }}">
                                    {{ $log->action }}
                                </span>
                                {{-- No duplicate description text – only the badge --}}
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="px-6 py-12 text-center text-gray-400">
                                No activity logs found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(isset($logs) && method_exists($logs, 'links'))
            <div class="px-6 py-4 border-t border-gray-100 bg-gray-50">
                {{ $logs->links() }}
            </div>
            @endif
        </div>
    </div>
</x-app-layout>