<?php 


function naologado(){


	//Botao Fechar
	if(isset($_SERVER['HTTP_REFERER'])) {
		$urlVoltar = $_SERVER['HTTP_REFERER'];
	} else {
		$urlVoltar =  home_url();
	}

	$video1 = get_field( "video_1" );
	$descricaov1 = get_field( "descricaov1" );
	$video2 = get_field( "video_2" );
	$descricaov2 = get_field( "descricaov2" );
	$video3 = get_field( "video_3" );
	$descricaov3 = get_field( "descricaov3");
	$imagem_exemplo = get_field( "imagem_exemplo" );
	$texto_descricao = get_field("texto_descricao");
	$linkv2 = get_field("link_v2");
	$linkv3 = get_field("link_v3");

	$usuario ='<a href="/registrar-usuario/" class="btncriaruser" >CRIAR USUARIO</a>
						<div class="formuserfaca">
							<form  method="post" action="">
								<input type="text" value="" placeholder="LOGIN" name="log" />
								<input type="password" value="" placeholder="SENHA" name="pwd" />
								<input type="submit"  value="ENTRAR" />
							</form>
					  </div>';

	$templateDeslogado = '<div class="content_deslogado">
							<div class="login">'.$usuario.'</div>
							<div class="btnvideos  fechardeslogado">
								<a href="'.$urlVoltar.'" class="btnfechamodal"> x </a>
							</div>
							<div class="contentvideo">
								<div class="colunm content_exemplo">
									<div class="video1">
										<video width="385" height="200" class="youtubeplayer">
											<source src="'.$video1["url"].'" type="video/mp4">
										</video>
										<div class="descricao">'. $descricaov1 .'</div>
									</div>
									<div class="video2">
									<a href="#" class="btnvideo2">
										<div class="video"><img src="'.$video2.'" /></div>
										<div class="descricao">'. $descricaov2.'</div>
										</a>
									</div>
									<div class="video3">
									<a href="#" class="btnvideo3">
										<div class="video"><img src="'. $video3.'" /></div>
										<div class="descricao">'. $descricaov3.'</div>
										</a>
									</div>
								</div>
								<div class="colunm content_texto">
									<div class="imgdescritiva"><img src="'.$imagem_exemplo.'" /></div>
									<div class="ajuda">'. $texto_descricao .'</div>
								</div>
							</div>
						</div>
						<div class="modalfalso"></div>	

						<div class="modalvideos">
							<div class="con_video2">
								<a href="#" class="fecharmodalvideo btnvideos">X</a>
								<video class="youtubeplayer">
									<source src="'.$linkv2["url"].'" type="video/mp4">
								</video>
							</div>
							<div class="con_video3">
								<a href="#" class="fecharmodalvideo btnvideos">X</a>
								<video  class="youtubeplayer">
									<source src="'.$linkv3["url"].'" type="video/mp4">
								</video>
							</div>
							<div class="modalfalso"></div>	
						</div>'; 

	return $templateDeslogado;

}

?>