<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/StudioModel.php';
require_once __DIR__ . './../models/GameModel.php';

// Callback for HTTP GET /studios
//-- Supported filtering operation: By developer, by pubisher and by location
function handleGetAllStudios(Request $request, Response $response, array $args) {
    $studios = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $studio_model = new StudioModel();

    $input_page_number = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
    $input_per_page = filter_input(INPUT_GET, "per_page", FILTER_VALIDATE_INT);

    // Set default values if one of the following was invalid.
    $page_number = ($input_page_number > 0) ? $input_page_number : 1;
    $per_page = ($input_per_page > 0) ? $input_per_page : 3;

    $studio_model->setPaginationOptions($page_number, $per_page);

    // Retrieve the query string parameter from the request's URI.
    $filter_params = $request->getQueryParams();
    if (isset($filter_params['developer'])) {
        $studios = $studio_model->getWhereLikeDeveloper($filter_params['developer']);
    } elseif (isset($filter_params['publisher'])) {
        $studios = $studio_model->getWhereLikePublisher($filter_params['publisher']);
    } elseif (isset($filter_params['location'])) {
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
function handleGetStudioById(Request $request, Response $response, array $args) {
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

// Callback for HTTP post /studios
function handleCreateStudio(Request $request, Response $response, array $args) {
    $response_code = HTTP_OK;
    $studio_model = new StudioModel();

    $data = $request->getParsedBody();

    //-- Go over the elements stored in the $data array and verify that they are valid.
    $studio_id = "";
    $studio_developer = "";
    $studio_publisher = "";
    $studio_description = "";
    $studio_location = "";

    for ($i = 0; $i < count($data); $i++) {
        $single_studio = $data[$i];

        $studio_id = $single_studio["GameStudioId"];
        $studio_developer = $single_studio["Developer"];
        $studio_publisher = $single_studio["Publisher"];
        $studio_description = $single_studio["StudioDescription"];
        $studio_location = $single_studio["Location"];

        $new_studio = array(
            "GameStudioId" => $studio_id,
            "Developer" => $studio_developer,
            "Publisher" => $studio_publisher,
            "StudioDescription" => $studio_description,
            "Location" => $studio_location
        );

        $studio_model->createstudio($new_studio);
    }

    if (isset($response)) {
        $response_data = makeCustomJSONsuccess("studioAdded", "The specified studio was Successfully created.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else {
        $response_data = makeCustomJSONError("badRequest", "There was an error creating the studio.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

// Callback for HTTP put /studios
function handleUpdateStudio(Request $request, Response $response, array $args) {
    $response_code = HTTP_OK;
    $studio_model = new StudioModel();

    $data = $request->getParsedBody();

    //-- Go over the elements stored in the $data array and verify that they are valid.
    $studio_id = "";
    $studio_developer = "";
    $studio_publisher = "";
    $studio_description = "";
    $studio_location = "";

    for ($i = 0; $i < count($data); $i++) {
        $existing_studio = $data[$i];

        $studio_id = $existing_studio["GameStudioId"];
        $studio_developer = $existing_studio["Developer"];
        $studio_publisher = $existing_studio["Publisher"];
        $studio_description = $existing_studio["StudioDescription"];
        $studio_location = $existing_studio["Location"];

        $existing_studio = array(
            // "GameStudioId" => $studio_id,
            "Developer" => $studio_developer,
            "Publisher" => $studio_publisher,
            "StudioDescription" => $studio_description,
            "Location" => $studio_location
        );

        $studio_model->updateStudio($existing_studio, array("GameStudioId" => $studio_id));
        if (!$studio_model->getStudioById($studio_id)) {
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified studio.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

    if (isset($response)) {
        $response_data = makeCustomJSONsuccess("studioEdited", "The specified studio was successfully edited.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else {
        $response_data = makeCustomJSONError("badRequest", "There was an error editing the studio.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

// Callback for HTTP DELETE /studios/{studio_id}
function handleDeleteStudio(Request $request, Response $response, array $args) {
    $response_data = array();
    $response_code = HTTP_OK;
    $studio_model = new StudioModel();

    // Retreive the studio if from the request's URI.
    $studio_id = $args["studio_id"];
    if (isset($studio_id)) {
        if (!$studio_model->getStudioById($studio_id)) {
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified studio.");
            $response_code = HTTP_NOT_FOUND;
        } else {
            // Delete the specified studio.
            $studio_model->deleteStudio($studio_id);
            $response_data = makeCustomJSONsuccess("resourceDeleted", "The specified studio was deleted successfully.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_OK);
        }
    } else {
        // No atist id provided.
        $response_data = makeCustomJSONError("badRequest", "No studio id was provided.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

// Callback for HTTP GET /studios/{studio_id}/games
//-- Supported filtering parameters: GameName and GameId
function handleGetGamesByStudioId(Request $request, Response $response, array $args) {
    $games = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $game_model = new GameModel();

    // Retreive the studio if from the request's URI.
    $studio_id = $args["studio_id"];
	
    // Fetch the info about the specified games.
    $filter_params = $request->getQueryParams();

    $games = $game_model->getGamesFiltered($filter_params, $studio_id);
	
    if (!$games) { // No matches found?
        $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified studio.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_NOT_FOUND);
    }

    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');

    //-- We verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($games, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}
