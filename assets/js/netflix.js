/* =========================================
   0. HELPER: FIX IMAGE PATHS (Prevents 404 Errors)
   ========================================= */
function getImagePath(filename) {
    if (!filename) return "";
    // If it's an external link (http) or already has the folder, leave it
    if (filename.startsWith("http") || filename.includes("assets/images/")) {
        return filename;
    }
    // Otherwise, add the folder path
    return "assets/images/" + filename;
}

/* =========================================
   1. GLOBAL VARIABLES & FETCH LOGIC
   ========================================= */
let videos = []; // Empty array, filled by database
let currentVideoData = null; // Stores currently playing video info
let currentModalVideoUrl = ""; // Stores the video URL for the modal

// Elements
const videoPlayer = document.getElementById("myVideo");
const placeholderImage = document.getElementById("placeholderImage");
const titleLogo = document.getElementById("img-side");
const descriptionText = document.getElementById("text-div");
const muteButton = document.getElementById("muteButton");

// --- MAIN FUNCTION: Fetch Data from PHP ---
async function fetchMovies() {
    try {
        const response = await fetch("api/get_movies.php");
        if (!response.ok) throw new Error("Network response was not ok");

        videos = await response.json();
        console.log("Movies loaded from DB:", videos);

        if (videos.length > 0) {
            shuffleVideo();
        } else {
            console.error("Database returned empty list");
        }
    } catch (error) {
        console.error("Error fetching movies:", error);
    }
}
window.onload = fetchMovies;

/* =========================================
   2. VIDEO PLAYER LOGIC (With Mobile Image Swap)
   ========================================= */

// Helper to switch image based on screen size
function updateHeroImage() {
    if (!currentVideoData) return; // Safety check

    const isMobile = window.innerWidth <= 768;
    const desktopImg = currentVideoData.image_url;

    // Check if we have a mobile image, otherwise fallback to desktop
    const mobileImg =
        currentVideoData.mobile_image_url || currentVideoData.image_url;

    let finalImg = isMobile ? mobileImg : desktopImg;

    // FIX: Use the helper to ensure path is correct
    if (finalImg) {
        finalImg = getImagePath(finalImg);
    }

    // Only update if it's different (prevents flickering)
    if (placeholderImage.src !== finalImg) {
        placeholderImage.src = finalImg;
    }
}

