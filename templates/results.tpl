<!DOCTYPE HTML>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <title>GPA Report</title>
        <style>
            .col {
                padding-left: 0 !important;
                padding-right: 0 !important;
            }
        </style>
    </head>
    <body>
        <h1>GPA Report</h1>
        <div class="row text-center font-weight-bold">
            <div class="col border">First Name</div>
            <div class="col border">Last Name</div>
            <div class="col border">Banner</div>
            <div class="col border">Transfer</div>
            <div class="col border">Credits</div>
            <div class="col border">Year</div>
            <div class="col border">GPA</div>
            <div class="col border">HS GPA</div>
            <div class="col border">Term</div>
        </div>
<?php foreach ($results as $row){
    echo("  <div class='row text-center'>
                <div class='col border'>" . $row['first_name'] . "</div>
                <div class='col border'>" . $row['last_name'] . "</div>
                <div class='col border'>" . $row['banner'] . "</div>
                <div class='col border'>" . $row['transfer'] . "</div>
                <div class='col border'>" . $row['credits'] . "</div>
                <div class='col border'>" . $row['year'] . "</div>
                <div class='col border'>" . $row['gpa'] . "</div>
                <div class='col border'>" . $row['hs_gpa'] . "</div>
                <div class='col border'>" . $row['term'] . "</div>
            </div>");
} ?>
    </body>
</html>