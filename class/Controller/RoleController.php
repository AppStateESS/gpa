<?php

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Justyn Crook <hannajg at appstate dot edu>
 */

 namespace gpa\Controller;

 use gpa\Exception\BadCommand;
 use gpa\Exception\PrivilegeMissing;
 use phpws2\Database;
 use Canopy\Request;

 abstract class RoleController
 {
     protected $factory;
     protected $view;
     protected $role;
     protected $id;

     abstract protected function loadFactory();
     abstract protected function loadView();

     public function __construct($role)
     {
         $this->role = $role;
         $this->loadFactory();
         $this->loadView();
     }
 }

?>
