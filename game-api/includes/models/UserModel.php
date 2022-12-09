<?php

class UserModel extends BaseModel {

    private $table_name = "user";

    function __construct() {
        parent::__construct();
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM user";
        $data = $this->paginate($sql);
        return $data;
    }

    public function getUserById($user_id) {
        $sql = "SELECT * FROM user WHERE UserId = ?";
        $data = $this->run($sql, [$user_id])->fetch();
        return $data;
    }

        /**
     * Create a new user.
     * @param string $name the name of the artist.
     */
    public function createUser($data) {
        $data = $this->insert("user", $data);
        return $data;
    }

    /**
     * Update an existing user.
     * @param int $artist_id the id of the artist.
     * @param string $name the name of the artist.
     */
    public function updateUser($data, $name) {
        $data = $this->update("user", $data, $name);
        return $data;
    }

    /**
     * Delete an user by its id.
     * @param int $user_id the id of the artist.
     * @return bool true if the user was deleted, false otherwise.
     */
    public function deleteUser($user_id) {
        $sql = "DELETE FROM user WHERE UserId = ?";
        $data = $this->run($sql, [$user_id]);
        return $data;
    }

    //GTS
    public function createGtsByUserId($data) {
        $data = $this->insert("gtsitem", $data);
        return $data;
    }

    public function getGtsByUserId($user_id) {
        $sql = "SELECT * FROM gtsitem WHERE UserId = ?";
        $data = $this->run($sql, [$user_id])->fetchAll();
        return $data;
    }

    public function getGtsAndUserById($user_id, $gts_id) {
        $sql = "SELECT * FROM gtsitem WHERE UserId = ? AND GtsId = ?";
        $data = $this->run($sql, [$user_id, $gts_id])->fetch();
        return $data;
    }

    public function deleteGtsById($user_id, $gts_id) {
        $sql = "DELETE FROM gtsitem WHERE UserId = ? AND GtsId = ?";
        $data = $this->run($sql, [$user_id, $gts_id]);
        return $data;
    }

    //Requests
    public function getRequestByUserId($user_id) {
        $sql = "SELECT * FROM traderequest WHERE UserId = ?";
        $data = $this->run($sql, [$user_id])->fetchAll();
        return $data;
    }

    public function createRequestByUserId($data) {
        $data = $this->insert("traderequest", $data);
        return $data;
    }

    public function getRequestAndUserById($user_id, $request_id) {
        $sql = "SELECT * FROM traderequest WHERE UserId = ? AND RequestId = ?";
        $data = $this->run($sql, [$user_id, $request_id])->fetch();
        return $data;
    }

    public function deleteRequestById($user_id, $request_id) {
        $sql = "DELETE FROM traderequest WHERE UserId = ? AND RequestId = ?";
        $data = $this->run($sql, [$user_id, $request_id]);
        return $data;
    }

    //Reviews
    public function getReviewsByUserId($user_id) {
        $sql = "SELECT * FROM review WHERE UserId = ?";
        $data = $this->run($sql, [$user_id])->fetchAll();
        return $data;
    }

    public function createReviewByUserId($data) {
        $data = $this->insert("review", $data);
        return $data;
    }

    public function getReviewAndUserById($user_id, $review_id) {
        $sql = "SELECT * FROM review WHERE UserId = ? AND ReviewId = ?";
        $data = $this->run($sql, [$user_id, $review_id])->fetch();
        return $data;
    }

    public function deleteReviewById($user_id, $review_id) {
        $sql = "DELETE FROM review WHERE UserId = ? AND ReviewId = ?";
        $data = $this->run($sql, [$user_id, $review_id]);
        return $data;
    }

    // public function getWhereLikeDeveloper($developer){
    //     $sql = "SELECT * FROM gamestudio WHERE developer LIKE :developer";
    //     $data = $this->run($sql, ["developer" => $developer . "%"])->fetchAll();
    //     return $data;
    // }
}