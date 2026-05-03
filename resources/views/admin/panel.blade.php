<x-app-layout>
    <div class="min-h-screen py-6 px-4 sm:px-6 lg:px-8 bg-gray-100">
        <div class="max-w-7xl mx-auto">
        {{-- Header --}}
        <div class="mb-6 relative">
            <div class="absolute left-0 top-0 w-1 h-full bg-gradient-to-b from-blue-500 to-teal-500 rounded-full"></div>
            <div class="pl-4">
                <h1 class="text-2xl font-semibold text-gray-800">System Settings</h1>
                <p class="text-sm text-gray-500">Manage global configuration, maintenance mode, and application details.</p>
            </div>
        </div>

        {{-- Settings Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
                <h2 class="text-base font-semibold text-gray-700">Global Configuration</h2>
            </div>

            <div class="p-6">
                <form method="POST" action="#" class="space-y-6">
                    @csrf

                    {{-- Application Name --}}
                    <div>
                        <label for="app_name" class="block text-sm font-medium text-gray-700 mb-1">Application Name</label>
                        <input type="text" name="app_name" id="app_name" value="Minazuki's Belly" 
                            class="w-full md:w-1/2 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Support Email --}}
                    <div>
                        <label for="support_email" class="block text-sm font-medium text-gray-700 mb-1">Support Email</label>
                        <input type="email" name="support_email" id="support_email" value="admin@minazuki.com" 
                            class="w-full md:w-1/2 rounded-lg border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    </div>

                    {{-- Maintenance Mode Toggle --}}
                    <div class="pt-4 border-t border-gray-100">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="text-sm font-medium text-gray-800">Maintenance Mode</h3>
                                <p class="text-xs text-gray-500 mt-1">Prevent non-admin users from accessing the system during updates.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="maintenance_mode" class="sr-only peer">
                                <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-indigo-100 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-indigo-600"></div>
                            </label>
                        </div>
                    </div>

                    {{-- Save Button --}}
                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="px-5 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-medium rounded-lg shadow-sm transition-colors focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Save Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Optional: Info Card --}}
        <div class="mt-6 bg-blue-50 rounded-xl p-4 border border-blue-100">
            <div class="flex items-start gap-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <div>
                    <h4 class="text-sm font-medium text-blue-800">About this panel</h4>
                    <p class="text-xs text-blue-600 mt-1">Changes made here affect the entire application. Maintenance mode will show a "down for maintenance" page to non‑admin users.</p>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>