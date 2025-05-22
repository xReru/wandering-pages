<head>
    @vite('resources/css/app.css')
</head>
<section class="bg-[#d7d6ff] py-12 sm:py-16 lg:py-20 px-4 sm:px-6 lg:px-8">
    <div class="container mx-auto max-w-7xl">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            <!-- Newsletter Content -->
            <div class="text-center lg:text-left space-y-4">
                <h2 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-[#191B29] font-primary leading-tight">
                    Don't Miss a Page!
                </h2>
                <p class="text-xl sm:text-2xl text-gray-800 font-primary">
                    Sign up for our newsletter.
                </p>
            </div>

            <!-- Newsletter Form -->
            <div class="w-full max-w-xl mx-auto lg:mx-0">
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
                    <div class="mb-4 text-red-600 font-semibold text-center lg:text-left">
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('newsletter.subscribe') }}" class="space-y-4">
                    @csrf
                    <div class="flex flex-col sm:flex-row gap-3">
                        <div class="flex-grow">
                            <input 
                                type="email" 
                                name="email" 
                                required 
                                placeholder="Enter your email" 
                                class="w-full px-4 py-3 rounded-lg sm:rounded-r-none bg-white border border-gray-300 focus:outline-none focus:ring-2 focus:ring-purple-400 text-base sm:text-lg transition-shadow duration-200"
                            />
                        </div>
                        <button 
                            type="submit" 
                            class="w-full sm:w-auto bg-[#7464B6] hover:bg-[#6354A0] text-white font-bold px-6 sm:px-8 py-3 rounded-lg sm:rounded-l-none transition-all duration-200 transform hover:scale-[1.02] active:scale-[0.98] shadow-sm hover:shadow-md"
                        >
                            Subscribe
                        </button>
                    </div>
                    <p class="text-sm text-gray-600 text-center lg:text-left">
                        We care about your data. Read our 
                        <a href="#" class="text-[#774DD9git] hover:text-[#54339F] hover:underline transition-colors duration-200">
                            privacy policy
                        </a>.
                    </p>
                </form>
            </div>
        </div>
    </div>
</section>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 