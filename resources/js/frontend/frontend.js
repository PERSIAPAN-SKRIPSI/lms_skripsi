document.addEventListener('DOMContentLoaded', function() {
    // Desktop dropdown hover functionality using delegated event listeners
    if (window.innerWidth >= 992) {
        document.querySelector('.navbar-nav').addEventListener('mouseover', function(event) {
            if (event.target.closest('.dropdown-submenu')) {
                event.target.closest('.dropdown-submenu').querySelector('.dropdown-menu').classList.add('show');
            }
        });

        document.querySelector('.navbar-nav').addEventListener('mouseout', function(event) {
            if (event.target.closest('.dropdown-submenu')) {
                event.target.closest('.dropdown-submenu').querySelector('.dropdown-menu').classList.remove('show');
            }
        });
    }

    // Mobile menu category toggle
    document.querySelectorAll('.mobile-category-toggle').forEach(function(toggle) {
        toggle.addEventListener('click', function(e) {
            if (this.getAttribute('data-bs-toggle') === 'collapse') {
                e.preventDefault();
                const icon = this.querySelector('.fas');
                icon.classList.toggle('fa-chevron-up');
                icon.classList.toggle('fa-chevron-down');
            }

            // Close offcanvas menu on mobile after clicking category link
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu && bootstrap.Offcanvas.getInstance(mobileMenu)) {
                bootstrap.Offcanvas.getInstance(mobileMenu).hide();
            }
        });
    });
});
