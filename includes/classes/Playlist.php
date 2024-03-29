<?php 

    class Playlist {

        private $conn;
        private $id;
        private $name;
        private $owner;

        public function __construct($conn, $data) 
        {

            if(!is_array($data)){
                // Data is an id (string)
                $query = mysqli_query($conn, "SELECT * FROM playlists WHERE id='$data'");
                $data = mysqli_fetch_array($query);
            }


            $this->conn = $conn;
            $this->id = $data['id'];
            $this->name = $data['name'];
            $this->owner = $data['owner'];
        }

        public function getId() {
            return $this->id;
        }

        public function getName() {
            return $this->name;
        }

        public function getOwner() {
            return $this->owner;
        }

        public function getNumberOfSongs() {
            $query = mysqli_query($this->conn, "SELECT song_id FROM playlistsongs WHERE playlist_id='$this->id'");
            return mysqli_num_rows($query);
        }

        public function getSongIds() {
            $query = mysqli_query($this->conn, "SELECT song_id FROM playlistsongs WHERE playlist_id='$this->id' ORDER BY playlist_order ASC");

            $array = array();

            while($row = mysqli_fetch_array($query)) 
            {
                array_push($array, $row['song_id']);
            }

            return $array;
        }


        public static function getPlaylistDropdown($conn, $username) {
            $dropdown = '<select class="item playlist">
                            <option value="">Add to playlist</option>
                        ';

            $query = mysqli_query($conn, "SELECT id, name FROM playlists WHERE owner='$username'");

            while($row = mysqli_fetch_array($query)) {
                $id = $row['id'];
                $name = $row['name'];

                $dropdown = $dropdown . "<option value='$id'>$name</option>";
            }
        
            return $dropdown . "</select>";
        }


    }
?>