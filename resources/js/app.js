import './bootstrap';

import Alpine from "alpinejs";
import collapse from "@alpinejs/collapse";
import PerfectScrollbar from "perfect-scrollbar";

// Import Chart.js
import Chart from 'chart.js/auto';
window.Chart = Chart;

window.PerfectScrollbar = PerfectScrollbar;
import { Notyf } from 'notyf';
import 'notyf/notyf.min.css';

// Initialize Notyf
const notyf = new Notyf({
    duration: 5000, // Durasi notifikasi muncul (dalam milidetik)
    position: {
        x: 'right', // 'left', 'center', 'right'
        y: 'top',     // 'top', 'center', 'bottom'
    },
    dismissible: true, // Apakah notifikasi bisa ditutup oleh pengguna
    types: [
        {
            type: 'success',
            background: '#28a745', // Warna background untuk notifikasi sukses (hijau)
            icon: {
                className: 'fas fa-check-circle', // Contoh Icon Font Awesome untuk sukses
                tagName: 'i',
                color: 'white'
            }
        },
        {
            type: 'error',
            background: '#dc3545', // Warna background untuk notifikasi error (merah)
            duration: 10000,       // Durasi notifikasi error lebih lama
            dismissible: true,
            icon: {
                className: 'fas fa-times-circle', // Contoh Icon Font Awesome untuk error
                tagName: 'i',
                color: 'white'
            }
        },
        {
            type: 'warning',
            background: '#ffc107', // Warna background untuk notifikasi warning (kuning)
            icon: {
                className: 'fas fa-exclamation-triangle', // Contoh Icon Font Awesome untuk warning
                tagName: 'i',
                color: 'white'
            }
        },
        {
            type: 'info',
            background: '#17a2b8', // Warna background untuk notifikasi info (biru muda)
            icon: {
                className: 'fas fa-info-circle', // Contoh Icon Font Awesome untuk info
                tagName: 'i',
                color: 'white'
            }
        }
    ]
});

// Make Notyf globally accessible
window.Notyf = notyf;

document.addEventListener("alpine:init", () => {
    Alpine.data("mainState", () => {
        let lastScrollTop = 0;
        const init = function () {
            window.addEventListener("scroll", () => {
                let st =
                    window.pageYOffset || document.documentElement.scrollTop;
                if (st > lastScrollTop) {
                    // downscroll
                    this.scrollingDown = true;
                    this.scrollingUp = false;
                } else {
                    // upscroll
                    this.scrollingDown = false;
                    this.scrollingUp = true;
                    if (st == 0) {
                        //  reset
                        this.scrollingDown = false;
                        this.scrollingUp = false;
                    }
                }
                lastScrollTop = st <= 0 ? 0 : st; // For Mobile or negative scrolling
            });
        };

        const getTheme = () => {
            if (window.localStorage.getItem("dark")) {
                return JSON.parse(window.localStorage.getItem("dark"));
            }
            return (
                !!window.matchMedia &&
                window.matchMedia("(prefers-color-scheme: dark)").matches
            );
        };
        const setTheme = (value) => {
            window.localStorage.setItem("dark", value);
        };

        // Notification functions to be used in Alpine components
        const notifySuccess = (message) => {
            window.Notyf.success(message);
        };
        const notifyError = (message) => {
            window.Notyf.error(message);
        };
        const notifyWarning = (message) => {
            window.Notyf.warning(message);
        };
        const notifyInfo = (message) => {
            window.Notyf.info(message);
        };


        return {
            init,
            isDarkMode: getTheme(),
            toggleTheme() {
                this.isDarkMode = !this.isDarkMode;
                setTheme(this.isDarkMode);
            },
            isSidebarOpen: window.innerWidth > 1024,
            isSidebarHovered: false,
            handleSidebarHover(value) {
                if (window.innerWidth < 1024) {
                    return;
                }
                this.isSidebarHovered = value;
            },
            handleWindowResize() {
                if (window.innerWidth <= 1024) {
                    this.isSidebarOpen = false;
                } else {
                    this.isSidebarOpen = true;
                }
            },
            scrollingDown: false,
            scrollingUp: false,

            // Expose notification functions to Alpine component
            notifySuccess,
            notifyError,
            notifyWarning,
            notifyInfo,
        };
    });
});
// Inisialisasi Chart.js di sini
document.addEventListener('DOMContentLoaded', function() {
    const chartElement = document.getElementById('quizPerformanceChart');
    if (chartElement) { // Pastikan elemen ada sebelum mencoba menginisialisasi chart
        const ctx = chartElement.getContext('2d');

        const chartData = {
            labels: JSON.parse(chartElement.dataset.labels),
            datasets: [{
                label: 'Rata-rata Skor Quiz (%)',
                data: JSON.parse(chartElement.dataset.data),
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1,
                tension: 0.4
            }]
        };

        const chartOptions = {
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    title: {
                        display: true,
                        text: 'Skor (%)'
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                },
                title: {
                    display: false,
                }
            }
        };

        const myChart = new Chart(ctx, {
            type: 'line',
            data: chartData,
            options: chartOptions
        });
    } else {
        console.warn('Elemen dengan ID "quizPerformanceChart" tidak ditemukan.');
    }
});
Alpine.plugin(collapse);

Alpine.start();
