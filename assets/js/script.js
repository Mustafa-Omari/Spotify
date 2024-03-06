var currentPlaylist = [];
var shufflePlaylist = [];
var tempPlaylist = [];
var audioElement;
var mouseDown = false;
var currentIndex = 0;
var repeat = false;
var shuffle = false; 
var userLoggedIn;
var timer;


$(document).click(function(click) {
    var target = $(click.target);

    if(!target.hasClass("item") && !target.hasClass("optionsButton")){
        hideOptionsMenu();
    }
});

// to hide the menu options
$(window).scroll(function() {
    hideOptionsMenu();
});

$(document).on("change", "select.playlist", function() {
    
    var select = $(this);
    var playlistId = select.val(); // this refere to item option is selected from drop down 
    var songId = select.prev(".songId").val();

    // Just to test 
    // console.log("playlistId: " + playlistId);
    // console.log("songId: " + songId);

    $.post("includes/handlers/ajax/addToPlaylist.php", { playlistId: playlistId, songId: songId })
    .done(function(error) {

        if(error != "") {
            alert(error);
            return;
        }

        hideOptionsMenu();
        select.val("");
    });

});

// function to change a email 
function updateEmail(emailClass) {
    var emailValue = $("." + emailClass).val();

    $.post("includes/handlers/ajax/updateEmail.php", { email: emailValue, username: userLoggedIn })
    .done(function(response) {
        $("." + emailClass).nextAll(".message").text(response);
    });
}

// function to change a password 
function updatePassword(oldPasswordClass, newPasswordClass1, newPasswordClass2) {
    var oldPassword = $("." + oldPasswordClass).val();
    var newPassword1 = $("." + newPasswordClass1).val();
    var newPassword2 = $("." + newPasswordClass2).val();

    $.post("includes/handlers/ajax/updatePassword.php",
    { oldPassword: oldPassword, 
        newPassword1: newPassword1,
        newPassword2: newPassword2,
        username: userLoggedIn })
    .done(function(response) {
        $("." + oldPasswordClass).nextAll(".message").text(response);
    });
}

function logout() {
    $.post("includes/handlers/ajax/logout.php", function() {
        location.reload();
    });
}

// To keep the same song playing  when you are in album and press on logo 
function openPage(url) {

    if(timer != null) {
        clearTimeout(timer);
    }

    if(url.indexOf("?") == -1) {
        url = url + "?"; 
    }

    var encodedUrl = encodeURI(url + "&userLoggedIn=" + userLoggedIn);
    console.log(encodedUrl);
    $("#mainContent").load(encodedUrl);
    $("body").scrollTop(0);
    history.pushState(null, null, url);
}

function removeFromPlaylist(button, playlistId) {

    var songId = $(button).prevAll(".songId").val(); 

    $.post("includes/handlers/ajax/removeFromPlaylist.php", { playlistId: playlistId, songId: songId })
    .done(function(error) {
        if(error != "") {
            alert(error);
            return;
        }
        // do something when ajax returns 
        openPage("playlist.php?id=" + playlistId);
    });

}


// function to create the playlist 
function createPlaylist() { 
    // console.log(userLoggedIn);
    var popup = prompt("Please enter the name of your playlist");
    if(popup != null) {
        // console.log(popup);
        $.post("includes/handlers/ajax/createPlaylist.php", { name: popup, username: userLoggedIn })
        .done(function(error) {
            if(error != "") {
                alert(error);
                return;
            }
            // do something when ajax returns 
            openPage("yourMusic.php");
        });
    }
}

// function to delete playlist 
function deletePlaylist(playlistId){
    var prompt = confirm("Are you sure you want to delete this playlist?");

    if(prompt == true) {
        // console.log("DELETE PLAYLIST");

        $.post("includes/handlers/ajax/deletePlaylist.php", { playlistId: playlistId })
        .done(function(error) {
            if(error != "") {
                alert(error);
                return;
            }
            // do something when ajax returns 
			openPage("yourMusic.php");
        });

    }
}

function hideOptionsMenu() {
    var menu = $(".optionsMenu");
    if(menu.css("display") != "none") {
        menu.css("display", "none");
    }
}

function showOptionsMenu(button) {
    var songId = $(button).prevAll(".songId").val(); 
    var menu = $(".optionsMenu");
    var menuWidth = menu.width();
    menu.find(".songId").val(songId);

    var scrollTop = $(window).scrollTop(); // Distance from top of window to top of document 
    var elementOffset = $(button).offset().top; // Distance from top of document 

    var top = elementOffset - scrollTop;
    var left = $(button).position().left;

    menu.css({ "top": top + "px", "left": left - menuWidth + "px", "display": "inline" });

}


// to format the time  -> convert time from seconds to minute 
function formatTime(seconds) {
    var time = Math.round(seconds);
    var minutes = Math.floor(time / 60); // Rounds down
    var seconds = time - minutes * 60;

    // to put zero before the number less than 10, on duration
    var extraZero = (seconds < 10) ? "0" : "";

    return minutes + ":" + extraZero + seconds ;
}

// to display the timer of duration 
function updateTimeProgressBar(audio) {
    // to current time 
    $(".progressTime.current").text(formatTime(audio.currentTime));
    // to duration time 
    $(".progressTime.remaining").text(formatTime(audio.duration - audio.currentTime));
    // to bar time 
    var progress = audio.currentTime / audio.duration * 100;
    $(".playbackBar .progress").css("width", progress + "%");
}
// to display the persentage of volume 
function updateVolumeProgressBar(audio) {
    var volume = audio.volume * 100;
    $(".volumeBar .progress").css("width", volume + "%");

}

function playFirstSong() {
    setTrack(tempPlaylist[0], tempPlaylist, true);
}


function Audio() {

	this.currentlyPlaying;
	this.audio = document.createElement('audio');

    // to play the next song when the song it is end 
    this.audio.addEventListener("ended", function() {
		nextSong();
	});

    // to display the duration of the song 
    this.audio.addEventListener("canplay", function() {
        var duration = formatTime(this.duration);
        $(".progressTime.remaining").text(duration);
    });

    
    this.audio.addEventListener("timeupdate", function() {
        if(this.duration) {
            updateTimeProgressBar(this);
        }
    });

    this.audio.addEventListener("volumechange", function() {
        updateVolumeProgressBar(this);
    });

    // to paly the track 
	this.setTrack = function(track) {
        this.currentlyPlaying = track ;
		this.audio.src = track.path;
	}

    this.play = function() {
        this.audio.play();
    }

    this.pause = function() {
        this.audio.pause();
    }

    this.setTime = function(seconds) {
        this.audio.currentTime = seconds;
    }

}