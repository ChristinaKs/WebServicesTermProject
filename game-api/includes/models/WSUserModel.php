<?php

/**
 * A model for managing the Web service users.
 *
 * @author Sleiman Rabah
 */
class WSUserModel extends BaseModel {

    private $table_name = "ws_users";

    /**
     * A model class for the `ws_users` database table.
     * It exposes operations for creating and authenticating in users.
     */
    function __construct() {
        // Call the parent class and initialize the database connection settings.
        parent::__construct();
    }

    /**
     * Verifies the provided user's email address.
     * @param string $email the email address of the registered user.
     */
    public function verifyEmail($email) {
        $sql = "SELECT * FROM $this->table_name WHERE email= :email";
        return $this->run($sql, [":email" => $email])->fetchAll();
    }

    /**
     * Verifies the provided user password.
     * @param string $email the email address of the registered user. 
     * @param string $input_password the password  of the registered user.
     */
    public function verifyPassword($email, $input_password) {
        $sql = "SELECT * FROM $this->table_name WHERE email= :email";
        $row = $this->run($sql, [":email" => $email])->fetchAll();
        if ($row && is_array($row)) {
            if (password_verify($input_password, $row[0]['password'])) {
                return $row[0];
            }
        }
        return null;
    }

    /**
     * Creates a new user with the provide user info.
     * Requires a first_name, last_name, email and a password
     * @param array $new_user
     */
    public function createUser($new_user) {
        //-- 1) Add the value of the required created at (date and time) field.        
        $new_user["created_at"] = $this->getCurrentDateAndTime();
        //-- 2) We need to hash the password! 
        $new_user["password"] = $this->getHashedPassword($new_user["password"]);
        //var_dump($new_user);exit;
        return $this->insert($this->table_name, $new_user);
    }

    /**
     * Makes and returns a hashed password.
     * 
     * @param string $password_to_hash the user password that needs to be hashed
     * @return string the hashed password.
     */
    private function getHashedPassword($password_to_hash) {
        //@see: https://www.php.net/manual/en/function.password-hash.php
        $options = ['cost' => 15];
        $hash = password_hash($password_to_hash, PASSWORD_DEFAULT, $options);
        return $hash;
    }

    /**
     * Gets the current date and time give the provided time zone.
     * 
     * For more information about the supported time zones, 
     * @see: https://www.php.net/manual/en/timezones.america.php
     * 
     * @return string
     */
    private function getCurrentDateAndTime() {
        // By setting the time zone, we ensure that the produced time 
        // is accurate.
        $tz_object = new DateTimeZone('America/Toronto');
        $datetime = new DateTime();
        $datetime->setTimezone($tz_object);
        return $datetime->format('Y\-m\-d\ h:i:s');
    }

}
