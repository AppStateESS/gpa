<?php

namespace gpa\Factory;
use Canopy\Request;
use phpws2\Database;
use gpa\View;

class RetrieveGPA {
    
    function createReport(Request $request) {

        $db = Database::getDB();
        $tbl1 = $db->addTable('gpa_data');

        $errors = array();
        $user = \Current_User::getUsername();

        if (!empty($_POST['report-name'])) {
            $reportName = $_POST['report-name'];
            $report = $reportName;
        } else {
            array_push($errors, "Missing report name.");
        }

        if (!empty($_POST['term'])) {
            $term = $_POST['term'];
        } else {
            $term = "Fall 2020";
        }

        if (isset($_FILES['gpa-report'])) {
            $upload_file = $_FILES["gpa-report"]["tmp_name"];
        } else {
            array_push($errors, "File upload failed.");
            $upload_file = "";
        }

        try {
            $tbl1->addValue('name', $reportName);
            $tbl1->addValue('username', $user);
            $tbl1->addValue('term', $term);
            $db->insert();
        } catch (Exception $e) {
            array_push($errors, "Insertion failed on gpa_data.");
        }

        try {
            $tbl1->addFieldConditional('name', $reportName);
            $reportRow = $db->select();
            $reportID = $reportRow[0]['id'];
        } catch (Exception $e) {
            array_push($errors, "Report ID Selection failed.");
            $reportID = NULL;
        }

        $filecontents = fopen($upload_file, 'r');

        if ($filecontents == FALSE) {
            die("Could not open file.\n");
            exit;
        }

        $import_url = "https://node-prd-orgsync.appstate.edu/student/";
        $curl = curl_init();

        $db = Database::getDB();
        $tbl2 = $db->addTable('gpa_results');

        while ((($line = fgetcsv($filecontents, 0, ',')) !== FALSE) && $reportID != NULL) {
            foreach ($line as $key=>$element) {
                $line[$key] = pg_escape_string($element);
            }

            $banner_id = trim($line[2]);

            if (substr($banner_id, 0, 3) != "900") {
                $email_parts = explode("@",$banner_id);
                $banner_id = $email_parts[0];
            }

            curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => $import_url.$banner_id));
            $result = json_decode(curl_exec($curl));
            $student = $result->response;
            //$student = json_decode(file_get_contents("stu.json", true));

            if(!empty($student->lastName)) {
                $year = "Freshmen";
                $transfer = 0;
                $hrs = $student->totalHoursEarned;
                $firstName = $student->firstName;
                $lastName = $student->lastName;
                $GPA = $student->overallGPA;
                $HS_GPA = $student->highSchoolGPA;

                if($student->studentType === "T")
                    $transfer = 1;

                if ($hrs >= 30 && $hrs < 60)
                    $year = "Sophomore";
                elseif ($hrs >= 60 && $hrs < 90)
                    $year = "Junior";
                elseif ($hrs >= 90)
                    $year = "Senior";
            } else {
                $firstName = $line[0];
                $lastName = $line[1];
                $transfer = 0;
                $hrs = 0;
                $year = "NOT FOUND";
                $GPA = 0.0;
                $HS_GPA = 0.0;
            }

            $tbl2->addValue('first_name', $firstName);
            $tbl2->addValue('last_name', $lastName);
            $tbl2->addValue('banner', $banner_id);
            $tbl2->addValue('transfer', $transfer);
            $tbl2->addValue('credits', $hrs);
            $tbl2->addValue('year', $year);
            $tbl2->addValue('gpa', $GPA);
            $tbl2->addValue('hs_gpa', $HS_GPA);
            $tbl2->addValue('term', $term);
            $tbl2->addValue('report_id', $reportID);
            $db->insert();
        }
        curl_close($curl);

        $tbl2->addFieldConditional('report_id', $reportID);
        $rows = $db->select();

        return $rows;
    }
}
