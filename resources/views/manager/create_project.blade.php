<x-app-layout>
    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-8">

            <div class="px-4 sm:px-0">
                <h3 class="text-3xl font-extrabold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 via-purple-600 to-pink-500 tracking-tight mb-2">
                    Create New Project
                </h3>
                <p class="text-gray-500 text-sm font-medium">Launch a new initiative and start assigning tasks to your team.</p>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden relative">
                
                <div class="h-2 w-full bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500"></div>

                <div class="p-8 sm:p-10">

                    @if ($errors->any())
                        <div class="mb-6 bg-red-50 border border-red-100 rounded-2xl p-5 flex items-start space-x-4">
                            <div class="flex-shrink-0">
                                <svg class="h-6 w-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-red-800">Oops! Something went wrong.</h3>
                                <ul class="mt-2 list-disc list-inside text-sm text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                    
                    <form action="{{ route('manager.projects.store') }}" method="POST" class="space-y-6">
                        @csrf
                        
                        <div>
                            <label for="title" class="block text-sm font-black text-gray-700 mb-2 uppercase tracking-wide">Project Title</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <input type="text" name="title" id="title" value="{{ old('title') }}" class="block w-full pl-11 bg-gray-50 border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 py-3 font-medium placeholder-gray-400" placeholder="e.g., E-commerce App Redesign" required>
                            </div>
                        </div>

                        <div>
                            <label for="description" class="block text-sm font-black text-gray-700 mb-2 uppercase tracking-wide">Description</label>
                            <textarea name="description" id="description" rows="4" class="block w-full bg-gray-50 border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 py-3 px-4 font-medium placeholder-gray-400" placeholder="What are the goals and objectives of this project?">{{ old('description') }}</textarea>
                        </div>

                        <div>
                            <label for="due_date" class="block text-sm font-black text-gray-700 mb-2 uppercase tracking-wide">Due Date (Optional)</label>
                            <input type="date" name="due_date" id="due_date" value="{{ old('due_date') }}" class="block w-full md:w-1/2 bg-gray-50 border-gray-200 text-gray-900 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all duration-200 py-3 px-4 font-medium text-gray-600">
                        </div>

                        <div class="pt-8 mt-8 border-t border-gray-100 flex items-center justify-end space-x-4">
                            <a href="{{ route('manager.dashboard') }}" class="inline-flex items-center px-5 py-2.5 text-sm font-bold text-gray-600 bg-white border border-gray-200 rounded-xl hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-200 transition-all duration-200">
                                Cancel
                            </a>
                            
                            <button type="submit" class="inline-flex items-center px-6 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-indigo-600 to-purple-600 rounded-xl hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-md shadow-indigo-200/50 transform hover:-translate-y-0.5 transition-all duration-200">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                Save Project
                            </button>
                        </div>

                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>