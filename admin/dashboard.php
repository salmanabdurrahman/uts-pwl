<?php
session_start();
include '../config/config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

try {
    // user
    $userQuery = "SELECT user_id, username, full_name, email, gender 
                  FROM users 
                  WHERE user_id = ?";
    $stmt = $conn->prepare($userQuery);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows === 0) {
        session_destroy();
        header('Location: ../pages/login.php');
        exit();
    }
    $user = $result->fetch_assoc();
    $loggedInUserEmail = $user['email'];
    $current_user = $user;
    $stmt->close();

    // all users
    $usersQuery = "SELECT user_id, username, full_name, email, gender, created_at 
                   FROM users 
                   ORDER BY created_at DESC";
    $stmt = $conn->prepare($usersQuery);
    $stmt->execute();
    $usersResult = $stmt->get_result();

    $users = [];
    while ($row = $usersResult->fetch_assoc()) {
        $users[] = $row;
    }
    $stmt->close();

    // all articles
    $articlesQuery = "SELECT a.*, u.full_name as creator_name 
                      FROM articles a 
                      LEFT JOIN users u ON a.created_by = u.user_id 
                      ORDER BY a.created_at DESC";
    $stmt = $conn->prepare($articlesQuery);
    $stmt->execute();
    $articlesResult = $stmt->get_result();

    $articles = [];
    while ($row = $articlesResult->fetch_assoc()) {
        $articles[] = $row;
    }
    $stmt->close();
} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage());
    $_SESSION['error'] = "An error occurred while loading the page. Please try again.";
    header('Location: ../pages/error.php');
    exit();
} finally {
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="shortcut icon" href="../assets/icons/favicon.png" type="image/x-icon">
    <title>SimpleNews | Dashboard</title>
    <!-- google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="../assets/css/style.css">
</head>

<body class="font-inter text-base font-normal" id="dashboard-parent">
    <!-- header -->
    <header class="sticky top-0 inset-x-0 flex flex-wrap md:justify-start md:flex-nowrap z-[48] w-full bg-white border-b text-sm py-2.5 lg:ps-[260px]">
        <nav class="px-4 sm:px-6 flex basis-full items-center w-full mx-auto">
            <div class="me-5 lg:me-0 lg:hidden">
                <div class="px-6 pt-4">
                    <a class="flex-none font-semibold text-2xl text-black focus:outline-none focus:opacity-80"
                        href="../pages/home.php" aria-label="Brand">SimpleNews</a>
                </div>
            </div>
            <div class="w-full flex items-center justify-end ms-auto md:justify-between gap-x-1 md:gap-x-3">
                <div class="hidden md:block"></div>
                <div class="flex flex-row items-center justify-end gap-1">
                    <div class="hs-dropdown [--placement:bottom-right] relative inline-flex">
                        <button id="hs-dropdown-account" type="button"
                            class="size-[38px] inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-full border border-transparent text-gray-800 focus:outline-none disabled:opacity-50 disabled:pointer-events-none"
                            aria-haspopup="menu" aria-expanded="false" aria-label="Dropdown">
                            <img class="shrink-0 size-[25px] rounded-full block" src="../assets/images/user.png"
                                alt="Avatar">
                        </button>
                        <div class="hs-dropdown-menu transition-[opacity,margin] duration hs-dropdown-open:opacity-100 opacity-0 hidden min-w-60 bg-white shadow-md rounded-lg mt-2 after:h-4 after:absolute after:-bottom-4 after:start-0 after:w-full before:h-4 before:absolute before:-top-4 before:start-0 before:w-full"
                            role="menu" aria-orientation="vertical" aria-labelledby="hs-dropdown-account">
                            <div class="py-3 px-5 bg-gray-100 rounded-t-lg">
                                <p class="text-sm text-gray-500">Signed in as</p>
                                <p class="text-sm font-medium text-gray-800"><?php echo htmlspecialchars($loggedInUserEmail); ?></p>
                            </div>
                            <div class="p-1.5 space-y-0.5">
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
                </div>
            </div>
        </nav>
    </header>
    <!-- header -->
    <!-- main -->
    <section class="-mt-px">
        <div class="sticky top-0 inset-x-0 z-20 bg-white border-y px-4 sm:px-6 lg:px-8 lg:hidden">
            <div class="flex items-center py-2">
                <button type="button"
                    class="size-8 flex justify-center items-center gap-x-2 border border-gray-200 text-gray-800 hover:text-gray-500 rounded-lg focus:outline-none focus:text-gray-500 disabled:opacity-50 disabled:pointer-events-none"
                    aria-haspopup="dialog" aria-expanded="false" aria-controls="hs-application-sidebar"
                    aria-label="Toggle navigation" data-hs-overlay="#hs-application-sidebar">
                    <span class="sr-only">Toggle Navigation</span>
                    <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="3" rx="2" />
                        <path d="M15 3v18" />
                        <path d="m8 9 3 3-3 3" />
                    </svg>
                </button>
            </div>
        </div>
    </section>
    <section id="hs-application-sidebar" class="hs-overlay [--auto-close:lg] hs-overlay-open:translate-x-0 -translate-x-full transition-all duration-300 transform w-[260px] h-full hidden fixed inset-y-0 start-0 z-[60] bg-white border-e border-gray-200 lg:block lg:translate-x-0 lg:end-auto lg:bottom-0" role="dialog" tabindex="-1" aria-label="Sidebar">
        <div class="relative flex flex-col h-full max-h-full">
            <div class="px-6 pt-4">
                <a class="flex-none font-semibold text-2xl text-black focus:outline-none focus:opacity-80"
                    href="../pages/home.php" aria-label="Brand">SimpleNews</a>
            </div>
            <div
                class="h-full overflow-y-auto [&::-webkit-scrollbar]:w-2 [&::-webkit-scrollbar-thumb]:rounded-full [&::-webkit-scrollbar-track]:bg-gray-100 [&::-webkit-scrollbar-thumb]:bg-gray-300">
                <nav class="hs-accordion-group p-3 w-full flex flex-col flex-wrap" data-hs-accordion-always-open>
                    <ul class="flex flex-col space-y-1">
                        <li class="hs-accordion" id="users-accordion">
                            <button type="button"
                                class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                aria-expanded="true" aria-controls="users-accordion-child" id="dashboard-button">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                                    <polyline points="9 22 9 12 15 12 15 22" />
                                </svg>
                                Dashboard
                            </button>
                        </li>
                        <li class="hs-accordion" id="users-accordion">
                            <button type="button"
                                class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                aria-expanded="true" aria-controls="users-accordion-child" id="profile-button">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                    <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                                </svg>
                                Update Profile
                            </button>
                        </li>
                        <li class="hs-accordion" id="users-accordion">
                            <button type="button"
                                class="hs-accordion-toggle w-full text-start flex items-center gap-x-3.5 py-2 px-2.5 text-sm text-gray-800 rounded-lg hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                aria-expanded="true" aria-controls="users-accordion-child" id="content-button">
                                <svg class="shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <rect width="20" height="14" x="2" y="7" rx="2" ry="2" />
                                    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16" />
                                </svg>
                                Add Content
                            </button>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </section>
    <section class="w-full lg:ps-64">
        <div class="p-4 sm:p-6 ">
            <!-- dashboard -->
            <div class="dashboard-section w-full max-w-[1100px] px-4 py-10 sm:px-8 lg:px-10 mx-auto" id="dashboard">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7 w-full">
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-800">
                            Dashboard
                        </h2>
                        <p class="text-sm text-gray-600">
                            Manage user account and content in the system.
                        </p>
                    </div>
                    <!-- users -->
                    <div class="max-w-[1100px] w-full px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                        <div class="flex flex-col">
                            <div class="-m-1.5 overflow-x-auto">
                                <div class="p-1.5 min-w-full inline-block align-middle">
                                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                                        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
                                            <div>
                                                <h2 class="text-xl font-semibold text-gray-800">
                                                    User
                                                </h2>
                                                <p class="text-sm text-gray-600">
                                                    View and manage user account.
                                                </p>
                                            </div>
                                        </div>
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            ID
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            Username
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            Full Name
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            Email
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            Gender
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            Created
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            Action
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                <?php foreach ($users as $user): ?>
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="text-sm text-gray-800"><?php echo htmlspecialchars($user['user_id']); ?></span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="text-sm text-gray-800"><?php echo htmlspecialchars($user['username']); ?></span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="text-sm text-gray-800"><?php echo htmlspecialchars($user['full_name']); ?></span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="text-sm text-gray-800"><?php echo htmlspecialchars($user['email']); ?></span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="inline-flex items-center gap-1.5 py-0.5 px-2 rounded-full text-xs font-medium <?php echo empty($user['gender']) ? '' : ($user['gender'] === 'male' ? 'bg-blue-100 text-blue-800' : 'bg-pink-100 text-pink-800'); ?>">
                                                                <?php echo empty($user['gender']) ? '' : htmlspecialchars($user['gender']); ?>
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="text-sm text-gray-500">
                                                                <?php echo date('d M Y, H:i', strtotime($user['created_at'])); ?>
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex gap-4">
                                                                <a href="../actions/delete_profile_action.php?id=<?php echo $user['user_id']; ?>"
                                                                    class="inline-flex items-center gap-x-1 text-sm text-red-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium">
                                                                    Delete
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200">
                                            <div>
                                                <p class="text-sm text-gray-600">
                                                    <span class="font-semibold text-gray-800"><?php echo count($users); ?></span> results
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- articles -->
                    <div class="max-w-[1100px] w-full px-4 py-10 sm:px-6 lg:px-8 lg:py-14 mx-auto">
                        <div class="flex flex-col">
                            <div class="-m-1.5 overflow-x-auto">
                                <div class="p-1.5 min-w-full inline-block align-middle">
                                    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">
                                        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-b border-gray-200">
                                            <div>
                                                <h2 class="text-xl font-semibold text-gray-800">
                                                    Articles
                                                </h2>
                                                <p class="text-sm text-gray-600">
                                                    View and manage article content.
                                                </p>
                                            </div>
                                        </div>
                                        <table class="min-w-full divide-y divide-gray-200">
                                            <thead class="bg-gray-50">
                                                <tr>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            ID
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            Title
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            Content
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            Short Description
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            Image
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            Created
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            Created By
                                                        </span>
                                                    </th>
                                                    <th scope="col" class="px-6 py-3 text-start">
                                                        <span class="text-xs font-semibold uppercase tracking-wide text-gray-800">
                                                            Action
                                                        </span>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200">
                                                <?php foreach ($articles as $article): ?>
                                                    <tr>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="text-sm text-gray-800"><?php echo htmlspecialchars($article['article_id']); ?></span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="text-sm text-gray-800"><?php echo htmlspecialchars($article['title']); ?></span>
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <span class="text-sm text-gray-800"><?php echo substr(htmlspecialchars($article['content']), 0, 100) . '...'; ?></span>
                                                        </td>
                                                        <td class="px-6 py-4">
                                                            <span class="text-sm text-gray-800"><?php echo substr(htmlspecialchars($article['short_description']), 0, 100) . '...'; ?></span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <?php if ($article['image_url']): ?>
                                                                <img src="<?php echo htmlspecialchars($article['image_url']); ?>"
                                                                    alt="Article image"
                                                                    class="h-10 w-10 rounded object-cover">
                                                            <?php else: ?>
                                                                <span class="text-sm text-gray-500">No image</span>
                                                            <?php endif; ?>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="text-sm text-gray-500">
                                                                <?php echo date('d M Y, H:i', strtotime($article['created_at'])); ?>
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <span class="text-sm text-gray-800">
                                                                <?php echo htmlspecialchars($article['creator_name']); ?>
                                                            </span>
                                                        </td>
                                                        <td class="px-6 py-4 whitespace-nowrap">
                                                            <div class="flex gap-4">
                                                                <a href="edit.php?id=<?php echo $article['article_id']; ?>"
                                                                    class="inline-flex items-center gap-x-1 text-sm text-blue-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium">
                                                                    Edit
                                                                </a>
                                                                <a href="../actions/delete_article_action.php?id=<?php echo $article['article_id']; ?>"
                                                                    class="inline-flex items-center gap-x-1 text-sm text-red-600 decoration-2 hover:underline focus:outline-none focus:underline font-medium">
                                                                    Delete
                                                                </a>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            </tbody>
                                        </table>
                                        <div class="px-6 py-4 grid gap-3 md:flex md:justify-between md:items-center border-t border-gray-200">
                                            <div>
                                                <p class="text-sm text-gray-600">
                                                    <span class="font-semibold text-gray-800"><?php echo count($articles); ?></span> results
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- dashboard -->
            <!-- update profile -->
            <div class="dashboard-section max-w-[1100px] px-4 py-10 sm:px-6 lg:px-8 mx-auto" id="update-profile">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7">
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-800">
                            Update Profile
                        </h2>
                        <p class="text-sm text-gray-600">
                            Manage your name, password, and account settings.
                        </p>
                    </div>
                    <form action="../actions/update_profile_action.php" method="POST">
                        <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                            <div class="sm:col-span-3">
                                <label for="username" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Username
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <input id="username" type="text"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg disabled:opacity-50 disabled:pointer-events-none bg-gray-100 cursor-not-allowed focus:ring-0 hover:ring-0 hover:outline-none focus:ring-none focus:shadow-none focus:outline-none focus:bg-gray-200 hover:bg-gray-200 disabled:bg-gray-200"
                                    name="username" value="<?= htmlspecialchars($current_user['username']) ?>" readonly>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="fullname" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Full name
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <input id="fullname" type="text"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    name="fullname" value="<?= htmlspecialchars($current_user['full_name']) ?>">
                            </div>
                            <div class="sm:col-span-3">
                                <label for="email" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Email
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <input id="email" type="email"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    name="email" value="<?= htmlspecialchars($current_user['email']) ?>">
                            </div>
                            <div class="sm:col-span-3">
                                <label for="password" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Password
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <div class="space-y-2">
                                    <input id="password" type="password" name="password"
                                        class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                        placeholder="Enter current password">
                                    <input type="password"
                                        class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                        placeholder="Enter new password (optional)" id="new-password"
                                        name="new-password">
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="gender" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Gender
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <div class="sm:flex">
                                    <label for="male"
                                        class="flex py-2 px-3 w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                                        <input type="radio" name="gender"
                                            class="shrink-0 mt-0.5 border-gray-300 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                            id="male" value="male" <?= $current_user['gender'] == 'male' ? 'checked' : '' ?>>
                                        <span class="text-sm text-gray-500 ms-3">Male</span>
                                    </label>
                                    <label for="female"
                                        class="flex py-2 px-3 w-full border border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none">
                                        <input type="radio" name="gender"
                                            class="shrink-0 mt-0.5 border-gray-300 rounded-full text-blue-600 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                            id="female" value="female" <?= $current_user['gender'] == 'female' ? 'checked' : '' ?>>
                                        <span class="text-sm text-gray-500 ms-3">Female</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="mt-5 flex justify-end gap-x-2">
                            <button type="reset"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- update profile -->
            <!-- add content -->
            <div class="dashboard-section max-w-[1100px] px-4 py-10 sm:px-6 lg:px-8 mx-auto" id="update-content">
                <div class="bg-white rounded-xl shadow p-4 sm:p-7">
                    <div class="mb-8">
                        <h2 class="text-xl font-bold text-gray-800">
                            Add Content
                        </h2>
                        <p class="text-sm text-gray-600">
                            Add your content, such as news, articles, or blog posts.
                        </p>
                    </div>
                    <form action="../actions/add_content_action.php" method="POST" enctype="multipart/form-data">
                        <div class="grid sm:grid-cols-12 gap-2 sm:gap-6">
                            <div class="sm:col-span-3">
                                <label for="title" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Title
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <input id="title" type="text"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm text-sm rounded-lg focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    name="title" placeholder="Your title here">
                            </div>
                            <div class="sm:col-span-3">
                                <label for="short-description" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Short description
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <textarea id="short-description" name="short_description"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="Your short description here"></textarea>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="content" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Content
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <textarea id="content" name="content"
                                    class="py-2 px-3 pe-11 block w-full border-gray-200 shadow-sm rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none"
                                    placeholder="Your content here"></textarea>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="image" class="inline-block text-sm text-gray-800 mt-2.5">
                                    Image
                                </label>
                            </div>
                            <div class="sm:col-span-9">
                                <label for="image-url" class="sr-only">Choose file</label>
                                <input type="file" name="image-url" id="image-url" class="block w-full border border-gray-100 shadow-sm rounded-lg text-sm focus:z-10 focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400
                                file:bg-gray-50 file:border-0
                                file:me-4
                                file:py-2 file:px-4
                                dark:file:bg-neutral-700 dark:file:text-neutral-400">
                            </div>
                        </div>
                        <div class="mt-5 flex justify-end gap-x-2">
                            <button type="reset"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit"
                                class="py-2 px-3 inline-flex items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                Add content
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- add content -->
        </div>
    </section>
    <!-- main -->
    <!-- flowbite -->
    <script src="../node_modules/flowbite/dist/flowbite.min.js"></script>
    <!-- preline -->
    <script src="../node_modules/preline/dist/preline.js"></script>
    <!-- js -->
    <script src="../assets/js/script.js"></script>
    <!-- script -->
    <script>
        const dashboardSection = document.querySelectorAll('.dashboard-section');
        const dashboardParent = document.getElementById('dashboard-parent');

        if (dashboardParent && dashboardSection.length > 0) {
            const sections = {
                'dashboard-button': 'dashboard',
                'profile-button': 'update-profile',
                'content-button': 'update-content',
            };

            dashboardSection.forEach((section, index) => {
                section.classList.add('hidden');

                if (index === 0) {
                    section.classList.remove('hidden');
                }
            });

            dashboardParent.addEventListener('click', function(event) {
                const targetId = event.target.id;

                if (sections[targetId]) {
                    dashboardSection.forEach(section =>
                        section.classList.add('hidden')
                    );

                    const targetSection = document.getElementById(sections[targetId]);
                    if (targetSection) {
                        targetSection.classList.remove('hidden');
                    }
                }
            });
        }
    </script>
</body>

</html>