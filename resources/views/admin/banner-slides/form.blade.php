@extends('layouts.admin')

@section('header')
    {{ isset($slide) ? 'Edit Banner Slide' : 'Add New Banner Slide' }}
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <form action="{{ isset($slide) ? route('admin.banner-slides.update', $slide) : route('admin.banner-slides.store') }}" method="POST" class="space-y-6">
                @csrf
                @if(isset($slide))
                    @method('PUT')
                @endif

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Book Selection -->
                    <div class="md:col-span-2">
                        <label for="book_id" class="block text-sm font-medium text-gray-700">Select Book</label>
                        <select name="book_id" id="book_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="">Select a book</option>
                            @foreach($books as $book)
                                <option value="{{ $book->id }}" {{ (old('book_id', $slide->book_id ?? '') == $book->id) ? 'selected' : '' }}>
                                    {{ $book->title }} by {{ $book->author }}
                                </option>
                            @endforeach
                        </select>
                        @error('book_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Type -->
                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Type</label>
                        <select name="type" id="type" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="new_release" {{ (old('type', $slide->type ?? '') === 'new_release') ? 'selected' : '' }}>New Release</option>
                            <option value="bestseller" {{ (old('type', $slide->type ?? '') === 'bestseller') ? 'selected' : '' }}>Bestseller</option>
                            <option value="coming_soon" {{ (old('type', $slide->type ?? '') === 'coming_soon') ? 'selected' : '' }}>Coming Soon</option>
                        </select>
                        @error('type')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                            <option value="active" {{ (old('status', $slide->status ?? '') === 'active') ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ (old('status', $slide->status ?? '') === 'inactive') ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Order -->
                    <div>
                        <label for="order" class="block text-sm font-medium text-gray-700">Display Order</label>
                        <input type="number" name="order" id="order" value="{{ old('order', $slide->order ?? 0) }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('order')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.banner-slides.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        Cancel
                    </a>
                    <button type="submit" class="bg-indigo-600 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        {{ isset($slide) ? 'Update Slide' : 'Create Slide' }}
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection 