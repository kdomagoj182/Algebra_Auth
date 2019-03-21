<?php
ini_set('session.gc_maxlifetime',900); #ograničava vrijeme trajanja sesije - briše podatke
;
session_start();

# automatski uključuje klase, ne radi sa funkcijama pa se moraju posebno include-ati
spl_autoload_register(function($class){
	include_once 'classes/'.$class.'.php';
});

include_once 'functions/sanitize.php';
include_once 'functions/debug.php';
