<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="px-4 sm:px-0">
                <h3 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 tracking-tight mb-2">
                    Admin Dashboard
                </h3>
                <p class="text-gray-500 text-sm font-medium">Overview of system metrics, progress, and user management.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-gradient-to-br from-indigo-500 to-blue-600 rounded-2xl p-6 shadow-lg shadow-indigo-200/50 flex flex-col justify-center text-white transform transition-all duration-200 hover:-translate-y-1">
                    <span class="text-indigo-100 text-xs font-black uppercase tracking-wider mb-1">System Projects</span>
                    <span class="text-4xl font-extrabold">{{ $totalProjects ?? 4 }}</span>
                </div>

                <div class="bg-gradient-to-br from-purple-500 to-fuchsia-600 rounded-2xl p-6 shadow-lg shadow-purple-200/50 flex flex-col justify-center text-white transform transition-all duration-200 hover:-translate-y-1">
                    <span class="text-purple-100 text-xs font-black uppercase tracking-wider mb-1">Total Tasks</span>
                    <span class="text-4xl font-extrabold">{{ $totalTasks ?? 3 }}</span>
                </div>

                <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex flex-col justify-center relative overflow-hidden">
                    <div class="flex justify-between items-start mb-2 relative z-10">
                        <span class="text-xs font-black text-gray-500 uppercase tracking-wider">Overall Progress</span>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-gradient-to-r from-indigo-50 to-purple-50 text-indigo-700 border border-indigo-100">
                            System Efficiency
                        </span>
                    </div>
                    <div class="flex items-center space-x-4 mt-1 relative z-10">
                        <span class="text-4xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-purple-600">
                            {{ $overallProgress ?? 67 }}%
                        </span>
                        <div class="flex-1 h-3 bg-gray-100 rounded-full overflow-hidden shadow-inner">
                            <div class="h-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 rounded-full" style="width: {{ $overallProgress ?? 67 }}%"></div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white rounded-2xl p-5 shadow-sm border-l-4 border-l-indigo-500 border-y border-r border-gray-100 flex justify-between items-center group hover:bg-indigo-50/30 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="p-2.5 bg-indigo-50 rounded-xl text-indigo-600 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700">Total Admins</span>
                    </div>
                    <span class="text-2xl font-black text-indigo-600">{{ $totalAdmins ?? 1 }}</span>
                </div>
                
                <div class="bg-white rounded-2xl p-5 shadow-sm border-l-4 border-l-purple-500 border-y border-r border-gray-100 flex justify-between items-center group hover:bg-purple-50/30 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="p-2.5 bg-purple-50 rounded-xl text-purple-600 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700">Total Managers</span>
                    </div>
                    <span class="text-2xl font-black text-purple-600">{{ $totalManagers ?? 1 }}</span>
                </div>
                
                <div class="bg-white rounded-2xl p-5 shadow-sm border-l-4 border-l-pink-500 border-y border-r border-gray-100 flex justify-between items-center group hover:bg-pink-50/30 transition-colors">
                    <div class="flex items-center space-x-3">
                        <div class="p-2.5 bg-pink-50 rounded-xl text-pink-600 group-hover:scale-110 transition-transform">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <span class="text-sm font-bold text-gray-700">Total Members</span>
                    </div>
                    <span class="text-2xl font-black text-pink-600">{{ $totalMembers ?? 1 }}</span>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gradient-to-r from-gray-50 to-indigo-50/30 flex justify-between items-center">
                    <h3 class="text-lg font-bold text-gray-800 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        User Management
                    </h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50/80">
                            <tr>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Name</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Email</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Status</th>
                                <th scope="col" class="px-6 py-4 text-left text-xs font-black text-gray-400 uppercase tracking-wider">Role</th>
                                <th scope="col" class="px-6 py-4 text-right text-xs font-black text-gray-400 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                            
                            @forelse($users ?? [['name' => 'mizpakipot', 'email' => 'mizpakipotthack@gmail.com', 'role' => 'Manager'], ['name' => 'catayoc', 'email' => 'princecarlcatayoc2006@gmail.com', 'role' => 'Team Member']] as $user)
                            <tr class="hover:bg-indigo-50/30 transition-colors duration-150 group">
                                
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="h-8 w-8 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 border border-indigo-200 flex items-center justify-center text-indigo-700 font-bold text-xs mr-3 uppercase shadow-sm">
                                            {{ substr(is_array($user) ? $user['name'] : $user->name, 0, 1) }}
                                        </div>
                                        <span class="text-sm font-bold text-gray-800">{{ is_array($user) ? $user['name'] : $user->name }}</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="text-sm text-gray-500 font-medium">{{ is_array($user) ? $user['email'] : $user->email }}</span>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <span class="relative flex h-2.5 w-2.5">
                                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-green-400 opacity-75"></span>
                                          <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-green-500"></span>
                                        </span>
                                        <span class="text-sm text-gray-500 font-medium">Active</span>
                                    </div>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap">
                                    <form action="#" method="POST" class="m-0">
                                        @csrf
                                        @method('PATCH')
                                        <select name="role" class="block w-36 text-sm font-bold text-gray-700 bg-gray-50 border-gray-200 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 py-1.5 shadow-sm transition-colors cursor-pointer">
                                            <option value="Admin" {{ (is_array($user) ? $user['role'] : $user->role) == 'Admin' ? 'selected' : '' }}>Admin</option>
                                            <option value="Manager" {{ (is_array($user) ? $user['role'] : $user->role) == 'Manager' ? 'selected' : '' }}>Manager</option>
                                            <option value="Team Member" {{ (is_array($user) ? $user['role'] : $user->role) == 'Team Member' ? 'selected' : '' }}>Team Member</option>
                                        </select>
                                    </form>
                                </td>

                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <form action="#" method="POST" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="inline-flex items-center px-3 py-1 border border-red-200 text-xs font-bold rounded-lg text-red-600 bg-red-50 hover:bg-red-500 hover:text-white transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 shadow-sm">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                                
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-gray-400 italic">
                                    No users found.
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