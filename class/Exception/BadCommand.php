<?php

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Justyn Crook <hannajg at appstate dot edu>
 */

 namespace gpa\Exception;

class BadCommand extends \Exception
{
    public function __construct($command=null) {
        if ($command) {
            $this->message = 'Unknown command sent to controller: ' . $command;
        } else {
            $this->message = 'Empty command sent to controller';
        }
    }
}

?>
