<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

 namespace gpa\Controller\Admin;

 use triptrack\Controller\SubController;
 use triptrack\Factory\AdminFactory;
 use Canopy\Request;

 class Home extends SubController
 {
     protected $view;

     public function __construct(\triptrack\Role\Base $role)
     {
         parent::__construct($role);
         $this->view = new \triptrack\View\TripView();
     }

     protected function show()
     {
         return $this->view->show();
     }
 }
