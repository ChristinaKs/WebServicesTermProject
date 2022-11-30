<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/PropertiesModel.php';

// Get all properties
function handleGetAllProperties(Request $request, Response $response, array $args) {
    $properties = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $prop_model = new PropertiesModel();

    $input_page_number = filter_input(INPUT_GET, "page", FILTER_VALIDATE_INT);
    $input_per_page = filter_input(INPUT_GET, "per_page", FILTER_VALIDATE_INT);

    // Set default values if one of the following was invalid.
    $page_number = ($input_page_number > 0) ? $input_page_number : 1;
    $per_page = ($input_per_page > 0) ? $input_per_page : 3;

    $prop_model->setPaginationOptions($page_number, $per_page);

    $properties = $prop_model->getAllProperties();
 
    $requested_format = $request->getHeader('Accept');
   
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($properties, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}


// Callback for HTTP DELETE /user/{user_id}
function handleDeleteProperty(Request $request, Response $response, array $args) {
    $response_data = array();
    $response_code = HTTP_OK;
    $prop_model = new PropertiesModel();

    $property_id = $args["owned_id"];
    if (isset($property_id)) {
        if(!$prop_model->getPropertiesById($property_id)) {
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified property.");
            $response_code = HTTP_NOT_FOUND;
        } else {
            $prop_model->deleteProperty($property_id);
            $response_data = makeCustomJSONsuccess("propertyDeleted", "The specified property was deleted Successfully.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_OK);
        }
    } else{
        $response_data = makeCustomJSONError("badRequest", "No property id was provided.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleGetPropertiesById(Request $request, Response $response, array $args){
    $property_info = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $prop_model = new PropertiesModel();

    $property_id = $args['owned_id'];
    if (isset($property_id)) {
        $property_info = $prop_model->getPropertiesById($property_id);
        if (!$property_info) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified property.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');

    //-- Verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($property_info, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleCreateProperty(Request $request, Response $response, array $args) {
    $response_code = HTTP_OK;
    $prop_model = new PropertiesModel();

    $data = $request->getParsedBody();

    //-- Go over the elements stored in the $data array and verify that they are valid.
    $owned_id = "";
    $is_for_trade = "";
    $trade_link = "";
    $review_id = "";
    $game_id = "";
    $user_id = "";


    for ($i = 0; $i < count($data); $i++) {
        $single_property = $data[$i];

        $owned_id = $single_property["OwnedId"];
        $is_for_trade = $single_property["isForTrade"];
        $trade_link = $single_property["TradeLink"];
        $review_id = $single_property["ReviewId"];
        $game_id = $single_property["GameId"];
        $user_id = $single_property["UserId"];


        $new_property = array(

            "OwnedId" => $owned_id,
            "isForTrade" => $is_for_trade,
            "TradeLink" => $trade_link,
            "ReviewId" => $review_id,
            "GameId" => $game_id,
            "UserId" => $user_id
        );

        $prop_model->createProperty($new_property);
    }
    if (isset($response)) {
        $response_data = makeCustomJSONsuccess("propertyAdded", "The specified property was Successfully created.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else {
        $response_data = makeCustomJSONError("badRequest", "There was an error creating the property.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}


function handleUpdateProperty(Request $request, Response $response, array $args) {
    $prop_model = new PropertiesModel();
    $data = $request->getParsedBody();

    //-- Go over the elements stored in the $data array and verify that they are valid.
    $owned_id = "";
    $is_for_trade = "";
    $trade_link = "";
    $review_id = "";
    $game_id = "";
    $user_id = "";

    for ($i = 0; $i < count($data); $i++) {
        $existing_property = $data[$i];

        $owned_id = $existing_property["OwnedId"];
        $is_for_trade = $existing_property["isForTrade"];
        $trade_link = $existing_property["TradeLink"];
        $review_id = $existing_property["ReviewId"];
        $game_id = $existing_property["GameId"];
        $user_id = $existing_property["UserId"];

        $existing_property = array(
            "isForTrade" => $is_for_trade,
            "TradeLink" => $trade_link,
            "ReviewId" => $review_id,
            "GameId" => $game_id,
            "UserId" => $user_id

        );

        $prop_model->updateProperty($existing_property, array("OwnedId" => $owned_id));
        if(!$prop_model->getPropertiesById($owned_id)) {
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified property.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

    if (isset($response)) {
        $response_data = makeCustomJSONsuccess("propertyEdited", "The specified Property was successfully edited.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else {
        $response_data = makeCustomJSONError("badRequest", "There was an error editing the Properties.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}
