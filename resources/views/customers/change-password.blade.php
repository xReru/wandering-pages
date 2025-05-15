<!-- Change Password Modal -->
<div x-show="openChangePassword" class="fixed inset-0 z-50 flex items-center justify-center bg-white/30 backdrop-blur-[1px]" style="display: none;">
        <div class="bg-[#f6edff] rounded-lg shadow-lg p-8 w-full max-w-md relative">
            <button @click="openChangePassword = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
            <h2 class="text-lg font-semibold mb-2 text-gray-800">Change Password</h2>
            <p class="text-xs text-gray-500 mb-4">Update your account password</p>
            <form @submit.prevent="changePasswordLoading = true; changePasswordError = ''; changePasswordSuccess = ''; fetch('{{ route('customer.password.change') }}', { method: 'POST', headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]').getAttribute('content') }, body: JSON.stringify({ current_password, new_password, new_password_confirmation }) }).then(async r => { const data = await r.json(); changePasswordLoading = false; if(r.ok && data.success){ changePasswordSuccess = data.success; setTimeout(() => { openChangePassword = false; changePasswordSuccess = ''; }, 1500); current_password = ''; new_password = ''; new_password_confirmation = ''; } else { changePasswordError = data.error || 'An error occurred.'; } }).catch(() => { changePasswordLoading = false; changePasswordError = 'An error occurred.'; })">
                <div class="flex flex-col gap-3">
                    <label class="text-sm text-gray-700">Current Password
                        <input type="password" x-model="current_password" class="w-full border rounded px-2 py-1 mt-1" required />
                    </label>
                    <label class="text-sm text-gray-700">New Password
                        <input type="password" x-model="new_password" class="w-full border rounded px-2 py-1 mt-1" required />
                    </label>
                    <label class="text-sm text-gray-700">Confirm New Password
                        <input type="password" x-model="new_password_confirmation" class="w-full border rounded px-2 py-1 mt-1" required />
                    </label>
                    <template x-if="changePasswordError">
                        <div class="text-red-600 text-xs mt-1" x-text="changePasswordError"></div>
                    </template>
                    <template x-if="changePasswordSuccess">
                        <div class="text-green-600 text-xs mt-1" x-text="changePasswordSuccess"></div>
                    </template>
                </div>
                <div class="mt-6 text-right">
                    <button type="submit" class="bg-purple-700 text-white px-8 py-2 rounded font-semibold hover:bg-purple-800 transition" :disabled="changePasswordLoading">
                        <span x-show="!changePasswordLoading">Save</span>
                        <span x-show="changePasswordLoading">Saving...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div> 