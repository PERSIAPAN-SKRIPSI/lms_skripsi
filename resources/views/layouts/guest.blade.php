<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <meta name="csrf-token" content="{{ csrf_token() }}">

   <title>{{ config('app.name', 'Laravel') }}</title>

   <!-- Fonts -->
   <link href="https://fonts.bunny.net" rel="preconnect">
   <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

   <!-- Styles -->
   @vite(['resources/css/app.css', 'resources/js/app.js'])

   <!-- Notify CSS -->
   <link href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css" rel="stylesheet">
   <style>
      [x-cloak] {
         display: none !important;
      }
   </style>
</head>

<body>
   <div class="font-sans antialiased" x-data="mainState" :class="{ dark: isDarkMode }" x-cloak>
      <div class="flex flex-col min-h-screen text-gray-900 bg-gray-100 dark:bg-dark-bg dark:text-gray-200">
         {{ $slot }}

         <x-footer />
      </div>

      <!-- Notifikasi akan muncul di sini -->
      <div class="notify-container fixed top-5 right-5 z-50 w-80"></div>

      <div class="fixed top-10 right-10">
         <x-button type="button" iconOnly variant="secondary" srText="Toggle dark mode" @click="toggleTheme">
            <x-heroicon-o-moon class="w-6 h-6" aria-hidden="true" x-show="!isDarkMode" />
            <x-heroicon-o-sun class="w-6 h-6" aria-hidden="true" x-show="isDarkMode" />
         </x-button>
      </div>
   </div>

   <!-- Script Notifikasi -->
   <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

   <script>
      // Inisialisasi Notyf dengan konfigurasi custom
      const notyf = new Notyf({
         position: {
            x: 'right',
            y: 'top',
            container: document.querySelector('.notify-container')
         },
         types: [{
               type: 'success',
               background: '#10B981',
               icon: false
            },
            {
               type: 'error',
               background: '#EF4444',
               icon: false
            }
         ]
      });

      // Notifikasi sukses
      @if (session('success'))
         notyf.success('{{ session('success') }}');
      @endif

      // Notifikasi error
      @if (session('error'))
         notyf.error('{{ session('error') }}');
      @endif

      // Notifikasi error validasi
      @if ($errors->any())
         @foreach ($errors->all() as $error)
            notyf.error('{{ $error }}');
         @endforeach
      @endif
   </script>
</body>

</html>
