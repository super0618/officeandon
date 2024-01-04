<?php
require_once ("db_config.php");
require_once ("functions.php");

if ($_FILES["opr_csv"]["error"] > 0)
{
    echo $_FILES["opr_csv"]["error"];
}
else
{
    $upload = move_uploaded_file($_FILES["opr_csv"]["tmp_name"],"csv/opr.csv");
    if($upload) {
        $file = fopen("csv/opr.csv", "r");
        if($file) {
            $res = true;
            $i = 0;
            //Default index for each machine
            $all_machines = array_merge($g_andon, $g_machines);
            $assy_index = 0;
            $short_block_index = 1;
            $head_sub_index = 2;
            $cam_hsg_index = 3;
            $crank_index = 4;
            $block_index = 5;
            $head_index = 6;
            $housing_index = 7;
            $rod_index = 8;
            $cam_index = 9;
            while (($getData = fgetcsv($file, 10000, ",")) !== FALSE)
            {
                if($i == 0) {
                    foreach ($getData as $index => $machine){
                        if($machine != "") {
                            switch ($machine) {
                                case "ASSY": $assy_index = $index; break;
                                case "SHORT BLOCK": $short_block_index = $index; break;
                                case "HEAD SUB": $head_sub_index = $index; break;
                                case "CAM HSG": $cam_hsg_index = $index; break;
                                case "CRANK": $crank_index = $index; break;
                                case "BLOCK": $block_index = $index; break;
                                case "HEAD": $head_index = $index; break;
                                case "HOUSING": $housing_index = $index; break;
                                case "ROD": $rod_index = $index; break;
                                case "CAM": $cam_index = $index; break;
                            }
                        }
                    }
                }
                if($i > 0) {
                    $assy = $getData[$assy_index];
                    $short_block = $getData[$short_block_index];
                    $head_sub = $getData[$head_sub_index];
                    $cam_hsg = $getData[$cam_hsg_index];
                    $crank = $getData[$crank_index];
                    $block = $getData[$block_index];
                    $head = $getData[$head_index];
                    $housing = $getData[$housing_index];
                    $rod = $getData[$rod_index];
                    $cam = $getData[$cam_index];
                    foreach ($all_machines as $mc){
                        switch ($mc) {
                            case "ASSY": $opr = $assy; break;
                            case "SHORT BLOCK": $opr = $short_block; break;
                            case "HEAD SUB": $opr = $head_sub; break;
                            case "CAM HSG": $opr = $cam_hsg; break;
                            case "CRANK": $opr = $crank; break;
                            case "BLOCK": $opr = $block; break;
                            case "HEAD": $opr = $head; break;
                            case "HOUSING": $opr = $housing; break;
                            case "ROD": $opr = $rod; break;
                            case "CAM": $opr = $cam; break;
                            default: $opr = 0; break;
                        }
                        $res = set_opr_time_set($mc, $opr);
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