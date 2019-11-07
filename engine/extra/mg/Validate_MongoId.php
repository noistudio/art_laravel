<?php

namespace mg;

use MongoId;

class Validate_MongoId {

    private $id;

    /**
     * Initiate the class giving an expected MongoId.
     *
     * @param string $id
     */
    public function __construct($id) {
        $this->id = $id;
    }

    /**
     * Validate the given ID from the __construct
     *
     * @return boolean true for valid / false for invalid.
     */
    public function isValid() {
        $regex = '/^[0-9a-z]{24}$/';


        if (preg_match($regex, $this->id)) {
            return true;
        }
        return false;
    }

}