function shuffleVideo() {
    if (!videoPlayer || videos.length === 0) return;

    const randomIndex = Math.floor(Math.random() * videos.length);
    const selectedVideo = videos[randomIndex];
    currentVideoData = selectedVideo;

    // 1. Set Video Source
    videoPlayer.src = selectedVideo.video_url;

    // 2. Set Image
    updateHeroImage();

    // 3. GENERATE HERO CONTENT
    const heroContent = document.getElementById("imgTextCont");
    const buttonHolder = document.querySelector(".buttonHolder");

    // FIX: Add path to Logo
    const logoSrc = selectedVideo.logo_url ? getImagePath(selectedVideo.logo_url) : "";

    heroContent.innerHTML = `
    <div class="img-div">
        <img src="${logoSrc}" alt="Title Logo">
    </div>
    <div class="text-div desktop-only" style="margin-bottom: 20px;">
        ${selectedVideo.description}
    </div>
    <div class="text-div mobile-only" style="color: white; font-size: 0.85rem; margin-bottom: 20px;">
        Exciting <span class="tags-dot">•</span> Reality TV <span class="tags-dot">•</span> Drama
    </div>
  `;

    buttonHolder.innerHTML = `
      <button class="side desktop-only" id="side-desktop">
          <svg xmlns="http://www.w3.org/2000/svg" height="20" width="15.5" viewBox="0 0 384 512"><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/></svg> <span>Play</span>
      </button>
      <button class="side1 desktop-only" id="side1-desktop">
          <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg> <span>More info</span>
      </button>

      <button class="mylist-btn mobile-only" id="add-to-list-hero">
          <div><svg width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg></div>
          <div><span>My List</span></div>
      </button>
      <button class="play-btn-mobile mobile-only" id="side-mobile">
          <svg width="24" height="24" viewBox="0 0 24 24" fill="black"><path d="M8 5v14l11-7z"/></svg>
          <span>Play</span>
      </button>
      <button class="info-btn mobile-only" id="side1-mobile">
          <div><svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg></div>
          <div><span>Info</span></div>
      </button>
  `;

    // --- ATTACH EVENT LISTENERS ---

    // 1. Play Buttons (Desktop & Mobile)
    const playHandler = () => openVideoPlayer(selectedVideo.full_video_url);
    document
        .getElementById("side-desktop")
        ?.addEventListener("click", playHandler);
    document
        .getElementById("side-mobile")
        ?.addEventListener("click", playHandler);

    // 2. Info Buttons (Desktop & Mobile)
    const infoHandler = () =>
        openModal(
            selectedVideo.image_url,
            selectedVideo.description,
            selectedVideo.title
        );
    document
        .getElementById("side1-desktop")
        ?.addEventListener("click", infoHandler);
    document
        .getElementById("side1-mobile")
        ?.addEventListener("click", infoHandler);

    // 3. MOBILE "ADD TO LIST" LOGIC
    const mobileListBtn = document.getElementById("add-to-list-hero");
    if (mobileListBtn) {
        mobileListBtn.addEventListener("click", () => {
            if (!selectedVideo.id) return;

            const formData = new FormData();
            formData.append("movie_id", selectedVideo.id);

            fetch("api/Notes.php", {
                method: "POST",
                body: formData,
            })
                .then((response) => response.text())
                .then((data) => {
                    if (data.includes("Success")) {
                        showToast("Added to My List");

                        // Change Icon to Checkmark
                        mobileListBtn.innerHTML = `
                  <div><svg width="24" height="24" viewBox="0 0 24 24" fill="white"><path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/></svg></div>
                  <div><span>Added</span></div>`;

                        loadMyList(); // Refresh the list row
                    } else if (data.includes("Already")) {
                        showToast("Already in your list");
                    } else {
                        showToast("Error adding to list");
                    }
                })
                .catch((err) => console.error(err));
        });
    }

    videoPlayer.load();
    videoPlayer.play().catch((error) => {
        console.log("Autoplay prevented:", error);
        showImage();
    });
}
// 4. ADD RESIZE LISTENER
window.addEventListener("resize", updateHeroImage);

function toggleMute() {
    if (videoPlayer.ended || videoPlayer.paused) {
        videoPlayer.currentTime = 0;
        videoPlayer.play();
        videoPlayer.muted = false;
        updateMuteIcon();
        return;
    }
    videoPlayer.muted = !videoPlayer.muted;
    updateMuteIcon();
}

function updateMuteIcon() {
    if (videoPlayer.muted) {
        muteButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#e8eaed"><path d="m612.67-322-47.34-47.33 110.67-110-110.67-110 47.34-47.34 110 110.67 110-110.67L880-589.33l-110.67 110 110.67 110L832.67-322l-110-110.67-110 110.67ZM120-360v-240h160l200-200v640L280-360H120Zm293.33-274-104 100.67H186.67v106.66h122.66l104 101.34V-634Zm-106 153.33Z"/></svg>`;
    } else {
        muteButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#e8eaed"><path d="M560-131v-68.67q94.67-27.33 154-105 59.33-77.66 59.33-176.33 0-98.67-59-176.67-59-78-154.33-104.66V-831q124 28 202 125.5T840-481q0 127-78 224.5T560-131ZM120-360v-240h160l200-200v640L280-360H120Zm426.67 45.33v-332Q599-628 629.5-582T660-480q0 55-30.83 100.83-30.84 45.84-82.5 64.5ZM413.33-634l-104 100.67H186.67v106.66h122.66l104 101.34V-634Zm-96 154Z"/></svg>`;
    }
}

const showImage = () => {
    videoPlayer.style.display = "none";
    placeholderImage.style.display = "block";
};
const showVideo = () => {
    videoPlayer.style.display = "block";
    placeholderImage.style.display = "none";
};

