<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
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
