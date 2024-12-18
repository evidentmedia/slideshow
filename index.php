<?php 
$files = glob("./media/*.*");
shuffle($files);
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slideshow</title>
</head>
<body>
    <div id="slideshow"><button onclick="playSlideshow()">Play</button></div>
    <script
        src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo="
        crossorigin="anonymous">
    </script>
    <style>
        body {
            background-color: black;
        }

        #slideshow {
            max-width: 100%;
            max-height: 100%;
            height: auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        img, video {
            position: fixed;
            top: 50%;
            left: 50%;
            max-width: 100%;
            max-height: 100%;
            width: auto;
            height: 100%;
            z-index: -100;
            transform: translateX(-50%) translateY(-50%);
            background-size: cover;
        }
    </style>
    <script>
    const intervalLength = 8000;

    function img(src) {
        var el = document.createElement('img');
        el.src = src;
        return el;
    }

    function vid() {
        //Accepts any number of ‘src‘ to a same video ('.mp4', '.ogg' or '.webm')
        var el = document.createElement('video');
        el.onplay = function () {
            clearInterval(sliding);
        };
        el.onended = function () {
            sliding = setInterval(rotateimages, intervalLength);
            rotateimages();
        };
        var source = document.createElement('source');
        for (var i = 0; i < arguments.length; i++) {
            source.src = arguments[i];
            // source.type = "video/" + arguments[i].split('.')[arguments[i].split('.').length - 1];
            el.appendChild(source);
        }
        return el;
    }

    var galleryarray = [];

    // create img/video elements depending on file-format
    <?php 
        foreach($files as $file){
            if(str_ends_with(strtolower($file), ".jpg") || str_ends_with(strtolower($file), ".gif") || str_ends_with(strtolower($file), ".png") || str_ends_with(strtolower($file), ".dng")){
                ?> 
                    galleryarray.push(img("<?= $file; ?>"));
                <?php
            } else if(str_ends_with(strtolower($file), ".mp4") || str_ends_with(strtolower($file), ".mov")) {
                ?> 
                    galleryarray.push(vid("<?= $file; ?>"));
                <?php
            }
        }
    ?>

    var curimg = 1;

    function rotateimages() {
        $("#slideshow").fadeOut("slow");
        setTimeout(function () {
            curimg = (curimg < galleryarray.length - 1) ? curimg + 1 : 0
            document.getElementById('slideshow').innerHTML = '';
            document.getElementById('slideshow').appendChild(galleryarray[curimg]);
            if (galleryarray[curimg].tagName === "VIDEO") {
                galleryarray[curimg].play();
            }
            $("#slideshow").fadeIn("slow");
        }, 800);
    }

    var sliding;
    window.onload = function () {
        document.getElementById('slideshow').onclick = function () {
            if (this.requestFullscreen) {
                this.requestFullscreen();
            } else if (this.msRequestFullscreen) {
                this.msRequestFullscreen();
            } else if (this.mozRequestFullScreen) {
                this.mozRequestFullScreen();
            } else if (this.webkitRequestFullscreen) {
                this.webkitRequestFullscreen();
            }
        }
    }

    function playSlideshow() {
        sliding = setInterval(rotateimages, intervalLength);
        rotateimages();
    }
    </script>
</body>
</html>