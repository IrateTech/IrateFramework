<?php

namespace Application\Models;

/**
 * UserModel model
 */
class UserModel extends \Irate\Core\Model
{

    // Set public class variables
    public $isGuest = true;
    public $identityData;

    /**
     * Sets identity data
     */
    public function identity($field = null)
    {
        if (is_null($field)) {
            return $this->identityData;
        }

        if (!isset($this->identityData->{$field})) {
            return false;
        }

        return $this->identityData->{$field};
    }
}