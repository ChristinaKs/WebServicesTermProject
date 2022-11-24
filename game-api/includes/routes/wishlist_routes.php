<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/WishlistModel.php';

// Get all properties
function handleGetAllWishlistItems(Request $request, Response $response, array $args) {
    $wishlist_items = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $wishlist_model = new WishlistModel();

    $wishlist_items = $wishlist_model->getAllWishlistItems();
 
    $requested_format = $request->getHeader('Accept');
   
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($wishlist_items, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}


// Callback for HTTP DELETE /user/{user_id}
function handleDeleteWishlistItem(Request $request, Response $response, array $args) {
    $response_data = array();
    $response_code = HTTP_OK;
    $wishlist_model = new WishlistModel();

    $wishlist_id = $args["wishlist_id"];
    if (isset($wishlist_id)) {

        $wishlist_model->deleteWishlistItem($wishlist_id);
        $response_data = makeCustomJSONsuccess("wishlistDeleted", "The specified wishlist item was deleted Successfully.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else{
        $response_data = makeCustomJSONError("badRequest", "No wishlist id was provided.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleGetWishlistById(Request $request, Response $response, array $args){
    $wishlist_info = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $wishlist_model = new WishlistModel();

    $wishlist_id = $args['wishlist_id'];
    if (isset($wishlist_id)) {
        $wishlist_info = $wishlist_model->getWishlistItemById($wishlist_id);
        if (!$wishlist_info) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified wishlist item.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');

    //-- Verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($wishlist_info, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleCreateWishlistItem(Request $request, Response $response, array $args) {
    $response_code = HTTP_OK;
    $wishlist_model = new WishlistModel();

    $data = $request->getParsedBody();

    //-- Go over the elements stored in the $data array and verify that they are valid.
    $wishlist_id = "";
    $user_id = "";
    $game_id = "";
  


    for ($i = 0; $i < count($data); $i++) {
        $single_property = $data[$i];

        $wishlist_id = $single_property["WishlistId"];
        $user_id = $single_property["UserId"];
        $game_id = $single_property["GameId"];
       

        $new_wishlist_item = array(

            "WishlistId" => $wishlist_id,
            "UserId" => $user_id,
            "GameId" => $game_id,
        );

        $wishlist_model->createWishlistItem($new_wishlist_item);
    }
    if (isset($response)) {
        $response_data = makeCustomJSONsuccess("wishlistAdded", "The specified wishlist was Successfully created.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else {
        $response_data = makeCustomJSONError("badRequest", "There was an error creating the wishlist.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleUpdateWishlist(Request $request, Response $response, array $args) {
    $response_code = HTTP_OK;
    $wishlist_model = new WishlistModel();

    $data = $request->getParsedBody();

    //-- Go over the elements stored in the $data array and verify that they are valid.
    $wishlist_id = "";
    $user_id = "";
    $game_id = "";
    

    for ($i = 0; $i < count($data); $i++) {
        $existing_wishlist_item = $data[$i];

        $wishlist_id = $existing_wishlist_item["WishlistId"];
        $user_id = $existing_wishlist_item["UserId"];
        $game_id = $existing_wishlist_item["GameId"];
       
        $existing_wishlist_item = array(
            "UserId" => $user_id,
            "GameId" => $game_id
        );

        $wishlist_model->updateWishlistItem($existing_wishlist_item, array("WishlistId" => $wishlist_id));
    }
    if (isset($response)) {
        $response_data = makeCustomJSONsuccess("wishlistEdited", "The specified wishlist was successfully edited.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else {
        $response_data = makeCustomJSONError("badRequest", "There was an error editing the wishlist.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}