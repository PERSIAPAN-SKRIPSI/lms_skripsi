document.addEventListener("DOMContentLoaded",function(){window.innerWidth>=992&&(document.querySelector(".navbar-nav").addEventListener("mouseover",function(t){t.target.closest(".dropdown-submenu")&&t.target.closest(".dropdown-submenu").querySelector(".dropdown-menu").classList.add("show")}),document.querySelector(".navbar-nav").addEventListener("mouseout",function(t){t.target.closest(".dropdown-submenu")&&t.target.closest(".dropdown-submenu").querySelector(".dropdown-menu").classList.remove("show")})),document.querySelectorAll(".mobile-category-toggle").forEach(function(t){t.addEventListener("click",function(e){if(this.getAttribute("data-bs-toggle")==="collapse"){e.preventDefault();const o=this.querySelector(".fas");o.classList.toggle("fa-chevron-up"),o.classList.toggle("fa-chevron-down")}const n=document.getElementById("mobileMenu");n&&bootstrap.Offcanvas.getInstance(n)&&bootstrap.Offcanvas.getInstance(n).hide()})})});document.addEventListener("DOMContentLoaded",function(){document.querySelectorAll('[id^="chapter-menu-button-"]').forEach(t=>{const e=t.id.replace("chapter-menu-button-",""),n=document.getElementById(`chapter-menu-${e}`);t.addEventListener("click",o=>{o.stopPropagation(),document.querySelectorAll('[id^="chapter-menu-"]:not(#chapter-menu-'+e+")").forEach(c=>{c.classList.add("hidden")}),n.classList.toggle("hidden")})}),document.addEventListener("click",t=>{document.querySelectorAll('[id^="chapter-menu-"]').forEach(e=>{!e.classList.contains("hidden")&&!e.contains(t.target)&&!t.target.matches('[id^="chapter-menu-button-"]')&&e.classList.add("hidden")})})});document.addEventListener("DOMContentLoaded",function(){document.querySelectorAll(".video-modal").forEach(e=>{e.addEventListener("hidden.bs.modal",function(){const o=this.querySelector("iframe"),c=o.src;o.src="",setTimeout(()=>{o.src=c},100)});const n=e.querySelector(".fullscreen-btn");n&&n.addEventListener("click",function(){e.requestFullscreen?e.requestFullscreen():e.webkitRequestFullscreen?e.webkitRequestFullscreen():e.msRequestFullscreen&&e.msRequestFullscreen()})})});
