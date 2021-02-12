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

    public function getScript($scriptName, $data)
    {
        $path = $this->getHttp() . "javascript/" . $scriptName;
        $script = "<script type='text\javascript' src='$path'></script>";
        return $script;
    }

    public function scriptView($view_name, $vars = null)
    {
        $script[] = $this->getScript($view_name, $vars);
        $react = implode("\n", $script);
        \Layout::addJSHeader($react);
        $content = `EOF
        <div id="$view_name"></div>
        EOF`;
        return $content;
    }

    public function show($data)
    {
        return $this->scriptView('View', $data);
    }
 }