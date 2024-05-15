<?php
	echo '
<!DOCTYPE html>
<html>
<head>
<title>Commander\'s Beats</title>
<link rel="stylesheet" type="text/css" href="/css/main_style.css">
<link rel="stylesheet" type="text/css" href="/css/music.css">
</head>
<body>
';
	echo '<div><h1 style="font-size: 64px;padding-top: 25px;">Beats \'n Shizzless!</h1>
	';
	echo '<h2> Zu den <a href="songs.php">Songs</a></h2>';
	$files = glob('extras/beats/*.mp3');
	echo '<p style="margin-bottom: 72px">';
	usort($files, function($x, $y) {
    return filemtime($x) < filemtime($y);
	});
	//print_r($files);
    echo "</p></div>";
	for ($i=0; $i<count($files); $i++){
		$cur = $files[$i];
		echo '<h2>'.basename($cur, ".mp3").' - '.date ("F d Y H:i:s.", filemtime($cur)).'</h2><hr>';
		echo '<div class="audio-container"><audio preload controls>';
		echo '<source src="'.$cur.'" type="audio/mpeg">';
		echo '</audio></div>';
		if (file_exists('extras/songs/'.pathinfo($cur, PATHINFO_FILENAME).'.txt'))
		{
			echo '<p class="lyrics"> Lyrics:<br>';
			echo nl2br( file_get_contents('extras/songs/'.pathinfo($cur, PATHINFO_FILENAME).'.txt') );
			echo '</p>';
		}
		echo '<br><br>';
	}
	echo '
</body>
</html>';
?>
