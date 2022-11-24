<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require_once './includes/app_constants.php';
require_once './includes/helpers/helper_functions.php';

//--Step 1) Instantiate App.
$app = AppFactory::create();

//-- Step 2) Add middleware.
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

//-- Step 3) Base Path
$app->setBasePath("/game-api");

//-- Step 4) Include the files containing the definitions of the callbacks.
require_once './includes/routes/studio_routes.php';
require_once './includes/routes/user_routes.php';

//-- Step 5) define app routes
$app->get("/studios", "handleGetAllStudios");
$app->post("/studios", "handleCreateStudio");
$app->put("/studios", "handleUpdateStudio");

$app->get("/users", "handleGetAllUsers");
$app->post("/users", "handleCreateUser");

$app->get("/users/{user_id}", "handleGetUserById");
$app->delete("/users/{user_id}", "handleDeleteUser");
$app->put("/users/{user_id}", "handleUpdateUser");

$app->get("/users/{user_id}/gts", "handleGetGtsByUserId");
$app->post("/users/{user_id}/gts", "handleCreateGtsByUserId");
$app->get("/users/{user_id}/gts/{gts_id}", "handleGetGtsAndUserById");
$app->delete("/users/{user_id}/gts/{gts_id}", "handleDeleteGtsById");

$app->get("/users/{user_id}/requests", "handleGetRequestByUserId");
$app->post("/users/{user_id}/requests", "handleCreateRequestByUserId");
$app->get("/users/{user_id}/requests/{request_id}", "handleGetRequestAndUserById");
$app->delete("/users/{user_id}/requests/{request_id}", "handleDeleteRequestById");

$app->get("/users/{user_id}/reviews", "handleGetReviewByUserId");
$app->post("/users/{user_id}/reviews", "handleCreateReviewByUserId");
$app->get("/users/{user_id}/reviews/{review_id}", "handleGetReviewAndUserById");
$app->delete("/users/{user_id}/reviews/{review_id}", "handleDeleteReviewById");

$app->get("/studios/{studio_id}", "handleGetStudioById");
$app->delete("/studios/{studio_id}", "handleDeleteStudio");

$app->get("/studios/{studio_id}/games", "handleGetGamesByStudioId");

// Run the app.
$app->run();
