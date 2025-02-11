<footer
    class="bg-gradient-to-br from-gray-50 to-gray-200 dark:from-gray-900 dark:to-gray-800 py-8 px-6 rounded-xl shadow-lg">
    <div class="container mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 items-center">
            <div class="text-sm text-gray-700 dark:text-gray-300 font-medium">
                © {{ date('Y') }} All rights reserved.
            </div>
            <div class="text-sm text-gray-400 font-medium text-right space-x-3">
                <span>
                    Made with
                </span>
                <span class="text-red-400 inline-flex items-center justify-center glow">
                    <x-heroicon-s-heart class="w-5 h-5" />
                </span>
                <span>
                    by
                </span>
                <a href="https://github.com/DEVCODEFAISHOL" target="_blank"
                    class="text-cyan-400 hover:text-cyan-300 hover:underline transition-colors duration-200">
                    Faishol Coding
                </a>
            </div>
        </div>
    </div>
    <style>
        .glow {
            text-shadow: 0 0 5px rgba(255, 255, 255, 0.3);
            /* Bayangan teks putih tipis */
        }

        .glow>svg {
            filter: drop-shadow(0 0 3px rgba(255, 0, 0, 0.7));
            /* Efek glow merah pada ikon */
        }

        .text-cyan-400 {
            color: #22d3ee;
            /* Cyan-400 */
        }

        .hover\:text-cyan-300:hover {
            color: #38bdf8;
            /* Cyan-300 */
        }
    </style>
</footer>
