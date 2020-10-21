<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

namespace gpa;

 use Canopy\Request;
 use Canopy\Response;
 use Canopy\Server;
 use gpa\Controller\Controller;

 $defineFile = PHPWS_SOURCE_DIR . 'mod/gpa/config/defines.php';
 if (is_file($defineFile)) {
    require_once $defineFile;
} else {
    require_once PHPWS_SOURCE_DIR . 'mod/gpa/config/defines.dist.php';
}

 class Module extends \Canopy\Module
 {
     public function __construct()
     {
         parent::__construct();
         $this->setTitle('gpa');
         $this->setProperName('Greek Life GPA');
         spl_autoload_register('\gpa\Module::autoloader', true, true);
     }

     public static function autoloader($class_name)
     {
         static $not_found = array();

         if (strpos($class_name, 'gpa') !== 0)
         {
             return;
         }
         if (isset($not_found[$class_name]))
         {
             return;
         }

         $class_array = explode('\\', $class_name);
         array_shift($class_array);
         $class_dir = implode('/', $class_array);

         $class_path = PHPWS_SOURCE_DIR . 'mod/gpa/class' . $class_dir . '.php';
         if (is_file($class_path))
         {
             require_once $class_path;
             return true;
         } else {
             $not_found[] = $class_name;
             return false;
         }
     }

     public function getSettingDefaults()
     {
         $settings = array();
         return $settings;
     }
/*
     public function getController(Request $request)
     {
         try {
             if (!\Current_User::isLogged()) {
                 \Current_User::requireLogin();
             }
             $controller = new Controller($this, $request);
             return $controller;
         } catch (\Exception $e) {
                 throw $e;
         }
     }
*/
     public function runTime(Request $request)
     {/*
         //$this->checkDefine();
         if (\PHPWS_Core::atHome())
         {
             $content = Home::view();
             \Layout::add($content);
         }
         */
     }

     public function getController(Request $request)
     {
         try {
             $controller = new Controller($this, $request);
             return $controller;
         } catch (\gpa\Exception\PrivilegeMissing $e) {
             if ($request->isGet() && !$request->isAjax()) {
                 \Current_User::requireLogin();
             } else {
                 throw $e;
             }
         }
     }
 }

?>
