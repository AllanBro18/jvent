<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> <?= esc($title) ?> </title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- tailwind -->
    <link rel="stylesheet" href="<?= base_url('assets/css/styles.css') ?>">
    
</head>
<style type="">
    * {
    }
</style>
<body class="bg-primary font-inter">
    <!-- Header -->
    <header class="bg-gradient-to-br from-secondary-main via-primary to-secondary-main px-4 md:px-8 py-4 flex flex-col md:flex-row md:justify-between md:items-center space-y-2 md:space-y-0">
        <!-- Logo + Searchbar Grid on Mobile -->
        <div class="w-full grid grid-cols-1 gap-2 md:flex md:items-center md:w-auto md:gap-0 md:space-x-6">
        <!-- Logo -->
        <div class="text-3xl text-secondary-second font-bold text-center md:text-left">Jvent</div>

        <!-- Search bar (selalu tampil) -->
        <div class="flex items-center bg-gray-200 px-3 py-1 rounded-md w-full md:w-[400px]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" />
            </svg>
            <input type="text" placeholder="Cari event disini" class="bg-transparent outline-none w-full text-base text-gray-600">
        </div>
        </div>

        <!-- Desktop Menu -->
        <nav class="hidden md:flex items-center space-x-4">
        <a href="#" class="flex items-center space-x-1 text-md text-white hover:text-secondary-second">
            <svg class="h-5 w-5 text-secondary-second" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3M16 7V3M4 11h16M4 19h16M4 15h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Buat Event</span>
        </a>
        <a href="/events" class="flex items-center space-x-1 text-md text-white hover:text-secondary-second">
            <svg class="h-5 w-5 text-secondary-second" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Jelajah</span>
        </a>
        <button class="border border-blue-500 text-blue-500 px-4 py-1 rounded-full hover:bg-blue-100">Sign In</button>
        </nav>

        <!-- Hamburger -->
        <button id="hamburger" class="md:hidden absolute top-4 right-4">
        <svg class="w-6 h-6 text-secondary-second" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
        </button>
    </header>

    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden bg-gradient-to-b from-primary to-secondary-main text-white py-8 px-6">
        <div class="flex flex-col items-center space-y-4">
        <a href="#" class="flex items-center space-x-2 text-white hover:text-secondary-second">
            <svg class="h-5 w-5 text-secondary-second" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M8 7V3M16 7V3M4 11h16M4 19h16M4 15h16" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Buat Event</span>
        </a>
        <a href="/events" class="flex items-center space-x-2 text-white hover:text-secondary-second">
            <svg class="h-5 w-5 text-secondary-second" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
            <span>Jelajah</span>
        </a>
        <button class="border border-blue-500 text-blue-500 px-4 py-1 rounded-full hover:bg-blue-100">Sign In</button>
        </div>
    </div>