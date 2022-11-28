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
require_once './includes/routes/games_routes.php';
require_once './includes/routes/studio_routes.php';
require_once './includes/routes/user_routes.php';
require_once './includes/routes/wishlist_routes.php';
require_once './includes/routes/properties_routes.php';


//-- Step 5) define app routes
// Studios routes
$app->get("/studios", "handleGetAllStudios");
$app->post("/studios", "handleCreateStudio");
$app->put("/studios", "handleUpdateStudio");

$app->get("/studios/{studio_id}", "handleGetStudioById");
$app->delete("/studios/{studio_id}", "handleDeleteStudio");

$app->get("/studios/{studio_id}/games", "handleGetGamesByStudioId");


// User routes
$app->get("/users", "handleGetAllUsers");
$app->post("/users", "handleCreateUser");

$app->get("/users/{user_id}", "handleGetUserById");
$app->delete("/users/{user_id}", "handleDeleteUser");
$app->put("/users/{user_id}", "handleUpdateUser");

$app->get("/users/{user_id}/gts", "handleGetGtsByUserId");


// properties routes
$app->get("/properties", "handleGetAllProperties");
$app->post("/properties", "handleCreateProperty");

$app->get("/properties/{owned_id}", "handleGetPropertiesById");
$app->delete("/properties/{owned_id}", "handleDeleteProperty");
$app->put("/properties/{owned_id}", "handleUpdateProperty");


// Wishlist routes
$app->get("/wishlists", "handleGetAllWishlistItems");
$app->post("/wishlists", "handleCreateWishlistItem");

$app->get("/wishlists/{wishlist_id}", "handleGetWishlistById");
$app->delete("/wishlists/{wishlist_id}", "handleDeleteWishlistItem");
$app->put("/wishlists/{wishlist_id}", "handleUpdateWishlist");


//game routes
$app->get("/games", "handleGetAllGames");
$app->post("/games", "handleCreateGame");

$app->get("/games/{game_id}", "handleGetGameById");
$app->delete("/games/{game_id}", "handleDeleteGame");
$app->put("/games/{game_id}", "handleUpdateGame");

$app->get("/games/{game_id}/boxart", "handleGetGameBoxartById");
// $app->put("/games/{game_id}/boxart", "handleUpdateGameBoxart"); // Does not work

$app->get("/games/{game_id}/reviews", "handleGetGameReviews");
// $app->post("/games/{game_id}/reviews", "handleCreateGameReview"); // Does not work

// $app->put("/games/{game_id}/reviews/{review_id}", "handleUpdateReview"); // Does not work
$app->get("/games/{game_id}/reviews/{review_id}", "handleGetGameReviewById");


// Run the app.
$app->run();
