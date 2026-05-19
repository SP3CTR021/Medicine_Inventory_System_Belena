<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('error'))
                <div class="mb-4 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('error') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <p class="text-lg">{{ __('Welcome back, ') }} {{ Auth::user()->name }}!</p>
                </div>
            </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Medicine Management</h3>
                            <p class="text-sm text-gray-500 mb-4">Add, edit, view, and delete medicine records in the inventory.</p>
                            <a href="{{ route('medicines.index') }}">
                                <x-primary-button>{{ __('Manage Medicines') }}</x-primary-button>
                            </a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Reports</h3>
                            <p class="text-sm text-gray-500 mb-4">Generate and export medicine inventory reports.</p>
                            <a href="{{ route('reports.index') }}">
                                <x-primary-button>{{ __('View Reports') }}</x-primary-button>
                            </a>
                        </div>
                    </div>
                </div>
        </div>
    </div>
</x-app-layout>
















