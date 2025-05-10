<section class="bg-white py-16 px-4">
    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between gap-8">
        <div class="md:w-1/2 mb-8 md:mb-0">
            <h2 class="text-4xl font-bold text-gray-900 mb-2">Want book news and updates?</h2>
            <p class="text-2xl font-semibold text-gray-800">Sign up for our newsletter.</p>
        </div>
        @if(session('success'))
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'success',
                        title: 'Subscribed!',
                        text: '{{ session('success') }}',
                        confirmButtonColor: '#7c3aed',
                        timer: 1000,
                        showConfirmButton: false
                    });
                });
            </script>
        @endif
        @if($errors->any())
            <div class="mb-4 text-red-600 font-semibold">
                {{ $errors->first('email') }}
            </div>
        @endif
        <form class="md:w-1/2 flex flex-col items-start md:items-end" method="POST" action="{{ route('newsletter.subscribe') }}">
            @csrf
            <div class="flex w-full max-w-md">
                <input type="email" name="email" required placeholder="Enter your email" class="flex-grow px-4 py-3 rounded-l-md border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-400 text-lg" />
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white font-bold px-8 py-3 rounded-r-md transition">Subscribe</button>
            </div>
            <p class="mt-3 text-sm text-gray-600">We care about your data. Read our <a href="#" class="text-purple-600 hover:underline">privacy policy</a>.</p>
        </form>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 