<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/GamesModel.php';
require_once __DIR__ . './../models/WSLoggingModel.php';

function handleGetAllGames(Request $request, Response $response, array $args) {
    $games = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $games_model = new GamesModel();

    $input_page_number = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
    $input_per_page = filter_input(INPUT_GET, "per_page", FILTER_VALIDATE_INT);

    // Set default values if one of the following was invalid.
    $page_number = ($input_page_number > 0) ? $input_page_number : 1;
    $per_page = ($input_per_page > 0) ? $input_per_page : 3;

    $games_model->setPaginationOptions($page_number, $per_page);

    $games = $games_model->getAllGames();
 
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
    $games_model = new GamesModel();

    $data = $request->getParsedBody();

    //(GameName, GameProductCode, Boxart, GameDescription, MPAARating, Platform, GameStudioId)
    $GameName = "";
    $GameProductCode = "";
    $Boxart = "";
    $GameDescription = "";
    $MPAARating = "";
    $Platform = "";
    $GameStudioId = "";

    for ($i = 0; $i < count($data); $i++) {
        $single_game = $data[$i];

        $GameName = $single_game['GameName'];
        $GameProductCode = $single_game['GameProductCode'];
        $Boxart = $single_game['Boxart'];
        $GameDescription = $single_game['GameDescription'];
        $MPAARating = $single_game['MPAARating'];
        $Platform = $single_game['Platform'];
        $GameStudioId = $single_game['GameStudioId'];

        $new_game = array(
            "GameName" => $GameName,
            "GameProductCode" => $GameProductCode,
            "Boxart" => $Boxart,
            "GameDescription" => $GameDescription,
            "MPAARating" => $MPAARating,
            "Platform" => $Platform,
            "GameStudioId" => $GameStudioId
        );

        $games_model->createGame($new_game);
    }

    if (isset($response)) {
        $response_data = makeCustomJSONsuccess("gameAdded", "The specified game was successfully created.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else {
        $response_data = makeCustomJSONError("badRequest", "There was an error creating the game.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleUpdateGame(Request $request, Response $response, array $args)
{
    $response_code = HTTP_OK;
    $games_model = new GamesModel();

    $data = $request->getParsedBody();

    $GameId = "";
    $GameName = "";
    $GameProductCode = "";
    $Boxart = "";
    $GameDescription = "";
    $MPAARating = "";
    $Platform = "";
    $GameStudioId = "";

    for ($i = 0; $i < count($data); $i++) {
        $single_game = $data[$i];

        $GameId = $single_game['GameId'];
        $GameName = $single_game['GameName'];
        $GameProductCode = $single_game['GameProductCode'];
        $Boxart = $single_game['Boxart'];
        $GameDescription = $single_game['GameDescription'];
        $MPAARating = $single_game['MPAARating'];
        $Platform = $single_game['Platform'];
        $GameStudioId = $single_game['GameStudioId'];

        $game = array(
            // "GameId" => $GameId,
            "GameName" => $GameName,
            "GameProductCode" => $GameProductCode,
            "Boxart" => $Boxart,
            "GameDescription" => $GameDescription,
            "MPAARating" => $MPAARating,
            "Platform" => $Platform,
            "GameStudioId" => $GameStudioId
        );

        $games_model->updateGame($game, array("GameId" => $GameId));
        if(!$games_model->getGameById($GameId)) {
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified game.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

    if (isset($response)) {
        $response_data = makeCustomJSONsuccess("gameEdited", "The specified game was successfully edited.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else {
        $response_data = makeCustomJSONError("badRequest", "There was an error editing the game.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleDeleteGame(Request $request, Response $response, array $args) {
    $response_data = array();
    $response_code = HTTP_OK;
    $games_model = new GamesModel();

    $game_id = $args["game_id"];
    
    if (isset($game_id)) {
        if(!$games_model->getGameById($game_id)) {
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified game.");
            $response_code = HTTP_NOT_FOUND;
        } else {
            $games_model->deleteGame($game_id);
            $response_data = makeCustomJSONsuccess("resourceDeleted", "The specified game was deleted Successfully.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_OK);
        }
    } else {
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
    $games_model = new GamesModel();

    $game_id = $args['game_id'];
    if (isset($game_id)) {
        $game_info = $games_model->getGameById($game_id);
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
    $games_model = new GamesModel();

    $game_id = $args['game_id'];
    if (isset($game_id)) {
        $reviews = $games_model->getGameReviews($game_id);
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
    $games_model = new GamesModel();
    
    $game_id = $args['game_id'];
    $review_id = $args['review_id'];
    if (isset($game_id) && isset($review_id)) {
        $review = $games_model->getGameReviewById($game_id, $review_id);
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

// function handleCreateGameReview(Request $request, Response $response, array $args){
//     $response_code = HTTP_OK;
//     $games_model = new GamesModel();

//     $data = $request->getParsedBody();

//     //(GameId, PosOrNeg, RatingId, Review)
//     $ReviewId = "";
//     $RatingId = "";
//     $PosOrNeg = "";
//     $Review = "";
//     $GameId = "";

//     for ($i = 0; $i < count($data); $i++) {
//         $single_rev = $data[$i];

//         $GameId = $single_rev['GameId'];

//         $ReviewId = $single_rev['ReviewId'];
//         $PosOrNeg = $single_rev['PosOrNeg'];
//         $RatingId = $single_rev['RatingId'];
//         $Review = $single_rev['Review'];

//         $new_rev = array(
//             "ReviewId" => $ReviewId,
//             "PosOrNeg" => $PosOrNeg,
//             "RatingId" => $RatingId,
//             "Review" => $Review,
//             "GameId" => $GameId,
//         );

//         $games_model->createReview($new_rev);
//     }

//     $response->getBody()->write($GameId);
//     return $response;
// }

// function handleUpdateGameReview(Request $request, Response $response, array $args){
//     $response_code = HTTP_OK;
//     $games_model = new GamesModel();

//     $data = $request->getParsedBody();

//     //(GameId, PosOrNeg, RatingId, Review)
//     $GameId = "";
//     $PosOrNeg = "";
//     $RatingId = "";
//     $Review = "";

//     for ($i = 0; $i < count($data); $i++) {
//         $single_rev = $data[$i];

//         $ReviewId = $single_rev['ReviewId'];
//         $GameId = $single_rev['GameId'];
//         $PosOrNeg = $single_rev['PosOrNeg'];
//         $RatingId = $single_rev['RatingId'];
//         $Review = $single_rev['Review'];

//         $new_rev = array(
//             "PosOrNeg" => $PosOrNeg,
//             "RatingId" => $RatingId,
//             "Review" => $Review,
//         );

//         $games_model->updateReview($GameId, $ReviewId, $new_rev);
//     }

//     $response->getBody()->write($GameId);
//     return $response;
// }


function handleGetGameBoxartById(Request $request, Response $response, array $args){
    $game_box = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $games_model = new GamesModel();

    $game_id = $args['game_id'];
    if (isset($game_id)) {
        $game_box = $games_model->getGameOwnedBoxart($game_id);
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
?>