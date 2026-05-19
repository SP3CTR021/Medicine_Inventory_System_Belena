<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Medicine Reports') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Report Summary</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div class="bg-indigo-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-indigo-600">Total Medicines</div>
                            <div class="mt-1 text-2xl font-semibold text-indigo-900">{{ $totalMedicines }}</div>
                        </div>

                        <div class="bg-green-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-green-600">Available</div>
                            <div class="mt-1 text-2xl font-semibold text-green-900">{{ $availableCount }}</div>
                        </div>

                        <div class="bg-yellow-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-yellow-600">Low Stock</div>
                            <div class="mt-1 text-2xl font-semibold text-yellow-900">{{ $lowStockCount }}</div>
                        </div>

                        <div class="bg-red-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-red-600">Expired</div>
                            <div class="mt-1 text-2xl font-semibold text-red-900">{{ $expiredCount }}</div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-4">
                            <div class="text-sm font-medium text-gray-600">Out of Stock</div>
                            <div class="mt-1 text-2xl font-semibold text-gray-900">{{ $outOfStockCount }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Generate Reports</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="text-base font-semibold text-gray-800 mb-2">Available Medicines</h4>
                            <p class="text-sm text-gray-500 mb-4">View all medicines that are currently available in stock.</p>
                            <div class="flex gap-2">
                                <a href="{{ route('reports.available') }}">
                                    <x-primary-button>{{ __('View Report') }}</x-primary-button>
                                </a>
                                <a href="{{ route('reports.export', 'available') }}">
                                    <x-secondary-button>{{ __('Export CSV') }}</x-secondary-button>
                                </a>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="text-base font-semibold text-gray-800 mb-2">Expired Medicines</h4>
                            <p class="text-sm text-gray-500 mb-4">View all medicines that have passed their expiration date.</p>
                            <div class="flex gap-2">
                                <a href="{{ route('reports.expired') }}">
                                    <x-primary-button>{{ __('View Report') }}</x-primary-button>
                                </a>
                                <a href="{{ route('reports.export', 'expired') }}">
                                    <x-secondary-button>{{ __('Export CSV') }}</x-secondary-button>
                                </a>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="text-base font-semibold text-gray-800 mb-2">Low Stock Medicines</h4>
                            <p class="text-sm text-gray-500 mb-4">View medicines with quantity of 10 or less.</p>
                            <div class="flex gap-2">
                                <a href="{{ route('reports.low_stock') }}">
                                    <x-primary-button>{{ __('View Report') }}</x-primary-button>
                                </a>
                                <a href="{{ route('reports.export', 'low_stock') }}">
                                    <x-secondary-button>{{ __('Export CSV') }}</x-secondary-button>
                                </a>
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg p-4">
                            <h4 class="text-base font-semibold text-gray-800 mb-2">Full Inventory</h4>
                            <p class="text-sm text-gray-500 mb-4">View the complete medicine inventory with all records.</p>
                            <div class="flex gap-2">
                                <a href="{{ route('reports.inventory') }}">
                                    <x-primary-button>{{ __('View Report') }}</x-primary-button>
                                </a>
                                <a href="{{ route('reports.export', 'inventory') }}">
                                    <x-secondary-button>{{ __('Export CSV') }}</x-secondary-button>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
