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
     protected $factory;
     protected $view;

     public function isUser() {
         return true;
     }

     protected function loadFactory()
     {
         $this->factory = new Factory;
     }

     protected function loadView()
     {
         $this->view = new View;
     }

     protected function editHtmlCommand(Request $request)
     {
         return $this->view->edit();
     }

     protected function presentHtmlCommand(Request $request)
     {
         return $this->view->present();
     }

     protected function presentJsonCommand(Request $request)
     {
         return $this->factory->get($request);
     }
 }

 ?>
