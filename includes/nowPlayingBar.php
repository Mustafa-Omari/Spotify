<?php 

$songQuery = mysqli_query($conn, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");

$resultArray = array();

while($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);
?>

<script>
    
$(document).ready(function() {
    var newPlaylist =  <?php echo $jsonArray; ?>;
    audioElement = new Audio();
    setTrack(newPlaylist[0], newPlaylist, false);
    updateVolumeProgressBar(audioElement.audio); // to make by defualt of volume is max 



    // When you do drag and drop  , dont highlight thing
    $("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(e) {
        e.preventDefault();
    });

    $("#nowPlayingBarContainer").mousedown(function(e) {
        e.preventDefault();
    });

    $("#nowPlayingBarContainer").mousemove(function(e) {
        e.preventDefault();
    });

    $("#nowPlayingBarContainer").mouseup(function(e) {
        e.preventDefault();
    });

    $("#nowPlayingBarContainer").mousedown(function(e) {
        e.preventDefault();
    });
    // end highlight section 



    // to press mouse on the bar for music duration to change the duration 
    $(".playbackBar .progressBar").mousedown(function() {
        mouseDown = true;
    });
    // to press mouse and hold on the bar for music duration to change the duration
    $(".playbackBar .progressBar").mousemove(function(e) {
        if(mouseDown === true){
            //Set time of song, depending on position of time 
            timeFromOffset(e, this);
        }
    });
    // to move mouse on the bar for music duration to change the duration
    $(".playbackBar .progressBar").mouseup(function(e) {
        timeFromOffset(e, this);
    });



    // to press mouse on the bar for volume bar to change the volume 
	$(".volumeBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

    // to press mouse and hold on the bar for volume bar to change the volume 
	$(".volumeBar .progressBar").mousemove(function(e) {
		if(mouseDown == true) {

			var percentage = e.offsetX / $(this).width();

			if(percentage >= 0 && percentage <= 1) {
				audioElement.audio.volume = percentage;
			}
		}
	});    
    // to move mouse on the bar for volume bar to change the volume 
	$(".volumeBar .progressBar").mouseup(function(e) {
		var percentage = e.offsetX / $(this).width();

		if(percentage >= 0 && percentage <= 1) {
			audioElement.audio.volume = percentage;
		}
	});


    $(document).mouseup(function() {
        mouseDown = false;
    })


});

// to set the time when you drag 
function timeFromOffset(mouse, progressBar) {
    var percentage = mouse.offsetX / $(progressBar).width() * 100;
    var seconds = audioElement.audio.duration * (percentage / 100);
    audioElement.setTime(seconds);
}

// To go to the previous song
function prevSong() {
    // to repeat the the song and dont go to the next song
    if(repeat == true) {
        audioElement.setTime(0);
        playSong();
        return;
    }

    if(audioElement.audio.currentTime >= 3 || currentIndex == 0) {
        audioElement.setTime(0);
    }else { 
        currentIndex = currentIndex - 1 ;
        setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    }
}

// To go to the next song
function nextSong() {
    // to repeat the the song and dont go to the next song
    if(repeat == true) {
        audioElement.setTime(0);
        playSong();
        return;
    }

    if(currentIndex == currentPlaylist.length - 1){
        currentIndex = 0;
    }
    else { 
        currentIndex++;
    }

    var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
    setTrack(trackToPlay, currentPlaylist, true);
}


// to repeat the song 
function setRepeat() {
    repeat = !repeat;
    var imageName = repeat ? "repeat-active.png" : "repeat.png";
    $(".controlButton.repeat img").attr("src", "assets/images/icons/" + imageName);
}

// To mute the volume 
function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
    $(".controlButton.volume img").attr("src", "assets/images/icons/" + imageName);
}

// To set Shuffle 
function setShuffle() {
    shuffle = !shuffle;
    var imageName = shuffle ? "shuffle-active.png" : "shuffle.png";
    $(".controlButton.shuffle img").attr("src", "assets/images/icons/" + imageName);


    if(shuffle == true) {
        // Randomize playlist
        shuffleArray(shufflePlaylist);
        currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
    }
    else { 
        // shuffle has been deactivated
        currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
        // go back to regular playlist
    }

}
// to shuffle
function shuffleArray(a) {
    var j, x, i;
    for(i = a.length; i; i--){
        j = Math.floor(Math.random() * i);
        x = a[i - 1];
        a[i - 1] = a[j];
        a[j] = x;
    } 
}


