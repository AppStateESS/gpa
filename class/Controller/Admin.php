<?php

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Justyn Crook <hannajg at appstate dot edu>
 */

 namespace gpa\Controller\Role;

 use Canopy\Request;
 use gpa\Factory\HostFactory;
 use gpa\View\HostView as View;
 use gpa\Controller\RoleController;

 class Admin extends User
 {
     public function isAdmin() {
         return true;
     }
 }

 ?>
