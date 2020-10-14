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
 }
