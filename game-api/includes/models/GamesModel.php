<?php

class GamesModel extends BaseModel{

    private $table_name = "game";

    /**
     * A model class for the 'studios' database table.
     * It exposes methods for CRUD operations.
     */
    
    public function __construct() {
        // Calk the parent class and initialize the database connection
       parent::__construct();
    }

    /**
     * Retrieve all games from the 'game' table.
     * @return array A list of games
     */
    public function getAllGames(){
        $sql = "SELECT * FROM $table_name";
        $data = $this->rows($sql);
        return $data;
    }

    /**
     * Get a single game by its ID
     * @param int $gameId
     * @return array of information related to the game
     */
    public function getGameById($gameId){
        $sql = "SELECT * FROM $table_name WHERE GameId = ?";
        $data = $this->run($sql, [$gameId])->fetch();
        return $data;
    }

    /**
     * Gets a game's boxart by its ID
     * @param int $gameId
     * @return array of information related to the game's boxart
     */
    public function getGameOwnedBoxart($gameId){
        $sql = "SELECT Boxart FROM game WHERE GameId = ?";
        $data = $this->run($sql, [$gameId])->fetch();
        return $data;
    }

    /**
     * Gets a game's reviews by its ID
     * @param int $gameId
     * @return array A list of reviews
     */
    public function getGameReviews($gameId){
        $sql = "SELECT * FROM review WHERE GameId = ?";
        $data = $this->run($sql, [$gameId])->fetchAll();
        return $data;
    }

    /**
     * Gets one of a game's review by its ID
     * @param int $gameId
     * @param int $reviewId
     * @return array of information related to a game's review
     */
    public function getGameReviewById($gameId, $reviewId){
        $sql = "SELECT * FROM review WHERE GameId = ? AND ReviewId = ?";
        $data = $this->run($sql, [$gameId, $reviewId])->fetch();
        return $data;
    }

    /**
     * Creates a game in the database
     * @param object $game
     * @return array of information related to the game
     */
    public function createGame($game){
        $sql = "INSERT INTO $table_name (Title, Description, ReleaseDate, Developer, Publisher, Genre, Platform, Boxart) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $data = $this->run($sql, [$game->Title, $game->Description, $game->ReleaseDate, $game->Developer, $game->Publisher, $game->Genre, $game->Platform, $game->Boxart]);
        return $data;
    }

    public function updateGame($game){
        $sql = "UPDATE $table_name SET Title = ?, Description = ?, ReleaseDate = ?, Developer = ?, Publisher = ?, Genre = ?, Platform = ?, Boxart = ? WHERE GameId = ?";
        $data = $this->run($sql, [$game->Title, $game->Description, $game->ReleaseDate, $game->Developer, $game->Publisher, $game->Genre, $game->Platform, $game->Boxart, $game->GameId]);
        return $data;
    }

    public function deleteGame($gameId){
        $sql = "DELETE FROM $table_name WHERE GameId = ?";
        $data = $this->run($sql, [$gameId]);
        return $data;
    }

    public function createReview($gameId, $review){
        $sql = "INSERT INTO review (GameId, Reviewer, Rating, Review) VALUES (?, ?, ?, ?)";
        $data = $this->run($sql, [$gameId, $review->Reviewer, $review->Rating, $review->Review]);
        return $data;
    }
}