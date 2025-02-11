<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-cover bg-center"
        style="background-image: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('{{ asset('assets/background/Hero-Banner.png') }}');">
        <div
            class="w-full max-w-md px-4 py-8 bg-white rounded-lg shadow-xl backdrop-blur-sm bg-opacity-90 dark:bg-gray-800">
            <div class="mb-8 text-center">
                <h1
                    class="text-4xl font-bold text-transparent bg-clip-text bg-gradient-to-r from-purple-600 to-blue-500 dark:from-purple-400 dark:to-blue-300">
                    Welcome Back
                </h1>
                <p class="mt-2 text-gray-500 dark:text-gray-400">Please sign in to continue</p>
            </div>

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Email Input -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-medium">Email Address</label>
                    <div class="relative">
                        <span
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207" />
                            </svg>
                        </span>
                        <input type="email" name="email" required
                            class="w-full pl-12 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200 transition-colors duration-300 bg-white dark:bg-gray-700 dark:text-gray-100"
                            placeholder="you@example.com">
                    </div>
                </div>

                <!-- Password Input -->
                <div>
                    <label class="block text-gray-700 dark:text-gray-300 mb-2 font-medium">Password</label>
                    <div class="relative">
                        <span
                            class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400 dark:text-gray-500">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </span>
                        <input type="password" name="password" id="password-input" required
                            class="w-full pl-12 pr-4 py-3 rounded-lg border-2 border-gray-200 dark:border-gray-600 focus:border-purple-500 focus:outline-none focus:ring-2 focus:ring-purple-200 transition-colors duration-300 bg-white dark:bg-gray-700 dark:text-gray-100"
                            placeholder="••••••••">
                        <button type="button" id="toggle-password"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-purple-500">
                            <svg id="eye-icon" class="w-6 h-6" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-slash-icon" class="w-6 h-6 hidden" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0012 19.5c-.47.0-.943-.01-.732-.182 1.082-1.077 2.174-2.121 3.231-3.112 1.046-1.007 2.079-2.035 3.08-3.082.104-.106.207-.215.304-.326a10.114 10.114 0 00-2.553 1.213m-2.756 2.756a10.178 10.178 0 01-2.756-2.756M3.5 15.834C4.226 15.503 5.474 15 6.906 15a24.21 24.21 0 011.146-.104m-1.611 0L6.906 15m-1.611 0c.418-.123.839-.234 1.265-.333A11.343 11.343 0 018 13.875m-1.575-.333A10.034 10.034 0 005.775 12a10.06 10.06 0 00-1.955-2.023M18.45 9.575c.773.495 1.453 1.095 1.997 1.767m-2.684 3.233a9.95 9.95 0 01-1.085-1.05c.03-.054.045-.109.054-.162m-10.738 7.802c.187.186.283.416.283.654 0 .238-.096.468-.283.654m.14-.144a9.979 9.979 0 01-1.939 1.174m0 0a12.02 12.02 0 01-3.528.848m-.868-.284c.167.084.33.154.5.214m1.522-.214c.006-.001.013-.002.019-.003m.051.003a9.995 9.995 0 01-1.437-.804M12 2.25c-5.304 0-9.75 4.446-9.75 9.75s4.446 9.75 9.75 9.75 9.75-4.446 9.75-9.75S17.304 2.25 12 2.25z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <script>
                    const passwordInput = document.getElementById('password-input');
                    const togglePasswordButton = document.getElementById('toggle-password');
                    const eyeIcon = document.getElementById('eye-icon');
                    const eyeSlashIcon = document.getElementById('eye-slash-icon');

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
                </script>

                <!-- Remember & Forgot Password -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center space-x-2">
                        <input type="checkbox" name="remember"
                            class="w-5 h-5 text-purple-600 rounded focus:ring-purple-500 border-gray-300 dark:border-gray-600">
                        <span class="text-gray-600 dark:text-gray-400">Remember me</span>
                    </label>
                    <a href="#" class="text-purple-600 hover:text-purple-700 font-medium">Forgot Password?</a>
                </div>

                <!-- Login Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-purple-600 to-blue-500 hover:from-purple-700 hover:to-blue-600 text-white font-medium py-3 rounded-lg transition-all duration-300 transform hover:scale-[1.01] shadow-lg">
                    Sign In
                </button>


                <!-- Registration Link -->
                <p class="text-center text-gray-600 dark:text-gray-400">
                    Don't have an account?
                    <a href="{{ route('register') }}" class="text-purple-600 hover:text-purple-700 font-medium">Sign
                        up</a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
