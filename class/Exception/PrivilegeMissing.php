<?php

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Justyn Crook <hannajg at appstate dot edu>
 */

 namespace gpa\Exception;

class PrivilegeMissing extends \Exception
{
    protected $defaultMessage = 'You do not have permissions for this action';

    public function __construct($className = null)
    {
        $message = $this->defaultMessage;
        if ($className) {
            $message .= ': ' . $className;
        }
        parent::__construct($message);
    }
}

?>
