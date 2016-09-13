(function($){
	$(".fecharmodalvideo").click(function(e){
		e.preventDefault();
		$(".modalvideos").hide();
		$(".con_video2").hide();
		$(".con_video3").hide();
		$('.youtubeplayer').trigger('pause');
	});
	
	$(".btnvideo2").click(function(e){
		e.preventDefault();
		$(".modalvideos").show();
		$(".con_video2").show();

	});

	$(".btnvideo3").click(function(e){
		e.preventDefault();
		$(".modalvideos").show();
		$(".con_video3").show();
	});

})(jQuery);

(function($){
			$(window).load(function(){
					$(".lista").mCustomScrollbar({
						scrollButtons:{enable:true,scrollType:"stepped"},
						keyboard:{scrollType:"stepped"},
						mouseWheel:{scrollAmount:188},
						theme:"rounded-dark",
						autoExpandScrollbar:true,
						snapAmount:188,
						snapOffset:65
					});
			});

			$("#btnApagar").click(function(){
				var qtdtimeline = $(".videosecenas").find(".ativado").size();
				if(qtdtimeline >= 2){
					$(".div1.ativado:last").addClass("desativado");
					$(".div1.ativado:last").removeClass("ativado");
					$(".div1.ativado:last a").remove();
					$(".div1.desativado").removeAttr("ondragover");
					
					
					
					$(".div2.ativado:last").addClass("desativado");
					$(".div2.ativado:last").removeClass("ativado");
					$(".div2.ativado:last a").remove();
					$(".div2.ativado:last").removeClass("frasePre");
				}
			});

		$("a.videoPrev").click(function( e ){
			
			e.preventDefault();

			var linkVideo =  this.href;	
			
			$(".divPreview").empty();
			$(".divPreview").append('<video id="previewVideo" width="440" height="315"></video>');
			var player = new MediaElementPlayer('#previewVideo', {

			    type: 'video/mp4',
			    success: function (mediaElement, domObject) {
			        var sources = [
			            {src: linkVideo, type: 'video/mp4'}
			        ];
			        mediaElement.setSrc(sources);
			        mediaElement.load();
			        mediaElement.play();
			    }

			});


		});

})(jQuery);



//
function allowDrop(ev) {
	 ev.preventDefault();
}

var item = "";

function drag(ev) {
	(function($){


			ev.dataTransfer.setData("text", ev.target.id);
			var classes = ev.target.className;
			var classe = classes.substring(0, 3);
			//Define o Item para Setar na TimeLine e validar
			item  = classe;


			if(classe == "fra"){
				$(".audio .ativado").removeAttr('ondragover');
				if(!$("li").hasClass("cenaSemAudio")){
					$(".videosecenas .ativado").attr('ondrop','drop(event)');	
					$(".videosecenas .ativado").attr('ondragover','allowDrop(event)');
				}
			}

			if(classe == "cen"){
				$(".audio .ativado").removeAttr('ondragover');
				if(!$("li").hasClass("cenaSemAudio")){
					$(".videosecenas .ativado").attr('ondrop','drop(event)');	
					$(".videosecenas .ativado").attr('ondragover','allowDrop(event)');
				}	
			}

			if(classe == "som"){
				$(".videosecenas .ativado").removeAttr('ondragover');
				$(".frasePre").removeAttr('ondragover');//FRASE nao tem audio
				$(".audio .cenaSemAudio").attr('ondragover','allowDrop(event)');
			}
	 })(jQuery);//Function $
}//Function $drag



function drop(ev) {
    ev.preventDefault();
    var data = ev.dataTransfer.getData("text");

    var classes = ev.target.className;
	var classe = classes.substring(0, 4);

	var nodeCopy = document.getElementById(data).cloneNode(true);
	nodeCopy.id = data; /* We cannot use the same ID */
	ev.target.appendChild(nodeCopy);
	


	// Validar qual item esta no Drag para Validar Frase video e Audio
	if(item == "fra"){
	 		(function($){
	 				$("div.audio li.ativado:last").addClass('frasePre');
	 		})(jQuery);
	}
	if(item == "cen"){
		(function($){
	 				$("div.texto ").append("<span class='btnAudio'></span>");
	 				$(".videosecenas .ativado").removeAttr('ondragover');
	 				$("div.audio li.ativado:last").addClass("cenaSemAudio");	
	 	})(jQuery);	
	}
	if(item == "som"){
		(function($){
			$("span.btnAudio").remove();
			$("div.audio li.ativado").removeClass("cenaSemAudio");
		})(jQuery);	
	}


	// Ativar o proximo Campo
	if(classe == "div1"){
	   (function($){
				$("li.ativado").next().removeClass('desativado').addClass('ativado');
				$("div.videosecenas li.ativado").attr('ondragover','allowDrop(event)');
		})(jQuery);
	}

	if(item == "cen"){
		(function($){
	 				$(".videosecenas .ativado").removeAttr('ondragover');
	 				$(".videosecenas .ativado").removeAttr('ondrop');
	 	})(jQuery);	
	}



}



