@extends('layouts.admin')

@section('header')
    Admin Dashboard
@endsection

@section('content')
    <div class="space-y-6">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6">
            <!-- Books Card -->
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-indigo-500 rounded-lg p-3">
                            <i class="fas fa-book text-white text-xl sm:text-2xl"></i>
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
                <div class="bg-gray-50 px-5 py-3 rounded-b-lg">
                    <div class="text-sm">
                        <a href="{{ route('admin.books.index') }}" class="font-medium text-indigo-600 hover:text-indigo-900 flex items-center">
                            View all books
                            <i class="fas fa-arrow-right ml-2 text-xs"></i>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Actions Card -->
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-500 rounded-lg p-3">
                            <i class="fas fa-bolt text-white text-xl sm:text-2xl"></i>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 truncate">
                                    Quick Actions
                                </dt>
                                <dd class="mt-1 text-sm text-gray-900">
                                    <div class="space-y-2">
                                        <a href="{{ route('admin.books.create') }}" class="block text-blue-600 hover:text-blue-900 transition-colors duration-200">
                                            <i class="fas fa-plus mr-1"></i> Add New Book
                                        </a>
                                        <a href="{{ route('admin.cms.dashboard') }}" class="block text-blue-600 hover:text-blue-900 transition-colors duration-200">
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
            <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-500 rounded-lg p-3">
                            <i class="fas fa-server text-white text-xl sm:text-2xl"></i>
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
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 sm:gap-6">
            <!-- Top Selling Products Chart -->
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-line mr-2 text-indigo-500"></i>
                    Top Selling Books
                </h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="topSellingProductsChart"></canvas>
                </div>
            </div>

            <!-- Order Status Breakdown Chart -->
            <div class="bg-white p-4 sm:p-6 rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                    <i class="fas fa-chart-pie mr-2 text-indigo-500"></i>
                    Order Status Breakdown
                </h3>
                <div class="relative" style="height: 300px;">
                    <canvas id="orderStatusChart"></canvas>
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
                        type: 'line',
                        data: {
                            labels: data.labels,
                            datasets: [{
                                label: 'Completed Sales',
                                data: data.values,
                                backgroundColor: 'rgba(99, 102, 241, 0.1)',
                                borderColor: 'rgba(99, 102, 241, 1)',
                                borderWidth: 2,
                                pointBackgroundColor: 'rgba(99, 102, 241, 1)',
                                pointBorderColor: '#fff',
                                pointBorderWidth: 2,
                                pointRadius: 4,
                                pointHoverRadius: 6,
                                tension: 0.4
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
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    padding: 12,
                                    titleFont: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    bodyFont: {
                                        size: 13
                                    },
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
                                    grid: {
                                        color: 'rgba(0, 0, 0, 0.05)'
                                    },
                                    ticks: {
                                        stepSize: 1,
                                        font: {
                                            size: 12
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Number of Units Sold',
                                        font: {
                                            size: 13,
                                            weight: 'bold'
                                        }
                                    }
                                },
                                x: {
                                    grid: {
                                        display: false
                                    },
                                    ticks: {
                                        font: {
                                            size: 12
                                        }
                                    },
                                    title: {
                                        display: true,
                                        text: 'Books',
                                        font: {
                                            size: 13,
                                            weight: 'bold'
                                        }
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
                                        font: {
                                            size: 12
                                        }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                                    padding: 12,
                                    titleFont: {
                                        size: 14,
                                        weight: 'bold'
                                    },
                                    bodyFont: {
                                        size: 13
                                    },
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