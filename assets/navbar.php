  <!-- Navbar -->
  <nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
      <div class="relative flex items-center justify-between h-16">
        <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
          <!-- Mobile menu button -->
          <button id="toggleMenu" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-white hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <!-- Hamburger menu icon -->
            <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
          </button>
        </div>
        <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">
          <!-- Logo -->
          <div class="flex-shrink-0 flex items-center">
           <a class="navbar-brand bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium">Perpustakaan</a>
          </div>
          <!-- Menu items -->
          <div class="hidden sm:block sm:ml-6">
            <div class="flex space-x-4">
              <a href="index.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Beranda</a>
              <a href="profile.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Profile</a>
              <a href="peminjaman.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Peminjaman Buku</a>
              <a href="pengembalian.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Pengembalian Buku</a>
              <a href="logout.php" class="text-gray-300 hover:bg-gray-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Logout</a>
            </div>
          </div>
        </div>
        <!-- Dark mode toggle button -->
        <div class="flex items-center">
          <button id="toggleDarkMode" class="bg-gray-800 p-1 rounded-full text-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" aria-pressed="false">
            <span class="sr-only">Toggle dark mode</span>
            <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6a9 9 0 00-9 9c0 4.97 4.03 9 9 9s9-4.03 9-9a9 9 0 00-9-9zm0 14c-3.87 0-7-3.13-7-7 0-3.87 3.13-7 7-7s7 3.13 7 7c0 3.87-3.13 7-7 7z"></path>
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 17l5 5m0 0l-5-5m5 5H7m13-6H4a1 1 0 01-1-1V9a1 1 0 011-1h18a1 1 0 011 1v2a1 1 0 01-1 1z"></path>
            </svg>
          </button>
        </div>
      </div>
      <!-- Mobile menu -->
      <div class="sm:hidden" id="mobileMenu">
        <div class="px-2 pt-2 pb-3 space-y-1">
          <a href="index.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Beranda</a>
          <a href="profile.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Profile</a>
          <a href="peminjaman.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Peminjaman Buku</a>
          <a href="pengembalian.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Pengembalian Buku</a>
          <a href="logout.php" class="text-gray-300 hover:bg-gray-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Logout</a>
        </div>
      </div>
    </div>
  </nav>