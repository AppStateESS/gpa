<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

 namespace gpa\Role;

 class Admin extends Base
 {
     public function isAdmin()
     {
         return true;
     }
 }

 ?>
