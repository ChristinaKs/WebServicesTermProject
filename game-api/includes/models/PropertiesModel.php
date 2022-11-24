<?php

class PropertiesModel extends BaseModel {

    private $table_name = "owneditem";

    function __construct() {
        parent::__construct();
    }

    public function getAllProperties() {
        $sql = "SELECT * FROM owneditem";
        $data = $this->rows($sql);
        return $data;
    }

    public function getPropertiesById($property_id) {
        $sql = "SELECT * FROM owneditem WHERE OwnedId = ?";
        $data = $this->run($sql, [$property_id])->fetch();
        return $data;
    }
        /**
     * Create a new user.
     * @param string $name the name of the artist.
     */
    public function createProperty($data) {
        $data = $this->insert("owneditem", $data);
        return $data;
    }

    /**
     * Update an existing user.
     * @param int $artist_id the id of the artist.
     * @param string $name the name of the artist.
     */
    public function updateProperty($data, $name) {
        $data = $this->update("owneditem", $data, $name);
        return $data;
    }

    /**
     * Delete an user by its id.
     * @param int $user_id the id of the artist.
     * @return bool true if the user was deleted, false otherwise.
     */
    public function deleteProperty($property_id) {
        $sql = "DELETE FROM owneditem WHERE OwnedId = ?";
        $data = $this->run($sql, [$property_id]);
        return $data;
    }
}