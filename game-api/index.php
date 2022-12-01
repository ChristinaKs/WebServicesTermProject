<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require_once './includes/app_constants.php';
require_once './includes/helpers/Paginator.php';
require_once './includes/helpers/helper_functions.php';
require_once './includes/helpers/JWTManager.php';

//--Step 1) Instantiate App.
$app = AppFactory::create();

//-- Step 2) Add middleware.
$app->addRoutingMiddleware();
$app->addBodyParsingMiddleware();
$errorMiddleware = $app->addErrorMiddleware(true, true, true);

//-- Step 3) Base Path
$app->setBasePath("/game-api");


$jwt_secret = JWTManager::getSecretKey();
$api_base_path = "/game-api";
$app->add(new Tuupola\Middleware\JwtAuthentication([
            'secret' => $jwt_secret,
            'algorithm' => 'HS256',
            'secure' => false, // only for localhost for prod and test env set true            
            "path" => $api_base_path, // the base path of the API
            "attribute" => "decoded_token_data",
            "ignore" => ["$api_base_path/token", "$api_base_path/account"], // makes only certain files private
            "error" => function ($response, $arguments) {
                $data["status"] = "error";
                $data["message"] = $arguments["message"];
                $response->getBody()->write(
                        json_encode($data, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT)
                );
                return $response->withHeader("Content-Type", "application/json;charset=utf-8");
            }
        ]));


//-- Step 4) Include the files containing the definitions of the callbacks.
require_once './includes/routes/token_routes.php';
require_once './includes/routes/games_routes.php';
require_once './includes/routes/studio_routes.php';
require_once './includes/routes/user_routes.php';
require_once './includes/routes/wishlist_routes.php';
require_once './includes/routes/properties_routes.php';

//-- Step 5) define app routes
$app->post("/token", "handleGetToken");
$app->post("/account", "handleCreateUserAccount");


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

$app->get("/games/{game_id}/reviews", "handleGetGameReviews");
// $app->post("/games/{game_id}/reviews", "handleCreateGameReview"); // Does not work

// $app->put("/games/{game_id}/reviews/{review_id}", "handleUpdateReview"); // Does not work
$app->get("/games/{game_id}/reviews/{review_id}", "handleGetGameReviewById");


// Run the app.
$app->run();
