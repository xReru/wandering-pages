<div x-show="{{ isset($openBinding) ? $openBinding : 'open' }}" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
    <div class="min-h-screen px-4 text-center">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black/40" aria-hidden="true"></div>
        
        <!-- Modal panel -->
        <div class="inline-block w-full max-w-3xl my-20 text-left align-middle transition-all transform bg-white rounded-xl shadow-2xl relative">
            <div class="p-6">
                <button @click="{{ isset($openBinding) ? $openBinding : 'open' }} = false" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-xl transition-colors">&times;</button>
                
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-gray-800">My Profile</h2>
                    <p class="text-sm text-gray-500">Manage and protect your account</p>
                </div>

                <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @csrf
                    @method('POST')
                    
                    <div class="md:col-span-2 space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                <input type="text" name="username" value="{{ old('username', Auth::guard('customer')->user()->username) }}" 
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" 
                                    placeholder="Username" required />
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email" value="{{ old('email', Auth::guard('customer')->user()->email) }}" 
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" 
                                    required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', Auth::guard('customer')->user()->first_name) }}" 
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" 
                                    placeholder="First Name" required />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', Auth::guard('customer')->user()->last_name) }}" 
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" 
                                    placeholder="Last Name" required />
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                                <input type="text" name="phone_number" value="{{ old('phone_number', Auth::guard('customer')->user()->phone_number) }}" 
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" 
                                    required />
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Date of Birth</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', Auth::guard('customer')->user()->date_of_birth ? Auth::guard('customer')->user()->date_of_birth->format('Y-m-d') : '') }}" 
                                    class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" 
                                    required />
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                            <textarea name="address" 
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition" 
                                required>{{ old('address', Auth::guard('customer')->user()->address) }}</textarea>
                        </div>

                        <div class="flex flex-wrap gap-4 items-center">
                            <span class="text-sm font-medium text-gray-700">Gender</span>
                            <div class="flex gap-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="gender" value="female" {{ Auth::guard('customer')->user()->gender == 'female' ? 'checked' : '' }} 
                                        class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500"> 
                                    <span class="ml-2 text-sm text-gray-700">Female</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="gender" value="male" {{ Auth::guard('customer')->user()->gender == 'male' ? 'checked' : '' }} 
                                        class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500"> 
                                    <span class="ml-2 text-sm text-gray-700">Male</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="gender" value="other" {{ Auth::guard('customer')->user()->gender == 'other' ? 'checked' : '' }} 
                                        class="w-4 h-4 text-purple-600 border-gray-300 focus:ring-purple-500"> 
                                    <span class="ml-2 text-sm text-gray-700">Others</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-col items-center justify-start space-y-4">
                        <label class="relative cursor-pointer w-48 h-48 bg-gray-50 rounded-lg flex flex-col items-center justify-center border-2 border-dashed border-gray-300 hover:border-purple-400 transition-colors">
                            @if(Auth::guard('customer')->user()->profile_picture)
                                <img src="{{ asset('storage/' . Auth::guard('customer')->user()->profile_picture) }}" 
                                    class="w-32 h-32 rounded-full object-cover mb-2" id="profilePreview" />
                            @else
                                <div class="w-32 h-32 rounded-full bg-purple-100 flex items-center justify-center mb-2">
                                    <i class="fas fa-user text-5xl text-purple-400"></i>
                                </div>
                            @endif
                            <span class="text-center text-gray-600 text-sm font-medium">Upload Profile<br>Picture</span>
                            <input type="file" name="profile_picture" class="hidden" accept="image/*" 
                                onchange="document.getElementById('profilePreview').src = window.URL.createObjectURL(this.files[0])">
                        </label>
                    </div>

                    <div class="md:col-span-3 flex justify-end mt-4">
                        <button type="submit" 
                            class="bg-purple-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-purple-500 focus:ring-offset-2 transition-colors">
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>