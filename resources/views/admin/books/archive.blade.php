@extends('layouts.admin')

@section('header')
    Archived Books
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <!-- Archived Books Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Author</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Genre</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Archived At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($archivedBooks as $book)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $book->title }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $book->author }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $book->genre }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">${{ number_format($book->price, 2) }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $book->quantity }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $book->archived_at->format('M d, Y H:i') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <form action="{{ route('admin.books.restore', $book) }}" method="POST" class="inline" id="restore-form-{{ $book->id }}">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" 
                                            onclick="confirmRestore('{{ $book->title }}', {{ $book->id }})" 
                                            class="text-green-600 hover:text-green-900 mr-3">
                                            <i class="fas fa-undo"></i> Restore
                                        </button>
                                    </form>
                                    <form action="{{ route('admin.books.permanent-delete', $book) }}" method="POST" class="inline" id="delete-form-{{ $book->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" 
                                            onclick="confirmPermanentDelete('{{ $book->title }}', {{ $book->id }})" 
                                            class="text-red-600 hover:text-red-900">
                                            <i class="fas fa-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">No archived books found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $archivedBooks->links() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    function confirmRestore(bookTitle, bookId) {
        Swal.fire({
            title: 'Restore Book',
            html: `Are you sure you want to restore <strong>${bookTitle}</strong> to the inventory?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#22c55e',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, restore it',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`restore-form-${bookId}`).submit();
            }
        });
    }

    function confirmPermanentDelete(bookTitle, bookId) {
        Swal.fire({
            title: 'Permanent Delete',
            html: `
                <div class="text-left">
                    <p class="mb-4">Are you sure you want to <strong class="text-red-600">permanently delete</strong> <strong>${bookTitle}</strong>?</p>
                    <p class="text-sm text-gray-600">This action cannot be undone. All data associated with this book will be permanently removed.</p>
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Yes, delete permanently',
            cancelButtonText: 'Cancel',
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${bookId}`).submit();
            }
        });
    }
</script>
@endpush 