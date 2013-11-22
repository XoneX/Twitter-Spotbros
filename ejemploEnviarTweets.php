<?php
	require_once('../SBClientSDK/SBApp.php'); //Cambiar Aqui por la ruta que tengas tu el SDK de SB
	require_once ('timeline.php'); //timeline con los tweets de twitter
	require_once ('datos.php');//incluye un array con los datos de conexion por comodidad de no ponerlos en todas las apps.

	//Envia Notificacion a todos los usuarios de la SBapp sin necesitar que esta le haya enviado nada.
	class enviarNotificacion extends SBClientApi
	{
		public function sendNotificationToFollowers($notificationToBeSent_,$urlImg)
		{
			if(!($followersSBCodes = $this->getFollowerSBCodesOrFalse()))
			{error_log ("There was an error while getting the sbcodes");}
			$this->_SBAttachments->addTitleOrFalse("Prueba De SBMail con imagenes..");
		
			$imgPath=$this->_curlMngr->downloadFileOrFalse($urlImg); //Descarga la imagen al servidor
			$this->_SBAttachments->addImageOrFalse($imgPath,10000,true); //Envia un adjunto con la imagen y borra la imagen del server
			
			if (!($this-> sendTextMessageToGroupOrFalse($notificationToBeSent_, $followersSBCodes))) //Envia el mensaje a todos los usuarios
			{error_log ("Could not send message to group");}
		}
	}
	
	//Crea un objeto de la clase timeline de twitter y obtiene los tuits!
	$timeline= new timeline($settings,"Spotbros","&count=4&exclude_replies=true"); //Datos Api,Usuario,Parametros como el nº de tweets a traer
	//$count=4 significa que obtenga 4 tweets, &exclude_replies que no nos envie las respuestas a usuarios.
	
	$jsonDec=$timeline->getJsonDecoded(); //obtiene el json Decodificado.
	$count = count($jsonDec); //Cuenta los Tweets del json.
	//echo $timeline->jsonEncoded; //imprime el codigo de json en el navegador, lo uso para ver la estructura de los tweet en json
	
	for($i=0;$i<$count;$i++){ //un bucle que recorre todos los tweets.
			$tweet=$timeline->printSBMsg($i,$jsonDec); //Lo de pasarle el json,no tendria que ser necesario,es por un error que tengo que corregir
			$urlimg=$jsonDec[$i][entities][media][0][media_url]; //obtiene la url de la imagen del tweet(si la tiene), deberia hacer comprobaciones antes pero esto es solo un ejemplo muy simple
			$notificationSender = new enviarNotificacion($SBCode,$SBKey);// crea un objeto notificacion
			$notificationSender->sendNotificationToFollowers($tweet,$urlimg); //Envia la notificacion a todos los usuarios de la app.
	}
?>
