<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once ("db_config.php");
require_once ("functions.php");
require_once ('PHPExcel/PHPExcel.php');

if ($_FILES["plan_xls"]["error"] > 0)
{
    echo $_FILES["plan_xls"]["error"];
}
else
{
    $upload = move_uploaded_file($_FILES["plan_xls"]["tmp_name"],"excel/shift_plan_xls.xlsx");
    if($upload) {
        $inputFileName = "excel/shift_plan_xls.xlsx";
        if (!file_exists($inputFileName)) {
            exit("Failed." . EOL);
        }

        $reader = PHPExcel_IOFactory::createReaderForFile($inputFileName);
        if (!$reader->canRead($inputFileName)) {
            $errors = PHPExcel_Settings::getLog();
            die("Error loading file: " . implode("\n", $errors));
        }

        $objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
        $worksheet = $objPHPExcel->getActiveSheet();

        $row_offset = array(array(15, 17, 18), array(56, 64, 69), array(76, 84, 91), array(99, 107, 116), array(125, 133, 140), 
                            array(151, 159, 162), array(167, 175, 182), array(190, 196, 201), array(207, 213, 218));

        if($worksheet) {
            $res = true;
            $date_row_index = 13;
            $_base_col_index = 6;
            $_date_col_index = 0;

            $flag = false;
            $index = 0;
            while(true) {
                $cellValue = $worksheet->getCellByColumnAndRow($_date_col_index + $_base_col_index, $date_row_index)->getFormattedValue();
                if($cellValue == "" || $cellValue == "#REF!"){
                    if($flag)
                        break;
                    $flag = true;
                    $_date_col_index += 1;
                    continue;
                }
                $flag = false;
                $plan_date = $cellValue;

                $number = explode('-', $plan_date);
                if(strlen($number[0]) == 1) {
                    $plan_date = '0'.$number[0].'-'.$number[1];
                }
                foreach($g_period_cumulative as $index => $machine){
                    getShiftData($worksheet, $_date_col_index + $_base_col_index, $row_offset[$index][0], $plan_date, $machine, 'ot_plan' );
                    getShiftData($worksheet, $_date_col_index + $_base_col_index, $row_offset[$index][1], $plan_date, $machine, 'opr' );
                    getShiftData($worksheet, $_date_col_index + $_base_col_index, $row_offset[$index][2], $plan_date, $machine, 'shift_plan' );
                }

                $_date_col_index += 3;
                if($_date_col_index % 15 == 0) {
                    $_base_col_index += 17;
                    $_date_col_index = 0;
                }
            }

            if($res)
                echo "OK";
            else
                echo "Fail";
        }
    } else {
        echo 'uploading failed';
    }
}

function getShiftData($worksheet, $_col_index, $_row_index, $plan_date, $machine, $plan_name) {
    $cellValue = $worksheet->getCellByColumnAndRow($_col_index, $_row_index)->getFormattedValue();
    $data = intval($cellValue);
    if($data < 0)
        $data = 0;
    set_shift_plan($plan_date, 'shift1', $machine, $data, $plan_name);
    $cellValue = $worksheet->getCellByColumnAndRow($_col_index+1, $_row_index)->getFormattedValue();
    $data = intval($cellValue);
    if($data < 0)
        $data = 0;
    set_shift_plan($plan_date, 'shift2', $machine, $data, $plan_name);
    $cellValue = $worksheet->getCellByColumnAndRow($_col_index+2, $_row_index)->getFormattedValue();
    $data = intval($cellValue);
    if($data < 0)
        $data = 0;
    set_shift_plan($plan_date, 'shift3', $machine, $data, $plan_name);
}