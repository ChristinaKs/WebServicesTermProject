<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
//var_dump($_SERVER["REQUEST_METHOD"]);
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/StudioModel.php';

// Callback for HTTP GET /studios
//-- Supported filtering operation: By developer
function handleGetAllStudios(Request $request, Response $response, array $args){
    $studios = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $studio_model = new StudioModel();

    // Retrieve the query string parameter from the request's URI.
    $filter_params = $request->getQueryParams();
    if(isset($filter_params['developer'])){
        $studios = $studio_model->getWhereLikeDeveloper($filter_params['developer']);
    } elseif (isset($filter_params['publisher'])){
        $studios = $studio_model->getWhereLikePublisher($filter_params['publisher']);
    } elseif (isset($filter_params['location'])){
        $studios = $studio_model->getWhereLikeLocation($filter_params['location']);
    } else { // No filtering dectected
        $studios = $studio_model->getAllStudios();
    }

    // Handle server-side content negotiation and produce the requested representation
    $requested_format = $request->getHeader('Accept');

    // Verify requested resource representation
    if($requested_format[0] === APP_MEDIA_TYPE_JSON){
        $response_data = json_encode($studios, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
    }
}