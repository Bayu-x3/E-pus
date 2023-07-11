<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.15/dist/tailwind.min.css">
  <title>Admin Dashboard</title>
</head>
<body class="bg-gray-100">
  <!-- Sidebar -->
  <aside class="bg-gray-800 text-white w-64 min-h-screen">
    <!-- Sidebar Content -->
    <div class="flex flex-col items-center py-6">
      <!-- Logo -->
      <h2 class="text-2xl font-bold">Admin Dashboard</h2>
    </div>
    <!-- Navigation -->
    <nav class="text-gray-400">
      <a href="#" class="flex items-center py-2 px-8 text-gray-100 bg-gray-900">
        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 3L21 9V15L12 21L3 15V9L12 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Dashboard
      </a>
      <a href="#" class="flex items-center py-2 px-8">
        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M12 4C12 3.44772 11.5523 3 11 3C10.4477 3 10 3.44772 10 4V5H12V4ZM14 6H8V20C8 20.5523 8.44772 21 9 21H15C15.5523 21 16 20.5523 16 20V6ZM14 4H16C16.5523 4 17 4.44772 17 5V20C17 21.6569 15.6569 23 14 23H8C6.34315 23 5 21.6569 5 20V5C5 4.44772 5.44772 4 6 4H8H14ZM14 4V3C14 2.44772 13.5523 2 13 2H11C10.4477 2 10 2.44772 10 3V4H14Z" fill="currentColor"/>
        </svg>
        Orders
      </a>
      <a href="#" class="flex items-center py-2 px-8">
        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M21 16C21 16.5523 20.5523 17 20 17H4C3.44772 17 3 16.5523 3 16V8C3 7.44772 3.44772 7 4 7H20C20.5523 7 21 7.44772 21 8V16Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M16 3H8C7.44772 3 7 3.44772 7 4V20C7 20.5523 7.44772 21 8 21H16C16.5523 21 17 20.5523 17 20V4C17 3.44772 16.5523 3 16 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Products
      </a>
      <a href="#" class="flex items-center py-2 px-8">
        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M6 6H3C2.44772 6 2 6.44772 2 7V19C2 19.5523 2.44772 20 3 20H6V6Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M10 11H21C21.5523 11 22 11.4477 22 12V19C22 19.5523 21.5523 20 21 20H10C9.44772 20 9 19.5523 9 19V12C9 11.4477 9.44772 11 10 11Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Categories
      </a>
      <a href="#" class="flex items-center py-2 px-8">
        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M17 2H7C5.89543 2 5 2.89543 5 4V16C5 17.1046 5.89543 18 7 18H17C18.1046 18 19 17.1046 19 16V4C19 2.89543 18.1046 2 17 2Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M7 13H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M7 9H17" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          <path d="M12 21V13" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
        Customers
      </a>
    </nav>
  </aside>
  <!-- Main Content -->
  <main class="p-8">
    <!-- Page Header -->
    <header class="flex justify-between items-center mb-8">
      <h1class="text-3xl font-bold">Dashboard</h1>
      <div class="flex items-center">
        <a href="#" class="text-gray-600 hover:text-gray-900">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 4C12 3.44772 11.5523 3 11 3C10.4477 3 10 3.44772 10 4V5H12V4ZM14 6H8V20C8 20.5523 8.44772 21 9 21H15C15.5523 21 16 20.5523 16 20V6ZM14 4H16C16.5523 4 17 4.44772 17 5V20C17 21.6569 15.6569 23 14 23H8C6.34315 23 5 21.6569 5 20V5C5 4.44772 5.44772 4 6 4H8H14ZM14 4V3C14 2.44772 13.5523 2 13 2H11C10.4477 2 10 2.44772 10 3V4H14Z" fill="currentColor"/>
          </svg>
        </a>
        <a href="#" class="ml-4 text-gray-600 hover:text-gray-900">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M9.46967 3.46967C9.17678 3.17678 8.67678 3 8.15685 3H3C2.44772 3 2 3.44772 2 4V9.15685C2 9.67678 2.17678 10.1768 2.46967 10.4697L11.9697 20.9697C12.2626 21.2626 12.7374 21.2626 13.0303 20.9697L20.9697 13.0303C21.2626 12.7374 21.2626 12.2626 20.9697 11.9697L10.4697 1.46967C10.1768 1.17678 9.67678 1 9.15685 1H4C3.44772 1 3 1.44772 3 2V7.15685C3 7.67678 3.17678 8.17678 3.46967 8.46967L9.46967 14.4697C9.76256 14.7626 10.2374 14.7626 10.5303 14.4697L16.5303 8.46967C16.8232 8.17678 17 7.67678 17 7.15685V2C17 1.44772 16.5523 1 16 1H10.8431C10.3232 1 9.82322 1.17678 9.53033 1.46967L9.46967 1.53033L9.53033 1.46967L9.46967 3.46967Z" fill="currentColor"/>
          </svg>
        </a>
        <a href="#" class="ml-4 text-gray-600 hover:text-gray-900">
          <svg class="w-6 h-6" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M5 3H19C19.5523 3 20 3.44772 20 4V20C20 20.5523 19.5523 21 19 21H5C4.44772 21 4 20.5523 4 20V4C4 3.44772 4.44772 3 5 3Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 14H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            <path d="M12 8H12.01" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
          </svg>
        </a>
      </div>
    </header>
    <!-- Main Content -->
    <div class="bg-white rounded-lg p-6">
      <!-- Content Goes Here -->
      <h2 class="text-xl font-semibold mb-4">Welcome, Admin!</h2>
      <p class="text-gray-600">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer eget odio auctor, ultrices eros eget, aliquet velit. Quisque nec nisi sagittis, tempus ex id, feugiat libero.</p>
    </div>
  </main>
</body>
</html>