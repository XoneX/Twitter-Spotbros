Twitter-Spotbros
================

Conectar Twitter con Spotbros. ^-^

1- Abre el archivo datos.php
Y rellenalo con tus datos de Spotbros y de Twitter, en total son 6 datos los que tienes que poner.

2- En el archivo configApp.php,
puedes personalizar los mensajes que aparecen  cuando alguien se suscribe a la app o cuando la vota.
Tambien puedes guardar logs de errores, etc..
Tambien puedes controlar respuestas al evente de nuevo mensaje, es decir si te mandan un mensaje  a la SBApp puedes decidir que hacer si responderle o lo que sea.

3-Abre el archivo timeline.php y personaliza el metodo printSBMsg a tu gusto.. lo mismo con el metodo printTweets, aunque este ultimo es prescindible y puedes eliminarlo..


4-Intentar NO Tocar nada de TwitterAPIExchange.. si no funciona comprueba rutas y credenciales..
En el archivo ejemploEnviarTweets.php, comprobar que la ruta hacia el SDK de Spotbros esta correctamente..

Espero les funcione! es un ejemplo rapido y quiza tenga algun error.. Cualquier posible error comunicarmelo y lo arreglo.. 
El codigo no es seguramente el mas optimizado ni el mejor pero hice lo que pude.. :((

Cualquier duda sobre la api de Twitter la pueden consultar aqui: https://dev.twitter.com/docs/api/1.1/get/statuses/user_timeline

Cuando tenga la app terminada sin errores subire aqui el codigo..
Usa varias clases de las anteriores pero otras las cree de propio para hacer esta guia de ejemplo.
Saludos!!
