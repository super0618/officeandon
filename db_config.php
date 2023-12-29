<?php
$DB_HOST = "localhost";
$DB_USER = "root";
$DB_PASSWORD = "123123";
$DB_NAME = "officeandon";

//Table Name
$tblLive = 'live';
$tblSettings = 'settings';
$tblTagSettings = 'tag_settings';
$tblTargetStop = 'target_stop';
$tblHistory = 'histories';
$tblShiftPlan = 'shift_plan';
$tblPageCycles = 'page_cycles';
$tblUsers = 'users';
$APP_NAME = 'Office Andon';

$db = new mysqli($DB_HOST,$DB_USER,$DB_PASSWORD,$DB_NAME);
// Check connection
if (mysqli_connect_errno())
{
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit;
}

//Set Time Zone
//date_default_timezone_set('Europe/London');

//Get Current Datetime
$current = date('Y-m-d H:i:s');
$today = date("Y-m-d");

$g_shifts = array('shift1', 'shift2', 'shift3');

$g_andon = array('ASSY', 'SHORT BLOCK', 'HEAD SUB', 'CAM HSG');
$g_machines = array('CRANK', 'BLOCK', 'HEAD', 'HOUSING', 'ROD', 'CAM');
$g_period_cumulative = array('ASSY', 'CRANK', 'BLOCK', 'HEAD', 'HOUSING', 'ROD', 'CAM', 'L/P CAST', 'HP CAST');
$g_shift_patterns = array('QCC', 'TMAB 5', 'TMAB 10', 'TMAB 15', 'TBU 30', 'NO O/T');

$g_items = array(
    'SHIFT PLAN',
    'TARGET',
    'ACTUAL',
    'LIVE +/-',
    'SHIFT LINE STOP',
    'SHIFT OPR',
    //'SHIFT OPR OUT',
    'LAST HOUR OPR',
    'O/T PLAN',
    'O/T CALL'
);