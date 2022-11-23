<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/GamesModel.php';

function handleGetAllGames(Request $request, Response $response, array $args) {
    $games = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $game_model = new GamesModel();

    $games = $game_model->getAllGames();
 
    $requested_format = $request->getHeader('Accept');
   
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($games, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleCreateGame(Request $request, Response $response, array $args)
{
    $response_code = HTTP_OK;
    $game_model = new GamesModel();

    $data = $request->getParsedBody();

    //(GameName, GameProductCode, Boxart, GameDescrption, MPAARating, Platform, GameStudioId)
    $GameName = "";
    $GameProductCode = "";
    $Boxart = "";
    $GameDescrption = "";
    $MPAARating = "";
    $Platform = "";
    $GameStudioId = "";

    for ($i = 0; $i < count($data); $i++) {
        $single_game = $data[$i];

        $GameName = $single_game['GameName'];
        $GameProductCode = $single_game['GameProductCode'];
        $Boxart = $single_game['Boxart'];
        $GameDescrption = $single_game['GameDescrption'];
        $MPAARating = $single_game['MPAARating'];
        $Platform = $single_game['Platform'];
        $GameStudioId = $single_game['GameStudioId'];

        $new_game = array(
            "GameName" => $GameName,
            "GameProductCode" => $GameProductCode,
            "Boxart" => $Boxart,
            "GameDescrption" => $GameDescrption,
            "MPAARating" => $MPAARating,
            "Platform" => $Platform,
            "GameStudioId" => $GameStudioId
        );

        $game_model->createGame($new_game);
    }

    $response->getBody()->write($GameName);
    return $response;
}

function handleUpdateGame(Request $request, Response $response, array $args)
{
    $response_code = HTTP_OK;
    $game_model = new GamesModel();

    $data = $request->getParsedBody();

    $GameId = "";
    $GameName = "";
    $GameProductCode = "";
    $Boxart = "";
    $GameDescrption = "";
    $MPAARating = "";
    $Platform = "";
    $GameStudioId = "";

    for ($i = 0; $i < count($data); $i++) {
        $single_game = $data[$i];

        $GameId = $single_game['GameId'];
        $GameName = $single_game['GameName'];
        $GameProductCode = $single_game['GameProductCode'];
        $Boxart = $single_game['Boxart'];
        $GameDescrption = $single_game['GameDescrption'];
        $MPAARating = $single_game['MPAARating'];
        $Platform = $single_game['Platform'];
        $GameStudioId = $single_game['GameStudioId'];

        $game = array(
            "GameId" => $GameId,
            "GameName" => $GameName,
            "GameProductCode" => $GameProductCode,
            "Boxart" => $Boxart,
            "GameDescrption" => $GameDescrption,
            "MPAARating" => $MPAARating,
            "Platform" => $Platform,
            "GameStudioId" => $GameStudioId
        );

        $game_model->updateGame($game);
    }

    $response->getBody()->write($GameName);
    return $response;
}

function handleDeleteGame(Request $request, Response $response, array $args) {
    $response_data = array();
    $response_code = HTTP_OK;
    $game_model = new GamesModel();

    $game_id = $args["game_id"];
    if (isset($game_id)) {
        $game_model->deleteGame($game_id);
        $response_data = makeCustomJSONsuccess("resourceDeleted", "The specified game was deleted Successfully.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else{
        $response_data = makeCustomJSONError("badRequest", "No game id was provided.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleGetGameById(Request $request, Response $response, array $args){
    $game_info = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $game_model = new GamesModel();

    $game_id = $args['game_id'];
    if (isset($game_id)) {
        $game_info = $game_model->getGameById($game_id);
        if (!$game_info) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified game.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');

    //-- Verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($game_info, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}


function handleGetGameReviews(Request $request, Response $response, array $args){
    $reviews = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $game_model = new GamesModel();

    $game_id = $args['game_id'];
    if (isset($game_id)) {
        $reviews = $game_model->getGameReviews($game_id);
        if (!$reviews) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified game.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');

    //-- Verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($reviews, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleGetGameReviewById(Request $request, Response $response, array $args){
    $review = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $game_model = new GamesModel();
    
    $game_id = $args['game_id'];
    $review_id = $args['review_id'];
    if (isset($game_id) && isset($review_id)) {
        $review = $game_model->getGameReviewById($game_id, $review_id);
        if (!$review) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified game.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }
    
    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');
    
    //-- Verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($review, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleCreateGameReview(Request $request, Response $response, array $args){
    //TODO
}

function handleUpdateGameReview(Request $request, Response $response, array $args){
    //TODO
}


function handleGetGameBoxartById(Request $request, Response $response, array $args){
    $game_box = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $game_model = new GamesModel();

    $game_id = $args['game_id'];
    if (isset($game_id)) {
        $game_box = $game_model->getGameOwnedBoxart($game_id);
        if (!$game_box) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified game.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');

    //-- Verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($game_box, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleUpdateGameBoxart(Request $request, Response $response, array $args)
{
    $response_code = HTTP_OK;
    $game_model = new GamesModel();

    $data = $request->getParsedBody();

    $GameId = "";
    $Boxart = "";

    for ($i = 0; $i < count($data); $i++) {
        $single_game = $data[$i];

        $GameId = $single_game['GameId'];
        $Boxart = $single_game['Boxart'];

        $game = array(
            "GameId" => $GameId,
            "Boxart" => $Boxart,
        );

        $game_model->updateGameOwnedBoxart($game);
    }

    $response->getBody()->write($GameId);
    return $response;
}
?>