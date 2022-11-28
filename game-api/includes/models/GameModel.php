<?php

class GameModel extends BaseModel {
    private $table_name = "game";

    /**
     * A model class for the `game` database table.
     * It exposes operations that can be performed on games records.
     */
    function __construct() {
        // Call the parent class and initialize the database connection settings.
        parent::__construct();
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