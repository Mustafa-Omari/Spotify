<?php 
include("../../config.php");


if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
    $playlistId = $_POST['playlistId'];
    $songId = $_POST['songId'];
    
    $query = mysqli_query($conn, "DELETE FROM playlistsongs WHERE playlist_id='$playlistId' AND song_id='$songId'");



}
else { 
    echo "PlaylistId or songId was not passed into removeFromPlaylist.php";
}



?>