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

    /**
     * Filter a game from a studio by a game name
     * @param string $GameName
     */
    public function getWhereLikeGameName($GameName) {
        //echo "$GameName";exit;
        $sql = "SELECT * FROM game WHERE GameName LIKE :GameName";
        // $sql = "SELECT * FROM game WHERE GameName = ?";
        $data = $this->run($sql, ["GameName" => $GameName . "%"])->fetchAll();
        // $data = $this->run($sql, [ $GameName])->fetchAll();
        return $data;
    }

    /**
     * Retrieve all games from the `game` table from a specified studio.
     * 
     * If filtering options was specified, the list of matching games will 
     * be returned. 
     * @return array A list of games. 
     */
    public function getGamesFiltered($filters_params, $studio_id) {
        $whereValues = Array();

        //-- First, we add to the WHERE clause the ID of the studio
        // for which we are fetching the list of games 
        $sql = "SELECT * FROM game WHERE GameStudioId =:GameStudioId ";
        $whereValues["GameStudioId"] = $studio_id;

        //-- Has the GameName filter been specified in the request's 
        // query string param along with a value? 
        if (isset($filters_params['GameName'])) {
            $sql .= " AND GameName LIKE :GameName ";
            $whereValues["GameName"] = $filters_params['GameName'] . "%";
        }
        if (isset($filters_params['GameId'])) {
            $sql .= " AND GameId LIKE :GameId ";
            //$sql .= " OR GameId LIKE :GameId ";
            $whereValues["GameId"] = $filters_params['GameId'] . "%";
        }
        //echo "$sql";exit;
        $data = $this->run($sql, $whereValues)->fetchAll();
        return $data;
    }

    /**
     * Filter a game from a studio by a game id
     * @param int $GameId
     */
    public function getWhereLikeGameId($GameId) {
        $sql = "SELECT * FROM game WHERE GameId LIKE :GameId";
        $data = $this->run($sql, ["GameId" => $GameId . "%"])->fetchAll();
        return $data;
    }

}
