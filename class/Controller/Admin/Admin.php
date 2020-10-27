<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

 namespace gpa\Controller\;

 use gpa\Controller\SubController;
 use gpa\Factory\AdminFactory;
 use Canopy\Request;

 class Admin extends SubController
 {
     protected $view;

     public function __construct(\gpa\Role\Base $role)
     {
         parent::__construct($role);
         var_dump($role);
         $this->view = new \gpa\View\View();
     }

     protected function show()
     {
         return $this->view->show();
     }
 }
