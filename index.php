<?php
session_start();
include 'includes/db_connection.php';

$isLoggedIn = isset($_SESSION['user']) ? 'true' : 'false';

// 1. Define the correct folder path
$basePath = "assets/images/";
$defaultAvatar = "AAAABQYlg7rw1jw8D4qZVkZSRxxRxXOwsY6wiZLThDOU9YkDTz8PyAUd1_98emUrSzgoPSTjDiMgattAyGUJoEnjCeNkH-3rlvE4Tg.png";

// 2. Start with the default
$imgName = $defaultAvatar;

// 3. Check Session (Active Profile)
if (isset($_SESSION['active_profile_img']) && !empty($_SESSION['active_profile_img'])) {
    $imgName = $_SESSION['active_profile_img'];
} 
// 4. Check Database (Main Account)
elseif (isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $sql = "SELECT profile_img FROM users WHERE id = '$userId'";
    $result = mysqli_query($conn, $sql);
    if ($row = mysqli_fetch_assoc($result)) {
        if (!empty($row['profile_img'])) {
            $imgName = $row['profile_img'];
        }
    }
}

// 5. FINAL FIX: Ensure the path is correct
// If the name already has "assets/images/", don't add it again.
if (strpos($imgName, $basePath) === false) {
    $currentProfileImg = $basePath . $imgName;
} else {
    $currentProfileImg = $imgName;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Personal Project</title>
   <link rel="stylesheet" href="assets/css/styles.css">
    <meta name="google-site-verification" content="0BUTgV0_WFAbnN7HYSYjMPcBECiq6GlosBrblwg27ao" />
</head>
<body>
<div id="splash-screen">
        <div class="netflix-intro">
            <span>N</span>
            <span>E</span>
            <span>T</span>
            <span>F</span>
            <span>L</span>
            <span>I</span>
            <span>X</span>
        </div>
    </div>

    <?php if ($isLoggedIn == 'true'): ?>
    <div class="wrapper">
    <?php else: ?>
    <div class="wrapper" style="display:none;"> <?php endif; ?>
    
        </div>










<div id="profile-gate" class="profile-gate">
    <div class="profile-header">
        <img src="assets/images/Netflix_Logo_CMYK.png" alt="Netflix" class="edit-logo" style="height: 40px;">
    </div>

    <h2>Who's Watching?</h2>

    <div class="profile-container" id="profile-list-container">
        </div>
    
    <div class="profile-container" style="margin-top: 0;">
         <div class="profile-box" onclick="openCreateProfileModal()">
            <div class="profile-icon add-profile">
                <svg viewBox="0 0 24 24" width="40" height="40"><path fill="white" d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
            </div>
            <span>Add Profile</span>
        </div>
    </div>
</div>

<div id="create-profile-modal" class="modal-overlay" style="display:none; align-items:center; justify-content:center;">
    <div class="profile-content" style="background:#141414; padding:30px; border-radius:8px; text-align:center; max-width:500px; width:90%;">
        <h2 style="color:white; margin-bottom:20px;">Add Profile</h2>
        
        <div style="margin-bottom:20px;">
            <img id="new-profile-preview" src="assets/images/AAAABQYlg7rw1jw8D4qZVkZSRxxRxXOwsY6wiZLThDOU9YkDTz8PyAUd1_98emUrSzgoPSTjDiMgattAyGUJoEnjCeNkH-3rlvE4Tg.png" style="width:100px; height:100px; border-radius:4px;">
        </div>

        <input type="text" id="new-profile-name" placeholder="Name" style="background:#333; border:1px solid #555; color:white; padding:10px; width:80%; font-size:1.2rem; margin-bottom:20px;">

        <h3 style="color:#999; font-size:1rem; margin-bottom:10px;">Choose Icon:</h3>
        
        <div class="avatar-grid" style="display:flex; gap:10px; justify-content:center; flex-wrap:wrap; margin-bottom:20px;">
            <img src="assets/images/AAAABQYlg7rw1jw8D4qZVkZSRxxRxXOwsY6wiZLThDOU9YkDTz8PyAUd1_98emUrSzgoPSTjDiMgattAyGUJoEnjCeNkH-3rlvE4Tg.png" class="avatar-option" onclick="selectNewAvatar(this)">
            <img src="assets/images/✨my history teacher✨.jpeg" class="avatar-option" onclick="selectNewAvatar(this)">
            <img src="assets/images/movie board.jpeg" class="avatar-option" onclick="selectNewAvatar(this)">
            <img src="assets/images/Player 456.jpeg" class="avatar-option" onclick="selectNewAvatar(this)">
            <img src="assets/images/kids.jpg" class="avatar-option" onclick="selectNewAvatar(this)">
        </div>

        <div>
            <button onclick="submitNewProfile()" style="background:white; color:black; padding:10px 30px; border:none; font-weight:bold; cursor:pointer; margin-right:10px;">Save</button>
            <button onclick="closeCreateProfileModal()" style="background:transparent; border:1px solid #555; color:#555; padding:10px 30px; font-weight:bold; cursor:pointer;">Cancel</button>
        </div>
    </div>
</div>



<div class="wrapper">

 <header>
    <div class="nav-bar" id="nav-bar">
        
        <div class="logo">
            <img src="assets/images/Netflix_Logo_CMYK.png" alt="Netflix" class="desktop-only">
            <img src="assets/images/Netflix_Symbol_RGB.png" alt="N" class="mobile-only" style="height: 40px;">
        </div>

        <div class="links desktop-only">
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">TV Shows</a></li>
                <li><a href="#">Movies</a></li>
                <li><a href="#">New and Popular</a></li>
                <li><a href="#">My List</a></li>
                <li><a href="#">Browse by Languages</a></li>
            </ul>
        </div>

        <div class="right desktop-only">
            <div id="search-holder">
                <div class="search-box" id="search-box">
                    <button class="search-btn">
                        
<svg width="24" height="24" viewBox="0 0 24 24" fill="white">
    <path d="M15.5 14h-.79l-.28-.27C15.41 12.59 16 11.11 16 9.5 16 5.91 13.09 3 9.5 3S3 5.91 3 9.5 5.91 16 9.5 16c1.61 0 3.09-.59 4.23-1.57l.27.28v.79l5 4.99L20.49 19l-4.99-5zm-6 0C7.01 14 5 11.99 5 9.5S7.01 5 9.5 5 14 7.01 14 9.5 11.99 14 9.5 14z"/>
</svg>
                    </button>
                    <input type="text" name="search_query" id="search-box" placeholder="Titles, people, genres">
                </div>
            </div> 
            
            <div class="kids" style="font-weight: 300;">Kids</div>
            
            <div class="alert" id="alert">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e8eaed"><path d="M160-200v-66.67h80v-296q0-83.66 49.67-149.5Q339.33-778 420-796v-24q0-25 17.5-42.5T480-880q25 0 42.5 17.5T540-820v24q80.67 18 130.33 83.83Q720-646.33 720-562.67v296h80V-200H160Zm320-301.33ZM480-80q-33 0-56.5-23.5T400-160h160q0 33-23.5 56.5T480-80ZM306.67-266.67h346.66v-296q0-72-50.66-122.66Q552-736 480-736t-122.67 50.67q-50.66 50.66-50.66 122.66v296Z"/></svg>
                <div id="under-alert"><div class="arrowtop"></div><div style="padding:20px; text-align:center; color:#777;">No new notifications</div></div>
            </div>

            <div class="profile-drop">
   <div class="img-cont" id="image-drop">
    <img src="<?php echo htmlspecialchars($currentProfileImg); ?>" alt="Profile">
</div>
                <svg id="drop-butt" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M480-360 280-559.33h400L480-360Z"/></svg>
                <div id="better-approach">
                    <div class="arrowtop"></div>
                    <div id="under-drop">
                        <div class="linkarea">
                            <a href="#">Link 1</a>
                            <a href="#">Link 2</a>
                            <a href="logout.php">Sign out</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mobile-right mobile-only">
             <svg width="24" height="24" viewBox="0 0 24 24" style="margin-right: 20px;"><path fill="white" d="M1 18v3h3c0-1.66-1.34-3-3-3zm0-4v2c2.76 0 5 2.24 5 5h2c0-3.87-3.13-7-7-7zm0-4v2c4.97 0 9 4.03 9 9h2c0-6.08-4.92-11-11-11zm20-7H3c-1.1 0-2 .9-2 2v3h2V5h18v14h-7v2h7c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2z"/></svg>
            
           <div class="search-box-mobile" id="mobile-search-trigger">
     <button class="search-btn-mobile">
         <svg xmlns="http://www.w3.org/2000/svg" height="24" width="24" viewBox="0 -960 960 960" fill="white"><path d="M784-120 532-372q-30 24-69 38t-83 14q-109 0-184.5-75.5T120-580q0-109 75.5-184.5T380-840q109 0 184.5 75.5T640-580q0 44-14 83t-38 69l252 252-56 56ZM380-200q158 0 269-111t111-269q0-158-111-269T380-760q-158 0-269 111T0-580q0 158 111 269t269 111Z"/></svg>
     </button>
     <input type="text" id="mobile-search-input" placeholder="Search...">
</div>

          <div class="nav-profile-mobile">
    <img src="<?php echo htmlspecialchars($currentProfileImg); ?>" alt="Profile">
</div>
        </div>

    </div> <div class="mobile-subnav mobile-only">
        <span>TV Shows</span>
        <span>Movies</span>
        <span>Categories <svg width="20" height="20" viewBox="0 0 24 24" fill="white" style="margin-left:5px;"><path d="M7 10l5 5 5-5z"/></svg></span>
    </div>

</header>

        <div class="vid-cont">
    <div class="ontopVideo">
        <div id="imgTextCont">
            <div class="img-div"><img alt="" id="img-side" src=""></div> 
            <div class="text-div" id="text-div"></div>
        </div>
        <div class="buttonHolder">
            <button class="side" id="side">
                <svg xmlns="http://www.w3.org/2000/svg" height="20" width="15.5" viewBox="0 0 384 512"><path d="M73 39c-14.8-9.1-33.4-9.4-48.5-.9S0 62.6 0 80L0 432c0 17.4 9.4 33.4 24.5 41.9s33.7 8.1 48.5-.9L361 297c14.3-8.7 23-24.2 23-41s-8.7-32.2-23-41L73 39z"/></svg> <span>Play</span>
            </button>
            <button class="side1" id="side1">
                <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#ffffff"><path d="M440-280h80v-240h-80v240Zm40-320q17 0 28.5-11.5T520-640q0-17-11.5-28.5T480-680q-17 0-28.5 11.5T440-640q0 17 11.5 28.5T480-600Zm0 520q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/></svg> <span>More info</span>
            </button>
        </div>
    </div>

<video 
    id="myVideo" 
    width="100%" 
    height="100%" 
    autoplay 
    muted 
    playsinline 
    webkit-playsinline
    preload="auto">
</video>
    
    <div class="mobile-controls mobile-only">
        <button id="mobile-mute-btn" class="control-btn">
            <svg id="icon-muted" width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M16.5 12c0-1.77-1.02-3.29-2.5-4.03v2.21l2.45 2.45c.03-.2.05-.41.05-.63zm2.5 0c0 .94-.2 1.82-.54 2.64l1.51 1.51C20.63 14.91 21 13.5 21 12c0-4.28-2.99-7.86-7-8.77v2.06c2.89.86 5 3.54 5 6.71zM4.27 3L3 4.27 7.73 9H3v6h4l5 5v-6.73l4.25 4.25c-.67.52-1.42.93-2.25 1.18v2.06c1.38-.31 2.63-.95 3.69-1.81L19.73 21 21 19.73 4.27 3zM12 4L9.91 6.09 12 8.18V4z"/></svg>
            <svg id="icon-unmuted" width="20" height="20" viewBox="0 0 24 24" fill="white" style="display:none;"><path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02zM14 3.23v2.06c2.89.86 5 3.54 5 6.71s-2.11 5.85-5 6.71v2.06c4.01-.91 7-4.49 7-8.77s-2.99-7.86-7-8.77z"/></svg>
        </button>

        <button id="mobile-restart-btn" class="control-btn">
            <svg width="20" height="20" viewBox="0 0 24 24" fill="white"><path d="M12 5V1L7 6l5 5V7c3.31 0 6 2.69 6 6s-2.69 6-6 6-6-2.69-6-6H4c0 4.42 3.58 8 8 8s8-3.58 8-8-3.58-8-8-8z"/></svg>
        </button>
    </div>

    <img id="placeholderImage" src="" alt="Video Placeholder" style="display: none;">
    
    <div class="buttonOut desktop-only">
        <button id="muteButton" onclick="toggleMute()">
            <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#e8eaed"><path d="m612.67-322-47.34-47.33 110.67-110-110.67-110 47.34-47.34 110 110.67 110-110.67L880-589.33l-110.67 110 110.67 110L832.67-322l-110-110.67-110 110.67ZM120-360v-240h160l200-200v640L280-360H120Zm293.33-274-104 100.67H186.67v106.66h122.66l104 101.34V-634Zm-106 153.33Z"/></svg>
        </button>
    </div>
    <div class="agePortion">18+</div>
</div>

        <div class="moviePart">
            <div class="undermoviePart"></div>
            
            <div class="text-area"><b>New on Netflix</b></div>
            <div class="row-wrapper" data-category="all">
                <div id="firstRowCont">
                    <div class="firstRow"><img class="skeleton" src="assets/images/AAAABRPuYTPDmt7ZdZ_WaNDgE3owVmisxoLyHpSgc6m8xz3MvUhkpuo39xyiRRTA9_ODLhMe9Lpyyv1yzySpHuz7XrG08pazXLhSDRKzFbU9YHy-LLTTuodJikAZPvbgMvpzQ1cG.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/omo.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/3.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/4.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/5.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/6.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/7.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/8.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/10.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/11.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/12.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/13.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/14.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/15.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/16.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/17.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/18.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/19.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/20.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/21.jpg" alt="" loading="lazy"></div>
                </div>
                <div class="scrollButton">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg></button>
                </div>
                <div class="scrollButton1">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg></button>
                </div>
            </div>

            <div class="text-area"><b>Continue Watching for Kolise</b></div>
            <div class="row-wrapper" >
                <div id="firstRowCont2">
                    <div class="firstRow"><img class="skeleton" src="assets/images/1...webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/2.+.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/3...jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/4...jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/5...jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/6...webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/7...jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/8...jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/9...jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/10...webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/11...webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/12...jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/13...webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/14...webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/15...webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/16...webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/17...webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/18...webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/19...jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/20...jpg" alt="" loading="lazy"></div>
                </div>
                <div class="scrollButton">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg></button>
                </div>
                <div class="scrollButton1">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg></button>
                </div>
            </div>

            <div class="text-area"><b>Top 10 TV Shows in Nigeria Today</b></div>
            <div class="row-wrapper" data-category="tv">
                <div id="firstRowCont3">
                    <div class="bestRow">
                        <div class="svg-holder"><svg id="rank-1" width="100%" height="100%" viewBox="-20 0 70 154" class="svg-icon svg-icon-rank-1 top-10-rank"><path stroke="#595959" stroke-width="4" d="M35.377 152H72V2.538L2 19.362v30.341l33.377-8.459V152z"></path></svg></div>
                        <div class="imgbesidesvg"><img class="skeleton" src="assets/images/1tv.jpg" alt="" loading="lazy"></div>
                    </div>
                    <div class="bestRow">
                        <div class="svg-holder"><svg id="rank-2" width="100%" height="100%" viewBox="0 0 80 154" class="svg-icon svg-icon-rank-2 top-10-rank"><path stroke="#595959" stroke-width="4" d="M3.72 152H113v-30.174H50.484l4.355-3.55 29.453-24.012c5.088-4.124 9.748-8.459 13.983-13.004 4.16-4.464 7.481-9.339 9.972-14.629 2.449-5.203 3.678-11.113 3.678-17.749 0-9.428-2.294-17.627-6.875-24.645-4.597-7.042-10.941-12.494-19.07-16.376C77.803 3.957 68.496 2 58.036 2 47.591 2 38.37 4.023 30.347 8.06c-8.015 4.032-14.457 9.578-19.352 16.654-4.492 6.493-7.389 13.803-8.693 21.952h34.055c1.236-3.52 3.398-6.52 6.459-8.97 3.54-2.834 8.277-4.224 14.147-4.224 5.93 0 10.552 1.537 13.76 4.681 3.181 3.12 4.791 7.024 4.791 11.594 0 4.151-1.16 7.934-3.468 11.298-2.192 3.194-5.987 7.124-11.405 11.84L3.72 122.465V152z"></path></svg></div>
                        <div class="imgbesidesvg"><img class="skeleton" src="assets/images/2tv.webp" alt="" loading="lazy"></div>
                    </div>
                    <div class="bestRow">
                        <div class="svg-holder"><svg id="rank-3" width="100%" height="100%" viewBox="0 0 80 154" class="svg-icon svg-icon-rank-3 top-10-rank"><path stroke="#595959" stroke-width="4" d="M3.809 41.577h33.243c1.3-2.702 3.545-4.947 6.674-6.72 3.554-2.015 7.83-3.01 12.798-3.01 5.555 0 10.14 1.11 13.723 3.376 3.839 2.427 5.782 6.283 5.782 11.315 0 4.553-1.853 8.395-5.473 11.38-3.547 2.926-8.18 4.37-13.821 4.37H41.44v28.366h16.77c5.572 0 10.275 1.227 14.068 3.711 4.02 2.633 6.071 6.581 6.071 11.616 0 5.705-1.943 9.975-5.853 12.562-3.658 2.42-8.292 3.61-13.863 3.61-5.205 0-9.82-.94-13.827-2.836-3.698-1.75-6.32-4.272-7.785-7.529H2.33c2.096 12.089 7.761 21.65 17.028 28.78C29.242 148.175 42.594 152 59.476 152c10.706 0 20.175-1.783 28.42-5.337 8.185-3.528 14.575-8.486 19.208-14.884 4.595-6.346 6.896-13.938 6.896-22.837 0-6.952-1.93-13.494-5.81-19.666-3.815-6.07-9.68-10.367-17.683-12.908l-5.46-1.735 5.353-2.04c6.659-2.538 11.667-6.338 15.083-11.412 3.431-5.096 5.142-10.806 5.142-17.181 0-8.471-2.262-15.778-6.787-21.985-4.574-6.275-10.7-11.17-18.408-14.696C77.683 3.775 69.109 2 59.687 2 44.084 2 31.515 5.816 21.91 13.415c-9 7.119-15.025 16.486-18.101 28.162z"></path></svg></div>
                        <div class="imgbesidesvg"><img class="skeleton" src="assets/images/3tv.webp" alt="" loading="lazy"></div>
                    </div>
                    <div class="bestRow">
                        <div class="svg-holder"><svg id="rank-4" width="100%" height="100%" viewBox="0 0 81 154" class="svg-icon svg-icon-rank-4 top-10-rank"><path stroke="#595959" stroke-width="4" d="M72 152h35.333v-30.977H128V92.497h-20.667V2H69.89L2 92.712v28.311h70V152zM36.202 92.188l35.93-47.998v47.998h-35.93z"></path></svg></div>
                        <div class="imgbesidesvg"><img class="skeleton" src="assets/images/4tv.jpg" alt="" loading="lazy"></div>
                    </div>
                    <div class="bestRow">
                        <div class="svg-holder"><svg id="rank-5" width="100%" height="100%" viewBox="0 0 81 154" class="svg-icon svg-icon-rank-5 top-10-rank"><path stroke="#595959" stroke-width="4" d="M105.588 32.174V2H13.534l-8.3 88.357h32.463c2.145-2.362 4.866-4.254 8.143-5.675 3.585-1.554 7.543-2.328 11.859-2.328 6.247 0 11.418 1.745 15.418 5.255 4.061 3.564 6.104 8.37 6.104 14.265 0 6.041-2.044 10.89-6.121 14.387-3.999 3.43-9.162 5.132-15.401 5.132-4.299 0-8.17-.694-11.601-2.095-3.11-1.268-5.577-2.946-7.368-5.042H2.592c3.308 11.593 9.782 20.623 19.46 27.164C32.472 148.464 45.64 152 61.602 152c10.12 0 19.294-1.99 27.548-5.966 8.198-3.949 14.711-9.718 19.572-17.335 4.844-7.59 7.278-16.95 7.278-28.123 0-9.182-2.013-17.314-6.032-24.431-4.02-7.118-9.514-12.7-16.51-16.775-6.99-4.072-14.849-6.109-23.612-6.109-11.06 0-20.099 3.483-27.234 10.461l-3.892 3.806 3.273-35.354h63.595z"></path></svg></div>
                        <div class="imgbesidesvg"><img class="skeleton" src="assets/images/5tv.jpg" alt="" loading="lazy"></div>
                    </div>
                    <div class="bestRow">
                        <div class="svg-holder"><svg id="rank-6" width="100%" height="100%" viewBox="0 0 81 154" class="svg-icon svg-icon-rank-6 top-10-rank"><path stroke="#595959" stroke-width="4" d="M79.482 38.192h35.551c-3.284-10.945-8.963-19.573-17.048-25.938C89.323 5.434 77.531 2 62.545 2 50.756 2 40.35 4.86 31.277 10.577c-9.064 5.712-16.198 14.09-21.412 25.178C4.63 46.893 2 60.425 2 76.365c0 14.416 2.356 27.344 7.059 38.798 4.667 11.368 11.573 20.34 20.734 26.956C38.904 148.7 50.225 152 63.816 152a61.513 61.513 0 0019.922-3.278 53.546 53.546 0 0017.378-9.792c5.154-4.33 9.255-9.64 12.314-15.947 3.042-6.273 4.57-13.556 4.57-21.868 0-8.812-2.062-16.636-6.182-23.51-4.134-6.897-9.643-12.293-16.55-16.212-6.905-3.917-14.48-5.874-22.76-5.874-14.546 0-25.34 4.55-32.569 13.63l-4.003 5.03.443-6.413c.874-12.636 3.56-21.85 8.168-27.654 4.69-5.907 10.885-8.9 18.421-8.9 4.26 0 7.826.734 10.685 2.24 2.445 1.287 4.396 2.867 5.829 4.74zM62.605 123c-5.825 0-10.902-1.894-15.136-5.655C43.173 113.528 41 108.603 41 102.71c0-5.881 2.164-10.864 6.44-14.818C51.674 83.975 56.762 82 62.604 82c5.847 0 10.906 1.98 15.074 5.905C81.878 91.859 84 96.837 84 102.71c0 5.885-2.131 10.805-6.35 14.622-4.167 3.77-9.214 5.668-15.045 5.668z"></path></svg></div>
                        <div class="imgbesidesvg"><img class="skeleton" src="assets/images/6tv.webp" alt="" loading="lazy"></div>
                    </div>
                    <div class="bestRow">
                        <div class="svg-holder"><svg id="rank-7" viewBox="0 0 78 154" width="100%" height="100%" class="svg-icon svg-icon-rank-7 top-10-rank"><path stroke="#595959" stroke-width="4" d="M113,2 L2,2 L2,33.4022989 L75.9665929,33.4022989 L21.22571,152 L60.28102,152 L113,32.7672283 L113,2 Z"></path></svg></div>
                        <div class="imgbesidesvg"><img class="skeleton" src="assets/images/7tv.webp" alt="" loading="lazy"></div>
                    </div>
                    <div class="bestRow">
                        <div class="svg-holder"><svg id="rank-8" width="100%" height="100%" viewBox="0 0 77 154" class="svg-icon svg-icon-rank-8 top-10-rank"><path stroke="#595959" stroke-width="4" d="M59.5 152c11.335 0 21.358-1.72 30.077-5.15 8.637-3.397 15.361-8.258 20.213-14.586 4.805-6.267 7.21-13.876 7.21-22.899 0-7.326-2.261-14.07-6.813-20.29-4.548-6.214-10.837-10.658-18.922-13.35l-5.4-1.799 5.338-1.975c7.238-2.678 12.572-6.683 16.066-12.018 3.53-5.388 5.284-11.178 5.284-17.414 0-7.912-2.133-14.839-6.405-20.84-4.3-6.042-10.403-10.825-18.345-14.351C79.816 3.78 70.386 2 59.5 2S39.184 3.781 31.197 7.328c-7.942 3.526-14.044 8.309-18.345 14.351-4.272 6.001-6.405 12.928-6.405 20.84 0 6.236 1.755 12.026 5.284 17.414 3.494 5.335 8.828 9.34 16.066 12.018l5.338 1.975-5.4 1.798c-8.085 2.693-14.374 7.137-18.922 13.351C4.261 95.295 2 102.04 2 109.365c0 9.023 2.405 16.632 7.21 22.899 4.852 6.328 11.576 11.19 20.213 14.586 8.72 3.43 18.742 5.15 30.077 5.15zm.5-89c-5.6 0-10.334-1.515-14.125-4.56C41.985 55.313 40 51.183 40 46.21c0-5.244 1.976-9.518 5.875-12.65C49.666 30.515 54.4 29 60 29s10.334 1.515 14.125 4.56C78.025 36.694 80 40.968 80 46.212c0 4.973-1.985 9.103-5.875 12.228C70.334 61.485 65.6 63 60 63zm-.5 62c-6.255 0-11.556-1.613-15.836-4.856-4.41-3.343-6.664-7.816-6.664-13.25 0-5.298 2.258-9.698 6.664-13.038C47.944 90.613 53.245 89 59.5 89c6.255 0 11.556 1.613 15.836 4.856 4.406 3.34 6.664 7.74 6.664 13.038 0 5.434-2.254 9.907-6.664 13.25C71.056 123.387 65.755 125 59.5 125z"></path></svg></div>
                        <div class="imgbesidesvg"><img class="skeleton" src="assets/images/8tv.webp" alt="" loading="lazy"></div>
                    </div>
                    <div class="bestRow">
                        <div class="svg-holder"><svg id="rank-9" viewBox="0 0 71 154" width="100%" height="100%" class="svg-icon svg-icon-rank-9 top-10-rank"><path stroke="#595959" stroke-width="4" d="M40.0597376,115.807692 L4.47328474,115.807692 C7.45109332,126.586242 13.4362856,135.15497 22.4670906,141.582071 C32.2129251,148.518048 44.5640134,152 59.5759717,152 C78.2141671,152 92.5105725,145.697944 102.6454,133.074799 C112.853557,120.360322 118,101.543854 118,76.5769231 C118,62.1603327 115.678843,49.3016297 111.046669,37.9886125 C106.453069,26.7698049 99.6241767,17.9802976 90.5435117,11.5767831 C81.5017862,5.20072813 70.1375399,2 56.3957597,2 C49.4158116,2 42.68229,3.15952329 36.1849549,5.47966815 C29.7045526,7.79376647 23.8782903,11.1932931 18.6948526,15.6846002 C13.5316746,20.1583529 9.45923583,25.508367 6.46782377,31.7491046 C3.4928156,37.95562 2,45.0644366 2,53.0961538 C2,61.9117395 4.02797967,69.7019439 8.0788911,76.5056791 C12.1434539,83.3323424 17.5832537,88.6925139 24.4218542,92.6108203 C31.2518358,96.5241882 38.8590885,98.4807692 47.2791519,98.4807692 C55.0853554,98.4807692 61.6095996,97.3619306 66.8547126,95.1478231 C72.0569983,92.9517941 76.4513169,89.5970183 80.0605818,85.0622151 L84.0584687,80.039134 L83.6207883,86.4440446 C82.74746,99.2241219 80.0984349,108.438199 75.5533003,114.10687 C70.9310132,119.871766 64.7726909,122.788462 57.2438163,122.788462 C52.8691399,122.788462 49.1904302,122.100251 46.212535,120.692834 C43.5930338,119.454801 41.5307848,117.825945 40.0597376,115.807692 Z M57.5,31 C63.3657106,31 68.4419893,32.9364861 72.6299874,36.7826253 C76.8609583,40.6682294 79,45.6186068 79,51.5 C79,57.3813932 76.8609583,62.3317706 72.6299874,66.2173747 C68.4419893,70.0635139 63.3657106,72 57.5,72 C51.6342894,72 46.5580107,70.0635139 42.3700126,66.2173747 C38.1390417,62.3317706 36,57.3813932 36,51.5 C36,45.6186068 38.1390417,40.6682294 42.3700126,36.7826253 C46.5580107,32.9364861 51.6342894,31 57.5,31 Z"></path></svg></div>
                        <div class="imgbesidesvg"><img class="skeleton" src="assets/images/9tv.jpg" alt="" loading="lazy"></div>
                    </div>
                    <div class="bestRow">
                        <div class="svg-holder">
                            <svg id="rank-10" width="100%" height="100%" viewBox="0 0 140 154" class="svg-icon svg-icon-rank-10 top-10-rank"><path stroke="#595959" stroke-width="4" d="M34.757 151.55h35.869V2.976L2 19.687v30.14l32.757-8.41v110.132zm105.53 3.45c12.394 0 23.097-3.12 32.163-9.353 9.093-6.25 16.11-15.047 21.066-26.43C198.5 107.766 201 94.196 201 78.5c0-15.698-2.5-29.266-7.484-40.716-4.955-11.384-11.973-20.18-21.066-26.431C163.384 5.119 152.681 2 140.287 2c-12.393 0-23.096 3.12-32.162 9.353-9.093 6.25-16.11 15.047-21.066 26.43-4.984 11.45-7.484 25.02-7.484 40.717 0 15.698 2.5 29.266 7.484 40.716 4.955 11.384 11.973 20.18 21.066 26.431 9.066 6.234 19.769 9.353 32.162 9.353zm0-31.368c-7.827 0-13.942-4.147-18.15-12.178-4.053-7.736-6.047-18.713-6.047-32.954s1.994-25.218 6.047-32.954c4.208-8.03 10.323-12.178 18.15-12.178 7.827 0 13.943 4.147 18.15 12.178 4.053 7.736 6.048 18.713 6.048 32.954s-1.995 25.218-6.047 32.954c-4.208 8.03-10.324 12.178-18.15 12.178z"></path></svg>
                        </div>
                        <div class="imgbesidesvg"><img class="skeleton" src="assets/images/11tv.jpg" alt="" loading="lazy"></div>
                    </div>
                </div>
                <div class="scrollButton">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg></button>
                </div>
                <div class="scrollButton1">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg></button>
                </div>
            </div>

            <div class="text-area"><b>Anime & Anime Inspired</b></div>
            <div class="row-wrapper" data-category="tv">
                <div id="firstRowCont4">
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime1.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime2.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime3.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime4.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime5.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime6.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime7.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime8.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime9.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime10.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime11.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime12.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime13.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime14.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime15.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime16.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime17.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime18.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime19.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/anime20.jpg" alt="" loading="lazy"></div>
                </div>
                <div class="scrollButton">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg></button>
                </div>
                <div class="scrollButton1">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg></button>
                </div>
            </div>

            <div class="text-area"><b>Games</b></div>
            <div class="row-wrapper">
                <div id="firstRowContg" class="GamesCont">
                    <div id="GamesArea"><img class="skeleton" src="assets/images/game1.png" alt="" loading="lazy"></div>
                    <div id="GamesArea"><img class="skeleton" src="assets/images/game2.png" alt="" loading="lazy"></div>
                    <div id="GamesArea"><img class="skeleton" src="assets/images/game3.png" alt="" loading="lazy"></div>
                    <div id="GamesArea"><img class="skeleton" src="assets/images/game4.png" alt="" loading="lazy"></div>
                    <div id="GamesArea"><img class="skeleton" src="assets/images/game5.png" alt="" loading="lazy"></div>
                    <div id="GamesArea"><img class="skeleton" src="assets/images/game6.png" alt="" loading="lazy"></div>
                    <div id="GamesArea"><img class="skeleton" src="assets/images/game7.png" alt="" loading="lazy"></div>
                    <div id="GamesArea"><img class="skeleton" src="assets/images/game8.png" alt="" loading="lazy"></div>
                    <div id="GamesArea"><img class="skeleton" src="assets/images/game10.png" alt="" loading="lazy"></div>
                </div>
                <div class="scrollButton">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg></button>
                </div>
                <div class="scrollButton1">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg></button>
                </div>
            </div>

            <div class="text-area"><b>My List</b></div>
            <div class="row-wrapper">

                <div id="firstRowContr">
                   </div>

                <div class="scrollButton">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg></button>
                </div>
                <div class="scrollButton1">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg></button>
                </div>
            </div>

            <div class="text-area"><b>Award Winning</b></div>
            <div class="row-wrapper">
                <div id="firstRowContp">
                    <div class="firstRow"><img class="skeleton" src="assets/images/award1.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/my10.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award3.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award4.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award5.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award6.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award7.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award8.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award9.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award10.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award11.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award12.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award13.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award14.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award17.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award18.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award19.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/award20.jpg" alt="" loading="lazy"></div>
                </div>
                <div class="scrollButton">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg></button>
                </div>
                <div class="scrollButton1">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg></button>
                </div>
            </div>

            <div class="text-area"><b>Animation</b></div>
            <div class="row-wrapper">
                <div id="firstRowConti">
                    <div class="firstRow"><img class="skeleton" src="assets/images/car1.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car2.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car3.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car4.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car5.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car6.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car7.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car8.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car9.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car10.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car11.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car12.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car13.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car14.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car15.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car16.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car17.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/car18.webp" alt="" loading="lazy"></div>
                </div>
                <div class="scrollButton">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg></button>
                </div>
                <div class="scrollButton1">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg></button>
                </div>
            </div>

            <div class="text-area"><b>Epic Worlds</b></div>
            <div class="row-wrapper" data-category="movie">
                <div id="firstRowContl">
                    <div class="firstRow"><img class="skeleton" src="assets/images/e1.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e2.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e3.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e4.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e5.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e6.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e7.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e8.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e9.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e10.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e11.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e12.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e13.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e14.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e15.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e16.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e17.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e18.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e19.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/e20.webp" alt="" loading="lazy"></div>
                </div>
                <div class="scrollButton">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg></button>
                </div>
                <div class="scrollButton1">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg></button>
                </div>
            </div>

            <div class="text-area"><b>Witty Tv Comedies</b></div>
            <div class="row-wrapper" data-category="tv">
                <div id="firstRowContd">
                    <div class="firstRow"><img class="skeleton" src="assets/images/w1.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w2.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w3.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w4.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w5.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w6.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w7.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w8.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w9.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w10.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w11.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w12.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w13.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w14.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w15.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w16.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w17.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w18.jpg" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w19.webp" alt="" loading="lazy"></div>
                    <div class="firstRow"><img class="skeleton" src="assets/images/w20.webp" alt="" loading="lazy"></div>
                </div>
                <div class="scrollButton">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M560-240 320-480l240-240 56 56-184 184 184 184-56 56Z"/></svg></button>
                </div>
                <div class="scrollButton1">
                    <button class="nav-btn" onclick="handleScroll(this)"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" fill="white"><path d="M504-480 320-664l56-56 240 240-240 240-56-56 184-184Z"/></svg></button>
                </div>
            </div>

        </div> <footer>
            <div class="footer-section">
                <div class="insidefoot">
                    <div class="faceArea">
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg></a>
                        <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg></a>
                    <a href="#"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg></a>
                </div>
                <div class="footerOther">
                    <div>
                        <ul>
                            <li><a href="">Audio Description</a></li>
                            <li><a href="">Investor Relations</a></li>
                            <li><a href="">Legal notices</a></li>
                        </ul>
                        <div class="Serve"><a href="">Service Code</a></div>
                        <div style="color: grey; margin-top: 10px; font-size: 11px;">&copy; 1997-2024 Netflix, Inc.</div>
                    </div>
                    <div>
                        <ul>
                            <li><a href="">Help Center</a></li>
                            <li><a href="">Jobs</a></li>
                            <li><a href="">Cookie Preferences</a></li>
                        </ul>
                    </div>
                    <div>
                        <ul>
                            <li><a href="">Gift Cards</a></li>
                            <li><a href="">Terms of use</a></li>
                            <li><a href="">Corporate Information</a></li>
                        </ul>
                    </div>
                    <div>
                        <ul>
                            <li><a href="">Media Center</a></li>
                            <li><a href="">Privacy</a></li>
                            <li><a href="">Contact us</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>
    </div>
    <div id="movie-modal" class="modal-overlay">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        
        <div class="modal-hero">
            <img id="modal-img" src="" alt="">
            <div class="modal-shadow"></div>
        </div>

        <div class="modal-info">
            <div class="modal-left">
                <h2 id="modal-title">Movie Title</h2>
                
                <div class="modal-meta">
                    <span class="match">98% Match</span>
                    <span class="age-box">18+</span> <span class="duration">2h 15m</span>
                    <span class="hd">HD</span>
                </div>

                <div class="modal-buttons">
                    <button class="modal-play">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="black"><path d="M8 5v14l11-7z"/></svg> 
                        <span>Play</span>
                    </button>

                    <button class="modal-add" id="add-to-list-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="5" x2="12" y2="19"></line><line x1="5" y1="12" x2="19" y2="12"></line></svg>
                        <span>My List</span>
                    </button>
                </div>

                <p id="modal-desc">Description goes here...</p>
            </div>

            <div class="modal-right">
                <p><span class="gray-text">Cast:</span> James McAvoy, Michael Fassbender, Jennifer Lawrence</p>
                <p><span class="gray-text">Genres:</span> Action, Sci-Fi, Adventure</p>
                <p><span class="gray-text">This movie is:</span> Exciting, Suspenseful</p>
            </div>
        </div>
    </div>
</div>

    </div>
    <div id="toast-box">Notification Message</div>
<div id="video-player-overlay" class="video-overlay">
    <video id="full-screen-video" controls>
        <source src="" type="video/mp4">
    </video>

    <iframe 
    id="youtube-player" 
    src="" 
    frameborder="0" 
    allow="autoplay; encrypted-media; fullscreen" 
    allowfullscreen="true"
    mozallowfullscreen="true" 
    webkitallowfullscreen="true">
</iframe>
    <button id="close-video-btn" class="close-video">&times;</button>
</div>
<div class="bottom-nav mobile-only">
    
    <div class="nav-item active">
        <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M240-200h120v-240h240v240h120v-360L480-740 240-560v360Zm-80 80v-480l320-240 320 240v480H520v-240h-80v240H160Zm320-350Z"/></svg>
        <span>Home</span>
    </div>



    <div class="nav-item">
        <div class="icon-container">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="m480-420 240-160-240-160v320Zm28 220h224q-7 26-24 42t-44 20L228-85q-33 5-59.5-15.5T138-154L85-591q-4-33 16-59t53-30l46-6v80l-36 5 54 437 290-36Zm-148-80q-33 0-56.5-23.5T280-360v-440q0-33 23.5-56.5T360-880h440q33 0 56.5 23.5T880-800v440q0 33-23.5 56.5T800-280H360Zm0-80h440v-440H360v440Zm220-220ZM218-164Z"/></svg>
            <span class="badge">1</span>
        </div>
        <span>New & Hot</span>
    </div>

    <div class="nav-item">
<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-260q68 0 123.5-38.5T684-400H276q25 63 80.5 101.5T480-260ZM312-520l44-42 42 42 42-42-84-86-86 86 42 42Zm250 0 42-42 44 42 42-42-86-86-84 86 42 42ZM480-80q-83 0-156-31.5T197-197q-54-54-85.5-127T80-480q0-83 31.5-156T197-763q54-54 127-85.5T480-880q83 0 156 31.5T763-763q54 54 85.5 127T880-480q0 83-31.5 156T763-197q-54 54-127 85.5T480-80Zm0-400Zm0 320q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Z"/></svg>
    <span>Fast Laughs</span>
    </div>

    <div class="nav-item">
<svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#e3e3e3"><path d="M480-320 280-520l56-58 104 104v-326h80v326l104-104 56 58-200 200ZM240-160q-33 0-56.5-23.5T160-240v-120h80v120h480v-120h80v120q0 33-23.5 56.5T720-160H240Z"/></svg>
    <span>Downloads</span>
    </div>

</div>
    <script src="assets/js/netflix.js"></script>
</body>
</html>