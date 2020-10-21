<?php

/**
 * @license https://opensource.org/licenses/MIT
 * @author Justyn Crook <hannajg@appstate.edu>
 */

 use phpws2\Database;
 use phpws2\ForeignKey;

 function gpa_install(&$content)
 {
     $db = Database::getDB();
     $db->begin();

     try {
         $reportDataTable = createReportDataTable();
         $reportResultsTable = createReportResultsTable();
     } catch (\Exception $e) {
         \phpws2\Error::log($e);
         $db->rollback();

         if (isset($reportDataTable)) {
             $reportDataTable->drop();
         }

         if (isset($reportResultsTable)) {
             $reportResultsTable->drop();
         }

         throw $e;
     }
     $db->commit();

     $content[] = 'Tables created';
     return true;
 }

 function createReportDataTable()
 {
     $db = Database::getDB();
     $reportData = new \gpa\Resource\ReportData;
     return $reportData->createTable($db);
 }

 function createReportResultsTable()
 {
     $db = Database::getDB();
     $reportDataTable = $db->addTable('report_data');
     $reportResults = new \gpa\Resource\ReportResults;
     $reportResultsTable = $reportResults->createTable($db);

     $foreign = new ForeignKey($reportResultsTable->getData('report_id'),
            $reportDataTable->getDataType('id'), ForeignKey::CASCADE);
    $foreign->add();

    return $reportResultsTable;
 }

?>