/* Controle Lista */
	(function($){
		$("a.btnfraseancora").click(function(){
			$(".listafilme").hide();
			$(".listafrases").show();
			$("a").removeClass("active");
			$(this).addClass("active");
		});
		$("a.btnfraseancora2").click(function(){
			$(".listafilme").hide();
			$(".listafrases2").show();
			$("a").removeClass("active");
			$(this).addClass("active");
		});
		$("a.btnfraseancora3").click(function(){
			$(".listafilme").hide();
			$(".listafrases3").show();
			$("a").removeClass("active");
			$(this).addClass("active");
		});
		$("a.btnfraseancora4").click(function(){
			$(".listafilme").hide();
			$(".listafrases4").show();
			$("a").removeClass("active");
			$(this).addClass("active");
		});
		$("a.btnfraseancora5").click(function(){
			$(".listafilme").hide();
			$(".listafrases5").show();
			$("a").removeClass("active");
			$(this).addClass("active");
		});
		$("a.btnfraseancora6").click(function(){
			$(".listafilme").hide();
			$(".listafrases6").show();
			$("a").removeClass("active");
			$(this).addClass("active");
		});
		$("a.btncenasancora").click(function(){
			$(".listafilme").hide();
			$(".listacenas").show();
			$("a").removeClass("active");
			$(this).addClass("active");

		});
		$("a.btncenasancora2").click(function(){
			$(".listafilme").hide();
			$(".listacenas2").show();
			$("a").removeClass("active");
			$(this).addClass("active");

		});
		$("a.btncenasancora3").click(function(){
			$(".listafilme").hide();
			$(".listacenas3").show();
			$("a").removeClass("active");
			$(this).addClass("active");

		});
		$("a.btncenasancora4").click(function(){
			$(".listafilme").hide();
			$(".listacenas4").show();
			$("a").removeClass("active");
			$(this).addClass("active");

		});

		$("a.btnsonsancora").click(function(){
			$(".listafilme").hide();
			$(".listasons").show();
			$("a").removeClass("active");
			$(this).addClass("active");
		});
		$("a.btnsonsancora2").click(function(){
			$(".listafilme").hide();
			$(".listasons2").show();
			$("a").removeClass("active");
			$(this).addClass("active");
		});
		$("a.btnsonsancora3").click(function(){
			$(".listafilme").hide();
			$(".listasons3").show();
			$("a").removeClass("active");
			$(this).addClass("active");
		});
		$("a.btnsonsancora4").click(function(){
			$(".listafilme").hide();
			$(".listasons4").show();
			$("a").removeClass("active");
			$(this).addClass("active");
		});
	})(jQuery);

// Termino DragDrop, avancar para salvar
(function($){
	$("#btnsalvartime").click(function() {
		if( $( "a" ).hasClass( "btncriaruser" )){
			alert("Por favor, faça o login antes de salvar seu video!")
		}else{
			$("#tipoAcao").val("salvarvideo");
		  	$(".forminfos").show();
		  	$(".contenttimeline").hide();
	  	}
	});

	$("fecharcompartilha").click(function() {
		window.location.href = "http://elvisbmartins.com/facaseuvideo/?cat=6";
	});

})(jQuery);

// Preview Faça seu Video 
(function($){
	$(".btnassistirtime").click(function(){
		$("#tipoAcao").val("preview");
		$( "#fsv_form" ).submit();
		//$(".previewfsvcontent").show();
		/*var contentVideo ;
		var zindex;
		var urlVideo;
		var timeline = new Array();
		var zindex = 995;

		 $('.timelines input').each(function()
		 {
		      timeline.push($(this).val());
		 });
		 
		 for(var i=0;i < timeline.length; i++){

		 	var video =  timeline[i].split("//");
		 	var tipovideo = video[0];
		 	var urlVideo = video[1];

		 	if(tipovideo == "frase"){
		 		contentVideo = contentVideo + "<div class='Contentvideofsv videofsv  executar' style='z-index:"+zindex+"'><video  width='560' height='315' class='youtubeplayer fraseFsv'><source src='http://"+urlVideo+"' type='video/youtube' ></video></div>";
		 	}
		 	if(tipovideo == "cena"){
		 		contentVideo = contentVideo + "<div class='Contentvideofsv videofsv  executar' style='z-index:"+zindex+"'><video  width='560' height='315' class='youtubeplayer cenaFsv'><source src='http://"+urlVideo+"' type='video/youtube' ></video></div>";
		 	}
		 	if(tipovideo == "som"){
		 		contentVideo = contentVideo + "<div class='Contentvideofsv somDisplay somPlay' style='z-index:"+zindex+"'><video  width='560' height='315' class='youtubeSomPlay somFsv'><source src='http://"+urlVideo+"' type='video/youtube' ></video></div>";
		 	}

		 	zindex =  zindex-1;
		 }


		//Adicionar timeline na pagina;
		$(".contentvideo").append(contentVideo);
		*/
	});

	$("#btnFecharPreview").click(function(){
		$(".previewfsvcontent").hide();
	});

	


})(jQuery);



	
 