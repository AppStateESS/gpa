<?php

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Justyn Crook <hannajg at appstate dot edu>
 */

namespace gpa\Factory;

use gpa\Resource\HostResource as Resource;
use phpws2\Database;
use Canopy\Request;

class HostFactory extends BaseFactory
{
    public function build(array $data = null)
    {
        $resource = new Resource;
        if ($data) {
            $resource->setVars($data);
        }
        return $resource;
    }
}

?>
