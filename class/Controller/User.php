<?php

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Justyn Crook <hannajg at appstate dot edu>
 */

 namespace gpa\Controller;

 use Canopy\Request;
 use gpa\Factory\HostFactor;
 use gpa\View\HostView as View;
 use gpa\Controller\RoleController;

 class User extends RoleController
 {
     protected $hostFactory;
     protected $view;

     protected function loadFactory()
     {
         $this->factory = new HostFactory;
     }

     protected function loadView()
     {
         $this->view = new View;
     }

     public function shareHtmlCommand(Request $request)
     {
         return $this->factory->shareRequest($request);
     }
 }

 ?>
