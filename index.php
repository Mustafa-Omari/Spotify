<?php 
// include("includes/header.php"); 
include("includes/includedFiles.php"); 
?>

<h1 class="pageHeadingBig">You Might Also Like</h1>

<div class="gridViewContainer">

    <?php 
        $alboumQuery = mysqli_query($conn, "SELECT * FROM albums ORDER BY RAND() LIMIT 10");

        while($row = mysqli_fetch_array($alboumQuery)){

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




<?php 
// include("includes/footer.php"); 
?>