// --- EVENT LISTENERS ---
const setRestartIcon = () => {
    showImage();
    muteButton.innerHTML = `<svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#e8eaed"><path d="M440-122q-121-15-200.5-105.5T160-440q0-66 26-126.5T260-672l57 57q-38 34-57.5 79T240-440q0 88 56 155.5T440-202v80Zm80 0v-80q87-16 143.5-83T720-440q0-100-70-170t-170-70h-3l44 44-56 56-140-140 140-140 56 56-44 44h3q134 0 227 93t93 227q0 121-79.5 211.5T520-122Z"/></svg>`;
};
videoPlayer.addEventListener("ended", setRestartIcon);
videoPlayer.addEventListener("pause", setRestartIcon);

videoPlayer.addEventListener("play", () => {
    showVideo();
    updateMuteIcon();
});

/* =========================================
   3. HERO ANIMATION (Desktop Only)
   ========================================= */
let isMinimized = false;

videoPlayer.addEventListener("timeupdate", () => {
    if (window.innerWidth <= 768) {
        return;
    }
    if (videoPlayer.currentTime >= videoPlayer.duration / 3) {
        if (!isMinimized) {
            minimizeContent();
            isMinimized = true;
        }
    } else {
        if (isMinimized && videoPlayer.currentTime < videoPlayer.duration / 3) {
            maximizeContent();
            isMinimized = false;
        }
    }
});

function minimizeContent() {
    const container = document.getElementById("imgTextCont");
    const textElements = container ? container.querySelectorAll(".text-div") : [];
    if (container) {
        container.style.transition = "all 1.5s cubic-bezier(0.25, 0.46, 0.45, 0.94)";
        container.style.transform = "scale(0.6) translateY(80px)";
        container.style.transformOrigin = "bottom left";
    }
    textElements.forEach((el) => {
        el.style.transition = "opacity 0.5s ease";
        el.style.opacity = "0";
    });
}

function maximizeContent() {
    const container = document.getElementById("imgTextCont");
    const textElements = container ? container.querySelectorAll(".text-div") : [];
    if (container) {
        container.style.transform = "scale(1) translateY(0px)";
    }
    textElements.forEach((el) => {
        el.style.opacity = "1";
    });
}

/* =========================================
   4. MORE INFO MODAL (Fixed: Mobile Image & Full Video)
   ========================================= */
const modal = document.getElementById("movie-modal");
const closeModal = document.querySelector(".close-modal");
const moreInfoBtn = document.getElementById("side1-desktop");
const moreInfoBtnMobile = document.getElementById("side1-mobile");

function openModalWithData(videoData) {
    if (!videoData) return;

    const isMobile = window.innerWidth <= 768;
    let imageSrc = videoData.image_url;

    if (isMobile) {
        if (videoData.mobile_image_url) {
            imageSrc = videoData.mobile_image_url;
        } else {
            imageSrc = videoData.image_url.replace(/(\.[\w\d_-]+)$/i, "-mobile$1");
        }
    }

    // FIX: Prepend Path
    imageSrc = getImagePath(imageSrc);

    const videoLink = videoData.full_video_url || videoData.video_url;
    openModal(imageSrc, videoData.description, videoData.title, videoLink);
}

// --- CLICK LISTENERS ---
if (moreInfoBtn) {
    moreInfoBtn.addEventListener("click", () =>
        openModalWithData(currentVideoData)
    );
}
if (moreInfoBtnMobile) {
    moreInfoBtnMobile.addEventListener("click", () =>
        openModalWithData(currentVideoData)
    );
}

// Universal Row Click (Fallback)
const allMovieCards = document.querySelectorAll(
    ".firstRow, .bestRow, #GamesArea"
);
allMovieCards.forEach((card) => {
    card.addEventListener("click", (e) => {
        const img = card.querySelector("img");
        if (img) {
            openModal(img.src, "Watch this title now.", "Selected Title", "");
        }
    });
});

// --- MODAL OPEN FUNCTION ---
function openModal(imageSrc, description, title, videoUrl) {
    if (!modal) return;

    // FIX: ensure path again just in case
    document.getElementById("modal-img").src = getImagePath(imageSrc);
    document.getElementById("modal-title").innerText = title || "Unknown Title";
    document.getElementById("modal-desc").innerText =
        description || "No description available.";

    currentModalVideoUrl = videoUrl;
    console.log("Modal Opened. Ready to play:", currentModalVideoUrl);

    modal.style.display = "block";
    document.body.style.overflow = "hidden";
}

