<?php
$report_errors = getenv('PHPDISPLAYERR');
error_reporting($report_errors); // display all faires
ini_set('display_errors', $report_errors);  
?>
