function initMusic() {
	const audios = document.getElementsByTagName('audio');
	const gen_player = document.querySelector('#general-player audio');
	const cur_time = document.querySelector('#time #current');
	const max_time = document.querySelector('#time #length');
	const progress = document.querySelector('.progress');
	const vol_progress = document.querySelector('.vol-progress');
	const master_chk = document.querySelector('#playing-master');
	const download_btn = document.querySelector('.download-btn');
	var cur_audio_chk;
	document.querySelector('#general-player .slider').addEventListener('click', function (e) {
		const width = this.clientWidth;
		const clickX = e.offsetX;
		const duration = gen_player.duration;

		gen_player.currentTime = (clickX / width) * duration;
	});
	
	document.querySelector('#general-player .vol-slider').addEventListener('mousemove', function (e) {
		if (e.buttons == 1) {
			e.preventDefault();
			const height = this.clientHeight;
			const clickY = e.offsetY;
			const newVol = 1 - clickY / height;
			vol_progress.style.height = newVol * 100 + '%';
			gen_player.volume = newVol;
		}
	});
	
	gen_player.onplay = function () {
		cur_audio_chk.checked = true;
		master_chk.checked = true;
	};
	gen_player.onpause = function () {
		cur_audio_chk.checked = false;
		master_chk.checked = false;
	};
	
	gen_player.addEventListener('timeupdate', function () {
	  var current = gen_player.currentTime;
	  var percent = (current / gen_player.duration) * 100;
	  progress.style.width = percent + '%';
	  cur_time.textContent = formatTime(current);
	});
	
	gen_player.addEventListener('loadedmetadata', () => {
		max_time.textContent = formatTime(gen_player.duration);
	});
	
	master_chk.addEventListener('change', (event) => {
		if (gen_player.readyState === 4) {
			if (event.currentTarget.checked) {
				gen_player.play();
			} else {
				gen_player.pause();	
			}
		}
	});
	
	// Load Songs
	document.querySelectorAll (".audio-container").forEach(function(aud, index) {
		var audio = aud.querySelector("#song")
	   	var checkbox = aud.parentNode.querySelector("input[type=checkbox]");
		checkbox.addEventListener('change', (event) => {
			//event.currentTarget.checked = event.returnValue;
			if (event.currentTarget.checked && event.currentTarget != cur_audio_chk) {
				cur_audio_chk = event.currentTarget;
				download_btn.href = audio.value;
				gen_player.src = audio.value; // Copy Src
				gen_player.load();
				gen_player.play();
				document.querySelectorAll(".active").forEach(obj => {
					obj.classList.remove('active');
				});
				var lyrics = aud.parentNode.querySelector(".lyrics")
				if (lyrics != null) {
					lyrics.classList.add('active');
				}
			} else {
				if (event.currentTarget.checked) {
					document.querySelectorAll(".active").forEach(obj => {
						obj.classList.remove('active');
					});
					var lyrics = aud.parentNode.querySelector(".lyrics")
					if (lyrics != null) {
						lyrics.classList.add('active');
					}
					gen_player.play();
				} else if (gen_player.readyState === 4) {
					gen_player.pause();	
				}
			}
			document.querySelectorAll("input[type=checkbox]:checked").forEach(el => el.checked = false);
			//event.currentTarget.checked = !gen_player.paused;
			//audio.parentNode.style.display = event.currentTarget.checked ? "flex" : "hidden";
		});
	});


	 document.querySelector(".loading").style.display = 'none';
}

function setProgress(e) {

}

function formatTime(time) {
  var min = Math.floor(time / 60);
  var sec = Math.floor(time % 60);
  return min + ':' + ((sec<10) ? ('0' + sec) : sec);
}
