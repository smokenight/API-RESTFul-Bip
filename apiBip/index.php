<?php
/* 
	Description: Core de API RestFUL para consulta de saldo de tarjeta Bip!
	Version: 1
	Author: Francisco Capone
	Author Mail: francisco.capone@gmail.com
	Author URI: http://www.franciscocapone.com
*/

@session_start();

require_once 'class/Utils.class.php';
require_once 'class/AbstractCURL.class.php';
require_once 'class/Bip.class.php';
require_once 'class/vendor/Slim/Slim.php';

\Slim\Slim::registerAutoloader();

$restBipApp = new \Slim\Slim();

$restBipApp->config(array(
	'templates.path' => 'vistas',
));

$restBipApp->get('/', function() use($restBipApp){
	$restBipApp->response->setStatus(200);
	echo "RestFUL BIP!";
});

$restBipApp->contentType('text/html; charset=utf-8');

$restBipApp->get('/getSaldo/:id', function ($id){
	$restBipApp = \Slim\Slim::getInstance();
	try{
		$resultadosSaldo = new Bip($id);
		if($resultadosSaldo){
			$restBipApp->response->setStatus(200);
			$restBipApp->response()->headers->set('Access-Control-Allow-Origin', '*');
			$restBipApp->response()->headers->set('Content-Type', 'application/json');
			print_r($resultadosSaldo->getData());
		}
	}
	catch(Exception  $e){
		$restBipApp->response()->setStatus(404);
		echo '{"error":{"text":'. $e->getMessage() .'}}';
	}
});

$restBipApp->run();