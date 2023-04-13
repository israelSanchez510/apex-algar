<?php

function marcar_numero($ext,$id_marcado,$numero){
	
	require "phpagi.php";

	$astHost = "10.220.0.5";
	$astUser = "ApexDev";
	$astPass = "4lg4rt3chCLI";

	$astManager = new AGI_AsteriskManager();
	
	$astRess    = $astManager->connect($astHost, $astUser, $astPass);

	if(!$astRess) {
        $respuesta = 'Connection to Asterisk Manager failed';
        return $respuesta;
        die();
	}

	$numero = substr($numero, -10);
	$did_llamada = "3347772191";
	$prefijo 	 = "OUT1/{$numero}";
	$callerid    = $ext;
  	$channel     = "IAX2/{$ext}"; 
	$exten       = $numero;
	$context     = "apex-tool";
	$priority    = "1";
	$account     = "apex-tool";
	$variable    = "prefijo={$prefijo},agente_ext={$ext},id_marcado={$id_marcado},did_llamada={$did_llamada}";
  
	$arr_resultado = $astManager->Originate($channel,$exten,$context,$priority,"","","",$callerid,$variable,$account,"","");
	$astManager->disconnect();
		
	return $arr_resultado['Message'];
	die();
}
?>