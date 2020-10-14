<?php

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Justyn Crook <hannajg at appstate dot edu>
 */

 namespace gpa\Resource;

use \phpws2\Database;
use gpa\Exception\MissingInput;

class BaseResource extends \phpws2\Resource
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
}

?>
