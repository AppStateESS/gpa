<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

namespace gpa\Controller;

use Canopy\Request;

class Controller extends \phpws2\Http\Controller
{

    protected $role;
    protected $controller;

    public function __construct(\Canopy\Module $module, Request $request)
    {
        parent::__construct($module);
        $this->loadRole();
        $this->loadSubController($request);
    }

    protected function loadRole()
    {
        $user_id = \Current_User::getId();
        if (\Current_User::allow('gpa')) {
            $this->role = new \gpa\Role\Admin($user_id);
        } else {
            \Current_User::requireLogin();
        }
    }

    private function loadSubController(Request $request)
    {
        $roleController = filter_var($request->shiftCommand(),
                FILTER_SANITIZE_STRING);

        if (empty($roleController) || preg_match('/\W/', $roleController)) {
            throw new \gpa\Exception\BadCommand('Missing role controller');
        }

        if ($roleController === 'Admin' && !$this->role->isAdmin()) {
            throw new \gpa\Exception\PrivilegeMissing;
        }

        $controlName = '\\gpa\\Controller\\' . $roleController . '\\';
        if (!class_exists($controlName)) {
            throw new \gpa\Exception\BadCommand($controlName);
        }
        $this->controller = new $controlName($this->role);
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
        return $this->controller->changeResponse($request);
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
        if ($request->isAjax()) {
            $result = $this->controller->getJson($request);
        } else {
            $result = $this->controller->getHtml($request);
        }

        return $result;
    }

}

?>
