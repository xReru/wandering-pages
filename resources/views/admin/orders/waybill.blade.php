<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Waybill - {{ $order->transaction_no }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            .no-print {
                display: none !important;
            }
            body {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .page-break {
                page-break-before: always;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
    <!-- Print Controls - Only visible on screen -->
    <div class="no-print fixed top-4 right-4 z-50">
        <button onclick="window.print()" class="px-4 py-2 bg-purple-600 text-white rounded-md hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2">
            Print Waybill
        </button>
        <a href="{{ route('admin.orders.show', $order) }}" class="ml-4 px-4 py-2 bg-gray-600 text-white rounded-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
            Back to Order
        </a>
    </div>

    <!-- Waybill Content -->
    <div class="max-w-4xl mx-auto bg-white p-8 my-8 shadow-lg">
        <!-- Header Section -->
        <div class="border-b pb-6 mb-6">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800">Wandering Pages</h2>
                    <p class="text-gray-600">Book Store & Publishing</p>
                </div>
                <div class="text-right">
                    <h3 class="text-lg font-semibold">Waybill #{{ $order->transaction_no }}</h3>
                    <p class="text-gray-600">Date: {{ $order->created_at->format('M d, Y') }}</p>
                    <!-- Barcode Section -->
                    <div class="mt-4">
                        <img src="data:image/png;base64,{{ DNS1D::getBarcodePNG($order->transaction_no, 'C128', 2, 50) }}" 
                             alt="Barcode"
                             class="mx-auto">
                        <p class="text-xs text-center mt-1">{{ $order->transaction_no }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <!-- From Address -->
            <div>
                <h3 class="text-lg font-semibold mb-2">From:</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="font-medium">Wandering Pages</p>
                    <p>123 Book Street</p>
                    <p>Reading City, RC 1234</p>
                    <p>Phone: (123) 456-7890</p>
                </div>
            </div>

            <!-- To Address -->
            <div>
                <h3 class="text-lg font-semibold mb-2">To:</h3>
                <div class="bg-gray-50 p-4 rounded-lg">
                    <p class="font-medium">{{ $order->user->full_name }}</p>
                    <p>{{ $order->shipping_address }}</p>
                    <p>Phone: {{ $order->user->phone_number }}</p>
                    <p>Email: {{ $order->user->email }}</p>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="mb-8">
            <h3 class="text-lg font-semibold mb-4">Order Details</h3>
            <div class="border rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($order->items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->book->title }}</div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $item->quantity }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($item->price_at_time_of_order, 2) }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${{ number_format($item->price_at_time_of_order * $item->quantity, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Shipping Information -->
        <div class="grid grid-cols-2 gap-8 mb-8">
            <div>
                <h3 class="text-lg font-semibold mb-2">Shipping Method</h3>
                <p class="text-gray-600">{{ ucfirst($order->shipping_method) }}</p>
            </div>
            <div>
                <h3 class="text-lg font-semibold mb-2">Payment Method</h3>
                <p class="text-gray-600">{{ $order->payment_method }}</p>
            </div>
        </div>

        <!-- Total Section -->
        <div class="border-t pt-4">
            <div class="flex justify-end">
                <div class="w-64">
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Subtotal:</span>
                        <span>${{ number_format($order->total_amount - $order->shipping_fee, 2) }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span class="text-gray-600">Shipping Fee:</span>
                        <span>${{ number_format($order->shipping_fee, 2) }}</span>
                    </div>
                    <div class="flex justify-between font-semibold text-lg pt-2 border-t">
                        <span>Total:</span>
                        <span>${{ number_format($order->total_amount, 2) }}</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Section -->
        <div class="mt-12 pt-6 border-t">
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Special Instructions</h3>
                    <p class="text-gray-600">Handle with care. Books are fragile items.</p>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Tracking Information</h3>
                    <p class="text-gray-600">Tracking number will be updated once shipped.</p>
                </div>
            </div>
        </div>

        <!-- Signature Section -->
        <div class="mt-12 pt-6 border-t">
            <div class="grid grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-semibold mb-2">Sender's Signature</h3>
                    <div class="border-t border-gray-300 mt-8 pt-2">
                        <p class="text-sm text-gray-600">Date: _________________</p>
                    </div>
                </div>
                <div>
                    <h3 class="text-lg font-semibold mb-2">Receiver's Signature</h3>
                    <div class="border-t border-gray-300 mt-8 pt-2">
                        <p class="text-sm text-gray-600">Date: _________________</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 