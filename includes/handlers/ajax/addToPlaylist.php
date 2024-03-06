<?php 
include("../../config.php");

    
if(isset($_POST['playlistId']) && isset($_POST['songId'])) {
    $playlistId = $_POST['playlistId'];
    $songId = $_POST['songId'];
    
    $orderIdQuery = mysqli_query($conn, "SELECT MAX(playlist_order) + 1 as playlist_order FROM playlistsongs WHERE playlist_id='$playlistId'");
    //WHERE playlist_id='$playlistId'
    $row = mysqli_fetch_array($orderIdQuery) ;
    $order = $row['playlist_order'];

    $query = mysqli_query($conn, "INSERT INTO playlistsongs VALUES('', '$songId', '$playlistId', '$order')");

}
else { 
    echo "PlaylistId or songId was not passed into addToPlaylist.php";
}

?>