function setTrack(trackId, newPlaylist, play) {
    // audioElement.setTrack("assets/music/bensound-anewbeginning.mp3");
    // to Shuffle the playlist
    if(newPlaylist != currentPlaylist) {
        currentPlaylist = newPlaylist;
        shufflePlaylist = currentPlaylist.slice();
        shuffleArray(shufflePlaylist);
    }

    if(shuffle == true) {
        currentIndex = shufflePlaylist.indexOf(trackId);
    }else {
        currentIndex = currentPlaylist.indexOf(trackId);
    }

    pauseSong();

    $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId}, function(data) {


        // to parse the data 
        var track = JSON.parse(data);

        // to give the track name 
        $(".trackName span").text(track.title);

        // to give the artist name 
        $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist}, function(data) {
            var artist = JSON.parse(data);
            // console.log(artist.name);
            $(".trackInfo .artistName span").text(artist.name);
            $(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
        });

        // to give the album photo
        $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album}, function(data) {
            var album = JSON.parse(data);
            $(".content .albumLink img").attr("src", album.artwork_path);
            $(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
            $(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
        });

    
        // console.log(track);
        // audioElement.setTrack(track.path);
        audioElement.setTrack(track);
        // audioElement.play();
        // playSong();

            
        if(play) {
            playSong();
        }
    });

}
// to play the song
function playSong() {
    // increase the plays when play the song 
    if(audioElement.audio.currentTime == 0) {
        $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
    }


    $(".controlButton.play").hide();
    $(".controlButton.pause").show();
    audioElement.play();
}
// to pause the song
function pauseSong() {
    $(".controlButton.pause").hide();
    $(".controlButton.play").show();
    audioElement.pause();
}

</script>



<div id="nowPlayingBarContainer">

    <div id="nowPlayingBar">

        <div id="nowPlayingLeft">
            <div class="content">
                <span class="albumLink">
                    <img role="link" tabindex="0" src="" class="albumArtwork" alt="">
                </span>

                <div class="trackInfo">

                    <span class="trackName">
                        <span role="link" tabindex="0" ></span>
                    </span>

                    <span class="artistName">
                        <span role="link" tabindex="0"></span>
                    </span>

                </div>


            </div>
        </div>

        <div id="nowPlayingCenter">

            <div class="content playerControls">

                <div class="buttons">

                    <button class="controlButton shuffle" title="Shuffle button" onclick="setShuffle()">
                        <img src="assets/images//icons/shuffle.png" alt="Shuffle">
                    </button>

                    <button class="controlButton previous" title="Previous button" onclick="prevSong()">
                        <img src="assets/images//icons/previous.png" alt="Previous">
                    </button>

                    <button class="controlButton play" title="Play button" onclick="playSong()">
                        <img src="assets/images//icons/play.png" alt="Play">
                    </button>

                    <button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
                        <img src="assets/images//icons/pause.png" alt="Pause">
                    </button>

                    <button class="controlButton next" title="Next button" onclick="nextSong()">
                        <img src="assets/images//icons/next.png" alt="Next">
                    </button>

                    <button class="controlButton repeat" title="Repeat button" onclick="setRepeat()">
                        <img src="assets/images//icons/repeat.png" alt="Repeat">
                    </button>

                </div>

                <div class="playbackBar">

                    <span class="progressTime current">0.00</span>
                    
                    <div class="progressBar">
                        <div class="progressBarBg">
                            <div class="progress"></div>
                        </div>
                    </div>
                    
                    <span class="progressTime remaining">0.00</span>

                </div>

            </div>

        </div>

        <div id="nowPlayingRight">

            <div class="volumeBar">

                <button class="controlButton volume" title="Volume button" onclick="setMute()">
                    <img src="assets/images/icons/volume.png" alt="Volume">
                </button>

                <div class="progressBar">
                    <div class="progressBarBg">
                        <div class="progress"></div>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>