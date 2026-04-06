<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="mb-8 px-4 sm:px-0">
                <h3 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 tracking-tight">
                    System Settings
                </h3>
                <p class="text-gray-500 text-sm mt-1 font-medium">Manage global configuration, maintenance mode, and application details.</p>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-5 border-b border-gray-100 bg-gray-50/50">
                    <h3 class="text-lg font-bold text-gray-800">Global Configuration</h3>
                </div>

                <div class="p-6">
                    <form method="POST" action="#" class="space-y-6">
                        @csrf

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            
                            <div>
                                <label for="app_name" class="block text-sm font-bold text-gray-700 mb-1">Application Name</label>
                                <input type="text" name="app_name" id="app_name" value="Minazuki's Belly" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm transition-colors duration-200" placeholder="Enter system name">
                            </div>

                            <div>
                                <label for="support_email" class="block text-sm font-bold text-gray-700 mb-1">Support Email</label>
                                <input type="email" name="support_email" id="support_email" value="admin@minazuki.com" class="w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500 shadow-sm text-sm transition-colors duration-200" placeholder="admin@example.com">
                            </div>

                        </div>

                        <div class="pt-6 mt-6 border-t border-gray-100">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="text-sm font-bold text-gray-800">Maintenance Mode</h4>
                                    <p class="text-xs text-gray-500 mt-1">Prevent non-admin users from accessing the system during updates.</p>
                                </div>
                                
                                <label class="relative inline-flex items-center cursor-pointer">
                                    <input type="checkbox" name="maintenance_mode" class="sr-only peer">
                                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-gradient-to-r peer-checked:from-indigo-500 peer-checked:to-purple-500"></div>
                                </label>
                            </div>
                        </div>

                        <div class="pt-6 flex justify-end">
                            <button type="submit" class="px-6 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 text-white font-bold rounded-xl shadow-sm hover:shadow-md transition-all duration-200 transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                Save Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>