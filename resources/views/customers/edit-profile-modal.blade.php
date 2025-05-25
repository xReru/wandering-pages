<div x-show="{{ isset($openBinding) ? $openBinding : 'open' }}" class="fixed inset-0 z-50 flex items-center justify-center bg-white/30 backdrop-blur-[1px]" style="display: none;">
    <div class="bg-[#f6edff] rounded-lg shadow-lg p-8 w-full max-w-2xl relative mt-20">
        <button @click="{{ isset($openBinding) ? $openBinding : 'open' }} = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
        <h2 class="text-lg font-semibold mb-2 text-gray-800">My Profile</h2>
        <p class="text-xs text-gray-500 mb-4">Manage and protect your account</p>
        <form method="POST" action="{{ route('customer.profile.update') }}" enctype="multipart/form-data" class="flex flex-col md:flex-row gap-8">
            @csrf
            @method('POST')
            <div class="flex-1 flex flex-col gap-3">
                <label class="text-sm text-gray-700">Username
                    <input type="text" name="username" value="{{ old('username', Auth::guard('customer')->user()->username) }}" class="w-full border border-gray-500 rounded px-2 py-1 mt-1" placeholder="Username" required />
                </label>
                
                <div class="flex gap-x-2">
                    <div class="flex-1">
                        <label class="text-sm text-gray-700" for="first_name">First Name</label>
                        <input type="text" id="first_name" name="first_name" value="{{ old('first_name', Auth::guard('customer')->user()->first_name) }}" class="w-full border border-gray-500 rounded px-2 py-1 mt-1" placeholder="First Name" required />
                    </div>
                    <div class="flex-1">
                        <label class="text-sm text-gray-700" for="last_name">Last Name</label>
                        <input type="text" id="last_name" name="last_name" value="{{ old('last_name', Auth::guard('customer')->user()->last_name) }}" class="w-full border border-gray-500 rounded px-2 py-1 mt-1" placeholder="Last Name" required />
                    </div>
                </div>
                <label class="text-sm text-gray-700">Email
                    <input type="email" name="email" value="{{ old('email', Auth::guard('customer')->user()->email) }}" class="w-full border border-gray-500 rounded px-2 py-1 mt-1" required />
                </label>
                <label class="text-sm text-gray-700">Phone
                    <input type="text" name="phone_number" value="{{ old('phone_number', Auth::guard('customer')->user()->phone_number) }}" class="w-full border border-gray-500 rounded px-2 py-1 mt-1" required />
                </label>
                <label class="text-sm text-gray-700">Address
                    <textarea name="address" class="w-full border rounded border-gray-500 px-2 py-1 mt-1" required>{{ old('address', Auth::guard('customer')->user()->address) }}</textarea>
                </label>
                <div class="flex gap-4 items-center">
                    <span class="text-sm text-gray-700">Gender</span>
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="female" {{ Auth::guard('customer')->user()->gender == 'female' ? 'checked' : '' }} class="mr-1 accent-[#7464B6]"> Female
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="male" {{ Auth::guard('customer')->user()->gender == 'male' ? 'checked' : '' }} class="mr-1 accent-[#7464B6]"> Male
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="gender" value="other" {{ Auth::guard('customer')->user()->gender == 'other' ? 'checked' : '' }} class="mr-1 accent-[#7464B6]"> Others
                    </label>
                </div>
                <label class="text-sm text-gray-700">Date of Birth
                    <input type="date" name="date_of_birth" value="{{ old('date_of_birth', Auth::guard('customer')->user()->date_of_birth ? Auth::guard('customer')->user()->date_of_birth->format('Y-m-d') : '') }}" class="w-full border border-gray-500 rounded px-2 py-1 mt-1" required />
                </label>
            </div>
            <div class="flex flex-col items-center justify-center w-full md:w-1/3">
                <label class="relative cursor-pointer w-56 h-56 bg-[#e7d6fa] rounded-lg flex flex-col items-center justify-center border-2 border-dashed border-purple-300">
                    @if(Auth::guard('customer')->user()->profile_picture)
                        <img src="{{ asset('storage/' . Auth::guard('customer')->user()->profile_picture) }}" class="w-32 h-32 rounded-full object-cover mb-2" id="profilePreview" />
                    @else
                        <div class="w-32 h-32 rounded-full bg-purple-200 flex items-center justify-center mb-2">
                            <i class="fas fa-user text-6xl text-purple-400"></i>
                        </div>
                    @endif
                    <span class="text-center text-gray-600 text-lg font-semibold">Upload Profile<br>Picture</span>
                    <input type="file" name="profile_picture" class="hidden" accept="image/*" onchange="document.getElementById('profilePreview').src = window.URL.createObjectURL(this.files[0])">
                </label>
            </div>
            <div class="absolute bottom-6 right-8">
                <button type="submit" class="bg-[#7464B6] text-white px-8 py-2 rounded font-semibold hover:bg-[#6454A6] transition">Save</button>
            </div>
        </form>
    </div>
</div>