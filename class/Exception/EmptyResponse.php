<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

namespace gpa\Exception;

class EmptyResponse extends \Exception
{
    public function __construct($className = null)
    {
        $message = "The response object has returned nothing. Please make sure data in the uploaded CSV file is correct.";
        parent::__construct($message);
    }
}

?>
