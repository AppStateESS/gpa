<?php

/**
 * @license http://opensource.org/licenses/lgpl-3.0.html
 * @author Justyn Crook <hannajg at appstate dot edu>
 */

namespace gpa\Controller;

use gpa\Exception\BadCommand;
use gpa\Exception\PrivilegeMissing;
use Canopy\Request;

class Controller extends \phpws2\Http\Controller
{
    protected $role;
    protected $controller;

    public function __construct($module, $request)
    {
        parent::__construct($module);
        $this->loadRole();
        $this->loadController($request, $this->role);
    }

    public function htmlResponse($content)
    {
        $view = new \phpws2\View\HtmlView($content);
        $response = new \Canopy\Response($view);
        return $response;
    }

    public function jsonResponse($json)
    {
        $view = new \phpws2\View\JsonView($json);
        $response = new \Canopy\Response($view);
        return $response;
    }

    protected function loadRole()
    {
        $user_id = \Current_User::getId();
        if (\Current_User::allow('gpa')) {
            $this->role = new \gpa\Controller\Admin($user_id);
        } elseif ($user_id) {
            $this->role = new \gpa\Controller\Logged($user_id);
        } else {
            $this->role = new \gpa\Controller\User;
        }
    }

    private function loadController(Request $request)
    {
        $major_controller = filter_var($request->shiftCommand(), FILTER_SANITIZE_STRING);

        if (empty($major_controller)) {
            throw new \gpa\Exception\BadCommand('Missing controller name');
        }

        $role_name = substr(strrchr(get_class($this->role), '\\'), 1);
        $controller_name = '\\gpa\\Controller\\' . $major_controller . '\\' . $role_name;
        if (!class_exists($controller_name)) {
            throw new \gpa\Exception\BadCommand($controller_name);
        }
        $this->controller = new $controller_name($this->role);
    }

    public function execute(Request $request)
    {
        try {
            return parent::execute($request);
        } catch (\Exception $e) {
            // Friendly error catch here if needed.
            throw $e;
        }
    }

    public function post(Request $request)
    {
        return $this->controller->post($request);
    }

    public function patch(Request $request)
    {
        return $this->controller->patch($request);
    }

    public function delete(Request $request)
    {
        return $this->controller->delete($request);
    }

    public function put(Request $request)
    {
        return $this->controller->put($request);
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