const playBtnInsideModal = document.querySelector(".modal-play");
if (playBtnInsideModal) {
    playBtnInsideModal.addEventListener("click", () => {
        if (currentModalVideoUrl) {
            openVideoPlayer(currentModalVideoUrl);
        } else {
            console.error("No video URL found for this modal item");
        }
    });
}

if (closeModal) {
    closeModal.addEventListener("click", () => {
        modal.style.display = "none";
        document.body.style.overflow = "auto";
    });
}
window.addEventListener("click", (e) => {
    if (e.target == modal) {
        modal.style.display = "none";
        document.body.style.overflow = "auto";
    }
});

/* =========================================
   5. UI INTERACTIONS (Scroll, Search, Mobile)
   ========================================= */
function handleScroll(button) {
    const wrapper = button.parentElement.parentElement;
    const container =
        wrapper.querySelector('div[id^="firstRowCont"]') ||
        wrapper.querySelector(".GamesCont");
    if (!container) return;

    const scrollAmount = container.clientWidth;
    const maxScrollLeft = container.scrollWidth - container.clientWidth;
    const isLeft = button.parentElement.classList.contains("scrollButton");

    if (isLeft) {
        container.scrollBy({ left: -scrollAmount, behavior: "smooth" });
    } else {
        if (container.scrollLeft >= maxScrollLeft - 10) {
            container.scrollTo({ left: 0, behavior: "smooth" });
        } else {
            container.scrollBy({ left: scrollAmount, behavior: "smooth" });
        }
    }
}

window.addEventListener("scroll", () => {
    const nav = document.getElementById("nav-bar");
    if (window.scrollY > 50) {
        nav.classList.add("scrolled");
    } else {
        nav.classList.remove("scrolled");
    }
});

window.selectProfile = function (name) {
    const gate = document.getElementById("profile-gate");
    if (gate) {
        gate.style.opacity = "0";
        setTimeout(() => {
            gate.style.display = "none";
            if (videoPlayer && videos.length > 0) videoPlayer.play();
        }, 500);
    }
};

const searchBox = document.getElementById("search-box");
const searchBtn = document.querySelector(".search-btn");
const searchInput = document.querySelector(".search-box input");

if (searchBtn && searchBox && searchInput) {
    searchBtn.addEventListener("click", () => {
        searchBox.classList.toggle("active");
        if (searchBox.classList.contains("active")) searchInput.focus();
    });

    searchInput.addEventListener("keyup", (e) => {
        const term = e.target.value.toLowerCase();
        const allImages = document.querySelectorAll(
            ".firstRow img, #GamesArea img, .bestRow img"
        );

        allImages.forEach((img) => {
            const src = img.getAttribute("src").toLowerCase();
            let card = img.parentElement;
            if (card.classList.contains("imgbesidesvg")) card = card.parentElement;

            if (src.includes(term)) {
                card.style.display = "block";
            } else {
                card.style.display = "none";
            }
        });

        const allWrappers = document.querySelectorAll(".row-wrapper");
        allWrappers.forEach((wrapper) => {
            const title = wrapper.previousElementSibling;
            const isTitle = title && title.classList.contains("text-area");
            const cards = wrapper.querySelectorAll(".firstRow, .bestRow, #GamesArea");
            let hasVisibleCards = Array.from(cards).some(
                (c) => c.style.display !== "none"
            );

            if (hasVisibleCards) {
                wrapper.style.display = "block";
                if (isTitle) title.style.display = "block";
            } else {
                wrapper.style.display = "none";
                if (isTitle) title.style.display = "none";
            }
        });
    });
}

const mobileMenu = document.getElementById("mobile-menu");
const hamburgerBtn = document.getElementById("hamburger-btn");
if (hamburgerBtn) {
    hamburgerBtn.addEventListener("click", () => {
        mobileMenu.classList.add("open");
    });
}
window.toggleMobileMenu = function () {
    if (mobileMenu) mobileMenu.classList.remove("open");
};

