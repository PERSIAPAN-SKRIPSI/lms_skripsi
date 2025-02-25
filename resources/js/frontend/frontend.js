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
document.addEventListener('DOMContentLoaded', function () {

    // Toggle Dropdown Menu
    document.querySelectorAll('[id^="chapter-menu-button-"]').forEach(button => {
        const chapterId = button.id.replace('chapter-menu-button-', '');
        const menu = document.getElementById(`chapter-menu-${chapterId}`);

        button.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent the click from bubbling up and closing the menu immediately

            // Close all other open menus
            document.querySelectorAll('[id^="chapter-menu-"]:not(#chapter-menu-' + chapterId + ')').forEach(otherMenu => {
                otherMenu.classList.add('hidden');
            });

            menu.classList.toggle('hidden');
        });

    });

    // Close Dropdown on Outside Click
    document.addEventListener('click', (event) => {
        document.querySelectorAll('[id^="chapter-menu-"]').forEach(menu => {
            if (!menu.classList.contains('hidden') && !menu.contains(event.target) && !event.target.matches('[id^="chapter-menu-button-"]')) {
                menu.classList.add('hidden');
            }
        });
    });
});
document.addEventListener('DOMContentLoaded', function() {
    const videoModals = document.querySelectorAll('.video-modal');

    videoModals.forEach(modal => {
        // Stop video when modal is closed
        modal.addEventListener('hidden.bs.modal', function () {
            const iframe = this.querySelector('iframe');
            const currentSrc = iframe.src;
            iframe.src = '';
            setTimeout(() => {
                iframe.src = currentSrc;
            }, 100);
        });

        // Handle fullscreen button click
        const fullscreenBtn = modal.querySelector('.fullscreen-btn');
        if (fullscreenBtn) {
            fullscreenBtn.addEventListener('click', function() {
                if (modal.requestFullscreen) {
                    modal.requestFullscreen();
                } else if (modal.webkitRequestFullscreen) {
                    modal.webkitRequestFullscreen();
                } else if (modal.msRequestFullscreen) {
                    modal.msRequestFullscreen();
                }
            });
        }
    });
});
