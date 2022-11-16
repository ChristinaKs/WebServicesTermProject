<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
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
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($studios, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

// Callback for HTTP GET /studios/{studio_id}
function handleGetStudioById(Request $request, Response $response, array $args){
    $studio_info = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $studio_model = new StudioModel();

    // Retrieve the query string parameter from the request's URI.
    $studio_id = $args['studio_id'];
    if (isset($studio_id)) {
        // Fetch the info about the specified studio.
        $studio_info = $studio_model->getStudioById($studio_id);
        if (!$studio_info) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified studio.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');

    //-- Verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($studio_info, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}