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
document.querySelectorAll('.duration-filter').forEach(checkbox => {
    checkbox.addEventListener('change', function() {
        let selectedDurations = [];
        document.querySelectorAll('.duration-filter:checked').forEach(checkedBox => {
            selectedDurations.push(checkedBox.value);
        });

        let url = new URL(window.location.href);
        if (selectedDurations.length > 0) {
            url.searchParams.set('duration', selectedDurations.join(',')); // Menggunakan koma untuk multiple values jika diperlukan
        } else {
            url.searchParams.delete('duration'); // Hapus parameter jika tidak ada yang dipilih
        }
        window.location.href = url.toString();
    });
});
document.addEventListener('DOMContentLoaded', () => {
    console.log('DOM loaded, initializing enhanced filters...');

    // Initialize filter elements
    const initFilters = () => {
        const categoryFilters = document.querySelectorAll('.category-filter');
        const subcategoryFilters = document.querySelectorAll('.subcategory-filter');
        const durationFilters = document.querySelectorAll('.duration-filter');
        const searchForm = document.querySelector('.wsus__sidebar form');
        const searchInput = document.querySelector('.wsus__sidebar_search input[type="text"]');

        console.log('Found category filters:', categoryFilters.length);
        console.log('Found subcategory filters:', subcategoryFilters.length);
        console.log('Found duration filters:', durationFilters.length);

        // Attach event listeners to category filters (parent)
        categoryFilters.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                handleCategoryChange(this);
                applyFilters();
            });
        });

        // Attach event listeners to subcategory filters (child)
        subcategoryFilters.forEach((checkbox) => {
            checkbox.addEventListener('change', function() {
                handleSubcategoryChange(this);
                applyFilters();
            });
        });

        // Attach event listeners to duration filters
        durationFilters.forEach(checkbox => {
            checkbox.addEventListener('change', applyFilters);
        });

        // Attach event listener to search form
        if (searchForm) {
            searchForm.addEventListener('submit', (e) => {
                e.preventDefault();
                console.log('Search form submitted');
                applyFilters();
            });
        }

        // Initialize filter states based on URL parameters
        initializeFilterStates();
    };

    // Handle category (parent) checkbox changes
    function handleCategoryChange(categoryCheckbox) {
        const categoryId = categoryCheckbox.value;
        const isChecked = categoryCheckbox.checked;

        // Find all subcategories for this category
        const subcategoryCheckboxes = document.querySelectorAll(`.subcategory-filter[data-parent="${categoryId}"]`);

        // If category is checked, check all its subcategories
        // If category is unchecked, uncheck all its subcategories
        subcategoryCheckboxes.forEach(subcategoryCheckbox => {
            subcategoryCheckbox.checked = isChecked;
        });

        console.log(`Category ${categoryId} ${isChecked ? 'checked' : 'unchecked'}, affected ${subcategoryCheckboxes.length} subcategories`);
    }

    // Handle subcategory (child) checkbox changes
    function handleSubcategoryChange(subcategoryCheckbox) {
        const parentId = subcategoryCheckbox.dataset.parent;
        const parentCheckbox = document.querySelector(`.category-filter[value="${parentId}"]`);

        if (!parentCheckbox) return;

        // Get all subcategories for this parent
        const allSubcategories = document.querySelectorAll(`.subcategory-filter[data-parent="${parentId}"]`);
        const checkedSubcategories = document.querySelectorAll(`.subcategory-filter[data-parent="${parentId}"]:checked`);

        // If all subcategories are checked, check the parent
        // If no subcategories are checked, uncheck the parent
        // If some are checked, keep parent checked (partial selection)
        if (checkedSubcategories.length === allSubcategories.length) {
            parentCheckbox.checked = true;
        } else if (checkedSubcategories.length === 0) {
            parentCheckbox.checked = false;
        } else {
            // Partial selection - keep parent checked to indicate some children are selected
            parentCheckbox.checked = true;
        }

        console.log(`Subcategory changed, parent ${parentId}: ${checkedSubcategories.length}/${allSubcategories.length} selected`);
    }

    // Initialize filter states based on URL parameters
    function initializeFilterStates() {
        const url = new URL(window.location.href);

        // Initialize search input
        const searchTerm = url.searchParams.get('search') || '';
        const searchInput = document.querySelector('.wsus__sidebar_search input[type="text"]');
        if (searchInput && searchTerm) {
            searchInput.value = searchTerm;
        }

        // Initialize category filters
        const categoriesParam = url.searchParams.get('categories');
        if (categoriesParam) {
            const selectedCategories = categoriesParam.split(',');
            selectedCategories.forEach(categoryId => {
                const checkbox = document.querySelector(`.category-filter[value="${categoryId}"], .subcategory-filter[value="${categoryId}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }

        // Initialize duration filters
        const durationParam = url.searchParams.get('duration');
        if (durationParam) {
            const selectedDurations = durationParam.split(',');
            selectedDurations.forEach(duration => {
                const checkbox = document.querySelector(`.duration-filter[value="${duration}"]`);
                if (checkbox) {
                    checkbox.checked = true;
                }
            });
        }

        // Update parent checkboxes based on their children's states
        updateParentCheckboxStates();
    }

    // Update parent checkbox states based on children
    function updateParentCheckboxStates() {
        const categoryFilters = document.querySelectorAll('.category-filter');

        categoryFilters.forEach(parentCheckbox => {
            const parentId = parentCheckbox.value;
            const allSubcategories = document.querySelectorAll(`.subcategory-filter[data-parent="${parentId}"]`);
            const checkedSubcategories = document.querySelectorAll(`.subcategory-filter[data-parent="${parentId}"]:checked`);

            if (allSubcategories.length > 0) {
                if (checkedSubcategories.length === allSubcategories.length) {
                    parentCheckbox.checked = true;
                } else if (checkedSubcategories.length === 0) {
                    parentCheckbox.checked = false;
                } else {
                    parentCheckbox.checked = true; // Partial selection
                }
            }
        });
    }

    // Apply filters function
    function applyFilters() {
        console.log('Applying enhanced filters...');

        const url = new URL(window.location.href);
        console.log('Current URL:', url.toString());

        // Get search term
        const searchInput = document.querySelector('.wsus__sidebar_search input[type="text"]');
        const searchTerm = searchInput ? searchInput.value.trim() : '';
        console.log('Search term:', searchTerm);

        // Get selected categories and subcategories
        const selectedCategories = [];

        // Add checked parent categories
        document.querySelectorAll('.category-filter:checked').forEach(checkbox => {
            selectedCategories.push(checkbox.value);
        });

        // Add checked subcategories
        document.querySelectorAll('.subcategory-filter:checked').forEach(checkbox => {
            selectedCategories.push(checkbox.value);
        });

        // Remove duplicates
        const uniqueCategories = [...new Set(selectedCategories)];
        console.log('All selected categories/subcategories:', uniqueCategories);

        // Get selected durations
        const selectedDurations = Array.from(document.querySelectorAll('.duration-filter:checked'))
            .map(checkbox => checkbox.value);
        console.log('Selected durations:', selectedDurations);

        // Update URL parameters
        url.searchParams.set('search', searchTerm || '');
        url.searchParams.set('categories', uniqueCategories.length ? uniqueCategories.join(',') : '');
        url.searchParams.set('duration', selectedDurations.length ? selectedDurations.join(',') : '');

        // Remove page parameter to start from first page
        url.searchParams.delete('page');

        // Clean up empty parameters
        if (!searchTerm) url.searchParams.delete('search');
        if (!uniqueCategories.length) url.searchParams.delete('categories');
        if (!selectedDurations.length) url.searchParams.delete('duration');

        console.log('New URL:', url.toString());

        // Navigate to new URL
        window.location.href = url.toString();
    }

    // Clear all filters function
    function clearAllFilters() {
        console.log('Clearing all filters...');

        // Clear search input
        const searchInput = document.querySelector('.wsus__sidebar_search input[type="text"]');
        if (searchInput) {
            searchInput.value = '';
        }

        // Uncheck all category, subcategory, and duration checkboxes
        ['.category-filter', '.subcategory-filter', '.duration-filter'].forEach(selector => {
            document.querySelectorAll(selector).forEach(checkbox => {
                checkbox.checked = false;
            });
        });

        // Redirect to base URL without parameters
        const baseUrl = window.location.origin + window.location.pathname;
        console.log('Redirecting to:', baseUrl);
        window.location.href = baseUrl;
    }

    // Make clearAllFilters available globally
    window.clearAllFilters = clearAllFilters;

    // Initialize filters on load
    initFilters();
});
