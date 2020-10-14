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
        parent::__construct($module, $request);
        $this->loadRole();
        $this->loadController($request, $this->role);
    }

    public function get(Request $request)
    {
        return $this->controller->getHtml($request);
    }

    public function execute(Request $request)
    {
        try {
            return parent::execute($request);
        } catch (\gpa\Exception\PrivilegeMissing $e) {
            \Current_User::requireLogin();
        } catch (\Exception $e) {
            // Friendly error catch here if needed.
            $friendly = new FriendlyError($this->getModule());
            if (GPA_FRIENDLY_ERROR) {
                return $friendly->execute($request);
            } else {
                throw $e;
            }
        }
    }

    protected function loadRole()
    {
        $user_id = \Current_User::getId();
        if (\Current_User::allow('gpa')) {
            $this->role = new \gpa\Controller\Admin($user_id);
        } else {
            $this->role = new \gpa\Controller\User;
        }
    }

    private function loadController(Request $request)
    {
        $major_controller = filter_var($request->shiftCommand(),
                FILTER_SANITIZE_STRING);

        if (empty($major_controller)) {
            throw new \gpa\Exception\BadCommand('Missing controller name');
        }

        $role_name = substr(strrchr(get_class($this->role), '\\'), 1);
        $controller_name = '\\gpa\\Controller\\' . $major_controller . '\\' . $role_name;
        if (!class_exists($controller_name)) {
            $entryFactory = new \gpa\Factory\EntryFactory;
            $entry = $entryFactory->getByUrlTitle($major_controller);
            if (!empty($entry)) {
                $request->setUrl($entry->id);
                $request->buildCommands();
                $controller_name = '\\gpa\\Controller\\Entry\\' . $role_name;
            } else {
                throw new \gpa\Exception\BadCommand($controller_name);
            }
        }
        $this->controller = new $controller_name($this->role);
    }
}

?>
