<?php

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Justyn Crook <hannajg at appstate dot edu>
 */

namespace gpa\Factory;
use gpa\Exception\ResourceNotFound;

abstract class BaseFactory extends \phpws2\ResourceFactory
{
    protected $header;

    abstract public function build();

    public function load(int $id)
    {
        if (empty($id)) {
            throw new ResourceNotFound;
        }
        $resource = $this->build();
        $resource->setId($id);
        if (!parent::loadByID($resource)) {
            throw new ResourceNotFound($id);
        }
        return $resource;
    }

    protected function walkingCase($name)
    {
        if (stripos($name, '_')) {
            return preg_replace_callback('/^(\w)(\w*)_(\w)(\w*)/',
                    function($letter) {
                $str = strtoupper($letter[1]) . $letter[2] . strtoupper($letter[3]) . $letter[4];
                return $str;
            }, $name);
        } else {
            return ucfirst($name);
        }
    }
}

?>
