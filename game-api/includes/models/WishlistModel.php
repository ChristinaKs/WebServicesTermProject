<?php

class WishlistModel extends BaseModel {

    private $table_name = "wishlistitem";

    function __construct() {
        parent::__construct();
    }

    public function getAllWishlistItems() {
        $sql = "SELECT * FROM wishlistitem";
        $data = $this->paginate($sql);
        return $data;
    }

    public function getWishlistItemById($wishlist_id) {
        $sql = "SELECT * FROM wishlistitem WHERE WishlistId = ?";
        $data = $this->run($sql, [$wishlist_id])->fetch();
        return $data;
    }
        /**
     * Create a new user.
     * @param string $name the name of the artist.
     */
    public function createWishlistItem($data) {
        $data = $this->insert("wishlistitem", $data);
        return $data;
    }

    /**
     * Update an existing user.
     * @param int $artist_id the id of the artist.
     * @param string $name the name of the artist.
     */
    public function updateWishlistItem($data, $name) {
        $data = $this->update("wishlistitem", $data, $name);
        return $data;
    }

    /**
     * Delete an user by its id.
     * @param int $user_id the id of the artist.
     * @return bool true if the user was deleted, false otherwise.
     */
    public function deleteWishlistItem($wishlist_id) {
        $sql = "DELETE FROM wishlistitem WHERE WishlistId = ?";
        $data = $this->run($sql, [$wishlist_id]);
        return $data;
    }
}