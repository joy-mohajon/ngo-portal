<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'NGO Management System') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- font awesome icons  -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />

    <!-- In your Blade file or layout (e.g., before </head> and before </body>) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>

    <!-- Custom styles -->
    <style>
        /* Fix horizontal scrolling issues */
        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }
        
        /* Responsive table handling */
        @media (max-width: 1024px) {
            table.table-fixed {
                table-layout: fixed;
                width: 100%;
                min-width: 800px; /* Ensure minimum width for content */
            }
        }
        
        /* Project badges wrapping */
        .flex-wrap span {
            margin-bottom: 0.25rem;
            display: inline-block;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        
        /* Prevent overflow on main container */
        main {
            overflow-x: hidden;
        }
        
        /* Make table containers scrollable */
        .overflow-x-auto {
            -webkit-overflow-scrolling: touch;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    <div x-data="{ isOpenSidebar: false }" class="flex min-h-screen bg-gray-100">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main Content -->
        <div class="flex-1 flex flex-col md:ml-64 w-full">
            <!-- Navigation -->
            @include('layouts.navbar')

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto overflow-x-hidden px-3 md:px-6 py-4 bg-[#F5F3EB]">
                {{ $slot }}
            </main>
        </div>
    </div>
</body>

</html>