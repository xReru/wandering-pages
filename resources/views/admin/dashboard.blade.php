@extends('layouts.admin')

@section('header')
    Dashboard
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Books Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-50 rounded-lg p-3">
                            <i class="fas fa-book text-indigo-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Total Books</p>
                            <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Book::count() }}</p>
                        </div>
                    </div>
                </div>
                <div class="border-t border-gray-100 px-4 py-3 sm:px-6">
                    <a href="{{ route('admin.books.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500 transition-colors duration-200">
                        View all books <span aria-hidden="true">&rarr;</span>
                    </a>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-50 rounded-lg p-3">
                            <i class="fas fa-bolt text-blue-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">Quick Actions</p>
                            <div class="mt-2 space-y-2">
                                <a href="{{ route('admin.orders.index') }}" class="block text-sm text-blue-600 hover:text-blue-500 transition-colors duration-200">
                                    <i class="fas fa-plus mr-1"></i> Go to Orders
                                </a>
                                <a href="{{ route('admin.cms.dashboard') }}" class="block text-sm text-blue-600 hover:text-blue-500 transition-colors duration-200">
                                    <i class="fas fa-cogs mr-1"></i> Go to CMS
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Status Card -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition-shadow duration-200">
                <div class="p-4 sm:p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-50 rounded-lg p-3">
                            <i class="fas fa-server text-green-600 text-xl"></i>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500">System Status</p>
                            <div class="mt-2 space-y-2">
                                <div class="flex items-center text-sm">
                                    <span class="h-2 w-2 bg-green-500 rounded-full mr-2"></span>
                                    <span class="text-gray-900">System Online</span>
                                </div>
                                <div class="flex items-center text-sm">
                                    <span class="h-2 w-2 bg-green-500 rounded-full mr-2"></span>
                                    <span class="text-gray-900">Database Connected</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <!-- Top Selling Products Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Top Selling Books</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="topSellingProductsChart" class="w-full h-full"></canvas>
                </div>
            </div>

            <!-- Order Status Breakdown Chart -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-100 p-4 sm:p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Order Status Breakdown</h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="orderStatusChart" class="w-full h-full"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Top Selling Products Chart
            fetch('/admin/dashboard/top-selling-products')
                .then(response => response.json())
                .then(data => {
                    new Chart(document.getElementById('topSellingProductsChart'), {
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Completed Sales',
                                data: data.values,
                                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                borderColor: 'rgba(99, 102, 241, 1)',
                                borderWidth: 2,
                                tension: 0.4,
                                pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                                    titleColor: '#1f2937',
                                    bodyColor: '#4b5563',
                                    borderColor: '#e5e7eb',
                                    borderWidth: 1,
                                    padding: 12,
                                    boxPadding: 6,
                                    usePointStyle: true,
                                    callbacks: {
                                        label: function(context) {
                                            return `Sales: ${context.raw} units`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)'
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        color: '#6b7280'
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        color: '#6b7280'
                                    }
                                }
                            }
                        }
                    });
                });

            // Order Status Breakdown Chart
            fetch('/admin/dashboard/order-status')
                .then(response => response.json())
                .then(data => {
                    new Chart(document.getElementById('orderStatusChart'), {
                        type: 'doughnut',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                data: data.values,
                                backgroundColor: [
                                    'rgba(99, 102, 241, 0.8)',
                                    'rgba(16, 185, 129, 0.8)',
                                    'rgba(245, 158, 11, 0.8)',
                                    'rgba(239, 68, 68, 0.8)'
                                ],
                                borderColor: '#fff',
                                borderWidth: 2
                            }]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        pointStyle: 'circle',
                                        color: '#4b5563'
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(255, 255, 255, 0.9)',
                                    titleColor: '#1f2937',
                                    bodyColor: '#4b5563',
                                    borderColor: '#e5e7eb',
                                    borderWidth: 1,
                                    padding: 12,
                                    boxPadding: 6,
                                    callbacks: {
                                        label: function(context) {
                                            const label = context.label || '';
                                            const value = context.raw || 0;
                                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                            const percentage = Math.round((value / total) * 100);
                                            return `${label}: ${value} (${percentage}%)`;
                                        }
                                    }
                                }
                            },
                            cutout: '70%'
                        }
                    });
                });
        });
    </script>
    @endpush
@endsection 