function openAjax(){
	var ajax;

try{
	ajax = new XMLHttpRequest();
}catch(erro){
	try{
		ajax = new ActiveXObject("Msxl2.XMLHTTP");
	}catch(ee){
		try{
			ajax = new ActiveXObject("Microsoft.XMLHTTP");
		}catch(e){
			ajax = false;
		}
	}
}
return ajax;
}//instancia dinamicamente o objecto xmlhttp

function enviarContato(){

	if(document.getElementById){
            
            var nome = $('#nome').val();
            var email = $('#email').val();
            var telefone = $('#telefone').val();
            var assunto = $('#assunto').val();
            var mensagem = $('#mensagem').val();
            var erro = 0;
            var txt = email;
            
            if(nome == ""){
                $("#nome").css("border", "1px solid #f00");
                erro++;
                $('#nome').focus();
            }else{
                $("#nome").css("border", "1px solid #ccc");
            }
            
            if(email == ""){
                $("#email").css("border", "1px solid #f00");
                erro++;
                $('#email').focus();
            }else{
                
                var verificarEspacosEmail = (email) => {
                    if (email.includes(' ')) {
                      return true; 
                    }
                    return false; 
                  };
                  
                if ((txt.length != 0) && ((txt.indexOf("@") < 1) ))
                {
                    $('.mes-aviso2').show();
                    $('#email').focus();
                    erro++;
                }else{
                    
                    if(verificarEspacosEmail(email) == false){                    
                        $('.mes-aviso2').hide("slow");
                    }else{
                        $('.mes-aviso2').show();
                        $('#email').focus();
                        erro++;
                    }       
                    
                }                
                $("#email").css("border", "1px solid #ccc");
            }          
            
            if(telefone == ""){
                $("#telefone").css("border", "1px solid #f00");
                erro++;
                $('#telefone').focus();
            }else{
                $("#telefone").css("border", "1px solid #ccc");
            }            
            
            if(assunto == ""){
                $("#assunto").css("border", "1px solid #f00");
                erro++;
                $('#assunto').focus();
            }else{
                $("#assunto").css("border", "1px solid #ccc");
            }
                        
            if(mensagem == ""){
                $("#mensagem").css("border", "1px solid #f00");
                erro++;
                $('#mensagem').focus();
            }else{
                $("#mensagem").css("border", "1px solid #ccc");
            }
            
            
            if(erro == 0)
            {
                $('.alert-info').show();
                
                
                var ajax = openAjax();
                        
			ajax.open("GET", "funcoes.php?acao=contato&email=" + email + "&nome=" + nome + "&telefone=" + telefone + "&mensagem=" + mensagem + "&assunto=" + assunto, true);
			ajax.onreadystatechange = function(){
				if(ajax.readyState == 1){
					
				}
				
				if(ajax.readyState == 4){
                                   
					if(ajax.status == 200){
						var resultado = ajax.responseText;
						resultado = resultado.replace(/\+/g, " ");				
						resultado = unescape(resultado);
                                                                                        
                                                $('#nome').val('');
                                                $('#email').val('');
                                                $('#telefone').val('');
                                                $('#assunto').val('');
                                                $('#mensagem').val('');                                     
                                                $('.alert-info').hide("slow");
                                                $('.alert-success').show();
                                                                
						
					}else{
						alert ('<p>Ouve algum erro na requisição</p>');
						
					}
				}
			}
			ajax.send(null);
		
            }
       
               
            
	}
        }
        
function mostrarAulas(){
	if(document.getElementById){
            
            $('.lista-aulas').show();
            $('.btn-aulas').hide();              
               
	}
}