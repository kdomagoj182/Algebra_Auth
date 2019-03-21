<?php 

function _e($string)  #funkcija za čišćenje ulaznog stringa
{
	return htmlentities($string, ENT_QUOTES, 'UTF-8');
}



