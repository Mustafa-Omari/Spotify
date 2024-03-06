<?php 
include("includes/includedFiles.php");


if(isset($_GET['term'])) {
    $term = urldecode($_GET['term']); // to handle the term with space 
    // echo $term;
}else { 
    $term = "";
}
?>


<div class="searchContainer">

    <h4>Search for an artist, album or song</h4>
    <input type="text" class="searchInput" value="<?php echo $term ?>" placeholder="Start typing..." onfocus="this.value = this.value">

</div>


<script>
    // focus to the input 
    $(".searchInput").focus();

    $(function() {        
        $(".searchInput").keyup(function() {
            clearTimeout(timer); // cancel the timer 

            timer = setTimeout(function() { // make a new timer 
                // console.log("hi");
                var val = $(".searchInput").val();
                openPage("search.php?term=" + val);
            }, 2000);
        });
    });
</script>

<?php 
    if($term == "") 
        exit();
    
?>

<!-- song by song name section  -->
<div class="trackListContainer borderBottom">
    <h2>SONGS</h2>
    <ul class="trackList">
        
        <?php 

            $songQuery = mysqli_query($conn, "SELECT id FROM songs WHERE title LIKE '$term%' LIMIT 10");

            if(mysqli_num_rows($songQuery) == 0){
                echo "<span class='noResults'>No songs found matching " . $term . "</span>";
            }

            $songIdArray = array();
        
            $i = 1;

            while($row = mysqli_fetch_array($songQuery)) {
                // to break the loop when i equal 15
                if($i > 15){
                    break;
                }

                array_push($songIdArray, $row['id']);

                $albumSong = new Song($conn, $row['id']);
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
            console.log(tempPlaylist);
        </script>
    </ul>
</div>

<!-- search song by artist name  -->
<div class="artistsContainer borderBottom">

    <h2>ARTISTS</h2>

    <?php 
        $artistQuery = mysqli_query($conn, "SELECT id FROM artists WHERE name LIKE '$term%' LIMIT 10");
    
        if(mysqli_num_rows($artistQuery) == 0){
            echo "<span class='noResults'>No artists found matching " . $term . "</span>";
        }

        while($row = mysqli_fetch_array($artistQuery)){
            $artistFound = new Artist($conn, $row['id']);

            echo "<div class='searchResultRow'>
                    <div class='artistName'>

                        <span role='link' tabindex='0' onclick='openPage(\"artist.php?id=" . $artistFound->getId() . "\")'>
                        "
                        .  $artistFound->getName()  .
                        "
                        </span>
                    
                        </div>
                </div>";
        }
    ?>
</div> 


<!--  search by album name -->
<div class="gridViewContainer">
    <h2>ALBUMS</h2>

    <?php 
        $albumQuery = mysqli_query($conn, "SELECT * FROM albums WHERE title LIKE '$term%' LIMIT 10");

        if(mysqli_num_rows($albumQuery ) == 0){
            echo "<span class='noResults'>No albums found matching " . $term . "</span>";
        }

        while($row = mysqli_fetch_array($albumQuery)){

            echo "<div class='gridViewItem'>
                    <span role='link' tabindex='0' onclick='openPage(\"album.php?id=" . $row['id'] . "\")' >
                        <img src='" . $row['artwork_path'] . "'>

                        <div class='gridViewInfo'>"
                            . $row['title'] .
                        "</div>
                    </span>
                </div>";
        }
    ?>
</div>


<nav class="optionsMenu">
    <input type="hidden" name="" class="songId">
    <?php echo Playlist::getPlaylistDropdown($conn, $userLoggedIn->getUsername()); ?>
</nav>
