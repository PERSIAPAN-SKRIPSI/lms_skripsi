var tag = document.createElement('script');
tag.src = "https://www.youtube.com/iframe_api";
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);

let player;
let currentVideoId = '{{ $firstVideo->path_video }}'; // Initialize currentVideoId

function onYouTubeIframeAPIReady() {
    player = new YT.Player('main-video', {
        height: '500',
        width: '100%',
        videoId: '{{ $firstVideo->path_video }}',
        playerVars: {
            'playsinline': 1
        },
        events: {
            'onReady': onPlayerReady,
            'onStateChange': onPlayerStateChange
        }
    });
    // Initialize currentVideoId after player is ready, using data attribute from iframe if available
    const mainVideoIframe = document.getElementById('main-video');
    if (mainVideoIframe && mainVideoIframe.dataset && mainVideoIframe.dataset.videoId) {
        currentVideoId = mainVideoIframe.dataset.videoId;
    }
}

function onPlayerReady(event) {
    console.log('Player is Ready');
}

function onPlayerStateChange(event) {
    if (event.data === YT.PlayerState.ENDED) {
        markVideoCompleteAndLoadNext();
    }
}

function markVideoCompleteAndLoadNext() {
    const videoId = document.getElementById('main-video').dataset.videoId;
    if (!videoId) {
        console.log("No video ID found for completion tracking.");
        return;
    }

    localStorage.setItem(`video-${videoId}`, 'completed');
    updateCheckbox(videoId);

    loadNextVideo();
}

function loadNextVideo() {
    const currentVideoCheckbox = document.querySelector(`.video-checkbox[data-video-id="${currentVideoId}"]`);
    const nextFormCheck = currentVideoCheckbox?.closest('.form-check')?.nextElementSibling;
    let nextVideoLink = nextFormCheck?.querySelector('.video-link');

    if (!nextVideoLink) {
        // Check for next chapter
        const currentChapter = currentVideoCheckbox?.closest('.accordion-collapse');
        const nextChapterItem = currentChapter?.closest('.accordion-item')?.nextElementSibling;
        const nextChapterCollapse = nextChapterItem?.querySelector('.accordion-collapse');
        nextVideoLink = nextChapterCollapse?.querySelector('.video-link');
    }


    if (nextVideoLink) {
        const nextVideoId = nextVideoLink.dataset.videoId;
        const nextVideoPath = nextVideoLink.dataset.videoPath;
        const nextVideoName = nextVideoLink.dataset.videoName;
        currentVideoId = nextVideoId; // Update currentVideoId
        loadVideo(nextVideoId, nextVideoPath, nextVideoName);
    } else {
        alert('Congratulations, you have completed all videos in this course!');
        document.getElementById('complete-video-btn').disabled = true;
        document.getElementById('complete-video-btn').innerText = "Course Complete";
    }
}


function loadVideo(videoId, videoPath, videoName) {
    player.loadVideoById({
        videoId: videoPath,
        startSeconds: 0,
        suggestedQuality: 'large'
    });

    const videoTitle = document.querySelector('.wsus__course_header a');
    videoTitle.textContent = videoName;

    // Update video ID of player and checkbox as well
    const mainVideo = document.getElementById('main-video');
    mainVideo.dataset.videoId = videoId;
    currentVideoId = videoId; // Update global currentVideoId

    updateCheckbox(videoId);
}

function updateCheckbox(videoId) {
    const checkbox = document.querySelector(`.video-checkbox[data-video-id="${videoId}"]`);
    if (checkbox) {
        const isCompleted = localStorage.getItem(`video-${videoId}`) === 'completed';
        checkbox.checked = isCompleted === 'completed';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const videoLinks = document.querySelectorAll('.video-link');
    const videoCheckboxes = document.querySelectorAll('.video-checkbox');
    const completeButton = document.getElementById('complete-video-btn');

    // Load video when a video link is clicked
    videoLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const videoId = this.dataset.videoId;
            const videoPath = this.dataset.videoPath;
            const videoName = this.dataset.videoName;

            currentVideoId = videoId; // Update currentVideoId when link is clicked
            loadVideo(videoId, videoPath, videoName);
        });
    });

    // Check all video checkboxes on page load
    videoCheckboxes.forEach(checkbox => {
        const videoId = checkbox.dataset.videoId;
        updateCheckbox(videoId);
    });

    // Complete button functionality
    completeButton.addEventListener('click', function() {
        markVideoCompleteAndLoadNext();
    });
});
