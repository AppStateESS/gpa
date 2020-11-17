<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

 use phpws2\Database;

 function contact_uninstall(&$content)
 {
     $db = Database::getDB();
     $db->buildTable('gpa_data')->drop(true);
     $db->buildTable('gpa_results')->drop(true);
     $db->delete();
     return true;
 }
