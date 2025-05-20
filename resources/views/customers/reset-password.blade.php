@extends('layouts.auth')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Reset Your Password
            </h2>
        </div>
        <form class="mt-8 space-y-6" id="resetPasswordForm" method="POST" action="{{ route('customer.password.reset') }}">
            @csrf
            <input type="hidden" name="token" value="{{ request()->query('token') }}">
            <input type="hidden" name="email" value="{{ request()->query('email') }}">
            
            <div class="rounded-md shadow-sm -space-y-px">
                <div>
                    <label for="password" class="sr-only">New Password</label>
                    <input id="password" name="password" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm" placeholder="New Password">
                </div>
                <div>
                    <label for="password_confirmation" class="sr-only">Confirm Password</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" required class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 focus:z-10 sm:text-sm" placeholder="Confirm Password">
                </div>
            </div>

            <!-- Password Requirements -->
            <div class="mt-4 text-sm text-gray-600">
                <p class="font-medium mb-2">Password Requirements:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li class="flex items-center">
                        <span id="length-check" class="text-gray-400 mr-2">•</span>
                        At least 8 characters long
                    </li>
                    <li class="flex items-center">
                        <span id="uppercase-check" class="text-gray-400 mr-2">•</span>
                        Contains at least one uppercase letter
                    </li>
                    <li class="flex items-center">
                        <span id="lowercase-check" class="text-gray-400 mr-2">•</span>
                        Contains at least one lowercase letter
                    </li>
                    <li class="flex items-center">
                        <span id="special-check" class="text-gray-400 mr-2">•</span>
                        Contains at least one special character
                    </li>
                </ul>
            </div>

            <div>
                <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-purple-600 hover:bg-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500">
                    Reset Password
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Password validation function
function validatePassword(password) {
    const checks = {
        length: password.length >= 8,
        uppercase: /[A-Z]/.test(password),
        lowercase: /[a-z]/.test(password),
        special: /[^A-Za-z0-9]/.test(password)
    };

    // Update visual indicators
    document.getElementById('length-check').className = checks.length ? 'text-green-500 mr-2' : 'text-gray-400 mr-2';
    document.getElementById('uppercase-check').className = checks.uppercase ? 'text-green-500 mr-2' : 'text-gray-400 mr-2';
    document.getElementById('lowercase-check').className = checks.lowercase ? 'text-green-500 mr-2' : 'text-gray-400 mr-2';
    document.getElementById('special-check').className = checks.special ? 'text-green-500 mr-2' : 'text-gray-400 mr-2';

    return Object.values(checks).every(Boolean);
}

// Add password validation on input
document.getElementById('password').addEventListener('input', function(e) {
    validatePassword(e.target.value);
});

document.getElementById('resetPasswordForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    const form = e.target;
    const submitButton = form.querySelector('button[type="submit"]');
    const password = form.querySelector('#password').value;
    
    // Validate password before submission
    if (!validatePassword(password)) {
        await Swal.fire({
            icon: 'error',
            title: 'Invalid Password',
            text: 'Please ensure your password meets all the requirements.',
            confirmButtonColor: '#6B46C1'
        });
        return;
    }
    
    submitButton.disabled = true;
    submitButton.innerHTML = 'Resetting...';
    
    try {
        const formData = new FormData(form);
        const response = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                token: formData.get('token'),
                email: formData.get('email'),
                password: formData.get('password'),
                password_confirmation: formData.get('password_confirmation')
            })
        });

        const data = await response.json();

        if (response.ok) {
            await Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: data.success,
                confirmButtonColor: '#6B46C1'
            });
            
            // Redirect to login page
            window.location.href = '{{ route('login') }}';
        } else {
            await Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: data.error || 'An error occurred while resetting your password.',
                confirmButtonColor: '#6B46C1'
            });
            submitButton.disabled = false;
            submitButton.innerHTML = 'Reset Password';
        }
    } catch (error) {
        console.error('Error:', error);
        await Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'An error occurred. Please try again.',
            confirmButtonColor: '#6B46C1'
        });
        submitButton.disabled = false;
        submitButton.innerHTML = 'Reset Password';
    }
});
</script>
@endpush
@endsection 