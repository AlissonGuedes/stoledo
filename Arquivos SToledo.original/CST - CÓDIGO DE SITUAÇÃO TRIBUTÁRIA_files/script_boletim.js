// function Loading(divhandle){
// console.log(window.location.href);
var url = window.location.href;
var divBoletim = document.getElementById("boletim_avaliacao");
if(url.includes("boletim") || divBoletim != undefined) {
	registraAcessoBoletim();
	if(divBoletim != null) {
		// var str = '<div style="padding: 10px; margin: 10 auto; width:500px; text-align: center;"> \
		// 			<p style="font-size:15px; font-family: Arial, Helvetica">Esse Conte&uacute;do foi &uacute;til?</p> \
		// 				<div onclick="avaliarBoletim(1)" style="cursor:pointer; float: left; margin-left: 30%; font-family: Arial, Helvetica; font-size:15px;"><img src="http://www.econeteditora.com.br/img/like.png" width="35px" /><br />Sim</div> \
		// 				<div onclick="avaliarBoletim(-1)" onclick="" style="cursor:pointer; float: right; margin-right: 30%; font-family: Arial, Helvetica; font-size:15px;"><img src="http://www.econeteditora.com.br/img/unlike.png" width="35px" /><br />N&atilde;o</div> \
		// 				<br style="clear: left;" /> \
		// 				<!-- <span>Não</span> --> \
		// 				<br /> \
		// 				<p onclick="openBoletimComentario()" style="cursor:pointer; width: 110px; height: 40px; line-height: 40px; margin:0 auto; border-radius:50px; color:white; text-align:center; background:#5B9Bd5; font-family: Arial, Helvetica">Comente</p> \
		// 		</div>';
		var str = '<div class="row"> \
					<div class="col-md-12"> \
						<div id="div_retorno" class="alert alert-success d-none" role="alert"> \
							<span><i class="far fa-check-circle"></i>Sua avalia&ccedil;&atilde;o e comentário foram registrados com sucesso!</span> \
						</div> \
						<div id="div_avaliacao"> \
							<div class="text-center"> \
								<span class="subtitulo_comentario">Essa informa&ccedil;&atilde;o foi &uacute;til?</span><br /> \
								<img onclick="avaliarBoletim(1)" class="img_comentario" src="/css/boletim/like.svg" width="30" style="margin-right: 15px" /> \
								<img onclick="avaliarBoletim(-1)" class="img_comentario" src="/css/boletim/unlike.svg" width="30" /> \
							</div> \
							<p> \
								<span class="titulo_comentario">Deixe um coment&aacute;rio sobre esse boletim</span> \
								<span class="subtitulo_comentario">O seu endere&ccedil;o de e-mail n&atilde;o ser&aacute; divulgado. Campos obrigat&oacute;rios s&atilde;o mercados com *</span> \
							</p> \
							<div class="row"> \
								<div class="col-md-6 altura"> \
								<textarea id="campo_comentario" class="textarea_comentario" placeholder="Seu coment&aacute;rio"></textarea> \
				 			</div> \
								<div class="col-md-6 altura"> \
				 				<form> \
								  <div class="form-group"> \
								    <label id="campo_nome" class="text_form" for="input_nome">Nome *</label> \
								    <input type="email" class="form-control" id="input_nome" aria-describedby="emailHelp" placeholder="Seu nome"> \
								  </div> \
								  <div class="form-group"> \
								    <label class="text_form" for="input_email">Email *</label> \
								    <input type="email" class="form-control" id="input_email" aria-describedby="emailHelp" placeholder="Seu email"> \
								  </div> \
								</form> \
				  			</div> \
				  			<button onclick="saveComentario()" class="btn_comentario btn btn-primary" type="button">Enviar Coment&aacute;rio</button> \
							</div> \
						</div> \
					</div> \
				</div>';
		divBoletim.insertAdjacentHTML( 'beforeend', str );
	}
	// console.log(divBoletim);
}

function registraAcessoBoletim() {

	var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
    	console.log(this.responseText);
    	// var resposta = JSON.parse(this.responseText);
    	// // console.log(resposta);
     	// console.log(resposta);
    }
  };
  xhttp.open("POST", "http://www.econeteditora.com.br/avaliacao_boletim.php?acao=ACESSO&&url="+window.location.href, true);
  xhttp.send();
}

function saveComentario() {
	if(document.getElementById("campo_comentario").value == "") {
		alert("Preencha seu coment\xE1rio");
		return;
	}
	if(document.getElementById("input_nome").value == "") {
		alert("Preencha seu nome");	
		return;
	}
	if(document.getElementById("input_email").value == "") {
		alert("Preencha email");	
		return;
	}
	var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
  		var resposta = JSON.parse(this.responseText);
  		console.log(resposta);
  	};
  	document.getElementById("div_retorno").classList.remove("d-none");
	document.getElementById("div_avaliacao").classList.add("d-none");
  	var data = new FormData();
	data.append('comentario', document.getElementById("campo_comentario").value);
	data.append('nome', document.getElementById("input_nome").value);
	data.append('email', document.getElementById("input_email").value);
  	
  	xhttp.open("POST", "//www.econeteditora.com.br/avaliacao_boletim.php?acao=COMENTARIO&url="+window.location.href, true);
  	xhttp.send(data);
}

function openBoletimComentario() {
	// window.location.href
	Swal.fire({
	  title: 'Envie seu coment&aacute;rio sobre esse conte&uacute;do',
	  input: 'text',
	  inputAttributes: {
	    autocapitalize: 'off'
	  },
	  showCancelButton: true,
	  confirmButtonText: 'Enviar',
	  cancelButtonText: "Cancelar",
	  showLoaderOnConfirm: true,
	  preConfirm: (comentario) => {
	    return fetch(`//www.econeteditora.com.br/avaliacao_boletim.php?acao=COMENTARIO&url=`+window.location.href, {
	    	method: "POST", 
	    	body: JSON.stringify({
	    		"comentario" : comentario
	    	})
	    }).then(response => {
	        if (!response.ok) {
	          throw new Error(response.statusText);
	        }
	        return response.json();
	      })
	      .catch(error => {
	        Swal.showValidationMessage(
	          `Erro ao enviar comentario, tente novamente`
	        )
	      })
	  },
	  allowOutsideClick: () => !Swal.isLoading()
	}).then((result) => {
	  if (result.value) {
	    Swal.fire({
	      title: `Sucesso`,
	      text: "Comentario enviado com sucesso!"
	    })
	  }
	})
}


function avaliarBoletim(voto) {

	// document.getElementById("div_retorno").classList.remove("d-none");
	// document.getElementById("div_avaliacao").classList.add("d-none");
	// console.log(voto);
	var xhttp = new XMLHttpRequest();
  	xhttp.onreadystatechange = function() {
    	// if (this.readyState == 4 && this.status == 200) {
	    // 	var resposta = JSON.parse(this.responseText);
	    // 	if(!resposta.status) {
	    // 		alert(resposta.message);
	    // 	}else {
	    // 		alert("Conteúdo avaliado!");
	    // 		var divBoletim = document.getElementById("boletim_avaliacao");
	    // 		if(divBoletim != null) {
	    // 			divBoletim.innerHTML = "<p>Conteudo avaliado com sucesso!</p>";
	    // 		}
	    // 	}
    	// }
  };
  xhttp.open("POST", "http://www.econeteditora.com.br/avaliacao_boletim.php?acao=AVALIAR&util="+voto+"&url="+window.location.href, true);
  xhttp.send();
}

	
// }
