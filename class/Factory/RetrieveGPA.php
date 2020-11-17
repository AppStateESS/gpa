<?php

namespace gpa\Factory;
use phpws2\Database;

class RetrieveGPA {

    const $db = Database::getDB();

    $errors = array();
    $user = \Current_User::getUsername();

    if (isset($_POST['retrieve-report'])) {
        createReport();
    }

    function createReport() {
        if (!empty($_POST['report-name'])) {
            $reportName = $_POST['report-name'];
            }
        } else {
            array_push($errors, "Missing report name.");
        }

        if (!empty($_POST['term'])) {
            $term = $_POST['term'];
        } else {
            $term = "Fall 2020";
        }

        if (!empty($_POST['gpa-report'])) {
            $upload_file = basename($FILES_["gpa-report"]["name"]);
        } else {
            array_push($errors, "File upload failed.");
        }

        $addReport = "INSERT INTO gpa_data (name, username, term)
                        VALUES ($reportName, $user, $term);";

        $reportID = "SELECT id FROM gpa_data WHERE name=$reportName";
        $filecontents = file($inputFile);
        $import_url = "https://node-prd-orgsync.appstate.edu/student";
        $curl = curl_init();

        foreach ($filecontents as $value) {
            $values = explode(",", $value);
            $banner_id = trim($values[2]);

            if (substr($banner_id, 0, 3) != "900") {
                $email_parts = explode("@",$banner_id);
                $banner_id = $email_parts[0];
            }

            curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => $import_url.$banner_id));
            $result = json_decode(curl_exec($curl));
            $student = $result->response;
    /*
            if($term) {
                curl_reset($curl);
                $url = $import_url.$banner_id."/$term/GPA";
                curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => $url));
                $term_result = json_decode(curl_exec($curl));
                $term_student = $term_result->response;
                $term_gpa = $term_student->termGPA;
            } else {
                $term_gpa = 0.0;
            }
    */
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
                $firstName = $values[0];
                $lastName = $values[1];
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
    }
}
/*
$filecontents = file($input_filename);
$fhandle = fopen($output_filename, "w+");
$import_url = "https://node-prd-orgsync.appstate.edu/student/";
$curl = curl_init();
if($term){
    $term_header = "$term GPA";
} else {
    $term_header = "";
}

$data = "'First Name','Last Name','Banner ID','Transfer','Credits','Year','GPA','High School GPA','$term_header'"."\n";


    curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => $import_url.$banner_id));
    $result = json_decode(curl_exec($curl));
    $student = $result->response;

    if($term) {
        curl_reset($curl);
        $url = $import_url.$banner_id."/$term/GPA";
        curl_setopt_array($curl, array(CURLOPT_RETURNTRANSFER => 1, CURLOPT_URL => $url));
        $term_result = json_decode(curl_exec($curl));
        $term_student = $term_result->response;
        $term_gpa = $term_student->termGPA;
    } else {
        $term_gpa = '';
    }

    if(!empty($student->lastName)){
        $year = "Freshmen";
        $transfer = "No";
        $hrs = $student->totalHoursEarned;
        $firstName = $student->firstName;
        $lastName = $student->lastName;
        $GPA = $student->overallGPA;
        $H_GPA = $student->highSchoolGPA;

        if($student->studentType === "T")
            $transfer = "Yes";

        if($hrs >= 30 && $hrs < 60)
            $year = "Sophomore";
        elseif($hrs >= 60 && $hrs < 90)
            $year = "Junior";
        elseif($hrs >= 90)
            $year = "Senior";
    }else{
        $firstName = $values[0];
        $lastName = $values[1];
        $transfer = "NOT FOUND";
        $hrs = "NOT FOUND";
        $year = "NOT FOUND";
        $GPA = "NOT FOUND";
        $H_GPA = "NOT FOUND";
    }
    $data .= $firstName.','.$lastName.','.$banner_id.','.$transfer.','.$hrs.','.$year.','.$GPA.','.$H_GPA.$term_gpa."\n";

}

fwrite($fhandle, $data);
fclose($fhandle);
curl_close($curl);
exit;
*/
