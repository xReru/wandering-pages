<div class="bg-white rounded-lg shadow-md p-8 flex flex-col md:flex-row gap-8 items-center">
    <div class="flex flex-col items-center md:items-start w-full md:w-1/3">
        <div class="relative">
            <div class="w-32 h-32 bg-purple-100 rounded-full flex items-center justify-center">
                <i class="fas fa-user text-6xl text-purple-400"></i>
            </div>
            <span class="absolute top-4 right-2 text-purple-400 text-2xl">
                <i class="fas fa-butterfly"></i>
            </span>
        </div>
    </div>
    <div class="flex-1 w-full">
        <h2 class="text-xl font-semibold mb-4 text-gray-800">My Profile</h2>
        <div class="space-y-2">
            <div><span class="font-medium text-gray-600">Name:</span> {{ Auth::guard('customer')->user()->name }}</div>
            <div><span class="font-medium text-gray-600">Email:</span> {{ Str::mask(Auth::guard('customer')->user()->email, '*', 2, strpos(Auth::guard('customer')->user()->email, '@') - 2) }}</div>
            <div><span class="font-medium text-gray-600">Phone:</span> ********{{ substr(Auth::guard('customer')->user()->phone, -2) }}</div>
            <div><span class="font-medium text-gray-600">Address:</span> {{ Auth::guard('customer')->user()->address }}</div>
            <div><span class="font-medium text-gray-600">Gender:</span> {{ Auth::guard('customer')->user()->gender ?? 'N/A' }}</div>
            <div><span class="font-medium text-gray-600">Date of Birth:</span> ** / ** / {{ Auth::guard('customer')->user()->birth_year ?? '****' }}</div>
            <div><span class="font-medium text-gray-600">Password:</span> ******** <a href="#" class="text-purple-700 text-xs font-semibold ml-2">change</a></div>
        </div>
        <div class="mt-6 text-right">
            <button class="bg-purple-700 text-white px-6 py-2 rounded font-semibold hover:bg-purple-800 transition">Edit Profile</button>
        </div>
    </div>
</div> 