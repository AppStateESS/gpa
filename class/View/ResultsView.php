<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

 namespace gpa\View;

 use Canopy\Request;
 use phpws2\Template;

class ResultsView
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
         return (
            "<h2>Results</h2>"
         );
     }
 }
