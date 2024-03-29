<?php 
    // include the header
    // include("includes/header.php"); 
    include("includes/includedFiles.php"); 


    if(isset($_GET['id'])){
        $albumId =  $_GET['id'];
    }
    else { 
        header("Location: index.php");
    }

    // To call the Album class
    $album = new Album($conn, $albumId);

    // To call the Artist class
    $artist = $album->getArtist();

    $artistId = $artist->getId();
?>

<div class="entityInfo">

    <div class="leftSection">
        <img src="<?php echo $album->getArtworkPath(); ?>" alt="">
    </div>

    <div class="rightSection">
        <h2><?php echo $album->getTitle(); ?></h2>
        <p role="link" tabindex="0" onclick="openPage('artist.php?id=$artistId')">By <?php echo $artist->getName(); ?></p>
        <p><?php echo $album->getNumberOfSongs(); ?> songs</p>
        
    </div>

</div>

<div class="trackListContainer">

    <ul class="trackList">
        
        <?php 
            $songIdArray = $album->getSongIds();
        
            $i = 1;

            foreach($songIdArray as $songId) {
                
                $albumSong = new Song($conn, $songId);
                $albumArtist = $albumSong->getArtist();

                echo "<li class='trackListRow'>
                        <div class='trackCount'>
                            <img class='play' src='assets/images/icons/play-white.png' onclick='setTrack(\"" . $albumSong->getId() . "\", tempPlaylist, true)'>
                            <span class='trackNumber'>$i</span>
                        </div>
                        <div class='trackInfo'>
                            <span class='trackName'>" . $albumSong->getTitle() . "</span>
                            <span class='artistName'>" . $albumArtist->getName() . "</span>
                        </div>
                        <div class='trackOptions'>
                            <input type='hidden' class='songId' value='" . $albumSong->getId() . "'>
                            <img class='optionsButton' src='assets/images/icons/more.png' onclick='showOptionsMenu(this)'>
                        </div>
                        <div class='trackDuration'>
                            <span class='duration'>" . $albumSong->getDuration() . "</span>
                        </div>
                    </li>";

                    $i++;
            }
        ?>

        <script>
            var tempSongIds = '<?php echo json_encode($songIdArray); ?>';
            tempPlaylist = JSON.parse(tempSongIds);
            // console.log(tempPlaylist);
        </script>

    </ul>
</div>

<nav class="optionsMenu">
    <input type="hidden" name="" class="songId">
    <?php echo Playlist::getPlaylistDropdown($conn, $userLoggedIn->getUsername()); ?>
</nav>



