<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

namespace gpa\Factory;

use gpa\Exception\ResourceNotFound;
use Canopy\Request;

abstract class BaseFactory extends \phpws2\ResourceFactory
{
    protected $header;

    abstract public function build();

    public function load(int $id)
    {
        $resource->setId($id);
        if (!parent::loadByID($resource)) {
            if ($throwException) {
                throw new ResourceNotFound($id);
            } else {
                return null;
            }
        }
        return $resource;
    }

    public static function save(\phpws2\Resource $resource)
    {
        return self::saveResource($resource);
    }
}

?>
