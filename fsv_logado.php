<?php
	

function logado(){

	//Botao Fechar
	if(isset($_SERVER['HTTP_REFERER'])) {
		$urlVoltar = $_SERVER['HTTP_REFERER'];
	} else {
		$urlVoltar =  home_url();
	}


	/*
		Pegar Video das pastas, Funciton LISTA
    */
	function lista($tipo){

		$path = "wp-content/uploads/videos/".$tipo; 
		$diretorio = dir($path);
		$tipoThumb =  explode("/", $tipo);
		$thumbnails = "wp-content/uploads/videos/thumbnails/".$tipoThumb[1];
		
		if($tipoThumb[0] == "frases"){
			$tipo = "frase";
		}else if($tipoThumb[0] == "cenas"){
			$tipo = "cena";
		}else if($tipoThumb[0] == "sons"){
			$tipo = "som";
		}
		

	
		 while($file = $diretorio -> read()){

	    	$url = $path."/".$file;
	    	$id = strtolower( ereg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($file)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ"),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
	    	$thumb = str_replace(".mp4","",$file);
	    	$thumbnail = $thumbnails."/".$thumb.".jpg";

	    	if($tipoThumb[0] == "sons"){
				$thumbnail = "wp-content/uploads/videos/thumbnails/sons/icon_sound.jpg";
			}

			$classeDrag = $tipoThumb[0];

		 	if (substr($file,-4) == ".mp4") { 
					$lista  = $lista . '<li>';
					$lista  = $lista . '<a href="'.$url.'" title="'. $file.'" id="'.  $id  .'" target="videoPlay" draggable="true"   ondragstart="drag(event)" class="'.$classeDrag.' videoPrev">';
					$lista  = $lista . '<img src="'.$thumbnail.'" alt="" width="150" id="'.  $id  .'" class="'.$tipo.'">';
					$lista  = $lista . '<input type="hidden" name="timeline[]" class="'.$tipo.' timeline" value="'.$tipo.'//'.	$url .'">';
					$lista  = $lista . '</a>';
					$lista  = $lista . '</li>';
				}
		  }
	
		$diretorio -> close();
		   
		return $lista;

	
	}// Function Lista
 
	global $current_user;
	global $userdata;
    get_currentuserinfo();
 

	$frase = "<p>arraste frases, cenas e sons para fazer um vídeo com trechos dos<br />programas da série ESTILHAÇOS e compartilhar com seus amigos</p>";
	$usuario ="<div class='nomeuser' >". $current_user->display_name ."</div><div class='avataruser'>".get_avatar( $userdata->ID, 40) ."</div>";


	//Verificação de POST da TIMELINE
	if($_POST['timeline'] || $_POST['compartilha']){

		//Recebe o tipo de acao se e PREVIEW ou SALVAR
		$tipoAcao = $_POST['tipoAcao'];

		for ($i=0; $i < count( $_POST['timeline']); $i++) { 
			$thumb[$i] = substr($_POST['timeline'][$i], -11);
		}

		$titulovideo = "Vídeo de ".$current_user->user_login;

		if($tipoAcao == "preview"){
			$timeline1 = "";
			$timeline2 = "";

			//Display do Preview
			$previewDisplay =  "display:block";	
				
			$qtdtime = 0;//saber a quantidade que falta para colocar na timeline


				
			for ($i=0; $i < count( $_POST['timeline']); $i++) { 
					
					$tipo[$i] = substr($_POST['timeline'][$i], 0, 3);
					
					$urlVideo = explode("//",$_POST['timeline'][$i]);
					$urlVideo = $urlVideo[1];
					$Tipothumb = explode("/",$urlVideo);
					$thumb = str_replace(".mp4","",$Tipothumb[5]);

					if($tipo[$i] == "fra"){
						$urlClass = "frase";
						$urlDiv = "div1";
						$timeline1 = $timeline1 . "<li class='".$urlDiv." ativado' ondrop='drop(event)' ondragover='allowDrop(event)'><a href='".$urlVideo."' title='' id='' target='videoPlay' draggable='true' ondragstart='drag(event)'><img src='/wp-content/uploads/videos/thumbnails/".$Tipothumb[4]."/".$thumb.".jpg' alt='' width='150' id='' class='".$urlClass." mCS_img_loaded'><input type='hidden' name='timeline[]' class='".$urlClass." timeline' value='".$urlClass."//".$urlVideo."'></a></li>";
						$qtdtime++;
						$marcacao[$i] = "f";//saber o lugar do audio
					}
					if($tipo[$i] == "cen"){
						$urlClass = "cena";
						$urlDiv = "div1";
						$timeline1 =  $timeline1."<li class='".$urlDiv." ativado' ondrop='drop(event)' ondragover='allowDrop(event)'>
						<a href='".$urlVideo."' title='' id='' target='videoPlay' draggable='true' ondragstart='drag(event)'>
						<img src='/wp-content/uploads/videos/thumbnails/".$Tipothumb[4]."/".$thumb.".jpg' alt='' width='150' id='' class='".$urlClass." mCS_img_loaded'><input type='hidden' name='timeline[]' class='".$urlClass." timeline' value='".$urlClass."//".$urlVideo."'></a></li>";
						$qtdtime++;
						$marcacao[$i] =  "c";//saber o lugar do audio
					}
			}//For Timeline

			//Montando a TimelIne do som
			$urlClass = "som";
			$urlDiv = "div2";
			for ($t=0; $t < count($marcacao) ; $t++) { 
				if($marcacao[$t] == "c"){
						$timeline2 = $timeline2  . "<li class='".$urlDiv." ativado' ondrop='drop(event)' ondragover='allowDrop(event)'><a href='".$urlVideo."' title='' id='' target='videoPlay' draggable='true' ondragstart='drag(event)'><img src='/wp-content/uploads/videos/thumbnails/sons/icon_sound.jpg' alt='' width='150' id='' class='".$urlClass." mCS_img_loaded'><input type='hidden' name='timeline[]' class='".$urlClass." timeline' value='".$urlClass."//".$urlVideo."'></a></li>";
				}else{
						$timeline2 = $timeline2  . '<li class="div2 ativado frasePre" ondrop="drop(event)" ondragover="allowDrop(event)"></li>';
				}
		    }

            //Montando o restante da timeline
  			$restotime = 24 - $qtdtime ;
			for ($i=0; $i < $restotime; $i++) { 
				if($i == 0){
					$timeline1 = $timeline1  . '<li class="div1 ativado" ondrop="drop(event)" ondragover="allowDrop(event)"></li>';
					$timeline2 = $timeline2  . '<li class="div2 ativado" ondrop="drop(event)" ondragover="allowDrop(event)"></li>';
				}else{
					$timeline1 = $timeline1  . '<li class="div1 desativado" ondrop="drop(event)" ></li>';
					$timeline2 = $timeline2  . '<li class="div2 desativado" ondrop="drop(event)" ></li>';
				}
			}

			//Preview content de videos
			$zindex = 995;
			for ($i=0; $i < count( $_POST['timeline']); $i++) { 
					
				$tipo[$i] = substr($_POST['timeline'][$i], 0, 3);
					
				$urlVideo = explode("//",$_POST['timeline'][$i]);
				$urlVideo = $urlVideo[1];

		

				if($tipo[$i] == "fra"){
			    	$tipoVideo = "videofsv  executar";
			    	$videotipo = "youtubeplayer fraseFsv"; 
			    	$contentVideosPreview = $contentVideosPreview . '<div class= "Contentvideofsv '. $tipoVideo .'"  style="z-index:'.$zindex.'">
								<video class="'.$videotipo.'">
									<source src="/'.$urlVideo.'" type="video/mp4">
								</video>
							</div>';
			    }
			    if($tipo[$i] == "cen"){
			    	$tipoVideo = "videofsv  executar";
			    	$videotipo = "youtubeplayer cenaFsv"; 
			    	$contentVideosPreview = $contentVideosPreview . '<div class= "Contentvideofsv '. $tipoVideo .'"  style="'.$zindex.'">
								<video  class="'.$videotipo.'">
									<source src="/'.$urlVideo.'" type="video/mp4">
								</video>
							</div>';

			    }
			    if($tipo[$i] == "som"){
			    	$tipoVideo = "somDisplay somPlay";
			    	$videotipo = "youtubeSomPlay somFsv"; 
			    	$contentVideosPreview = $contentVideosPreview . '<div class= "Contentvideofsv '. $tipoVideo .'"  style="'.$zindex.'">
								<video class="'.$videotipo.'">
									<source src="/'.$urlVideo.'" type="video/mp4">
								</video>
							</div>';
			    }

                $zindex--; 
			} 

		}// If Preview


		// SALVAR VIDEO
		if($tipoAcao == "salvarvideo"){

				$sinopse = explode("//",implode(",", $_POST['timeline']) );
				$sinopse = explode("/",$sinopse[1]);
				$sinopse = explode(",", $sinopse[4]."/". str_replace(".mp4", "",$sinopse[5]));
				$sinopse = $sinopse[0];
				$user_post_count = count_user_posts( $current_user->ID );
				if($user_post_count < 1){
					$num = 1;
				}else{
					$num =  $user_post_count + 1;
				}
				$titulovideo = "Vídeo de ". $current_user->user_login;

				$titulo =  $titulovideo." #".$num;
	

				//monta o array para salvar
				$postFaca = array(
				    'post_title' => $titulo,
				    'post_content' => implode(",", $_POST['timeline']),
				    'post_status' => 'publish',
				    'post_type' =>  "post",
				    'tags_input' =>  $_POST['palavrachave'],
				    'post_category'  => array('6'),
				 );

			$post_id = wp_insert_post($postFaca);
			//Add field value
			update_field( "field_548aeed96bcb4", $sinopse, $post_id );
			//update_field( "field_548212918c925", $thumb[0], $post_id );
	

			// Pegar ultimo post adicionado;
			 $query = new WP_Query( 'category_name=faca-seu-video&posts_per_page=1' );
			 if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();

			 	$urlpost = get_permalink( get_the_ID());
				
			
			 endwhile; 
			 endif;

			wp_reset_query();

			//Template para Compartilhar
			$templateCompartilha =  '<div class="forminfos" style="display:block;">
					<div class="textoFormInfos" ><p>para compartilhar com seus contatos, digite o e-mail, separados por vírgula</p></div>
					<div class="formcompartilhar">
						<form name="compartilhar" id="compartilhar" method="POST">
							<input type="text"  value="" placeholder="email, email, ..."  name="emails"/>
							<input type="hidden" name="tipoAcao" id="tipoAcao" value="compartilha"/>
							<input type="hidden" name="compartilha" id="tipoAcao" value="compartilha"/>

							<input type="submit"  value="ENVIAR" />
						</form>
					</div>
					<div class="textoFormInfos" ><p>para publicar nas redes sociais, clique nos botões abaixo</p></div>
					<a  href="https://www.facebook.com/sharer/sharer.php?u='.$urlpost.'"  target="_blank"><img src="http:/elvisbmartins.com/facaseuvideo/wp-content/uploads/iconfacebook.jpg" alt="" title=""></a>
					<a href="http://twitter.com/home?status='.$urlpost.'" target="_blank"><img src="http://http:/elvisbmartins.com/facaseuvideo/wp-content/uploads/icontwitter.jpg" alt="" title=""></a>
					<a href="'.$urlpost.'" class="fecharcompartilha" >Fechar</a>
				</div><div class="modalfalso"></div>';

				return $templateCompartilha;

			//wp_redirect( get_bloginfo('url').'/?cat=6' );
		}//IF Salvar Video


		

		// Enviar emai do Compartilhar
		if($tipoAcao == "compartilha"){
			
			 // Pegar ultimo post adicionado;
			 $query = new WP_Query( 'category_name=faca-seu-video&posts_per_page=1' );
			 if ($query->have_posts()) : while ($query->have_posts()) : $query->the_post();

			 	$urlpost = get_permalink( get_the_ID());
				
			
			 endwhile; 
			 endif;

			wp_reset_query();


			// Enviar Email
			$to = explode(",",  $_POST['emails']);
			$subject = "Faça seu video - Meu Video";
			$content = "veja aqui meu video: ". $urlpost;

			$status = wp_mail($to, $subject, $content);

			//Template para Compartilhar
			$templateCompartilha =  '<div class="forminfos" style="display:block;">
					<div class="textoFormInfos" ><p>para compartilhar com seus contatos, digite o e-mail, separados por vírgula</p></div>
					<div class="formcompartilhar">
						<form name="compartilhar" id="compartilhar" method="POST">
							<input type="text"  value="" placeholder="email, email, ..."  name="emails"/>
							<input type="hidden" name="tipoAcao" id="tipoAcao" value="compartilha"/>
							<input type="hidden" name="compartilha" id="tipoAcao" value="compartilha"/>

							<input type="submit"  value="ENVIAR" />
						</form>
					</div>
					<div class="textoFormInfos" ><p>para publicar nas redes sociais, clique nos botões abaixo</p></div>
					<a  href="https://www.facebook.com/sharer/sharer.php?u='.$urlpost.'" target="_blank"><img src="http:/elvisbmartins.com/facaseuvideo/wp-content/uploads/iconfacebook.jpg" alt="" title=""></a>
					<a href="http://twitter.com/home?status='.$urlpost.'" target="_blank"><img src="http://elvisbmartins.com/facaseuvideo/wp-content/uploads/icontwitter.jpg" alt="" title=""></a>
					<a href="'.$urlpost.'" class="fecharcompartilha" >Fechar</a>
				</div><div class="modalfalso"></div>';

				return $templateCompartilha;

		}//TemplateCompartilha
		

	}else{
		
		//Display do Preview
		$previewDisplay =  "display:none";	

		//Montando a timeline vazia
		for ($i=0; $i < 24; $i++) { 
				if($i == 0){
					$timeline1 = $timeline1  . '<li class="div1 ativado" ondrop="drop(event)" ondragover="allowDrop(event)"></li>';
					$timeline2 = $timeline2  . '<li class="div2 ativado" ondrop="drop(event)" ondragover="allowDrop(event)"></li>';
				}else{
					$timeline1 = $timeline1  . '<li class="div1 desativado" ondrop="drop(event)" ></li>';
					$timeline2 = $timeline2  . '<li class="div2 desativado" ondrop="drop(event)" ></li>';
				}
			}
	}
	
	

	//CARREGARLISTA
	$frases01 = lista("frases/frases01");
	$frases02 = lista("frases/frases02");
	$frases03 = lista("frases/frases03");
	$frases04 = lista("frases/frases04");
	$frases05 = lista("frases/frases05");
	$frases06 = lista("frases/frases06");
	$cenas01 = lista("cenas/cenas01");
	$cenas02 = lista("cenas/cenas02");
	$cenas03 = lista("cenas/cenas03");
	$cenas04 = lista("cenas/cenas04");
	$sons = lista("sons/sons1");
	$sons2 = lista("sons/sons2");
	$sons3 = lista("sons/sons3");


	$template = '<div class="contenttimeline" >
					<a href="/" class="btnfechar"> x </a>
					<div class="userfacaSeuVideo">'. $usuario .'</div>
					<div class="content_faca">
						<div class="itens">
							<div class="videofull box"><div class="divPreview"><video  width="440" height="315" class="youtubeplayer fraseFsv"><source src="http://elvisbmartins.com/facaseuvideo/wp-content/uploads/2015/04/Carne-Imagética.mp4" type="video/mp4" id="previewVideo" ></video></div><div class="legenda">clique nas miniaturas, para assistir um preview</div></div>
							<div class="ancorasfsv">
								<a href="#" class="btnfraseancora active">Frases</a> |
								<a href="#" class="btnfraseancora2">Frases 02</a> |
								<a href="#" class="btnfraseancora3">Frases 03</a> |
								<a href="#" class="btnfraseancora4">Frases 04</a> |
								<a href="#" class="btnfraseancora5">Frases 05</a> |
								<a href="#" class="btnfraseancora6">Frases 06</a> |
								<a href="#" class="btncenasancora">Cenas</a> |
								<a href="#" class="btncenasancora2">Cenas 02</a> |
								<a href="#" class="btncenasancora3">Cenas 03</a> |
								<a href="#" class="btncenasancora4">Cenas 04</a> |
								<a href="#" class="btnsonsancora">Sons</a> |
								<a href="#" class="btnsonsancora2">Sons 02</a> |
								<a href="#" class="btnsonsancora3">Sons 03</a> 
							</div>
							<div class="listafrases box listafilme" style="display:block;"><div class="lista"><ul>'. $frases01 .'</ul></div></div>
							<div class="listafrases2 box listafilme" ><div class="lista"><ul>'. $frases02 .'</ul></div></div>
							<div class="listafrases3 box listafilme" ><div class="lista"><ul>'. $frases03 .'</ul></div></div>
							<div class="listafrases4 box listafilme" ><div class="lista"><ul>'. $frases04 .'</ul></div></div>
							<div class="listafrases5 box listafilme" ><div class="lista"><ul>'. $frases05 .'</ul></div></div>
							<div class="listafrases6 box listafilme" ><div class="lista"><ul>'. $frases06 .'</ul></div></div>
							<div class="listacenas box listafilme"><div class="lista"><ul>'. $cenas01 .'</ul></div></div>	
							<div class="listacenas2 box listafilme"><div class="lista"><ul>'. $cenas02 .'</ul></div></div>	
							<div class="listacenas3 box listafilme"><div class="lista"><ul>'. $cenas03 .'</ul></div></div>	
							<div class="listacenas4 box listafilme"><div class="lista"><ul>'. $cenas04 .'</ul></div></div>	
							<div class="listasons box listafilme"><div class="lista"><ul>'. $sons .'</ul></div></div>
							<div class="listasons2 box listafilme"><div class="lista"><ul>'. $sons2 .'</ul></div></div>
							<div class="listasons3 box listafilme"><div class="lista"><ul>'. $sons3 .'</ul></div></div>
						</div>
						<div class="clear"></div>

						<form id="fsv_form" method="POST" >
							<div class="timelines">
								<div class="texto">'. $frase .'</div>
								<div  class="linhatempo" >
									<div class="videosecenas">
											<ul>'. $timeline1 .'</ul>
										<div class="clear"></div>
									</div>
									<div class="audio"> 
										<ul>'. $timeline2 .'</ul>
										<div class="clear"></div>
									</div>
								</div>
								<div class="btn btnApagar">
									<span id="btnApagar" class="btnApagar" ><img src="http://elvisbmartins.com/facaseuvideo/wp-content/plugins/faca-seu-video/images/apagar.jpg" alt="Apagar Ultimo Video" title="Apagar Ultimo Video" /></span>
								</div>
								<div class="btn btnAssistir">
										<a href="#" id="btnassistirtime" class="btnassistirtime" >Preview</a>
								</div>
								<div class="btn btnsalvar">
										<input type="submit"  value="SALVAR" id="btnsalvartime" class="btnsalvarTime" />	
								</div>
						   </div>

							<input type="hidden" name="tipoAcao" id="tipoAcao" value=""/>

						</form>
					</div>
					</div>
					
					<div class="modalfalso"></div>
					<div class="previewfsvcontent" style="'. $previewDisplay .'">	
						<a href="#" id="btnFecharPreview" > X </a>
						<div class="videosPreview" >
							<div class="contentvideo">
							'. $contentVideosPreview.'
							</div>
						</div>
						<div class="modalfalso"></div>
					</div>
				';// Variavel Template

		$templateLogado = $template;

	return $templateLogado;

}

 ?>