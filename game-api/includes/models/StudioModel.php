<?php

class StudioModel extends BaseModel{
    private $table_name = "studios";

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
        $sql = "SELECT * FROM studios";
        $data = $this->rows($sql);
        return $data;
    }

    /**
     * Get a list of studios whose developers matches or contains the provided value
     * @param string $developer
     * @return array A list of studios containing the matches found
     */
    public function getWhereLikeDeveloper($developer){
        $sql = "SELECT * FROM studios WHERE developer LIKE :developer";
        $data = $this->run($sql, ["developer" => $developer . "%"])->fetchAll();
        return $data;
    }

    /**
     * Get a list of studios whose publishers matches or contains the provided value
     * @param string $publisher
     * @return array A list of studios containing the matches found
     */
    public function getWhereLikePublisher($publisher){
        $sql = "SELECT * FROM studios WHERE publisher LIKE :publisher";
        $data = $this->run($sql, ["publisher" => $publisher . "%"])->fetchAll();
        return $data;
    }

    /**
     * Get a list of studios whose locations matches or contains the provided value
     * @param string $location
     * @return array A list of studios containing the matches found
     */
    public function getWhereLikeLocation($location){
        $sql = "SELECT * FROM studios WHERE location LIKE :location";
        $data = $this->run($sql, ["location" => $location . "%"])->fetchAll();
        return $data;
    }
}