// Skeletons
document.addEventListener("DOMContentLoaded", () => {
    const images = document.querySelectorAll("img.skeleton");
    images.forEach((img) => {
        if (img.complete) img.classList.remove("skeleton");
        else img.addEventListener("load", () => img.classList.remove("skeleton"));
    });
});

/* =========================================
   9. DYNAMIC MY LIST FEATURE
   ========================================= */
const addListBtn = document.getElementById("add-to-list-btn");
if (addListBtn) {
    addListBtn.addEventListener("click", () => {
        if (!currentVideoData || !currentVideoData.id) {
            showToast("Error: No movie selected");
            return;
        }
        const formData = new FormData();
        formData.append("movie_id", currentVideoData.id);

        fetch("api/Notes.php", {
            method: "POST",
            body: formData,
        })
            .then((response) => response.text())
            .then((data) => {
                if (data.includes("Success")) {
                    showToast("Added to My List");
                    loadMyList();
                } else if (data.includes("Already")) {
                    showToast("Already in your list");
                } else {
                    showToast("Error adding to list");
                }
            });
    });
}

// Load My List Function
async function loadMyList() {
    const listContainer = document.getElementById("firstRowContr");
    if (!listContainer) return;

    try {
        const response = await fetch("api/get_my_list.php");
        const movies = await response.json();

        listContainer.innerHTML = "";
        if (movies.length === 0) return;

        movies.forEach((movie) => {
            const div = document.createElement("div");
            div.className = "firstRow";

            let imgPath = movie.image_url || movie.image;
            // FIX: Use Helper
            imgPath = getImagePath(imgPath);

            div.innerHTML = `<img src="${imgPath}" alt="${movie.title}" loading="lazy">`;

            div.addEventListener("click", () => {
                const desc = movie.description || "No description";
                const movieLink = movie.full_video_url || movie.video_url;
                openModal(imgPath, desc, movie.title, movieLink);
            });

            listContainer.appendChild(div);
        });
    } catch (error) {
        console.error("Error loading My List:", error);
    }
}
document.addEventListener("DOMContentLoaded", loadMyList);

/* =========================================
   10. UTILITY: TOAST NOTIFICATIONS
   ========================================= */
function showToast(message) {
    const toast = document.getElementById("toast-box");
    if (toast) {
        toast.innerText = message;
        toast.className = "show";
        setTimeout(function () {
            toast.className = toast.className.replace("show", "");
        }, 3000);
    } else {
        alert(message);
    }
}

/* =========================================
   11. NEW: FULL SCREEN VIDEO PLAYER
   ========================================= */
const videoOverlay = document.getElementById("video-player-overlay");
const fullScreenVideo = document.getElementById("full-screen-video");
const youtubePlayer = document.getElementById("youtube-player");
const closeVideoBtn = document.getElementById("close-video-btn");
const heroPlayBtn = document.getElementById("side");
const modalPlayBtn = document.querySelector(".modal-play");

function openVideoPlayer(url) {
    if (!url) {
        showToast("Error: No episode available");
        return;
    }

    if (videoPlayer) videoPlayer.pause();
    if (videoOverlay) videoOverlay.classList.add("active");

    const lowerUrl = url.toLowerCase();
    const isYouTube = lowerUrl.includes("youtube.com") || lowerUrl.includes("youtu.be");
    const isGoogleDrive = lowerUrl.includes("drive.google.com");

    if (isYouTube || isGoogleDrive) {
        // --- DISABLE MP4 PLAYER ---
        if (fullScreenVideo) {
            fullScreenVideo.pause();
            fullScreenVideo.removeAttribute("src");
            fullScreenVideo.style.display = "none";
        }

        // --- ENABLE IFRAME PLAYER ---
        if (youtubePlayer) {
            youtubePlayer.style.display = "block";

            if (isGoogleDrive) {
                // 1. EXTRACT THE PURE ID (Removes ?usp=sharing, /view, etc.)
                // This Regex looks for the ID between /d/ and the next slash
                const idMatch = url.match(/\/d\/([a-zA-Z0-9_-]+)/);

                if (idMatch && idMatch[1]) {
                    // 2. FORCE A CLEAN PREVIEW URL
                    youtubePlayer.src = `https://drive.google.com/file/d/${idMatch[1]}/preview`;
                } else {
                    // Fallback if the link is weird
                    youtubePlayer.src = url.replace("/view", "/preview");
                }
            } 
            else if (isYouTube) {
                youtubePlayer.src = url.includes("autoplay")
                    ? url
                    : url + (url.includes("?") ? "&" : "?") + "autoplay=1";
            }
        }
    } else {
        // --- MP4 MODE ---
        if (youtubePlayer) {
            youtubePlayer.style.display = "none";
            youtubePlayer.src = "";
        }
        if (fullScreenVideo) {
            fullScreenVideo.style.display = "block";
            fullScreenVideo.src = url;
            fullScreenVideo.play().catch((e) => console.error("Play error:", e));
        }
    }
}
function closeVideoPlayer() {
    if (videoOverlay) videoOverlay.classList.remove("active");
    if (fullScreenVideo) {
        fullScreenVideo.pause();
        fullScreenVideo.src = "";
    }
    if (youtubePlayer) {
        youtubePlayer.src = "";
    }
}

