<?php
  $songQuery = mysqli_query($con, "SELECT id FROM songs ORDER BY RAND() LIMIT 10");

  $resultArray = array();
  while ($row = mysqli_fetch_array($songQuery)) {
    array_push($resultArray, $row['id']);
  }

  $jsonArray = json_encode($resultArray);

?>

<script>
  $(document).ready(function() {
    var newPlaylist = <?php echo $jsonArray ?>;
    audioElement = new Audio();
    setTrack(newPlaylist[0], newPlaylist, false);
    updateVolumeProgressBar(audioElement.audio);

    $('#nowPlayingBarContainer').on('mousedown touchstart mousemove touchmove', function(e) {
      e.preventDefault();
    });

    $('.playbackBar .progressBar').mousedown(function() {
      mouseDown = true;
    });

    $('.playbackBar .progressBar').mousemove(function(e) {
      if (mouseDown) {
        timeFromOffset(e, this);
      }
    });

    $('.playbackBar .progressBar').mouseup(function(e) {
      timeFromOffset(e, this);
    });

    $('.volumeBar .progressBar').mousedown(function() {
      mouseDown = true;
    });

    $('.volumeBar .progressBar').mousemove(function(e) {
      if (mouseDown) {
        var percentage = e.offsetX / $(this).width();

        if (percentage >= 0 && percentage <=1) {
          audioElement.audio.volume = percentage;
        }
      }
    });

    $('.volumeBar .progressBar').mouseup(function(e) {
      var percentage = e.offsetX / $(this).width();

      if (percentage >= 0 && percentage <=1) {
        audioElement.audio.volume = percentage;
      }
    });

    $(document).mouseup(function() {
      mouseDown = false;
    });
  });

  function timeFromOffset(mouse, progressBar) {
    var percentage = mouse.offsetX / $(progressBar).width() * 100;
    var seconds = audioElement.audio.duration * (percentage / 100);
    audioElement.setTime(seconds);
  }

  function prevSong() {
    if (audioElement.audio.currentTime >=3 || currentIndex === 0) {
      audioElement.setTime(0);
    } else {
      currentIndex = currentIndex - 1;
      setTrack(currentPlaylist[currentIndex], currentPlaylist, true);
    }
  }
  function nextSong() {
    if (repeat) {
      audioElement.setTime(0);
      playSong();
      return;
    }
    if (currentIndex === currentPlaylist.length - 1) {
      currentIndex = 0;
    } else {
      currentIndex++;
    }

    var trackToPlay = shuffle ? shufflePlaylist[currentIndex] : currentPlaylist[currentIndex];
    setTrack(trackToPlay, currentPlaylist, true);
  }

  function setRepeat() {
    repeat = !repeat;
    var iconColor = repeat ? "#47d819" : "#aaa";
    $(".controlButton.repeat i").css({"color": iconColor});
  }

  function setMute() {
    audioElement.audio.muted = !audioElement.audio.muted;
    var iconClass = audioElement.audio.muted ? "fa-volume-xmark" : "fa-volume-high";
    var iconClassRemove = audioElement.audio.muted ? "fa-volume-high" : "fa-volume-xmark";

    $(".controlButton.volume i").addClass(iconClass).removeClass(iconClassRemove);
  }

  function setShuffle() {
    shuffle = !shuffle;
    var iconColor = shuffle ? "#47d819" : "#aaa";
    $(".controlButton.shuffle i").css({"color": iconColor});

    if (shuffle){
      shuffleArray(shufflePlaylist);
      currentIndex = shufflePlaylist.indexOf(audioElement.currentlyPlaying.id);
    } else {
      currentIndex = currentPlaylist.indexOf(audioElement.currentlyPlaying.id);
    }
  }

  function shuffleArray(a) {
      var j, x, i;
      for (i = a.length - 1; i > 0; i--) {
          j = Math.floor(Math.random() * (i + 1));
          x = a[i];
          a[i] = a[j];
          a[j] = x;
      }
      return a;
  }

  function setTrack(trackId, newPlaylist, play) {
    if (newPlaylist !== currentPlaylist) {
      currentPlaylist = newPlaylist;
      shufflePlaylist = currentPlaylist.slice();
      shuffleArray(shufflePlaylist);
    }

    if (shuffle) {
      currentIndex = shufflePlaylist.indexOf(trackId);
    } else {
      currentIndex = currentPlaylist.indexOf(trackId);
    }

    pauseSong();
    $.post("includes/handlers/ajax/getSongJson.php", { songId: trackId }, function(data) {
      var track = JSON.parse(data);
      $(".trackName span").text(track.title);

      $.post("includes/handlers/ajax/getArtistJson.php", { artistId: track.artist }, function(data) {
        var artist = JSON.parse(data);
        $(".artistName span").text(artist.name);
      });

      $.post("includes/handlers/ajax/getAlbumJson.php", { albumId: track.album }, function(data) {
        var album = JSON.parse(data);
        $(".albumArtwork").attr("src", album.artworkPath);
      });

      audioElement.setTrack(track);
      playSong();
    });
 
    if (play) {
      audioElement.play();
    }
  }

  function playSong () {
    if (audioElement.audio.currentTime === 0) {
      $.post("includes/handlers/ajax/updatePlays.php", { songId: audioElement.currentlyPlaying.id });
    }
    $(".play").hide();
    $(".pause").show();
    audioElement.play();
  }

  function pauseSong () {
    $(".play").show();
    $(".pause").hide();
    audioElement.pause();
  }
</script>

<div id="nowPlayingBarContainer">
  <div id="nowPlayingBar">

    <div id="nowPlayingLeft">
      <div class="content">
        <span class="albumLink">
          <img class="albumArtwork" src="" alt="Album artwork">
        </span>
        <div class="trackInfo">
          <span class="trackName">
            <span></span>
          </span>
          <span class="artistName">
            <span>John Doe</span>
          </span>
        </div>
      </div>
    </div>

    <div id="nowPlayingCenter">
      <div class="content playerControls">
        <div class="buttons">
          <button class="controlButton shuffle" title="Shuffle" onclick="setShuffle()">
            <i class="fa-solid fa-shuffle"></i>
          </button>
          <button class="controlButton previous" title="Previous" onclick="prevSong()">
            <i class="fa-solid fa-arrow-left"></i>
          </button>
          <button class="controlButton play" title="Play" onclick="playSong()">
            <i class="fa-solid fa-play"></i>
          </button>
          <button class="controlButton pause" title="Pause" style="display:none" onclick="pauseSong()">
            <i class="fa-solid fa-pause"></i>
          </button>
          <button class="controlButton next" title="Next" onclick="nextSong()">
            <i class="fa-solid fa-arrow-right"></i>
          </button>
          <button class="controlButton repeat" title="Repeat" onclick="setRepeat()">
            <i class="fa-solid fa-repeat"></i>
          </button>
        </div>

        <div class="playbackBar">
          <span class="progressTime current">0:00</span>
          <div class="progressBar">
            <div class="progressBarBg">
              <div class="progress"></div>
            </div>
          </div>
          <span class="progressTime remaining">0:00</span>
        </div>
      </div>
    </div>

    <div id="nowPlayingRight">
      <div class="volumeBar">
        <button class="controlButton volume" title="Volume" onclick="setMute()">
          <i class="fa-solid fa-volume-high"></i> 
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