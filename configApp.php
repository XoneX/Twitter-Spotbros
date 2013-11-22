<?php

class configApp extends SBApp
{
	protected function onError($errorType_)
	{
		error_log($errorType_);
	}

	//Mensaje a mostrar si se vota la app
	protected function onNewVote(SBUser $user_,$newVote_,$oldRating_,$newRating_)
	{
	$this->replyOrFalse("Gracias por votar la app de testSB"); //.$newVote_." estrellas");
	}

	//Cuando un contacto se suscribe a la app
	protected function onNewContactSubscription(SBUser $user_)
	{
		if(($userName = $user_->getSBUserNameOrFalse()))
		{
			$this->replyOrFalse("Hola ".$userName."! Bienvenido a la app!");
		}
	}

	//Cuando un contacto se borre de la app..
	protected function onNewContactUnSubscription(SBUser $user_)
	{
		if(($userName = $user_->getSBUserNameOrFalse()))
		{
			error_log($userName." just unsubscribed");
		}
	}
	protected function onNewMessage(SBMessage $msg_)
	{
		if(($messageText = $msg_->getSBMessageTextOrFalse()))
		{
			$this->replyOrFalse("Aquí podrás consultar los test de la app!");
		}
	}
}
