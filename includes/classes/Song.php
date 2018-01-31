<?php
	class Song {

		private $connect;
		private $id;
		private $mysqliData;
		private $title;
		private $artistId;
		private $albumId;
		private $genre;
		private $duration;
		private $path;

		public function __construct($connect, $id) {
			$this->connect = $connect;
			$this->id = $id;

			$query = mysqli_query($this->connect, "SELECT * FROM songs WHERE id='$this->id'");
			$this->mysqliData = mysqli_fetch_array($query);
			$this->title = $this->mysqliData['title'];
			$this->artistId = $this->mysqliData['artist'];
			$this->albumId = $this->mysqliData['album'];
			$this->genre = $this->mysqliData['genre'];
			$this->duration = $this->mysqliData['duration'];
			$this->path = $this->mysqliData['path'];
		}

		public function getId() {
			return $this->id;
		}

		public function getTitle() {
			return $this->title;
		}

		public function getArtist() {
			return new Artist($this->connect, $this->artistId);
		}

		public function getAlbum() {
			return new Album($this->connect, $this->albumId);
		}

		public function getPath() {
			return $this->path;
		}

		public function getDuration() {
			return $this->duration;
		}

		public function getMysqliData() {
			return $this->mysqliData;
		}

		public function getGenre() {
			return $this->genre;
		}

	}
?>