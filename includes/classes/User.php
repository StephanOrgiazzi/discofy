<?php
	class User {

		private $connect;
		private $username;

		public function __construct($connect, $username) {
			$this->connect = $connect;
			$this->username = $username;
		}

		public function getUsername() {
			return $this->username;
		}

		public function getEmail() {
			$query = mysqli_query($this->connect, "SELECT email FROM users WHERE username='$this->username'");
			$row = mysqli_fetch_array($query);
			return $row['email'];
		}

	}
?>