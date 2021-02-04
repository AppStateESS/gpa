<?php

namespace gpa\Factory;
use Canopy\Request;
use phpws2\Database;
use gpa\View;

class RetrieveGPA {

    private $report;

    function createReport(Request $request) {

        $db = Database::getDB();

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

        $addReport = "INSERT INTO gpa_data (name, username, term)
                        VALUES ($reportName, $user, $term);";

        $reportID = "SELECT id FROM gpa_data WHERE name=$reportName";
        $filecontents = fopen($upload_file, 'r');

        if ($filecontents == FALSE) {
            die("Could not open file.\n");
            exit;
        }

        $import_url = "https://node-prd-orgsync.appstate.edu/student/";
        $curl = curl_init();

        while (($line = fgetcsv($filecontents, 0, ',')) !== FALSE) {
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
            //$student = $result->response ?? exit;
            $student = json_decode(file_get_contents("stu.json", true));

            if(!empty($student->lastName)) {
                $year = "Freshmen";
                $transfer = "No";
                $hrs = $student->totalHoursEarned;
                $firstName = $student->firstName;
                $lastName = $student->lastName;
                $GPA = $student->overallGPA;
                $H_GPA = $student->highSchoolGPA;

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
                $H_GPA = 0.0;
            }

            $addResult = "INSERT INTO gpa_results (first_name, last_name, banner,
                transfer, credits, year, gpa, hs_gpa, term, report_id)
                VALUES ($firstName, $lastName, $banner_id, $transfer, $hrs, $year,
                $GPA, $H_GPA, $term, $reportID);";
        }
        curl_close($curl);

        return $reportID;
    }
}