if (closeVideoBtn) closeVideoBtn.addEventListener("click", closeVideoPlayer);

if (heroPlayBtn) {
    heroPlayBtn.addEventListener("click", () => {
        if (currentVideoData && currentVideoData.full_video_url) {
            openVideoPlayer(currentVideoData.full_video_url);
        } else {
            console.log("No full movie found, playing trailer.");
            openVideoPlayer(currentVideoData.video_url);
        }
    });
}

if (modalPlayBtn) {
    modalPlayBtn.addEventListener("click", () => {
        if (currentModalVideoUrl) {
            openVideoPlayer(currentModalVideoUrl);
        } else if (currentVideoData && currentVideoData.full_video_url) {
            openVideoPlayer(currentVideoData.full_video_url);
        }
    });
}

const navItems = document.querySelectorAll(".nav-item");
navItems.forEach((item) => {
    item.addEventListener("click", () => {
        navItems.forEach((nav) => nav.classList.remove("active"));
        item.classList.add("active");
    });
});

/* =========================================
   MOBILE INTERACTIVITY
   ========================================= */
const mobileSearchContainer = document.getElementById("mobile-search-trigger");
const mobileSearchInput2 = document.getElementById("mobile-search-input");

if (mobileSearchContainer) {
    mobileSearchContainer.addEventListener("click", (e) => {
        if (e.target === mobileSearchInput2) return;
        mobileSearchContainer.classList.toggle("active");
        if (mobileSearchContainer.classList.contains("active")) {
            mobileSearchInput2.focus();
        }
    });
}

const subNavSpans = document.querySelectorAll(".mobile-subnav span");
subNavSpans.forEach((span) => {
    span.addEventListener("click", function () {
        const text = this.innerText.trim();
        filterContent(text);
        subNavSpans.forEach((s) => (s.style.color = "#b3b3b3"));
        this.style.color = "white";
        this.style.fontWeight = "bold";
    });
});

function filterContent(category) {
    const allRows = document.querySelectorAll(".row-wrapper");
    allRows.forEach((row) => {
        const rowCategory = row.getAttribute("data-category");
        if (category === "TV Shows") {
            if (rowCategory === "tv") row.style.display = "block";
            else if (rowCategory === "movie") row.style.display = "none";
        } else if (category === "Movies") {
            if (rowCategory === "movie") row.style.display = "block";
            else if (rowCategory === "tv") row.style.display = "none";
        } else {
            row.style.display = "block";
        }
    });
}

document.addEventListener("DOMContentLoaded", () => {
    const splash = document.getElementById("splash-screen");
    const contentWrapper = document.querySelector(".wrapper");
    const isUserLoggedIn = contentWrapper && contentWrapper.style.display !== "none";

    setTimeout(() => {
        if (isUserLoggedIn) {
            splash.classList.add("hidden");
            setTimeout(() => {
                splash.style.display = "none";
            }, 600);
        } else {
            window.location.href = "login.php";
        }
    }, 3500);
});

const mobileMuteBtn = document.getElementById("mobile-mute-btn");
const mobileRestartBtn = document.getElementById("mobile-restart-btn");
const iconMuted = document.getElementById("icon-muted");
const iconUnmuted = document.getElementById("icon-unmuted");

