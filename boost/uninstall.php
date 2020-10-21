<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

 use phpwl2\Database;

 function contact_uninstall(&$content)
 {
     $db = Database::getDB();
     $db->buildTable('report_data')->drop(true);
     $db->buildTable('report_results')->drop(true);
     $db->delete();
     return true;
 }
