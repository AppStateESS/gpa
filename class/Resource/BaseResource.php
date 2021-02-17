<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

 namespace gpa\Resource;

use \phpws2\Database;
use gpa\Exception\MissingInput;

abstract class BaseResource extends \phpws2\Resource
{
    public function __set($name, $value)
    {
        if ((!$this->$name->allowNull() &&
                (method_exists($this->$name, 'allowEmpty') && !$this->$name->allowEmpty())) &&
                ( (is_string($value) && $value === '') || is_null($value))) {
            throw new MissingInput("$name may not be empty");
        }

        $method_name = self::walkingCase($name, 'set');
        if (method_exists($this, $method_name)) {
            return $this->$method_name($value);
        } else {
            return $this->$name->set($value);
        }
    }

    public function __get($name)
    {
        $method_name = self::walkingCase($name, 'get');
        if (method_exists($this, $method_name)) {
            return $this->$method_name();
        } else {
            return $this->$name->get();
        }
    }

    public function __isset($name)
    {
        return isset($this->$name);
    }

    public function isEmpty($name)
    {
        return $this->$name->isEmpty();
    }

    protected function strip($text)
    {
        $allowed = implode('', TRIPTRACK_ALLOWED_TAGS);
        return strip_tags($text, $allowed);
    }
}

?>
