<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title')</title>
    @livewireStyles
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500&family=Quicksand:wght@300;400;500;600&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: lightgray;
            font-family: 'Quicksand', sans-serif;
        }
    </style>

    @livewireScripts
</head>
<body>
    <div>
        <nav class="bg-gray-800 text-white">
            <div class="container mx-auto flex justify-between items-center p-4">
                <a href="/kategori" wire:navigate class="text-lg">Kategori</a>
                <a href="/products" wire:navigate class="text-lg">Product</a>
                <a href="/transaksi" wire:navigate class="text-lg">Transaksi</a>
                <button class="navbar-toggler text-white" type="button" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="hidden md:flex md:items-center">
                    <a href="https://bukannezon.github.io/company-profile-tailwind/" target="_blank" class="bg-green-500 hover:bg-green-600 text-white py-2 px-4 rounded">BukanNezon</a>
                </div>
            </div>
        </nav>
    </div>
    
    {{ $slot }}

    <x-layouts.sweet-alert />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    @stack('script')
</body>
</html>
