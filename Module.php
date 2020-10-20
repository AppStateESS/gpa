<?php

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Justyn Crook <hannajg at appstate dot edu>
 */

namespace gpa;

 use Canopy\Request;
 use Canopy\Controller;

 class Module extends \Canopy\Module
 {
     public function __construct()
     {
         parent::__construct();
         $this->loadDefines();
         $this->setTitle('gpa');
         $this->setProperName('Greek Life GPA');
         spl_autoload_register('\gpa\Module::autoloader', true, true);
     }

     public function getSettingDefaults()
     {
         $settings = array();
         return $settings;
     }

     public function beforeRun(Request $request, Controller $controller)
     {
         $this->checkDefine();
     }

     public function checkDefine()
     {
         static $checked = false;
         if ($checked)
         {
             return;
         }
         $define_file = PHPWS_SOURCE_DIR . 'mod/gpa/config/defines.php';
         if (!is_file($define_file))
         {
             exit('Greek Life GPA requires a copy of config/defines.php to be created.');
         }
         $checked = true;
         require_once $define_file;
     }

     public function getController(Request $request)
     {
         try {
             if (!\Current_User::isLogged()) {
                 \Current_User::requireLogin();
             }
             $controller = new Controller\BaseController($this, $request);
             return $controller;
         } catch (\Exception $e) {
                 throw $e;
         }
     }

     public function runTime(Request $request)
     {
         $this->checkDefine();
         if (\PHPWS_Core::atHome())
         {
             $content = Home::view();
             \Layout::add($content);
         }
     }

     public static function autoloader($class_name)
     {
         static $not_found = array();

         if (strpos($class_name, 'gpa') != 0)
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

     private function frontPage(Request $request)
     {
         if (!empty($request->getModule())) {
             return;
         }
         $view = new \gpa\View\View;
         $settings = new \phpws2\Settings;
         \Layout::add($view->show($request), 'gpa', 'gpa', true);
     }

     private function loadDefines()
     {
         $custom = PHPWS_SOURCE_DIR . 'mod/gpa/config/defines.php';
         if (is_file($custom)) {
             require_once $custom;
         }
    }
 }

?>
