<?php

	function fsv_page_config() {
	
?>
	<div class="wrap">
	  <?php screen_icon(); ?>
	  <h2>Configurações Faça Seu Video</h2>
	  <form action="options.php" method="post">
	  	<div class="">
	  		<label>Link Playlist Youtube</label>
	    	<input type="text" name="youtubelist" id="youtubelist" class="youtubelist" value"" />
		</div>
		<div class="">
	  		<label>Link Playlist SoundCloud</label>
	    	<input type="text" name="soundlist" id="soundlist" class="soundlist" value"" />
		</div>
		<div class="">
	  		<label>Caminho Pasta Imagens</label>
	    	<input type="text" name="imglist" id="imglist" class="imglist" value"" />
		</div>
	  </form>
	</div>


<?php
	}
?>