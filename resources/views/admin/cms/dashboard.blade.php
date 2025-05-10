@extends('layouts.admin')

@section('header')
    Content Management System
@endsection

@section('content')
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                <!-- Genres Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <i class="fas fa-tags text-white text-2xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Total Genres
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            {{ \App\Models\Genre::count() }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('admin.genres.index') }}" class="font-medium text-green-600 hover:text-green-900">
                                Manage Genres
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Banner Slides Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <i class="fas fa-images text-white text-2xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Banner Slides
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            {{ \App\Models\BannerSlide::count() }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('admin.banner-slides.index') }}" class="font-medium text-purple-600 hover:text-purple-900">
                                Manage Banner Slides
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-indigo-500 rounded-md p-3">
                                <i class="fas fa-bolt text-white text-2xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Quick Actions
                                    </dt>
                                    <dd class="mt-1 text-sm text-gray-900">
                                        <div class="space-y-2">
                                            <a href="{{ route('admin.genres.create') }}" class="block text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-plus mr-1"></i> Add New Genre
                                            </a>
                                            <a href="{{ route('admin.banner-slides.create') }}" class="block text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-plus mr-1"></i> Add New Banner
                                            </a>
                                            <a href="{{ route('admin.bulk-email.index') }}" class="block text-indigo-600 hover:text-indigo-900">
                                                <i class="fas fa-envelope mr-1"></i> Send Bulk Email
                                            </a>
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Newsletter Stats Card -->
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <i class="fas fa-envelope text-white text-2xl"></i>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 truncate">
                                        Newsletter Subscribers
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900">
                                            {{ \App\Models\NewsletterSubscriber::count() }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-5 py-3">
                        <div class="text-sm">
                            <a href="{{ route('admin.bulk-email.index') }}" class="font-medium text-blue-600 hover:text-blue-900">
                                Manage Newsletter
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 