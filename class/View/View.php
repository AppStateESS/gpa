<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

 namespace gpa\View;

 use Canopy\Request;
 use phpws2\Template;

class View
 {
     const directory = PHPWS_SOURCE_DIR . 'mod/gpa/';
     const http = PHPWS_SOURCE_HTTP . '/mod/gpa/';

     private function getDirectory()
     {
         return self::directory;
     }

     private function getHttp()
     {
         return self::http;
     }

     public function show()
     {
         $template = new Template();
         $template->setModuleTemplate('gpa', 'gpa.html');
         return $template->get();
     }
 }
