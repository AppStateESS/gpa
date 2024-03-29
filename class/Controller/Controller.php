<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

namespace gpa\Controller;

use Canopy\Request;
use gpa\Factory\RetrieveGPA;
use gpa\View\ResultsView;

class Controller extends \phpws2\Http\Controller
{

    protected $role;
    protected $controller;

    public function __construct(\Canopy\Module $module, Request $request)
    {
        parent::__construct($module);
        if (!\Current_User::allow('gpa')) {
            \Current_User::requireLogin();
        }
        $this->loadSubController($request);
    }

    private function loadSubController(Request $request)
    {
        $controlName = '\\gpa\\Controller\\Admin\\Admin';
        if (!class_exists($controlName)) {
            throw new \gpa\Exception\BadCommand($controlName);
        }
        $this->controller = new $controlName();
    }

    public function execute(Request $request)
    {
        try {
            return parent::execute($request);
        } catch (\gpa\Exception\PrivilegeMissing $e) {
            \Current_User::require_login();
        } catch (\Exception $e) {
            // Friendly error catch here if needed.
            throw $e;
        }
    }

    public function post(Request $request)
    {
        $reportData = (new RetrieveGPA)->createReport($request);
        $rv = new ResultsView();
        $view = new \phpws2\View\HtmlView($rv->show($reportData));
        $response = new \Canopy\Response($view);
        return $response;
    }

    public function patch(Request $request)
    {
        return $this->controller->changeResponse($request);
    }

    public function delete(Request $request)
    {
        return $this->controller->changeResponse($request);
    }

    public function put(Request $request)
    {
        return $this->controller->changeResponse($request);
    }

    public function get(Request $request)
    {
        $result = $this->controller->getHtml($request);
        return $result;
    }

}

?>
