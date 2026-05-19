<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Medicine Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                        <h3 class="text-lg font-medium text-gray-900">{{ $medicine->name }}</h3>
                        <div class="flex gap-2">
                            <a href="{{ route('medicines.edit', $medicine) }}">
                                <x-secondary-button>{{ __('Edit') }}</x-secondary-button>
                            </a>
                            <a href="{{ route('medicines.index') }}">
                                <x-secondary-button>{{ __('Back to List') }}</x-secondary-button>
                            </a>
                        </div>
                    </div>

                    <div class="border-t border-gray-200 py-4">
                        <dl class="grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-6">
                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Medicine Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $medicine->name }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Generic Name</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $medicine->generic_name }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Category</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $medicine->category }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Quantity</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $medicine->quantity }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Expiration Date</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $medicine->expiration_date->format('F d, Y') }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Price</dt>
                                <dd class="mt-1 text-sm text-gray-900">${{ number_format($medicine->price, 2) }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Status</dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    @php
                                        $statusColors = [
                                            'available' => 'bg-green-100 text-green-800',
                                            'low_stock' => 'bg-yellow-100 text-yellow-800',
                                            'expired' => 'bg-red-100 text-red-800',
                                            'out_of_stock' => 'bg-gray-100 text-gray-800',
                                        ];
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusColors[$medicine->status] ?? 'bg-gray-100 text-gray-800' }}">
                                        {{ ucwords(str_replace('_', ' ', $medicine->status)) }}
                                    </span>
                                </dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Created At</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $medicine->created_at->format('F d, Y H:i') }}</dd>
                            </div>

                            <div class="sm:col-span-1">
                                <dt class="text-sm font-medium text-gray-500">Last Updated</dt>
                                <dd class="mt-1 text-sm text-gray-900">{{ $medicine->updated_at->format('F d, Y H:i') }}</dd>
                            </div>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
