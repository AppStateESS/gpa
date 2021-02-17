<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
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
