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
        /*$roleController = filter_var($request->shiftCommand(),
                FILTER_SANITIZE_STRING);

        if (empty($roleController) || preg_match('/\W/', $roleController)) {
            throw new \gpa\Exception\BadCommand('Missing role controller');
        }

        if ($roleController === 'Admin' && !$this->role->isAdmin()) {
            throw new \gpa\Exception\PrivilegeMissing;
        }*/

        //$controlName = '\\gpa\\Controller\\Admin\\' . $roleController . '\\';
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
        $reportID = (new RetrieveGPA)->createReport($request);
        $rv = new ResultsView();
        $view = $rv->show($reportID);
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
