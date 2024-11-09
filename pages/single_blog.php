<?php
session_start();
include '../config/config.php';

$isLoggedIn = isset($_SESSION['user_id']);

if ($isLoggedIn) {
    $user_id = $_SESSION['user_id'];
    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../assets/icons/favicon.png" type="image/x-icon">
    <title>SimpleNews | Single Blog</title>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="font-inter text-base font-normal">
    <!-- header -->
    <header class="flex flex-wrap  md:justify-start md:flex-nowrap z-50 w-full bg-white border-b border-gray-200">
        <nav class="relative max-w-[85rem] w-full mx-auto md:flex md:items-center md:justify-between md:gap-3 p-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center gap-x-1">
                <a class="flex-none font-semibold text-xl text-black focus:outline-none focus:opacity-80" href="../pages/home.php" aria-label="Brand">SimpleNews</a>
                <button type="button" class="hs-collapse-toggle md:hidden relative size-9 flex justify-center items-center font-medium text-[12px] rounded-lg border border-gray-200 text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 disabled:opacity-50 disabled:pointer-events-none" id="hs-header-base-collapse" aria-expanded="false" aria-controls="hs-header-base" aria-label="Toggle navigation" data-hs-collapse="#hs-header-base">
                    <svg class="hs-collapse-open:hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="3" x2="21" y1="6" y2="6" />
                        <line x1="3" x2="21" y1="12" y2="12" />
                        <line x1="3" x2="21" y1="18" y2="18" />
                    </svg>
                    <svg class="hs-collapse-open:block shrink-0 hidden size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 6 6 18" />
                        <path d="m6 6 12 12" />
                    </svg>
                    <span class="sr-only">Toggle navigation</span>
                </button>
            </div>
            <div id="hs-header-base" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow md:block " aria-labelledby="hs-header-base-collapse">
                <div class="overflow-hidden overflow-y-auto max-h-[75vh] [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
                    <div class="py-2 md:py-0  flex flex-col md:flex-row md:items-center gap-0.5 md:gap-1">
                        <div class="grow">
                            <div class="flex flex-col md:flex-row md:justify-end md:items-center gap-0.5 md:gap-1">
                                <a class="p-2 flex items-center text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100" href="../pages/home.php">
                                    <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2" />
                                        <circle cx="12" cy="7" r="4" />
                                    </svg>
                                    Home
                                </a>
                                <a class="p-2 flex items-center text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100" href="../pages/blog.php">
                                    <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M12 12h.01" />
                                        <path d="M16 6V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v2" />
                                        <path d="M22 13a18.15 18.15 0 0 1-20 0" />
                                        <rect width="20" height="14" x="2" y="6" rx="2" />
                                    </svg>
                                    Blog
                                </a>
                                <a class="p-2 flex items-center text-sm text-gray-800 hover:bg-gray-100 rounded-lg focus:outline-none focus:bg-gray-100" href="../pages/contact.php">
                                    <svg class="shrink-0 size-4 me-3 md:me-2 block md:hidden" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 22h16a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H8a2 2 0 0 0-2 2v16a2 2 0 0 1-2 2Zm0 0a2 2 0 0 1-2-2v-9c0-1.1.9-2 2-2h2" />
                                        <path d="M18 14h-8" />
                                        <path d="M15 18h-5" />
                                        <path d="M10 6h8v4h-8V6Z" />
                                    </svg>
                                    Contact
                                </a>
                            </div>
                        </div>
                        <div class="my-2 md:my-0 md:mx-2">
                            <div class="w-full h-px md:w-px md:h-4 bg-gray-100 md:bg-gray-300"></div>
                        </div>
                        <div class=" flex flex-wrap items-center gap-x-1.5">
                            <?php if (!$isLoggedIn): ?>
                                <a class="py-2 px-4 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none" href="../pages/login.php">
                                    Sign in
                                </a>
                            <?php else: ?>
                                <div class="hs-dropdown [--placement:bottom-right] relative inline-flex">
                                    <button id="hs-dropdown-account" type="button"
                                        class="size-[38px] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                                        aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                                        <img class="shrink-0 size-[25px] rounded-full block" src="../assets/images/user.png"
                                            alt="Avatar">
                                    </button>
                                    <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg mt-4 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full z-50"
                                        role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-account">
                                        <div class="py-3 px-5 bg-gray-100 rounded-t-lg">
                                            <p class="text-sm text-gray-500">Signed in as</p>
                                            <p class="text-sm font-medium text-gray-800"><?= htmlspecialchars($user['email']) ?></p>
                                        </div>
                                        <div class="p-1.5 space-y-0.5">
                                            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                href="../admin/dashboard.php">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <rect width="20" height="14" x="2" y="7" rx="2" ry="2" />
                                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                                                </svg>
                                                Dashboard
                                            </a>
                                            <a class="flex items-center gap-x-3.5 py-2 px-3 rounded-lg text-sm text-gray-800 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                href="../actions/logout.php">
                                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24"
                                                    height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                                                    <polyline points="16 17 21 12 16 7" />
                                                    <line x1="21" y1="12" x2="9" y2="12" />
                                                </svg>
                                                Log Out
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <!-- header -->
    <!-- blog article -->
    <section class="max-w-[85rem] px-4 sm:px-6 lg:px-8 mx-auto">
        <div class="grid lg:grid-cols-3 gap-y-8 lg:gap-y-0 lg:gap-x-6">
            <div class="lg:col-span-2">
                <div class="py-8 lg:pe-8">
                    <div class="space-y-5 lg:space-y-8">
                        <a class="inline-flex items-center gap-x-1.5 text-sm text-gray-600 decoration-2 hover:underline focus:outline-none focus:underline" href="../pages/home.php">
                            <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="m15 18-6-6 6-6" />
                            </svg>
                            Back to Blog
                        </a>
                        <h2 class="text-3xl font-bold lg:text-5xl">Announcing a free plan for small teams</h2>
                        <div class="flex items-center gap-x-5">
                            <a class="inline-flex items-center gap-1.5 py-1 px-3 sm:py-2 sm:px-4 rounded-full text-xs sm:text-sm bg-gray-100 text-gray-800 hover:bg-gray-200 focus:outline-none focus:bg-gray-200" href="#">
                                Salman Abdurrahman
                            </a>
                            <p class="text-xs sm:text-sm text-gray-800">January 18, 2023</p>
                        </div>
                        <div class="text-center">
                            <div class="flex items-center justify-center">
                                <figure class="relative w-full h-96">
                                    <img class="size-full background-cover background-center absolute top-0 start-0 object-cover rounded-xl" src="https://images.unsplash.com/photo-1670272505340-d906d8d77d03?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=560&q=80" alt="Blog Image">
                                </figure>
                            </div>
                        </div>
                        <p class="text-lg text-gray-800">As we've grown, we've seen how Preline has helped companies such as Spotify, Microsoft, Airbnb, Facebook, and Intercom bring their designers closer together to create amazing things. We've also learned that when the culture of sharing is brought in earlier, the better teams adapt and communicate with one another.</p>
                        <p class="text-lg text-gray-800">That's why we are excited to share that we now have a <a class="text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium" href="#">free version of Preline</a>, which will allow individual designers, startups and other small teams a chance to create a culture of openness early on.</p>
                    </div>
                </div>
            </div>
            <div class="lg:col-span-1 lg:w-full lg:h-full lg:bg-gradient-to-r lg:from-gray-50 lg:via-transparent lg:to-transparent">
                <div class="sticky top-0 start-0 py-8 lg:ps-8">
                    <div class="space-y-6">
                        <a class="group flex items-center gap-x-6 focus:outline-none" href="#">
                            <div class="grow">
                                <span class="text-sm font-bold text-gray-800 group-hover:text-blue-600 group-focus:text-blue-600">
                                    5 Reasons to Not start a UX Designer Career in 2022/2023
                                </span>
                            </div>

                            <div class="shrink-0 relative rounded-lg overflow-hidden size-20">
                                <img class="size-full absolute top-0 start-0 object-cover rounded-lg" src="https://images.unsplash.com/photo-1567016526105-22da7c13161a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=320&q=80" alt="Blog Image">
                            </div>
                        </a>
                        <a class="group flex items-center gap-x-6 focus:outline-none" href="#">
                            <div class="grow">
                                <span class="text-sm font-bold text-gray-800 group-hover:text-blue-600 group-focus:text-blue-600">
                                    If your UX Portfolio has this 20% Well Done, it Will Give You an 80% Result
                                </span>
                            </div>
                            <div class="shrink-0 relative rounded-lg overflow-hidden size-20">
                                <img class="size-full absolute top-0 start-0 object-cover rounded-lg" src="https://images.unsplash.com/photo-1542125387-c71274d94f0a?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=320&q=80" alt="Blog Image">
                            </div>
                        </a>
                        <a class="group flex items-center gap-x-6 focus:outline-none" href="#">
                            <div class="grow">
                                <span class="text-sm font-bold text-gray-800 group-hover:text-blue-600 group-focus:text-blue-600">
                                    7 Principles of Icon Design
                                </span>
                            </div>
                            <div class="shrink-0 relative rounded-lg overflow-hidden size-20">
                                <img class="size-full absolute top-0 start-0 object-cover rounded-lg" src="https://images.unsplash.com/photo-1586232702178-f044c5f4d4b7?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=320&q=80" alt="Blog Image">
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- blog article -->
    <!-- subscribe -->
    <section class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 lg:py-16 mx-auto">
        <div class="grid md:grid-cols-2 gap-8">
            <div class="max-w-md">
                <h2 class="text-2xl font-bold md:text-3xl md:leading-tight">Stay up to date</h2>
                <p class="mt-3 text-gray-600">
                    Subscribe to our newsletter to receive news, updates and tips about SimpleNews.
                </p>
            </div>
            <form id="subscribeForm" method="post">
                <div class="w-full sm:max-w-lg md:ms-auto">
                    <div class="flex flex-col items-center gap-2 sm:flex-row sm:gap-3">
                        <div class="w-full">
                            <label for="email" class="sr-only">Search</label>
                            <input type="email" id="email" name="email" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none" placeholder="Enter your email">
                        </div>
                        <button type="submit" class="w-full sm:w-auto whitespace-nowrap py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                            Subscribe
                        </button>
                    </div>
                    <p class="mt-3 text-sm text-gray-500">
                        No spam, unsubscribe at any time
                    </p>
                </div>
            </form>
        </div>
    </section>
    <!-- subscribe -->
    <!-- footer -->
    <footer class="bg-gray-900">
        <section class="mt-auto w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
            <div class="text-center text-white">
                <div>
                    <a class="flex-none text-xl font-semibold text-white" href="#" aria-label="Brand">SimpleNews</a>
                </div>
                <div class="mt-3">
                    <p class="text-gray-400">SimpleNews is a website that provides latest news from various sources.</p>
                    <p class="text-gray-400">
                        © 2024 SimpleNews. All rights reserved. Built with Salman Abdurrahman.
                    </p>
                </div>
                <div class="mt-3 space-x-2">
                    <a class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-400 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 disabled:opacity-50 disabled:pointer-events-none" href="#">
                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z" />
                        </svg>
                    </a>
                    <a class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-400 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 disabled:opacity-50 disabled:pointer-events-none" href="#">
                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M5.026 15c6.038 0 9.341-5.003 9.341-9.334 0-.14 0-.282-.006-.422A6.685 6.685 0 0 0 16 3.542a6.658 6.658 0 0 1-1.889.518 3.301 3.301 0 0 0 1.447-1.817 6.533 6.533 0 0 1-2.087.793A3.286 3.286 0 0 0 7.875 6.03a9.325 9.325 0 0 1-6.767-3.429 3.289 3.289 0 0 0 1.018 4.382A3.323 3.323 0 0 1 .64 6.575v.045a3.288 3.288 0 0 0 2.632 3.218 3.203 3.203 0 0 1-.865.115 3.23 3.23 0 0 1-.614-.057 3.283 3.283 0 0 0 3.067 2.277A6.588 6.588 0 0 1 .78 13.58a6.32 6.32 0 0 1-.78-.045A9.344 9.344 0 0 0 5.026 15z" />
                        </svg>
                    </a>
                    <a class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-400 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 disabled:opacity-50 disabled:pointer-events-none" href="#">
                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z" />
                        </svg>
                    </a>
                    <a class="size-8 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-400 hover:bg-gray-800 focus:outline-none focus:bg-gray-800 disabled:opacity-50 disabled:pointer-events-none" href="#">
                        <svg class="shrink-0 size-3.5" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M3.362 10.11c0 .926-.756 1.681-1.681 1.681S0 11.036 0 10.111C0 9.186.756 8.43 1.68 8.43h1.682v1.68zm.846 0c0-.924.756-1.68 1.681-1.68s1.681.756 1.681 1.68v4.21c0 .924-.756 1.68-1.68 1.68a1.685 1.685 0 0 1-1.682-1.68v-4.21zM5.89 3.362c-.926 0-1.682-.756-1.682-1.681S4.964 0 5.89 0s1.68.756 1.68 1.68v1.682H5.89zm0 .846c.924 0 1.68.756 1.68 1.681S6.814 7.57 5.89 7.57H1.68C.757 7.57 0 6.814 0 5.89c0-.926.756-1.682 1.68-1.682h4.21zm6.749 1.682c0-.926.755-1.682 1.68-1.682.925 0 1.681.756 1.681 1.681s-.756 1.681-1.68 1.681h-1.681V5.89zm-.848 0c0 .924-.755 1.68-1.68 1.68A1.685 1.685 0 0 1 8.43 5.89V1.68C8.43.757 9.186 0 10.11 0c.926 0 1.681.756 1.681 1.68v4.21zm-1.681 6.748c.926 0 1.682.756 1.682 1.681S11.036 16 10.11 16s-1.681-.756-1.681-1.68v-1.682h1.68zm0-.847c-.924 0-1.68-.755-1.68-1.68 0-.925.756-1.681 1.68-1.681h4.21c.924 0 1.68.756 1.68 1.68 0 .926-.756 1.681-1.68 1.681h-4.21z" />
                        </svg>
                    </a>
                </div>
            </div>
        </section>
    </footer>
    <!-- footer -->
    <!-- flowbite -->
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
    <!-- preline -->
    <script src="../node_modules/preline/dist/preline.js"></script>
    <!-- js -->
    <script src="../assets/js/script.js"></script>
</body>

</html>