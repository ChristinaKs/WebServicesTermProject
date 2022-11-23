<?php

class StudioModel extends BaseModel{

    private $table_name = "gamestudio";

    /**
     * A model class for the 'studios' database table.
     * It exposes methods for CRUD operations.
     */
    
    public function __construct() {
        // Calk the parent class and initialize the database connection
       parent::__construct();
    }

    /**
     * Retrieve all studios from the 'studios' table.
     * @return array A list of studios
     */
    public function getAllStudios(){
        $sql = "SELECT * FROM gamestudio";
        $data = $this->rows($sql);
        return $data;
    }

    /**
     * Get a list of studios whose developers matches or contains the provided value
     * @param string $developer
     * @return array A list of studios containing the matches found
     */
    public function getWhereLikeDeveloper($developer){
        $sql = "SELECT * FROM gamestudio WHERE developer LIKE :developer";
        $data = $this->run($sql, ["developer" => $developer . "%"])->fetchAll();
        return $data;
    }

    /**
     * Get a list of studios whose publishers matches or contains the provided value
     * @param string $publisher
     * @return array A list of studios containing the matches found
     */
    public function getWhereLikePublisher($publisher){
        $sql = "SELECT * FROM gamestudio WHERE publisher LIKE :publisher";
        $data = $this->run($sql, ["publisher" => $publisher . "%"])->fetchAll();
        return $data;
    }

    /**
     * Get a list of studios whose locations matches or contains the provided value
     * @param string $location
     * @return array A list of studios containing the matches found
     */
    public function getWhereLikeLocation($location){
        $sql = "SELECT * FROM gamestudio WHERE location LIKE :location";
        $data = $this->run($sql, ["location" => $location . "%"])->fetchAll();
        return $data;
    }

    /**
     * Get a single studio by its ID
     * @param int $studio_id
     * @return array of information related to the studio
     */
    public function getStudioById($studio_id){
        $sql = "SELECT * FROM gamestudio WHERE GameStudioId = ?";
        $data = $this->run($sql, [$studio_id])->fetch();
        return $data;
    }

    /**
     * Add a new studio to the database
     * @param string $data
     */
    public function createStudio($data) {
        $data = $this->insert("gamestudio", $data);
        return $data;
    }

    /**
     * Edit a studio in the database
     * @param string $data
     */
    public function updateStudio($data, $where) {
        $data = $this->update("gamestudio", $data, $where);
        return $data;
    }

    /**
     * Delete a studio from the database
     * @param int $studio_id
     * @return boolean if the studio was deleted
     */
    public function deleteStudio($studio_id) {
        $sql = "DELETE FROM gamestudio WHERE GameStudioId = ?";
        $data = $this->run($sql, [$studio_id]);
        return $data;
    }
}