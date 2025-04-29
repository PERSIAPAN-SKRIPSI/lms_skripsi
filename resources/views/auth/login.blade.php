<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('assets/background/Hero-Banner.png') }}');">
        <div class="w-full max-w-md px-4 py-8 bg-white rounded-lg shadow-xl backdrop-blur-sm bg-opacity-90 dark:bg-gray-800">

            <div class="mb-8 text-center">
                <h1
                    class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-500 dark:from-purple-400 dark:to-blue-300">
                    Selamat Datang Kembali
                </h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Silakan masuk untuk melanjutkan</p>
            </div>

            <form class="space-y-6" method="POST" action="{{ route('login') }}">
                @csrf

                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-medium" for="email">Alamat Email</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </span>
                        <input
                            class="w-full pl-12 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200 transition-colors duration-300 bg-white dark:bg-gray-700 dark:text-gray-100 @error('email') border-red-500 @enderror"
                            id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                            placeholder="you@example.com">
                    </div>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-medium" for="password-input">Password</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input
                            class="w-full pl-12 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200 transition-colors duration-300 bg-white dark:bg-gray-700 dark:text-gray-100 @error('password') border-red-500 @enderror"
                            id="password-input" name="password" type="password" required placeholder="••••••••">
                        <button
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-purple-500"
                            id="toggle-password" type="button" aria-label="Toggle password visibility">
                            <!-- Eye icon for show password -->
                            <svg class="w-6 h-6" id="eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Eye slash icon for hide password (hidden by default) -->
                            <svg class="w-6 h-6 hidden" id="eye-slash-icon" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Remember & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2 cursor-pointer group">
                        <div class="relative">
                            <input
                                class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500 border-gray-300 dark:border-gray-600 transition-colors duration-200 ease-in-out"
                                id="remember_me" name="remember" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                            <div
                                class="absolute inset-0 bg-purple-100 rounded opacity-0 group-hover:opacity-20 transition-opacity duration-200">
                            </div>
                        </div>
                        <span
                            class="text-gray-600 dark:text-gray-400 group-hover:text-purple-700 dark:group-hover:text-purple-300 transition-colors duration-200">Ingat
                            saya</span>
                    </label>
                    <a class="text-purple-600 hover:text-purple-700 font-medium transition-colors duration-200 hover:underline"
                        href="{{ route('password.request') }}">Lupa Password?</a>
                </div>

                <!-- Login Button -->
                <button
                    class="w-full bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 text-white font-medium py-3 rounded-lg transition-all duration-300 transform hover:scale-[1.01] shadow-lg focus:outline-none focus:ring-2 focus:ring-purple-400 focus:ring-opacity-50 relative overflow-hidden"
                    type="submit" id="login-button">
                    <span id="button-text">Masuk</span>
                    <div id="loading-spinner"
                        class="absolute top-0 left-0 w-full h-full flex items-center justify-center bg-opacity-50 bg-gray-100 dark:bg-gray-700 hidden">
                        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                            </path>
                        </svg>
                    </div>
                </button>

                <!-- Registration Link -->
                <p class="text-center text-gray-600 dark:text-gray-400">
                    Belum punya akun?
                    <a class="text-purple-600 hover:text-purple-700 font-medium hover:underline transition-colors duration-200"
                        href="{{ route('register') }}">Daftar</a>
                </p>
            </form>

            <!-- Remember Me Information -->
            <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="text-xs text-gray-500 dark:text-gray-400 text-center">
                    <p>Dengan memilih "Ingat saya", Anda akan tetap masuk selama 30 hari atau sampai Anda keluar.</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            const togglePasswordButton = document.querySelector('#toggle-password');
            const passwordInput = document.querySelector('#password-input');
            const eyeIcon = document.querySelector('#eye-icon');
            const eyeSlashIcon = document.querySelector('#eye-slash-icon');
            const loginButton = document.querySelector('#login-button');
            const buttonText = document.querySelector('#button-text');
            const loadingSpinner = document.querySelector('#loading-spinner');

            togglePasswordButton.addEventListener('click', function() {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    eyeIcon.classList.add('hidden');
                    eyeSlashIcon.classList.remove('hidden');
                } else {
                    passwordInput.type = 'password';
                    eyeIcon.classList.remove('hidden');
                    eyeSlashIcon.classList.add('hidden');
                }
            });

            loginButton.addEventListener('click', function() {
                buttonText.style.display = 'none';
                loadingSpinner.classList.remove('hidden');
            });
        </script>
    @endpush
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                icon: 'success',
                timer: 2000,
                showConfirmButton: false
            });
        </script>
    @endif
</x-guest-layout>
