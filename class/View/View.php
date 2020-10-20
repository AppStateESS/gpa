<?php

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Justyn Crook <hannajg at appstate dot edu>
 */

 namespace gpa\View;

 use Canopy\Request;
 use phpws2\Template;

 abstract class View
 {
     protected $factory;

     private function getScript($filename)
     {
         $root_directory = PHPWS_SOURCE_HTTP . 'mod/slideshow/javascript/';
         if (SLIDESHOW_REACT_DEV) {
             $path = "dev/$filename.js";
         } else {
             $path = "build/$filename.js";
         }
         $script = "<script type='text/javascript' src='{$root_directory}$path'></script>";
         return $script;
     }

     public function scriptView($view_name, $add_anchor = true, $vars = null)
     {
         static $vendor_included = false;
         if (!$vendor_included) {
             $script[] = $this->getScript('vendor');
             $vendor_included = true;
         }
         if (!empty($vars)) {
             $script[] = $this->addScriptVars($vars);
         }
         $script[] = $this->getScript($view_name);
         $react = implode("\n", $script);
         if ($add_anchor) {
             $content = <<<EOF
             <div id="$view_name"></div>
             $react
             EOF;
             return $content;
         } else {
             return $react;
         }
     }

     private function addScriptVars($vars)
     {
         if (empty($vars)) {
             return null;
         }
         foreach ($vars as $key => $value) {
             if (is_array($value)) {
                 $varList[] = "const $key = " . json_encode($value) . ';';
             } else {
                 $varList[] = "const $key = '$value';";
             }
         }
         return '<script type="text/javascript">' . implode('', $varList) . '</script>';
     }

     protected function getRootDirectory()
     {
         return PHPWS_SOURCE_DIR . 'mod/gpa/';
     }

     protected function getRootUrl()
     {
         return PHPWS_SOURCE_HTTP . 'mod/gpa/';
     }
 }
