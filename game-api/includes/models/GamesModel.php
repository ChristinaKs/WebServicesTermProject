<?php

class GamesModel extends BaseModel{

    // private game = "game";

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
        $sql = "SELECT * FROM game";
        $data = $this->rows($sql);
        return $data;
    }

    /**
     * Get a single game by its ID
     * @param int $gameId
     * @return array of information related to the game
     */
    public function getGameById($gameId){
        $sql = "SELECT * FROM game WHERE GameId = ?";
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

    
    // /**
    //  * updates a game's boxart by its ID
    //  * @param int $gameId
    //  * @return array of information related to the game's boxart
    //  */
    // // public function updateGameOwnedBoxart($game){
    // //     $sql = "UPDATE game SET Boxart = ?, WHERE GameId = ?";
    // //     $data = $this->run($sql, [$game->Boxart, $game->GameId])->fetch();
    // //     return $data;
    // // }
    // public function updateGameOwnedBoxart($gameId, $boxart){
    //     $sql = "UPDATE game SET Boxart = ? WHERE GameId = ?";
    //     $data = $this->run($sql, [$boxart, $gameId])->fetch();
    //     return $data;
    // }

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
    public function createGame($data) {
        $data = $this->insert("game", $data);
        return $data;
    }

    /**
     * Updates a game in the database
     * @param object $game
     * @return array of information related to the game
     */
    public function updateGame($data, $where) {
        $data = $this->update("game", $data, $where);
        return $data;
    }

    public function deleteGame($gameId){
        $sql = "DELETE FROM game WHERE GameId = ?";
        $data = $this->run($sql, [$gameId]);
        return $data;
    }

    // public function createReview($review){
    //     $sql = "INSERT INTO review (GameId, PosOrNeg, RatingId, Review) VALUES (?, ?, ?, ?)";
    //     $data = $this->run($sql, [$gameId, $review->PosOrNeg, $review->RatingId, $review->Review]);
    //     return $data;
    // }
    // public function createReview($data) {
    //     $data = $this->insert("game", $data);
    //     return $data;
    // }

    public function updateReview($gameId, $reviewId, $review){
        $sql = "UPDATE review SET GameId = ?, PosOrNeg = ?, RatingId = ?, Review = ? WHERE ReviewId = ? AND GameId = ?";
        $data = $this->run($sql, [$review->PosOrNeg, $review->RatingId, $review->Review, $reviewId, $gameId]);
        return $data;
    }

    /**
     * Retrieve all games from the `game` table from a specified studio.
     * @return array A list of games. 
     */
    function getGamesByStudioId($studio_id) {
        $sql = "SELECT * FROM game WHERE GameStudioId = ?";
        $data = $this->run($sql, [$studio_id])->fetchAll();
        return $data;
    }
}