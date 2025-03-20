/** Notyf init */
var notyf = new Notyf({
    duration: 5000,
    dismissible: true
});
document.addEventListener('DOMContentLoaded', function() {
    const videoPlayer = videojs('vid1');
    const videoLinks = document.querySelectorAll('.video-link');
    const videoCheckboxes = document.querySelectorAll('.video-checkbox');

    let currentVideoId = null;

    // Function to load video completion status from the server
    function loadVideoCompletionStatus() {
        fetch('/employee/get-video-completion-status', {
            method: 'GET',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() }
        })
        .then(response => response.json())
        .then(data => {
            data.forEach(video => {
                const checkbox = document.querySelector(`.video-checkbox[data-video-id="${video.video_id}"]`);
                if (checkbox) {
                    checkbox.checked = video.is_completed;
                    checkbox.disabled = video.is_completed;
                }
            });
        })
        .catch(error => console.error('Error loading video completion status:', error));
    }

    // Load video completion status when the page is loaded
    loadVideoCompletionStatus();

    // Function to load and play a video
      // Function to load video completion status from the server
      function loadVideoCompletionStatus() {
        fetch('/employee/get-video-completion-status', { // <--- API endpoint baru
            method: 'GET',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() }
        })
        .then(response => response.json())
        .then(data => {
            data.forEach(video => {
                const checkbox = document.querySelector(`.video-checkbox[data-video-id="${video.video_id}"]`);
                if (checkbox) {
                    checkbox.checked = video.is_completed;
                    checkbox.disabled = video.is_completed;
                }
            });
        })
        .catch(error => console.error('Error loading video completion status:', error));
    }

    // Function to reset checkbox state
    function resetCheckboxState(videoId) {
        const checkbox = document.querySelector(`.video-checkbox[data-video-id="${videoId}"]`);
        if (checkbox) {
            checkbox.checked = false;
            checkbox.disabled = true;
        }
    }

    // Function to handle completion update
    function handleCompletionUpdate(videoId, isCompleted) {
        fetch('/employee/update-lesson-completion', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': getCsrfToken() },
            body: JSON.stringify({ video_id: videoId, is_completed: isCompleted })
        })
        .then(response => response.json())
        .then(data => processCompletionResponse(data, videoId))
        .catch(error => handleCompletionError(error, videoId));
    }

    // Function to process completion response
    function processCompletionResponse(data, videoId) {
        if (data.message) {
            notyf.success(data.message);
            updateVideoNavigation(videoId);
            switch (data.next_step) {
                case 'quiz':          window.location.href = `/employee/quiz-info/${data.quiz_id}`; break;
                case 'next_chapter':  navigateToNextChapter(data.next_chapter_id, data.next_video_id); break;
                case 'course_completed': notyf.success('Selamat! Kursus telah selesai.'); break;
                case 'chapter_video_list': console.log('Video selesai dalam chapter.'); break;
            }
        } else if (data.error) {
            notyf.error(data.error);
            revertCheckboxState(videoId);
        }
    }

    // Function to navigate to the next chapter
    function navigateToNextChapter() {
        notyf.info('Mengarahkan ke chapter selanjutnya...');
        setTimeout(() => window.location.reload(), 1500);
    }

    // Function to handle completion error
    function handleCompletionError(error, videoId) {
        console.error('Error:', error);
        notyf.error('Terjadi kesalahan saat menyimpan progress.');
        revertCheckboxState(videoId);
    }

    // Function to revert checkbox state
    function revertCheckboxState(videoId) {
        const checkbox = document.querySelector(`.video-checkbox[data-video-id="${videoId}"]`);
        if (checkbox) checkbox.checked = false;
    }

    // Function to get CSRF token
    function getCsrfToken() {
        return document.querySelector('meta[name="csrf_token"]').getAttribute('content');
    }

    // Function to update video navigation
    function updateVideoNavigation(completedVideoId) {
        const completedVideoItem = document.querySelector(`.video-item[data-video-id="${completedVideoId}"]`);
        if (!completedVideoItem) return;

        const nextVideoItem = completedVideoItem.nextElementSibling;
        if (nextVideoItem && nextVideoItem.classList.contains('video-item')) {
            const nextVideoLink = nextVideoItem.querySelector('.video-link');
            if (nextVideoLink) {
                nextVideoLink.classList.remove('video-link-locked');
            }
        }
    }

    // Event listeners for video links
    document.querySelectorAll('.video-link').forEach(link => {
        link.addEventListener('click', (e) => {
            e.preventDefault();
            if (link.classList.contains('video-link-locked')) {
                notyf.error('Selesaikan video sebelumnya terlebih dahulu.');
                return;
            }
            loadVideo(link.dataset.videoId, link.dataset.videoPath, link.dataset.videoName);
        });
    });

    // Event listener for video time update
    videoPlayer.on('timeupdate', function() {
        const videoId = videoPlayer.currentVideoId;
        if (!videoId) return;

        const duration = videoPlayer.duration();
        const currentTime = videoPlayer.currentTime();
        const checkbox = document.querySelector(`.video-checkbox[data-video-id="${videoId}"]`);

        if (checkbox && !checkbox.disabled && !checkbox.checked && duration > 0 && currentTime >= duration * 0.98) {
            checkbox.disabled = false;
            checkbox.checked = true;
            handleCompletionUpdate(videoId, true);
        } else if (checkbox && checkbox.disabled && duration > 0 && currentTime > 0) {
            checkbox.disabled = false;
        }
    });

    // Event listener for video ended
    videoPlayer.on('ended', () => {
        const videoId = videoPlayer.currentVideoId;
        const checkbox = document.querySelector(`.video-checkbox[data-video-id="${videoId}"]`);
        if (checkbox && !checkbox.checked) {
            checkbox.checked = true;
            handleCompletionUpdate(videoId, true);
        }
    });

    // Prevent manual checkbox interaction
    videoCheckboxes.forEach(checkbox => {
        checkbox.addEventListener('click', function(e) {
            e.preventDefault();
            notyf.error('Checkbox otomatis tercentang setelah video selesai ditonton.');
        });
    });

    // Initialize player with first video and disable checkboxes initially
    const initialVideoLink = document.querySelector('.video-link:not(.video-link-locked)');
    if (initialVideoLink) {
        loadVideo(initialVideoLink.dataset.videoId, initialVideoLink.dataset.videoPath, initialVideoLink.dataset.videoName);
    }
    videoCheckboxes.forEach(checkbox => checkbox.disabled = true);

    // Lock video links initially, except the first video in each chapter
    document.querySelectorAll('.video-item').forEach((videoItem, index) => {
        if (index > 0 ) {
            const videoLink = videoItem.querySelector('.video-link');
            if (videoLink) {
                videoLink.classList.add('video-link-locked');
            }
        }
    });
});
