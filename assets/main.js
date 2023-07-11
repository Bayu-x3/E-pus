 // Mobile menu toggle
 const toggleMenu = document.getElementById('toggleMenu');
 const mobileMenu = document.getElementById('mobileMenu');
 toggleMenu.addEventListener('click', function() {
   mobileMenu.classList.toggle('hidden');
 });

 // Dark mode toggle
 const toggleDarkMode = document.getElementById('toggleDarkMode');
 toggleDarkMode.addEventListener('click', function() {
   const body = document.body;
   if (body.classList.contains('light-mode')) {
     body.classList.remove('light-mode');
     body.classList.add('dark-mode');
   } else {
     body.classList.remove('dark-mode');
     body.classList.add('light-mode');
   }
 });