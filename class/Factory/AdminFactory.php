<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

namespace gpa\Factory;

class Home
{
    public static function view()
    {
        $vars['logged'] = \Current_User::isLogged();
        $vars['admin'] = \Current_User::allow('gpa');
        $vars['login_url'] = "index.php?module=users&action=user&command=login_page";
        $vars['home_img'] = 'mod/gpa/img/gpa.png';

        $template = new \phpws2\Template($vars);
        $template->setModuleTemplate('gpa', 'index.html');
        $content = $template->get();
        return $content;
    }
}

?>
