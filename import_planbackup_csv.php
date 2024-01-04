<?php
require_once ("db_config.php");
require_once ("functions.php");
if ($_FILES["plan_csv"]["error"] > 0)
{
    echo $_FILES["plan_csv"]["error"];
}
else
{
    $upload = move_uploaded_file($_FILES["plan_csv"]["tmp_name"],"csv/shift_plan.csv");
    if($upload) {
        $file = fopen("csv/shift_plan.csv", "r");
        if($file) {
            $res = true;
            $i = 0;
            //Default index for each machine
            $all_machines = array_merge($g_andon, $g_machines);

            $plan_dates = array();

            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
            {
                if($i == 0) {
                    foreach ($getData as $index => $plan_date){
                        if($index % 3 == 2)
                            array_push($plan_dates, $plan_date);
                    }
                }

                else {
                    if($i % 3 == 1) {
                        $machine = $getData[0];
                        $plan_name = 'ot_plan';
                    } else if($i % 3 == 2) {
                        $plan_name = 'opr';
                    } else {
                        $plan_name = 'shift_plan';
                    }

                    foreach ($getData as $index => $data){
                        if($index > 1 ) {
                            $plan_date_index = (int) (($index -2) / 3);
                            if($index % 3 == 2) {
                                $shift = 'shift1';
                            } else if($index % 3 == 0) {
                                $shift = 'shift2';
                            } else {
                                $shift = 'shift3';
                            }
                            if(isset($plan_dates[$plan_date_index]))
                                set_shift_plan($plan_dates[$plan_date_index], $shift, $machine, $data, $plan_name);
                            else {
                                if(count($plan_dates) > 0 && $plan_date_index > 0)
                                    set_shift_plan($plan_dates[$plan_date_index - 1], $shift, $machine, $data, $plan_name);
                            }
                        }
                    }
                }
                $i++;
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