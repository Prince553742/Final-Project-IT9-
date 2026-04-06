<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="px-4 sm:px-0 flex justify-between items-end">
                <div>
                    <h3 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 tracking-tight mb-2">
                        Manage Team Members
                    </h3>
                    <p class="text-gray-500 text-sm font-medium">View your team roster, monitor active tasks, and check individual workloads.</p>
                </div>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                
                <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                <div class="p-6 sm:p-10 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b-2 border-gray-100">
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider">Name</th>
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider">Email</th>
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider">Active Tasks</th>
                                <th class="pb-4 px-4 text-xs font-black text-gray-400 uppercase tracking-wider text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-50">
                            
                            @forelse($teamMembers ?? [['name' => 'catayoc', 'email' => 'princecarlcatayoc2006@gmail.com', 'pending_tasks_count' => 1]] as $member)
                            <tr class="hover:bg-indigo-50/30 transition-colors group">
                                
                                <td class="py-5 px-4">
                                    <div class="flex items-center space-x-4">
                                        <div class="h-10 w-10 rounded-xl bg-gradient-to-br from-indigo-100 to-purple-100 border border-indigo-200/50 flex items-center justify-center text-indigo-700 font-black shadow-sm group-hover:scale-105 transition-transform">
                                            {{ strtoupper(substr(is_array($member) ? $member['name'] : $member->name, 0, 1)) }}
                                        </div>
                                        <span class="font-extrabold text-gray-900 group-hover:text-indigo-600 transition-colors">
                                            {{ is_array($member) ? $member['name'] : $member->name }}
                                        </span>
                                    </div>
                                </td>
                                
                                <td class="py-5 px-4 text-sm text-gray-500 font-medium">
                                    {{ is_array($member) ? $member['email'] : $member->email }}
                                </td>
                                
                                <td class="py-5 px-4">
                                    @php
                                        $taskCount = is_array($member) ? $member['pending_tasks_count'] : $member->pending_tasks_count;
                                    @endphp
                                    
                                    @if($taskCount > 0)
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-orange-50 text-orange-600 border border-orange-100/60 shadow-sm">
                                            <svg class="w-3.5 h-3.5 mr-1.5 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            {{ $taskCount }} Pending {{ Str::plural('Task', $taskCount) }}
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-3 py-1.5 rounded-full text-xs font-bold bg-emerald-50 text-emerald-600 border border-emerald-100/60 shadow-sm">
                                            <svg class="w-3.5 h-3.5 mr-1.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            All Caught Up
                                        </span>
                                    @endif
                                </td>
                                
                                <td class="py-5 px-4 text-right">
                                    <a href="#" class="inline-flex items-center px-4 py-2 text-xs font-bold text-indigo-600 bg-indigo-50 border border-indigo-100 rounded-lg hover:bg-gradient-to-r hover:from-indigo-600 hover:to-purple-600 hover:text-white hover:border-transparent transition-all duration-300 shadow-sm">
                                        View Workload
                                        <svg class="w-3.5 h-3.5 ml-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                    <h4 class="text-sm font-bold text-gray-900">No team members found</h4>
                                    <p class="text-sm text-gray-500 mt-1">There are no members currently assigned to your team.</p>
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