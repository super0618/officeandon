<?php
require_once 'PHPExcel/PHPExcel.php';
require_once 'db_config.php';
require_once 'functions.php';

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$post_data = $_POST;
$page = $post_data['page'];
$date = $post_data['date'];

$g_date = convert_date_string($date);
$g_shift = $post_data['select_shift'];
/*$shift = get_shift_by_date($g_date, $g_shift);
$start_time = $shift['start'];
$end_time = $shift['end'];*/

$title = "Office Andon History";
$fileName = "history.xlsx";

if($g_date >= date('Y-m-d', strtotime("-2 days"))) {
    $results = get_main_data($page);
} else {
    $results = read_history($g_date, $g_shift, $page);
}

if($page == 'live1') {
    //Make table headers
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'ASSEMBLY');
    $objPHPExcel->getActiveSheet()->mergeCells('B1:E1');

    $objPHPExcel->getActiveSheet()->setCellValue('G1', 'MACHINING');
    $objPHPExcel->getActiveSheet()->mergeCells('G1:L1');


    $objPHPExcel->getActiveSheet()
        ->setCellValue('A2', '')
        ->setCellValue('B2', 'ASSY')
        ->setCellValue('C2', 'S/BLOCK')
        ->setCellValue('D2', 'HEAD SUB')
        ->setCellValue('E2', 'CAM HSG')
        ->setCellValue('F2', '')
        ->setCellValue('G2', 'CRANK')
        ->setCellValue('H2', 'BLOCK')
        ->setCellValue('I2', 'HEAD')
        ->setCellValue('J2', 'HOUSING')
        ->setCellValue('K2', 'ROD')
        ->setCellValue('L2', 'CAM');

    $row = 3;

    foreach ($g_items as $index => $item) {
        $excel_row = $row + $index;
        $objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$excel_row, $item);
    }

    $column = 'B';
    $row = 3;
    $column_index = 1;
    foreach ($results as $table => $result) {
        if($table == 'ASSEMBLY' || $table == 'MACHINING') {
            foreach($result as $machine) {
                $column_cell = PHPExcel_Cell::stringFromColumnIndex($column_index);
                $index = 0;
                foreach($machine as $item) {
                    $excel_row = $row + $index;
                    $objPHPExcel->getActiveSheet()
                        ->setCellValue($column_cell.$excel_row, strval($item['value']));
                    $index ++;
                }
                $column_index ++;
            }

            $column_index ++;
        }
    }

    $row = $excel_row + 2;

    $period_start_date = get_setting('period_start_date');
    $period_end_date = get_setting('period_end_date');
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$row, 'Period Cumulative from '.$period_start_date.' to '.$period_end_date);
    $objPHPExcel->getActiveSheet()->mergeCells('A'.$row.':I'.$row);
    $row ++ ;

    $title_row = $row + 1;
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$title_row, 'Actual to Date');
    $title_row ++ ;
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$title_row, 'Period Actual');
    $title_row ++ ;
    $objPHPExcel->getActiveSheet()->setCellValue('A'.$title_row, 'Period Plan');

    $column_index = 1;
    //Get Period Cumulative
    $post_data['return'] = true;
    $p_data = get_period_cumulative($post_data);
    foreach($p_data as $key => $item) {
        $column_cell = PHPExcel_Cell::stringFromColumnIndex($column_index);
        $objPHPExcel->getActiveSheet()
            ->setCellValue($column_cell.$row, $key);
        $val_row = $row + 1;
        $objPHPExcel->getActiveSheet()
            ->setCellValue($column_cell.$val_row, strval($item['actual']));
        $val_row = $row + 2;
        $objPHPExcel->getActiveSheet()
            ->setCellValue($column_cell.$val_row, strval($item['plan_to_date']));
        $val_row = $row + 3;
        $objPHPExcel->getActiveSheet()
            ->setCellValue($column_cell.$val_row, strval($item['plan_period']));
        $column_index ++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('B15:J15')->applyFromArray(
        array(
            'font' => array(
                'bold' => true
            )
        )
    );

    $objPHPExcel->getActiveSheet()->getStyle('A1:L2')->applyFromArray(
        array(
            'font' => array(
                'bold' => true
            )
        )
    );

    $last_row = $row + 3;
    $objPHPExcel->getActiveSheet()->getStyle('A1:L'.$last_row)->applyFromArray(
        array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        )
    );
} else {
    $objPHPExcel->getActiveSheet()->setCellValue('B1', 'LOW PRESSURE CASTING');
    $objPHPExcel->getActiveSheet()->mergeCells('B1:D1');

    $objPHPExcel->getActiveSheet()->setCellValue('E1', 'HIGH PRESSURE CASTING');
    $objPHPExcel->getActiveSheet()->mergeCells('E1:G1');

    $objPHPExcel->getActiveSheet()->setCellValue('H1', 'SHIFT PATTERN');
    $objPHPExcel->getActiveSheet()->mergeCells('H1:I1');


    $objPHPExcel->getActiveSheet()
        ->setCellValue('A2', '')
        ->setCellValue('B2', 'HEAD')
        ->setCellValue('C2', 'EDM ACTUAL')
        ->setCellValue('D2', '')
        ->setCellValue('E2', 'BLOCK')
        ->setCellValue('F2', 'H1/H2 ACTUAL')
        ->setCellValue('G2', '');

    $row = 3;
    foreach ($g_items as $index => $item) {
        $excel_row = $row + $index;
        $objPHPExcel->getActiveSheet()
            ->setCellValue('A'.$excel_row, $item);
    }

    $objPHPExcel->getActiveSheet()->getStyle('A1:I2')->applyFromArray(
        array(
            'font' => array(
                'bold' => true
            )
        )
    );

    $row = 3;
    $index = 0;
    foreach($results['LOW_PRESSURE_CASTING']['LP HEAD'] as $item) {
        $excel_row = $row + $index;
        $objPHPExcel->getActiveSheet()
            ->setCellValue('B'.$excel_row, strval($item['value']));
        $index ++;
    }

    $index = 0;
    $row = 3;
    foreach($results['HIGH_PRESSURE_CASTING']['HP BLOCK'] as $item) {
        $excel_row = $row + $index;
        $objPHPExcel->getActiveSheet()
            ->setCellValue('E'.$excel_row, strval($item['value']));
        $index ++;
    }

    $objPHPExcel->getActiveSheet()
        ->setCellValue('C3', 'EDM1')
        ->setCellValue('D3', 'EDM4')
        ->setCellValue('C5', 'EDM2')
        ->setCellValue('D5', 'EDM5')
        ->setCellValue('C7', 'EDM3')
        ->setCellValue('D7', 'EDM6')
        ->setCellValue('F3', 'H1')
        ->setCellValue('G3', 'H2');

    $objPHPExcel->getActiveSheet()
        ->setCellValue('C4', strval($results['LOW_PRESSURE_CASTING']['EDM1']['value']))
        ->setCellValue('D4', strval($results['LOW_PRESSURE_CASTING']['EDM4']['value']))
        ->setCellValue('C6', strval($results['LOW_PRESSURE_CASTING']['EDM3']['value']))
        ->setCellValue('D6', strval($results['LOW_PRESSURE_CASTING']['EDM5']['value']))
        ->setCellValue('C8', strval($results['LOW_PRESSURE_CASTING']['EDM3']['value']))
        ->setCellValue('D8', strval($results['LOW_PRESSURE_CASTING']['EDM6']['value']))
        ->setCellValue('F4', strval($results['HIGH_PRESSURE_CASTING']['H1']['value']))
        ->setCellValue('G4', strval($results['HIGH_PRESSURE_CASTING']['H2']['value']));

    $objPHPExcel->getActiveSheet()->mergeCells('C2:D2');
    $objPHPExcel->getActiveSheet()->mergeCells('F2:G2');

    $excel_row = 2;
    foreach($results['SHIFT_PATTERN'] as $key => $item) {
        $objPHPExcel->getActiveSheet()
            ->setCellValue('H'.$excel_row, strval($key));
        $objPHPExcel->getActiveSheet()
            ->setCellValue('I'.$excel_row, strval($item['value']));
        $excel_row ++;
    }

    $objPHPExcel->getActiveSheet()->getStyle('A1:I13')->applyFromArray(
        array(
            'borders' => array(
                'allborders' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            )
        )
    );
}


$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(17);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(17);




$objPHPExcel->getActiveSheet()->setTitle($title);

header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$fileName.'"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
