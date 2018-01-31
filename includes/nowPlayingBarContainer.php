<?php 
$songQuery = mysqli_query($connect, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");

$resultArray = array();
while ($row = mysqli_fetch_array($songQuery)) {
	array_push($resultArray, $row['id']);
}

$jsonArray = json_encode($resultArray);
?>

<script>
$(document).ready(function(){
	currentPlaylist = <?php echo $jsonArray; ?>;
	audioElement = new Audio();
	setTrack(currentPlaylist[0], currentPlaylist, false);
	updateVolumeProgressBar(audioElement.audio);

	$("#nowPlayingBarContainer").on("mousedown touchstart mousemove touchmove", function(event){
		event.preventDefault();
	});

	// Song Bar
	$(".playbackBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

	$(".playbackBar .progressBar").mousemove(function(event) {
		if (mouseDown == true) {
			timeFromOffset(event, this);
		}
	});

	$(".playbackBar .progressBar").mouseup(function(event) {
		timeFromOffset(event, this);
	});

	// Volume Bar
	$(".volumeBar .progressBar").mousedown(function() {
		mouseDown = true;
	});

	$(".volumeBar .progressBar").mousemove(function(event) {
		if (mouseDown == true) {

			var percentage = event.offsetX / $(this).width(); 

			if (percentage >= 0 && percentage <= 1) {
				audioElement.audio.volume = percentage;
			}
		}
	});

	$(".volumeBar .progressBar").mouseup(function(event) {
		var percentage = event.offsetX / $(this).width();
			audioElement.audio.volume = percentage;
	});

	$(document).mouseup(function() {
		mouseDown = false;
	});

});

function timeFromOffset(event, progressBar) {
	var percentage = event.offsetX / $(progressBar).width() * 100;
	var seconds = audioElement.audio.duration * (percentage / 100);
	audioElement.setTime(seconds);
}

function nextSong() {
	if (currentIndex == currentPlaylist.length -1) {
		currentIndex = 0;
	}
	else {
		currentIndex++
	}

	var trackToPlay = currentPlaylist[currentIndex];
	setTrack(trackToPlay, currentPlaylist, true);
}

function previousSong() {
	if (audioElement.audio.currentTime >= 3 || currentIndex == 0) {
		audioElement.setTime(0);
	}
	else {
		currentIndex--
		var trackToPlay = currentPlaylist[currentIndex];
		setTrack(trackToPlay, currentPlaylist, true);
	}
}

function mute() {
	audioElement.audio.muted = !audioElement.audio.muted;
	var imageName = audioElement.audio.muted ? "volume-mute.png" : "volume.png";
	$(".volume img").attr("src", "assets/images/icons/" + imageName);
}

function setTrack(trackId, newPlaylist, play) {
	if(newPlaylist != currentPlaylist) {
		currentPlaylist = newPlaylist;
	}

	currentIndex = currentPlaylist.indexOf(trackId);
	
	pauseSong();

	$.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {
		
		var track = JSON.parse(data);
		$(".trackName span").text(track.title);

		$.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
			var artist = JSON.parse(data);
			$(".trackInfo .artistName span").text(artist.name);
			$(".trackInfo .artistName span").attr("onclick", "openPage('artist.php?id=" + artist.id + "')");
		});

		$.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
			var album = JSON.parse(data); 
			$(".content .albumLink img").attr("src", album.artworkPath);
			$(".content .albumLink img").attr("onclick", "openPage('album.php?id=" + album.id + "')");
			$(".trackInfo .trackName span").attr("onclick", "openPage('album.php?id=" + album.id + "')");
		});

		audioElement.setTrack(track);

		if (play) {
		playSong();
	}
	});
}

function playSong() {

	if (audioElement.audio.currentTime == 0) {
		$.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id});
	} 

	$(".controlButton.play").hide();
	$(".controlButton.pause").show();
	audioElement.play();
}

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
					<img src="" class="albumArtwork" role="link" tabindex="0">
				</span>

				<div class="trackInfo">

					<span class="trackName">
						<span role="link" tabindex="0"></span>
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

					<button class="controlButton previous" title="Previous button" onclick="previousSong()">
						<img src="assets/images/icons/previous.png" alt="Previous">
					</button>

					<button class="controlButton play" title="Play button" onclick="playSong()">
						<img src="assets/images/icons/play.png" alt="Play">
					</button>

					<button class="controlButton pause" title="Pause button" style="display: none;" onclick="pauseSong()">
						<img src="assets/images/icons/pause.png" alt="Pause">
					</button>

					<button class="controlButton next" title="Next button" onclick="nextSong()">
						<img src="assets/images/icons/next.png" alt="Next">
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

				<button class="controlButton volume" title="Volume button">
					<img src="assets/images/icons/volume.png" alt="Volume" onclick="mute()">
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