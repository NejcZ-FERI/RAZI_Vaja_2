<?php
/*
Vstopna točka za našo spletno storitev. Podobno kot pri MVC, bodo tudi vse zahteve na API šle skozi index.php,
ki bo poskrbel za njihovo obravnavo.
Index.php ima tako vlogo routerja, ki na podlagi HTTP zahteve sproži ustrezne akcije.
Za razliko od MVC, bo poleg URL-ja pomembna tudi HTTP metoda v zahtevi, saj REST predpisuje akcije, ki jih prožijo določene metode.

ENDPOINTI:
    api/ads/:id/
        PUT -> posodobi
        GET -> vrni oglas
        DELETE -> zbriši oglas

    api/ads
        POST -> dodaj nov oglas
	    GET-> vrni vse oglase

S pomočjo .htaccess preslikamo URL-je iz /api.php/foo/bar => /api/foo/bar (več v datoteki .htaccess)
*/

require_once "../admin/connection.php";
require_once "../admin/models/comments.php";
require_once "controllers/comments_controller.php";

session_start();

$comments_controller = new comments_controller;

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");

$method = $_SERVER['REQUEST_METHOD'];

if(isset($_SERVER['PATH_INFO']))
	$request = explode('/', trim($_SERVER['PATH_INFO'],'/'));
else
	$request="";

if(!isset($request[0]) || $request[0] != "comments"){
    echo json_encode((object)["status"=>"404", "message"=>"Not found"]);
    die();
}

switch($method){
    case "GET":
        if(!isset($request[1])) {
            $comments_controller->returnLastFive();
		} else {
            $comments_controller->index($request[1]);
        }
        break;
    case "POST":
		if(!isset($_SESSION["USER_ID"])) {
			echo json_encode((object)["status"=>"500", "message"=>"Invalid parameters"]);
			die();
		}

		$comments_controller->add();
        break;
    //case "PUT":
    case "DELETE":
        if(!isset($request[1]) || !isset($request[2])) {
            echo json_encode((object)["status"=>"500", "message"=>"Invalid parameters"]);
            die();
        }

		$comments_controller->delete($request[1], $request[2]);
        break;
    default: 
        break;
}


