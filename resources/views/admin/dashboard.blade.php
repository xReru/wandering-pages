@extends('layouts.admin')

@section('header')
    Admin Dashboard
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Books Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <i class="fas fa-book text-white text-2xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Books
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            {{ \App\Models\Book::count() }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('admin.books.index') }}" class="font-medium text-indigo-600 hover:text-indigo-900">
                                View all books
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <i class="fas fa-bolt text-white text-2xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Quick Actions
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <div class="space-y-2">
                                            <a href="{{ route('admin.books.create') }}" class="block text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-plus mr-1"></i> Add New Book
                                            </a>
                                            <a href="{{ route('admin.cms.dashboard') }}" class="block text-blue-600 hover:text-blue-900">
                                                <i class="fas fa-cogs mr-1"></i> Go to CMS
                                            </a>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- System Status Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <i class="fas fa-server text-white text-2xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        System Status
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <div class="space-y-2">
                                            <div class="flex items-center">
                                                <span class="h-2 w-2 bg-green-500 rounded-full mr-2"></span>
                                                <span>System Online</span>
                                            </div>
                                            <div class="flex items-center">
                                                <span class="h-2 w-2 bg-green-500 rounded-full mr-2"></span>
                                                <span>Database Connected</span>
                                            </div>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Top Selling Products Chart -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Top Selling Books</h3>
                    <canvas id="topSellingProductsChart" height="300"></canvas>
                </div>

                <!-- Order Status Breakdown Chart -->
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Order Status Breakdown</h3>
                    <canvas id="orderStatusChart" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        // Fetch and render charts when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            // Top Selling Products Chart
            fetch('/admin/dashboard/top-selling-products')
                .then(response => response.json())
                .then(data => {
                    new Chart(document.getElementById('topSellingProductsChart'), {
                        type: 'bar',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Completed Sales',
                                data: data.values,
                                backgroundColor: 'rgba(75, 192, 75, 0.8)',  // Green color for completed sales
                                borderColor: 'rgba(75, 192, 75, 1)',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            return `Completed Sales: ${context.raw} units`;
                                        }
                                    }
                                }
                            },
                            scales: {
                                y: {
                                    beginAtZero: true,
                                    ticks: {
                                        stepSize: 1
                                    },
                                    title: {
                                        display: true,
                                        text: 'Number of Units Sold'
                                    }
                                },
                                x: {
                                    title: {
                                        display: true,
                                        text: 'Books'
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
                        type: 'pie',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                data: data.values,
                                backgroundColor: data.colors,
                                borderColor: data.colors.map(color => color.replace('0.8', '1')),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'bottom',
                                    labels: {
                                        padding: 20,
                                        usePointStyle: true,
                                        pointStyle: 'circle'
                                    }
                                },
                                tooltip: {
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
                            }
                        }
                    });
                });
        });
    </script>
    @endpush
@endsection 