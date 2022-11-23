<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require_once __DIR__ . './../models/BaseModel.php';
require_once __DIR__ . './../models/UserModel.php';

// Get all users
function handleGetAllUsers(Request $request, Response $response, array $args) {
    $users = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $user_model = new UserModel();

    $users = $user_model->getAllUsers();
 
    $requested_format = $request->getHeader('Accept');
   
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($users, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}


// Callback for HTTP DELETE /user/{user_id}
function handleDeleteUser(Request $request, Response $response, array $args) {
    $response_data = array();
    $response_code = HTTP_OK;
    $user_model = new UserModel();

    $user_id = $args["user_id"];
    if (isset($user_id)) {

        $user_model->deleteUser($user_id);
        $response_data = makeCustomJSONsuccess("resourceDeleted", "The specified user was deleted Successfully.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else{
        $response_data = makeCustomJSONError("badRequest", "No user id was provided.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleGetUserById(Request $request, Response $response, array $args){
    $user_info = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $user_model = new UserModel();

    $user_id = $args['user_id'];
    if (isset($user_id)) {
        $user_info = $user_model->getUserById($user_id);
        if (!$user_info) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified user.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

    // Handle serve-side content negotiation and produce the requested representation.    
    $requested_format = $request->getHeader('Accept');

    //-- Verify the requested resource representation.    
    if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
        $response_data = json_encode($user_info, JSON_INVALID_UTF8_SUBSTITUTE);
    } else {
        $response_data = json_encode(getErrorUnsupportedFormat());
        $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleCreateUser(Request $request, Response $response, array $args) {
    $response_code = HTTP_OK;
    $user_model = new UserModel();

    $data = $request->getParsedBody();

    //-- Go over the elements stored in the $data array and verify that they are valid.
    $user_id = "";
    $user_email = "";
    $user_name = "";
    $user_pass = "";
    $user_fname = "";
    $user_lname = "";
    $user_cont = "";


    for ($i = 0; $i < count($data); $i++) {
        $single_user = $data[$i];

        $user_id = $single_user["UserId"];
        $user_email = $single_user["Email"];
        $user_name = $single_user["Username"];
        $user_pass = $single_user["Password"];
        $user_fname = $single_user["FirstName"];
        $user_lname = $single_user["LastName"];
        $user_cont = $single_user["ContactInfo"];

        $new_user = array(
            "UserId" => $user_id,
            "Email" => $user_email,
            "Username" => $user_name,
            "Password" => $user_pass,
            "FirstName" => $user_fname,
            "LastName" => $user_lname,
            "ContactInfo" => $user_cont
        );

        $user_model->createUser($new_user);
    }

    $response->getBody()->write($user_name);
    return $response;
}

function handleUpdateUser(Request $request, Response $response, array $args) {
    $response_code = HTTP_OK;
    $user_model = new UserModel();

    $data = $request->getParsedBody();

    //-- Go over the elements stored in the $data array and verify that they are valid.
    $user_id = "";
    $user_email = "";
    $user_name = "";
    $user_pass = "";
    $user_fname = "";
    $user_lname = "";
    $user_cont = "";

    for ($i = 0; $i < count($data); $i++) {
        $existing_user = $data[$i];

        $user_id = $existing_user["UserId"];
        $user_email = $existing_user["Email"];
        $user_name = $existing_user["Username"];
        $user_pass = $existing_user["Password"];
        $user_fname = $existing_user["FirstName"];
        $user_lname = $existing_user["LastName"];
        $user_cont = $existing_user["ContactInfo"];

        $existing_artist = array(
            "Username" => $user_name
        );

        $user_model->updateUser($existing_user, array("UserId" => $user_id));
    }

    $response->getBody()->write($user_name);
    return $response;
}

//GTS
function handleGetGtsByUserId(Request $request, Response $response, array $args){
    $user_gts_info = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $user_model = new UserModel();

    $user_id = $args['user_id'];
    if (isset($user_id)) {
        $user_gts_info = $user_model->getGtsByUserId($user_id);
        if (!$user_gts_info) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified gts item.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

        // Handle serve-side content negotiation and produce the requested representation.
        $requested_format = $request->getHeader('Accept');

        //-- Verify the requested resource representation.    
        if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
            $response_data = json_encode($user_gts_info, JSON_INVALID_UTF8_SUBSTITUTE);
        } else {
            $response_data = json_encode(getErrorUnsupportedFormat());
            $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
        }
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
}

function handleCreateGtsByUserId(Request $request, Response $response, array $args){
    $response_code = HTTP_OK;
    $user_model = new UserModel();

    $data = $request->getParsedBody();

    //-- Go over the elements stored in the $data array and verify that they are valid.
    $gts_id = "";
    $owned_id = "";
    $user_id = "";

    for ($i = 0; $i < count($data); $i++) {
        $single_gts = $data[$i];

        $gts_id = $single_gts["GtsId"];
        $owned_id = $single_gts["OwnedId"];
        $user_id = $single_gts["UserId"];

        $new_gts = array(
            "GtsId" => $gts_id,
            "OwnedId" => $owned_id,
            "UserId" => $user_id,
        );

        $user_model->createGtsByUserId($new_gts);
    }
    
    if (isset($response)) {
        $response_data = makeCustomJSONsuccess("gtsAdded", "The gts item was created successfully");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else {
        $response_data = makeCustomJSONError("badRequest", "There was an error creating the gts item.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

function handleGetGtsAndUserById(Request $request, Response $response, array $args){
    $user_gts_info = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $user_model = new UserModel();

    $user_id = $args['user_id'];
    $gts_id = $args['gts_id'];
    if (isset($user_id, $gts_id)) {
        $user_gts_info = $user_model->getGtsAndUserById($user_id, $gts_id);
        if (!$user_gts_info) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified gts item.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

        // Handle serve-side content negotiation and produce the requested representation.
        $requested_format = $request->getHeader('Accept');

        //-- Verify the requested resource representation.    
        if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
            $response_data = json_encode($user_gts_info, JSON_INVALID_UTF8_SUBSTITUTE);
        } else {
            $response_data = json_encode(getErrorUnsupportedFormat());
            $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
        }
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
}

function handleDeleteGtsAndUserById(Request $request, Response $response, array $args){
    $response_data = array();
    $response_code = HTTP_OK;
    $user_model = new UserModel();

    $user_id = $args["user_id"];
    $gts_id = $args['gts_id'];
    if (isset($user_id, $gts_id)) {

        $user_model->deleteGtsAndUserById($user_id, $gts_id);
        $response_data = makeCustomJSONsuccess("resourceDeleted", "The specified gts item was deleted successfully.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else{
        $response_data = makeCustomJSONError("badRequest", "No gts id or user id was provided.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}

//Request
function handleGetRequestByUserId(Request $request, Response $response, array $args){
    $user_gts_info = array();
    $response_data = array();
    $response_code = HTTP_OK;
    $user_model = new UserModel();

    $user_id = $args['user_id'];
    if (isset($user_id)) {
        $user_requests_info = $user_model->getRequestByUserId($user_id);
        if (!$user_requests_info) {
            // No matches found?
            $response_data = makeCustomJSONError("resourceNotFound", "No matching record was found for the specified user.");
            $response->getBody()->write($response_data);
            return $response->withStatus(HTTP_NOT_FOUND);
        }
    }

        // Handle serve-side content negotiation and produce the requested representation.
        $requested_format = $request->getHeader('Accept');

        //-- Verify the requested resource representation.    
        if ($requested_format[0] === APP_MEDIA_TYPE_JSON) {
            $response_data = json_encode($user_requests_info, JSON_INVALID_UTF8_SUBSTITUTE);
        } else {
            $response_data = json_encode(getErrorUnsupportedFormat());
            $response_code = HTTP_UNSUPPORTED_MEDIA_TYPE;
        }
        $response->getBody()->write($response_data);
        return $response->withStatus($response_code);
}

function handleCreateRequestByUserId(Request $request, Response $response, array $args){
    $response_code = HTTP_OK;
    $user_model = new UserModel();

    $data = $request->getParsedBody();

    //-- Go over the elements stored in the $data array and verify that they are valid.
    $request_id = "";
    $gts_id = "";
    $user_id = "";
    $accept_or_denied = "";

    for ($i = 0; $i < count($data); $i++) {
        $single_request = $data[$i];

        $request_id = $single_request["RequestId"];
        $gts_id = $single_request["GtsId"];
        $user_id = $single_request["UserId"];
        $accept_or_denied = $single_request["AcceptedOrDenied"];

        $new_request = array(
            "RequestId" => $request_id,
            "GtsId" => $gts_id,
            "UserId" => $user_id,
            "AcceptedOrDenied" => $accept_or_denied
        );

        $user_model->createRequestByUserId($new_request);
    }
    
    if (isset($response)) {
        $response_data = makeCustomJSONsuccess("requestAdded", "The request was created successfully");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_OK);
    } else {
        $response_data = makeCustomJSONError("badRequest", "There was an error creating the request.");
        $response->getBody()->write($response_data);
        return $response->withStatus(HTTP_BAD_REQUEST);
    }
    $response->getBody()->write($response_data);
    return $response->withStatus($response_code);
}