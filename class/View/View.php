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

     private function getScript($filename)
     {
         $jsDirectory = $this->getHttp() . 'javascript/';
         if (GPA_REACT_DEV) {
             $path = $jsDirectory . "dev/" . $this->getAssetPath($filename);
         } else {
             $path = "{$jsDirectory}build/$filename.js";
         }
         $script = "<script type='text/javascript' src='$path'></script>";
         return $script;
     }

     private function getAssetPath($filename)
     {
         if (!is_file($this->getDirectory() . 'assets.json')) {
             exit('Missing assets.json file. Run "npm run build" in the gpa directory.');
         }
         $jsonRaw = file_get_contents($this->getDirectory() . 'assets.json');
         $json = json_decode($jsonRaw, true);
         if (!isset($json[$scriptName]['js'])) {
             throw new \Exception('Script file not found among assets.');
         }
         return $json[$scriptName]['js'];
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
         \Layout::addJSHeader($react);
         $content = <<<EOF
         <div id="$view_name"></div>
         EOF;

         return $content;
     }

     private function addScriptVars($vars)
     {
         if (empty($vars)) {
             return null;
         }
         foreach ($vars as $key => $value) {
             $varList[] = "const $key = " . json_encode($value,
                            JSON_NUMERIC_CHECK) . ';';
         }
         return '<script type="text/javascript">' . implode('', $varList) . '</script>';
     }

     public function show()
     {
         return $this->scriptView('view');
     }
 }
