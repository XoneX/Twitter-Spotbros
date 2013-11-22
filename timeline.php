<?php
require_once('TwitterAPIExchange.php');

class timeline extends TwitterAPIExchange
{
	public $requestMethod = 'GET';
	public $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';

	public $jsonEncoded; //Codigo Json Codificado, podrian ser protected pero estan publicas por comodidad..
	public $jsonDecoded; //Codifo Json Decodificado
		
    public function __construct($settings,$usuario,$opciones) //Muy importantes los '__' no olvidarlos, sino coge el constructor del padre
    {    
    	parent::__construct($settings); //Ejecuta el constructor de la clase padre
    	parent::setGetfield("?screen_name=$usuario$opciones"); //Agrega el getfield a la clase padre, las opciones usan el formato &opcion1=valor1&opcion2=valor2
    	$this->url = 'https://api.twitter.com/1.1/statuses/user_timeline.json'; //Agrega la url de la api que usaremos, se puede cambiar por la que usemos   	
    }
    
    public function buildOauth(){
    	parent::buildOauth($this->url, $this->requestMethod);
    	return $this;
    }
    
    //Obtiene el Json de Twitter 
    private function getJsonEncoded(){
    	$this->jsonEncoded= $this->buildOauth()->performRequest();
    	return $this->jsonEncoded;
    }
    
    //Decodifica el Json
    public function getJsonDecoded(){
    	$this->jsonDecoded=json_decode($this->getJsonEncoded(), true);
 		return $this->jsonDecoded;
    }
    
    //Sbmsg con 'formato bonito' para enviar a la app
	public function printSBMsg($i,$json){
    	$jsonDec=$json;
		if(utf8_decode($jsonDec[$i][retweeted_status][id])===""){ //Estos son los Tweets normales, ya que no tienen id de retweet
			$tweet= "****Tweet:\n\n ".$jsonDec[$i][text]; //text es el contenido del tweet icluye imagenes y videos pero como si fueran links
			$tweet.= "\n\n****By: ".$jsonDec[$i][user][name]; //name es el @usuario pero sin la arroba.
			$tweet.="/@".$jsonDec[$i][user][screen_name]; //screen_name es el nombre de la cuenta
		}else{ // Estos son los Retweets
			$tweet= "****ReTweet:\n\n ".$jsonDec[$i][retweeted_status][text]; //Texto del tweet
			$tweet.= "\n\n****By: ".$jsonDec[$i][retweeted_status][user][name]; //Nombre en Twitter
			$tweet.= "/@".$jsonDec[$i][retweeted_status][user][screen_name]; //@Usuario 
			//Para añadir mas elementos o datos del tweet basta con mirar la estructura del json del tweet
			// y ver los nombres de los compos que queremos obtener, yo use los mas comunes el nombre, el usuario, la fecha..
    	}
    	return (string)$tweet;
    }
    
    //Imprimir Tweets en Web, Lo usaba para pruebas desde el navegador principalmente.. 
    public function printTweets(){
    	
    	$jsonDec=$this->getJsonDecoded();
    	$count = count($jsonDec);
    	for($i=0;$i<$count;$i++){
    		echo "<p style='border:2px solid black;'>";
    			
    		if(utf8_decode($jsonDec[$i][retweeted_status][id])===""){ //Estos son tw normales
    			echo "Tweet: ".utf8_decode($jsonDec[$i][text]);
    			echo "</br>\t ".$jsonDec[$i][user][name]; echo " -- @".$jsonDec[$i][user][screen_name];
    		}else{ // Los RT
    			echo "RT: ".utf8_decode($jsonDec[$i][retweeted_status][text]);
    			echo "</br>\t ".utf8_decode($jsonDec[$i][retweeted_status][user][name])."/@".utf8_decode($jsonDec[$i][retweeted_status][user][screen_name]);
    		}
    		echo " . . . ";
	    		setlocale(LC_ALL,"es_ES"); // pone en español la fecha, en este caso no muestro los nombres de los dias/meses, solo el numero
	    								   //  porque lo cambie, pero lo dejo por si algun dia lo volviera a cambiar
	    		$fechaUnix=strtotime($jsonDec[$i][created_at]); //La fecha del tweet convertida.
	    		echo strftime("%H:%M / %d-%B-%Y",$fechaUnix); //imprimo la fecha en el formato que yo quiero.
    		echo "</p>";
    	}
    }
	
    
}
