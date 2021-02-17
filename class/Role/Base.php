<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

 namespace gpa\Role;

 abstract class Base
 {
     protected $id;

     public function __construct($id = null)
     {
         $this->id = (int) $id;
     }

     public function isAdmin()
     {
         return false;
     }

     public function isLogged()
     {
         return false;
     }

     public function getId()
     {
         return $this->id;
     }

     public function getType()
     {
         switch (1) {
             case $this->isAdmin():
                    return 'admin';
        }
    }
}
