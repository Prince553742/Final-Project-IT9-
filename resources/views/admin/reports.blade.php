<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="mb-8 px-4 sm:px-0">
                <h3 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 tracking-tight">
                    System Reports & Analytics
                </h3>
                <p class="text-gray-500 text-sm mt-1 font-medium">Overview of system metrics, activity, and user distribution.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group hover:shadow-md transition-shadow duration-300">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-blue-50 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total System Users</p>
                            <h4 class="text-4xl font-black text-gray-800">{{ $totalUsers ?? 3 }}</h4>
                        </div>
                        <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white shadow-sm transform group-hover:rotate-3 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group hover:shadow-md transition-shadow duration-300">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-emerald-50 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Total Activity Logs</p>
                            <h4 class="text-4xl font-black text-gray-800">{{ $totalLogs ?? 36 }}</h4>
                        </div>
                        <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-emerald-400 to-green-600 flex items-center justify-center text-white shadow-sm transform group-hover:-rotate-3 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 relative overflow-hidden group hover:shadow-md transition-shadow duration-300">
                    <div class="absolute top-0 right-0 -mr-8 -mt-8 w-32 h-32 rounded-full bg-pink-50 opacity-50 group-hover:scale-110 transition-transform duration-500"></div>
                    <div class="relative z-10 flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-1">Logins (Past 7 Days)</p>
                            <h4 class="text-4xl font-black text-gray-800">{{ $recentLogins ?? 25 }}</h4>
                        </div>
                        <div class="h-14 w-14 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white shadow-sm transform group-hover:rotate-3 transition-transform">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                        </div>
                    </div>
                </div>

            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mt-8">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800">User Role Breakdown</h3>
                </div>
                
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        
                        <div class="flex flex-col items-center justify-center p-6 bg-indigo-50/50 rounded-xl border border-indigo-100">
                            <span class="text-3xl font-black text-indigo-600 mb-2">{{ $adminCount ?? 1 }}</span>
                            <span class="text-xs font-bold text-indigo-400 uppercase tracking-wider">Admins</span>
                        </div>

                        <div class="flex flex-col items-center justify-center p-6 bg-purple-50/50 rounded-xl border border-purple-100">
                            <span class="text-3xl font-black text-purple-600 mb-2">{{ $managerCount ?? 1 }}</span>
                            <span class="text-xs font-bold text-purple-400 uppercase tracking-wider">Managers</span>
                        </div>

                        <div class="flex flex-col items-center justify-center p-6 bg-pink-50/50 rounded-xl border border-pink-100">
                            <span class="text-3xl font-black text-pink-600 mb-2">{{ $memberCount ?? 1 }}</span>
                            <span class="text-xs font-bold text-pink-400 uppercase tracking-wider">Team Members</span>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>