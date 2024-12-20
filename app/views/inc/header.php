<!DOCTYPE html>
<html lang="en" class="text-[12px] md:text-[14px] lg:text-[16px]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= SITENAME ?></title>
    <link rel="stylesheet" href=<?= URLROOT . '/css/all.min.css'?>>
    <link rel="stylesheet" href=<?= URLROOT . '/css/fontawesome.min.css'?>>
    <link rel="stylesheet" href=<?= URLROOT . '/css/output.css'?>>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<header class="bg-secondary">
    <div class="sm:container sm:mx-auto sm:py-5 relative flex justify-between items-center">
        <div class="px-2 py-5 sm:p-0 relative bg-secondary flex justify-between flex-1 items-center z-20">
            <span class="text-primary font-bold text-xl font-lux">DINOUS</span>
            <span id="burger-menu" class="sm:hidden cursor-pointer text-based text-3xl"><i class="fa-solid fa-bars"></i></span>
        </div>
        <ul id="menu" class="flex flex-col sm:flex-row absolute sm:static bg-secondary w-full sm:w-fit left-0 z-10 -top-[300%] py-4 sm:py-0 rounded-b-lg sm:rounded-none items-center sm:gap-10 text-based transition-all duration-500">
            <li class="hover:text-primary hover:border-primary transition-all duration-300 border-b border-based w-full text-center pb-5 sm:p-0 sm:border-none sm:w-fit"><a href=<?= URLROOT . '/menus' ?>>Menus</a></li>
            <li class="hover:text-primary hover:border-primary transition-all duration-300 border-b border-based w-full text-center py-5 sm:p-0 sm:border-none sm:w-fit"><a href=<?= URLROOT . '/reservations' ?>>Reservations</a></li>
            <li class="hover:text-primary hover:border-primary transition-all duration-300 border-b border-based w-full text-center py-5 sm:p-0 sm:border-none sm:w-fit"><a href=<?= URLROOT . '/reservations/add' ?>>Book a reservation</a></li>
            <li class="bg-red-500 px-2 py-1 rounded-lg hover:bg-red-600 transition-all duration-300 mt-5 sm:m-0"><a href="">Logout <i class="fa-solid fa-right-from-bracket"></i></a></li>
        </ul>
    </div>
</header>