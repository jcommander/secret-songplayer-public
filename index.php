<?php

	// Header
	echo '
<!DOCTYPE html>
<html>
<head>
<title>My Songs</title>
<script src="/js/music.js"></script>
<link rel="stylesheet" type="text/css" href="/css/main_style.css">
<link rel="stylesheet" type="text/css" href="/css/music.css">
</head>
<body onload="initMusic();">';

	// Player
	echo '
	<div class="loading"><img src="/img/purple-loader.svg"/>Loading...</div>
	<div class="bgimg"></div>
	<div id="general-player">
		<div class="playpause small">
			<input type="checkbox" style="display: none;" value="None" id="playing-master"/>
			<label for="playing-master"></label>
		</div>
		<div class="vol-slider" data-direction="vertical">
			<div id="sound-logo"></div>
			<div class="vol-progress">
				<div class="pin" id="progress-pin" data-method="rewind"></div>
			</div>
		</div>
		<div class="slider-cont">
			<div id="time"><span id="current">NO</span><span id="length">SONG</span></div>
			<div class="slider" data-direction="horizontal">
				<div class="progress" style="width: 100%;">
					<div class="pin" id="progress-pin" data-method="rewind"></div>
				</div>
			</div>
		</div>
		<a href="extras/experimental.mp3" class="download-btn" download></a>
		<audio style="width: 0%" preload="none" controls>
		<source src="" type="audio/mpeg">
		</audio>
	</div>';

	// Content Header
	echo '
	<div>
		<h1 style="font-size: 64px;padding-top: 25px;">Songs/Demos</h1>
		<p style="margin-bottom: 72px"></p>
	</div>';
	
	$files = glob('audio/*.mp3');
	usort($files, function($x, $y) {
		return strtolower(basename($x)) <=> strtolower(basename($y));
	});
	
    echo '
	<div id="allSongs">';
	for ($i=0; $i<count($files); $i++){
		$cur = $files[$i];
		echo '
		<div class="song-container">
			<div class="song-content-square">
				<h2>'.basename($cur, ".mp3").'<hr>'.'<span style="font-size: 14px; top: -9px; position: relative;">'.date ("F d Y H:i:s", filemtime($cur)).'</span></h2>
				<div class="playpause">
					<input type="checkbox" value="None" id="playing-'.$i.'"/>
					<label for="playing-'.$i.'"></label>';
					
					// Lyrics
					if (file_exists('extras/songs/'.pathinfo($cur, PATHINFO_FILENAME).'.txt'))
					{
						echo '
						<div class="lyrics">
							<button class="close-btn" onclick="document.querySelector(\'.active\').classList.remove(\'active\')">X</button>
							<span style="color: gold; font-size: 26px; margin-bottom: 20px;">Lyrics:</span>';
						echo '
							<p>' . str_replace(array("\r\n", "\r", "\n"), "<br />", file_get_contents('extras/songs/'.pathinfo($cur, PATHINFO_FILENAME).'.txt') ) . '</p>';
						echo '
						</div>';
					}
					echo '
					<div class="audio-container">
						<input type="hidden" id="song" value="'.$cur.'">
					</div>
				</div>
			</div>
		</div>';
	}
	echo '
</body>
</html>';
?>