if (mobileMuteBtn && videoPlayer) {
    mobileMuteBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        if (videoPlayer.muted) {
            videoPlayer.muted = false;
            iconMuted.style.display = "none";
            iconUnmuted.style.display = "block";
        } else {
            videoPlayer.muted = true;
            iconMuted.style.display = "block";
            iconUnmuted.style.display = "none";
        }
    });
}

if (mobileRestartBtn && videoPlayer) {
    const handleRestart = (e) => {
        if (e.cancelable) e.preventDefault();
        e.stopPropagation();
        videoPlayer.load();
        videoPlayer.currentTime = 0;
        videoPlayer.play();
        videoPlayer.muted = false;
        if (iconMuted && iconUnmuted) {
            iconMuted.style.display = "none";
            iconUnmuted.style.display = "block";
        }
    };
    mobileRestartBtn.addEventListener("click", handleRestart);
    mobileRestartBtn.addEventListener("touchstart", handleRestart, { passive: false });
}

/* =========================================
   PROFILE SYSTEM
   ========================================= */
document.addEventListener("DOMContentLoaded", () => {
    if (document.getElementById("profile-gate")) {
        loadProfiles();
    }
});

function loadProfiles() {
    const container = document.getElementById("profile-list-container");
    fetch("api/get_profiles.php")
        .then((res) => res.json())
        .then((profiles) => {
            container.innerHTML = "";
            profiles.forEach((p) => {
                // FIX: Use Helper for profile image
                const profileImg = getImagePath(p.profile_img);

                const html = `
                <div class="profile-box" onclick="enterProfile(${p.id}, '${p.profile_img}')">
                    <div class="profile-icon">
                        <img src="${profileImg}" alt="${p.profile_name}">
                    </div>
                    <span>${p.profile_name}</span>
                </div>
            `;
                container.innerHTML += html;
            });
        });
}

function enterProfile(id, img) {
    // We send just the filename to PHP (which is safe), but display full path in JS
    fetch(`api/set_active_profile.php?id=${id}&img=${encodeURIComponent(img)}`);

    document.getElementById("profile-gate").style.display = "none";
    document.querySelector(".wrapper").style.display = "block";

    // FIX: Update images with Full Path
    const fullImgPath = getImagePath(img);

    const headerImg = document.querySelector("#image-drop img");
    if (headerImg) headerImg.src = fullImgPath;

    const mobileImg = document.querySelector(".nav-profile-mobile img");
    if (mobileImg) mobileImg.src = fullImgPath;
}

let selectedAvatar = "AAAABQYlg7rw1jw8D4qZVkZSRxxRxXOwsY6wiZLThDOU9YkDTz8PyAUd1_98emUrSzgoPSTjDiMgattAyGUJoEnjCeNkH-3rlvE4Tg.png";

function openCreateProfileModal() {
    document.getElementById("create-profile-modal").style.display = "flex";
}

function closeCreateProfileModal() {
    document.getElementById("create-profile-modal").style.display = "none";
}

function selectNewAvatar(imgEl) {
    // 1. Get the full source from the image
    let fullSrc = imgEl.getAttribute("src");
    // 2. Extract just the filename to store in variable (for PHP)
    // This splits by "/" and takes the last part (the filename)
    selectedAvatar = fullSrc.split('/').pop();

    // 3. Show preview (Full Path)
    document.getElementById("new-profile-preview").src = fullSrc;

    document.querySelectorAll(".avatar-option").forEach((el) => (el.style.border = "2px solid transparent"));
    imgEl.style.border = "2px solid white";
}

function submitNewProfile() {
    const name = document.getElementById("new-profile-name").value;
    if (!name) return alert("Enter a name");

    const formData = new FormData();
    formData.append("profile_name", name);
    // Send ONLY the filename to PHP (because your PHP checks a whitelist of filenames)
    formData.append("profile_img", selectedAvatar);

    fetch("api/add_profile.php", {
        method: "POST",
        body: formData,
    })
        .then((res) => res.text())
        .then((data) => {
            if (data.trim() === "Success") {
                closeCreateProfileModal();
                loadProfiles();
            } else {
                alert("Error: " + data);
            }
        });
}