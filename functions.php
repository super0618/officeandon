<?php
function convert_date_string($date)
{
    if(strpos($date, "/")){
        $string = explode("/", $date);
        return $string[2] . '-' . $string[1] . '-' . $string[0];
    }
    else {
        $string = explode("-", $date);
        return $string[2] . '/' . $string[1] . '/' . $string[0];
    }
}

function make_time_string($time)
{
    if (strlen($time) < 5) {
        $time = "0" . $time;
    }
    return $time;
}

function get_setting($set_type)
{
    global $db, $tblSettings;
    $query = "SELECT * FROM {$tblSettings} WHERE set_type = '{$set_type}' limit 1";
    $result = $db->query($query);
    if($result && mysqli_num_rows($result) > 0) {
        $setting = mysqli_fetch_object($result);
        return $setting->set_value;
    } else {
        return null;
    }
}

function update_setting($set_type, $set_value)
{
    global $db, $tblSettings;
    $old_setting = get_setting($set_type);
    if($old_setting != null)
        $sql = "UPDATE {$tblSettings} SET set_value = '{$set_value}' WHERE set_type = '{$set_type}'";
    else
        $sql = "INSERT INTO {$tblSettings} (set_value, set_type) VALUES ('{$set_value}', '{$set_type}')";

    return $db->query($sql);
}

function save_shift($post_data)
{
    $settings['shift1']['start'] = make_time_string($post_data['shift1_start']).":00";
    $settings['shift1']['end'] = make_time_string($post_data['shift1_end']).":00";

    $settings['shift2']['start'] = make_time_string($post_data['shift2_start']).":00";
    $settings['shift2']['end'] = make_time_string($post_data['shift2_end']).":00";

    $settings['shift3']['start'] = make_time_string($post_data['shift3_start']).":00";
    $settings['shift3']['end'] = make_time_string($post_data['shift3_end']).":00";

    for($i=0; $i<4; $i++) {
        $index = $i + 1;
        $settings['shift1']['breaks']['start'.$index] = make_time_string($post_data['shift1_break_start'][$i]).":00";
        $settings['shift1']['breaks']['end'.$index] = make_time_string($post_data['shift1_break_end'][$i]).":00";

        $settings['shift2']['breaks']['start'.$index] = make_time_string($post_data['shift2_break_start'][$i]).":00";
        $settings['shift2']['breaks']['end'.$index] = make_time_string($post_data['shift2_break_end'][$i]).":00";

        $settings['shift3']['breaks']['start'.$index] = make_time_string($post_data['shift3_break_start'][$i]).":00";
        $settings['shift3']['breaks']['end'.$index] = make_time_string($post_data['shift3_break_end'][$i]).":00";
    }

    $shift_setting = json_encode($settings, true);

    $set_type = $post_data['set_type'];
    $result = update_setting($set_type, $shift_setting);

    if($result)
        echo "OK";
    else
        echo "FAIL";
    exit;
}

function save_tag_setting($post_data)
{
    global $db, $tblTagSettings, $current;
    $table_name = $post_data['table_name'];
    $machine = $post_data['machine'];
    $field_name = $post_data['field_name'];
    $value = $post_data['value'];
    $shift = get_live_shift($machine);
    $live_shift = $shift['shift'];
    $live_date = $shift['date'];
    if($field_name == "shift_plan" || $field_name == "ot_plan"  || $field_name == "opr") {
        if(isset($post_data['g_shift']) && isset($post_data['g_date'])){
            $plan_date = date('d-M', strtotime($live_date));
        } else {
            $plan_date = date('d-M', strtotime($live_date));
        }
        set_shift_plan($plan_date, $live_shift, $machine, $value, $field_name);
    }
    //Check setting
    $query = "SELECT id FROM {$tblTagSettings} WHERE `table_name` = '{$table_name}' AND `machine` = '{$machine}'";
    $result = $db->query($query);
    $row = mysqli_fetch_object($result);
    if($row) {
        if(strpos($field_name, '_tag') !== false)
            $sql = "UPDATE {$tblTagSettings} SET `{$field_name}` = '{$value}' WHERE id = '{$row->id}'";
        else {
            if(empty($value))
                $sql = "UPDATE {$tblTagSettings} SET `{$field_name}` = NULL WHERE id = '{$row->id}'";
            else
                $sql = "UPDATE {$tblTagSettings} SET `{$field_name}` = {$value} WHERE id = '{$row->id}'";
        }

    } else {
        if(strpos($field_name, '_tag') !== false)
            $sql = "INSERT INTO {$tblTagSettings} (`table_name`, `machine`, `{$field_name}`) VALUES ('{$table_name}', '{$machine}', '{$value}')";
        else {
            if(empty($value))
                $sql = "INSERT INTO {$tblTagSettings} (`table_name`, `machine`, `{$field_name}`) VALUES ('{$table_name}', '{$machine}', NULL)";
            else
                $sql = "INSERT INTO {$tblTagSettings} (`table_name`, `machine`, `{$field_name}`) VALUES ('{$table_name}', '{$machine}', {$value})";
        }
    }

    $result = $db->query($sql);
    if($result)
        echo "OK";
    else
        echo "FAIL";
    exit;
}

function get_tag_setting($table_name, $machine, $field=null)
{
    global $db, $tblTagSettings;
    if($field == null) {
        $query = "SELECT * FROM {$tblTagSettings} WHERE `table_name` = '{$table_name}' AND `machine` = '{$machine}'";
        $result = $db->query($query);
        $row = mysqli_fetch_array($result);
        if($row) {
            return $row;
        } else {
            return null;
        }
    } else {
        $query = "SELECT `{$field}` FROM {$tblTagSettings} WHERE `table_name` = '{$table_name}' AND `machine` = '{$machine}'";
        $result = $db->query($query);
        $row = mysqli_fetch_array($result);
        if($row) {
            return $row[$field];
        } else {
            return '';
        }
    }
}

function get_shift($datetime, $shift_pattern)
{
    $datetime_arr = explode(" ", $datetime);
    $date = $datetime_arr[0];
    $week_day = date('N', strtotime($date));
    $next_date = date("Y-m-d", strtotime("+1 days", strtotime($date)));
    $pre_date = date("Y-m-d", strtotime("-1 days", strtotime($date)));

    $shift_settings = get_setting($shift_pattern);

    if($shift_settings != null)
        $shifts = json_decode($shift_settings, true);
    else{
        $string = file_get_contents("./shift.json");
        $shifts = json_decode($string, true);
    }

    if($shift_pattern == 'shift2') {
        if($week_day == 5) { //Friday
            if ($datetime < $date . " " . $shifts['shift1']['start']) {
                $shift['shift'] = "shift2";
                $shift['date'] = $pre_date;
                $shift['start'] = $pre_date. " ". $shifts['shift3']['start'];
                $shift['end'] = $date. " ". $shifts['shift3']['end'];
            } else if ($datetime >= $date . " " . $shifts['shift1']['start'] && $datetime < $date . " " . $shifts['shift3']['start']) {
                $shift['shift'] = "shift1";
                $shift['date'] = $date;
                $shift['start'] = $date. " ". $shifts['shift1']['start'];
                $shift['end'] = $date. " ". $shifts['shift1']['end'];
            } else {
                $shift['shift'] = "shift2";
                $shift['date'] = $date;
                $shift['start'] = $date. " ". $shifts['shift3']['start'];
                $shift['end'] = $next_date. " ". $shifts['shift3']['end'];
            }
        } else {
            if ($datetime < $date . " " . $shifts['shift1']['start']) {
                $shift['shift'] = "shift2";
                $shift['date'] = $pre_date;
                $shift['start'] = $pre_date. " ". $shifts['shift2']['start'];
                $shift['end'] = $date. " ". $shifts['shift2']['end'];
            } else if ($datetime >= $date . " " . $shifts['shift1']['start'] && $datetime < $date . " " . $shifts['shift2']['start']) {
                $shift['shift'] = "shift1";
                $shift['date'] = $date;
                $shift['start'] = $date. " ". $shifts['shift1']['start'];
                $shift['end'] = $date. " ". $shifts['shift1']['end'];
            } else {
                $shift['shift'] = "shift2";
                $shift['date'] = $date;
                $shift['start'] = $date. " ". $shifts['shift2']['start'];
                $shift['end'] = $next_date. " ". $shifts['shift2']['end'];
            }
        }
    } else {
        if ($datetime < $date . " " . $shifts['shift1']['start']) {
            $shift['shift'] = "shift3";
            $shift['date'] = $pre_date;
            $shift['start'] = $pre_date. " ". $shifts['shift3']['start'];
            $shift['end'] = $date. " ". $shifts['shift3']['end'];
        } else if ($datetime >= $date . " " . $shifts['shift1']['start'] && $datetime < $date . " " . $shifts['shift2']['start']) {
            $shift['shift'] = "shift1";
            $shift['date'] = $date;
            $shift['start'] = $date. " ". $shifts['shift1']['start'];
            $shift['end'] = $date. " ". $shifts['shift1']['end'];
        } else if ($datetime >= $date . " " . $shifts['shift2']['start'] && $datetime < $date . " " . $shifts['shift3']['start']) {
            $shift['shift'] = "shift2";
            $shift['date'] = $date;
            $shift['start'] = $date. " ". $shifts['shift2']['start'];
            $shift['end'] = $date. " ". $shifts['shift2']['end'];
        } else {
            $shift['shift'] = "shift3";
            $shift['date'] = $date;
            $shift['start'] = $date. " ". $shifts['shift3']['start'];
            $shift['end'] = $next_date. " ". $shifts['shift3']['end'];
        }
    }

    return $shift;
}

function get_live_shift($machine)
{
    global $current;
    $shift_pattern = get_setting($machine . ' shift pattern');
    if($shift_pattern == null)
        $shift_pattern = 'shift2';
    return get_shift($current, $shift_pattern);
}

function get_shift_by_date($date, $shift, $shift_pattern)
{
    $week_day = date('N', strtotime($date));
    if($week_day == 5)
        $shift_settings = get_setting($shift_pattern);
    else
        $shift_settings = get_setting($shift_pattern);

    if($shift_settings != null)
        $shifts = json_decode($shift_settings, true);
    else{
        $string = file_get_contents("./shift.json");
        $shifts = json_decode($string, true);
    }

    $shift_info['shift'] = $shift;
    $shift_info['date'] = $date;
    $shift_info['start'] = $date . ' ' . $shifts[$shift]['start'];
    $shift_info['end'] = $date . ' ' . $shifts[$shift]['end'];
    if($shift_info['end'] < $shift_info['start'])
        $shift_info['end'] = date('Y-m-d H:i:s' , strtotime("+1 day", strtotime($shift_info['end'])));
    return $shift_info;
}

function chk_history($date, $shift, $page)
{
    global $db, $tblHistory;
    $query = "SELECT * FROM {$tblHistory} WHERE `history_date` = '{$date}' AND `shift` = '{$shift}' AND `page` = '{$page}'";
    $result = $db->query($query);
    if(mysqli_num_rows($result) > 0) {
        $history = mysqli_fetch_object($result);
        return $history->id;
    }
    else
        return 0;
}

function make_history($date, $shift, $page)
{
    global $db, $tblHistory;
    $data = get_main_data($page, $date, $shift);
    $history = json_encode($data, true);
    $history_id = chk_history($date, $shift, $page);
    if($history_id == 0)
        $query = "INSERT INTO {$tblHistory} (`history_date`, `shift`, `page`, `data`) VALUES ('{$date}', '{$shift}', '{$page}', '{$history}')";
    else
        $query = "UPDATE {$tblHistory} SET `data` = '{$history}' WHERE id = {$history_id}";
    $db->query($query);
    return $data;
}

function read_history($date, $shift, $page)
{
    global $db, $tblHistory;
    $chk = chk_history($date, $shift, $page);
    if($chk > 0 && $date < date("Y-m-d", strtotime("-1 days"))) {
        $query = "SELECT * FROM {$tblHistory} WHERE `history_date` = '{$date}' AND `shift` = '{$shift}' AND `page` = '{$page}'";
        $result = $db->query($query);
        $d = mysqli_fetch_array($result);
        $data = json_decode($d['data'], true);
    } else {
        $data = make_history($date, $shift, $page);
    }
    return $data;
}

function get_main_data($page, $shift_date = null, $shift = null)
{
    global $current, $g_items, $g_andon, $g_machines, $g_shift_patterns;
    global $db, $tblLive, $tblTargetStop;

    if($page == "live1"){
        //$tables = array('ASSEMBLY', 'MACHINING', 'Period_Cumulative');
        $tables = array('ASSEMBLY', 'MACHINING');
    } else{
        $tables = array('LOW_PRESSURE_CASTING', 'HIGH_PRESSURE_CASTING', 'SHIFT_PATTERN');
        $shift_stop_tag = get_setting("casting_shift_stop_tag");
    }
    $data = array();

    foreach ($tables as $table) {
        if($table == 'ASSEMBLY')
        {
            $machines = $g_andon;
            $shift_stop_tag = get_setting("assembly_shift_stop_tag");
        }
        else if($table == 'MACHINING')
        {
            $machines = $g_machines;
            $shift_stop_tag = get_setting("machining_shift_stop_tag");
        }
        /*else if($table == 'Period_Cumulative')
            $machines = $g_period_cumulative;*/
        else if($table == "SHIFT_PATTERN")
            $machines = $g_shift_patterns;
        else if($table == 'LOW_PRESSURE_CASTING')
            $machines = array('LP HEAD');
        else
            $machines = array('HP BLOCK');

        $query = "SELECT value from live where name = '{$shift_stop_tag}' order by `timestamp` desc limit 1" ;
        $res = $db->query($query);
        if(mysqli_num_rows($res) > 0) {
            $shift_stop_tag_res = mysqli_fetch_object($res);
            $data[$table]['shift_stop'] = $shift_stop_tag_res->value;
        } else {
            $data[$table]['shift_stop'] = 0;
        }

        foreach ($machines as $machine) {
            //Get tag setting for table and machine
            $settings = get_tag_setting($table, $machine);
            if(isset($settings['opr']))
                $opr = $settings['opr'];
            else
                $opr = 50;

            // Get Shift Information
            if($shift_date == null && $shift == null){
                if($table == 'ASSEMBLY' || $table == 'MACHINING') {
                    $shift_info = get_live_shift($machine);
                } else if($table == 'LOW_PRESSURE_CASTING') {
                    $shift_info = get_live_shift('LOW PRESSURE CASTING');
                } else if($table == 'HIGH_PRESSURE_CASTING') {
                    $shift_info = get_live_shift('HIGH PRESSURE CASTING');
                } else {
                    $shift_info = get_shift($current, 'shift2');
                }
            } else {
                $shift_pattern = get_setting($machine . ' shift pattern');
                if($shift_pattern == null)
                    $shift_pattern = 'shift2';
                $shift_info = get_shift_by_date($shift_date, $shift, $shift_pattern);
            }

            $start_time = $shift_info['start'];
            $end_time = $shift_info['end'];

            //Get shift line stop finish tag value
            if($table == 'ASSEMBLY') {
                $finish_tag = get_tag_setting("ASSEMBLY", $machine, 'shift_line_stop_finish_tag');
                $stop_tag = get_tag_setting("ASSEMBLY", $machine, 'shift_line_stop_tag');
                $data[$table][$machine]['shift_line_stop_finish']['value'] = get_actual_value($finish_tag, $start_time, $end_time);
                $data[$table][$machine]['shift_line_stop_start']['value'] = get_actual_value($stop_tag, $start_time, $end_time);
            }

            //Get target stop value
            $target_stopped = false;
            $target_stopped_value = 0;
            $target_query = "SELECT * FROM {$tblTargetStop} WHERE `table_name` = '{$table}' AND `machine` = '{$machine}' AND `stop_time` BETWEEN '{$start_time}' AND '{$end_time}'";
            $target_res = $db->query($target_query);
            if(mysqli_num_rows($target_res) > 0) {
                $target_stopped = true;
                $target_s = mysqli_fetch_array($target_res);
                $target_stopped_value = $target_s['value'];
            }

            if($table != 'Period_Cumulative' && $table != 'SHIFT_PATTERN') {
                $tags = array();
                foreach($g_items as $item){
                    $value_name = str_replace(" +/-", "", $item);
                    $value_name = str_replace("/", "", $value_name);
                    $value_name = str_replace(" ", "_", strtolower($value_name));

                    $data[$table][$machine][$value_name]['value'] = 0;
                    $data[$table][$machine][$value_name]['style'] = '';

                    if($value_name == 'shift_plan' || $value_name == 'ot_plan') {
                        $plan_shift = $shift_info['shift'];
                        $plan_date = $shift_info['date'];
                        $plan_date = date('d-M', strtotime($plan_date));
                        if($machine == "LP HEAD") $data[$table][$machine][$value_name]['value'] = get_shift_plan($plan_date, $plan_shift, "L/P CAST", $value_name);
                        else if($machine == "HP BLOCK") $data[$table][$machine][$value_name]['value'] = get_shift_plan($plan_date, $plan_shift, "HP CAST", $value_name);
                        else $data[$table][$machine][$value_name]['value'] = get_shift_plan($plan_date, $plan_shift, $machine, $value_name);
                        if($value_name == 'ot_plan') $ot_plan = $data[$table][$machine][$value_name]['value'];
                    }
                    
                    if( $value_name == 'actual' ||
                        $value_name == 'shift_line_stop' ||
                        $value_name == 'shift_opr_in' ||
                        $value_name == 'shift_opr_out' ||
                        //$value_name == 'ot_plan' ||
                        $value_name == 'ot_call'
                    ) {
                        $tag_field = $value_name.'_tag';
                        if(isset($settings[$tag_field]) && !empty($settings[$tag_field])) {
                            if($value_name == 'shift_line_stop') {
                                //Fault Tag
                                $fault_tag = $value_name."_fault_tag";
                                $line_stop_fault_tags = explode(",", $settings[$fault_tag]);
                                foreach ($line_stop_fault_tags as $line_stop_fault_tag_tag)
                                    array_push($tags, $line_stop_fault_tag_tag);
                            }
                            else
                                array_push($tags, $settings[$tag_field]);
                        }
                    }
                }
                $ot_call_tag = $settings['ot_call_tag'];
                $query = "SELECT `name`, MAX(`value`) as value FROM {$tblLive} WHERE `name` = '{$ot_call_tag}' AND `timestamp` >= '{$start_time}' AND `timestamp` <= '{$end_time}'";
                $result = $db->query($query);
                while($row=mysqli_fetch_object($result)) {
                    if( $row->value > $ot_plan) $ot_plan = $row->value;
                }
                $end_time = date('Y-m-d H:i:s', strtotime("+".$ot_plan." minutes", strtotime($end_time)));
                //Get Tag values from live table
                if(count($tags) > 0) {
                    $names = join("','",$tags);
                    $query = "SELECT `name`, MAX(`value`) as value FROM {$tblLive} WHERE `name` IN ('$names') AND `timestamp` >= '{$start_time}' AND `timestamp` <= '{$end_time}' GROUP BY `name`";
                    $result = $db->query($query);
                    while($row=mysqli_fetch_object($result)) {
                        $value = $row->value;
                        $red_value = '';
                        $yellow_value = '';
                        // if($row->name == "ot_call_tag" && $row->value > $ot_plan) $ot_plan = $row->value;
                        if(isset($settings['actual_tag']) && $row->name == $settings['actual_tag']) {
                            if($table == 'MACHINING' && $machine == 'ROD') {
                                $value = round($value / 4);
                            }

                            if($table == 'MACHINING' && $machine == 'CAM') {
                                $value = round($value / 2);
                            }

                            $data[$table][$machine]['actual']['value'] = $value;
                            if(isset($settings['actual_red']))
                                $red_value = $settings['actual_red'];
                            if(isset($settings['actual_yellow']))
                                $yellow_value = $settings['actual_yellow'];
                            if(!empty($yellow_value) && !empty($red_value)) {
                                $data[$table][$machine]['actual']['style'] = get_td_style($value, $red_value, $yellow_value);
                            }
                        }

                        //Line Stop Fault Tags
                        if(isset($line_stop_fault_tags) && !empty($line_stop_fault_tags) && in_array($row->name, $line_stop_fault_tags) ) {
                            if(isset($data[$table][$machine]['shift_line_stop']['value']))
                                $data[$table][$machine]['shift_line_stop']['value'] += $value;
                            else
                                $data[$table][$machine]['shift_line_stop']['value'] = $value;

                            if(isset($settings['shift_line_stop_red']))
                                $red_value = $settings['shift_line_stop_red'];
                            if(isset($settings['shift_line_stop_yellow']))
                                $yellow_value = $settings['shift_line_stop_yellow'];
                            if(!empty($yellow_value) && !empty($red_value)) {
                                $data[$table][$machine]['shift_line_stop']['style'] = get_td_style($value, $red_value, $yellow_value);
                            }
                        }

                        if(isset($settings['shift_opr_in_tag']) && $row->name == $settings['shift_opr_in_tag']) {
                            $data[$table][$machine]['shift_opr_in']['value'] = $value;
                            if(isset($settings['shift_opr_in_red']))
                                $red_value = $settings['shift_opr_in_red'];
                            if(isset($settings['shift_opr_in_yellow']))
                                $yellow_value = $settings['shift_opr_in_yellow'];
                            if(!empty($yellow_value) && !empty($red_value)) {
                                $data[$table][$machine]['shift_opr_in']['style'] = get_td_style($value, $red_value, $yellow_value);
                            }
                        }

                        if(isset($settings['shift_opr_out_tag']) && $row->name == $settings['shift_opr_out_tag']) {
                            $data[$table][$machine]['shift_opr_out']['value'] = $value;
                            if(isset($settings['shift_opr_out_red']))
                                $red_value = $settings['shift_opr_out_red'];
                            if(isset($settings['shift_opr_out_yellow']))
                                $yellow_value = $settings['shift_opr_out_yellow'];
                            if(!empty($yellow_value) && !empty($red_value)) {
                                $data[$table][$machine]['shift_opr_out']['style'] = get_td_style($value, $red_value, $yellow_value);
                            }
                        }

                        if(isset($settings['ot_plan_tag']) && $row->name == $settings['ot_plan_tag']) {
                            $data[$table][$machine]['ot_plan']['value'] = $value;
                            if(isset($settings['ot_plan_red']))
                                $red_value = $settings['ot_plan_red'];
                            if(isset($settings['ot_plan_yellow']))
                                $yellow_value = $settings['ot_plan_yellow'];
                            if(!empty($yellow_value) && !empty($red_value)) {
                                $data[$table][$machine]['ot_plan']['style'] = get_td_style($value, $red_value, $yellow_value);
                            }
                        }

                        if(isset($settings['ot_call_tag']) && $row->name == $settings['ot_call_tag']) {
                            $data[$table][$machine]['ot_call']['value'] = $value;
                            if(isset($settings['ot_call_red']))
                                $red_value = $settings['ot_call_red'];
                            if(isset($settings['ot_call_yellow']))
                                $yellow_value = $settings['ot_call_yellow'];
                            if(!empty($yellow_value) && !empty($red_value)) {
                                $data[$table][$machine]['ot_call']['style'] = get_td_style($value, $red_value, $yellow_value);
                            }
                        }
                    }
                }
                //Convert shift line stop to min:sec
                $line_stop_val = $data[$table][$machine]['shift_line_stop']['value'];
                $hour = (int) ($line_stop_val / 60);
                $min = $line_stop_val % 60;
                if($hour < 10)
                    $hour = '0'.$hour;
                if($min < 10)
                    $min = '0'.$min;
                $data[$table][$machine]['shift_line_stop']['value'] = $hour . ':'. $min;

                // Target with just Takt
                if ($end_time > $current)
                    $target_time = $current;
                else
                    $target_time = $end_time;
                $data[$table][$machine]['target']['value'] = get_target($opr, $start_time, $target_time, $shift_info, $machine);

                if($target_stopped == false) {
                    //Get Target
                    if ($end_time > $current)
                        $target_time = $current;
                    else
                        $target_time = $end_time;

                    $value = get_target($opr, $start_time, $target_time, $shift_info, $machine);
                    //Check actual and plan
                    if($data[$table][$machine]['actual']['value'] >= $data[$table][$machine]['shift_plan']['value']) {
                        if($value > $data[$table][$machine]['shift_plan']['value'])
                            $data[$table][$machine]['target']['value'] = $data[$table][$machine]['shift_plan']['value'];
                        else
                            $data[$table][$machine]['target']['value'] = $value;
                        //Stop Target count
                        if($end_time < $current)
                            $stop_time = $end_time;
                        else
                            $stop_time = $current;
                        if($data[$table][$machine]['target']['value'] > 0) {
                            $target_stop_query = "INSERT INTO {$tblTargetStop} (`value`, `stop_time`, `table_name`, `machine`) VALUES ('{$data[$table][$machine]['target']['value']}', '{$stop_time}', '{$table}', '{$machine}')";
                            $db->query($target_stop_query);
                        }
                    } else {
                        $data[$table][$machine]['target']['value'] = $value;
                    }
                } else {
                    $data[$table][$machine]['target']['value'] = $target_stopped_value;
                }

                if($table == 'ASSEMBLY' || $table == 'MACHINING') {
                    $target_opr = get_tag_setting($table, $machine, 'target');
                    if($target_opr == "")
                        $target_opr = 1;
                    else
                        $target_opr = $target_opr / 100;
                    $data[$table][$machine]['target']['value'] = round($data[$table][$machine]['target']['value'] * $target_opr);
                }

                $red_value = '';
                $yellow_value = '';
                if(isset($settings['target_red']))
                    $red_value = $settings['target_red'];
                if(isset($settings['target_yellow']))
                    $yellow_value = $settings['target_yellow'];
                if(!empty($yellow_value) && !empty($red_value)) {
                    $data[$table][$machine]['target']['style'] = get_td_style($data[$table][$machine]['target']['value'], $red_value, $yellow_value);
                }

                //Get Live +/-
                if(isset($data[$table][$machine]['target']['value']) && isset($data[$table][$machine]['actual']['value'])) {
                    $value =  $data[$table][$machine]['actual']['value'] - $data[$table][$machine]['target']['value'];
                    $data[$table][$machine]['live']['value'] = $value;
                    $red_value = '';
                    $yellow_value = '';
                    if(isset($settings['live_red']))
                        $red_value = $settings['live_red'];
                    if(isset($settings['live_yellow']))
                        $yellow_value = $settings['live_yellow'];
                    if(!empty($yellow_value) && !empty($red_value)) {
                        $data[$table][$machine]['live']['style'] = get_td_style($value, $red_value, $yellow_value);
                    }
                }

                //Get Last Hour OPR
                if($end_time < $current)
                    $last_end = $end_time;
                else
                    $last_end = $current;
                $last_start_time = date('Y-m-d H:i:s', strtotime("-1 hour", strtotime($last_end)));
                if($last_start_time < $start_time)
                    $last_start_time = $start_time;
                $last_hour_target = get_target($opr, $last_start_time, $last_end, $shift_info, $machine);

                if($table != "LOW_PRESSURE_CASTING" && $table != "HIGH_PRESSURE_CASTING") {
                    if(isset($settings['actual_tag']) && $last_hour_target != 0) {
                        $last_hour_actual = get_actual_value($settings['actual_tag'], $start_time, $last_start_time);
                        if($table == 'MACHINING' && $machine == 'ROD') {
                            $last_hour_actual = round($last_hour_actual / 4);
                        }

                        if($table == 'MACHINING' && $machine == 'CAM') {
                            $last_hour_actual = round($last_hour_actual / 2);
                        }
                        $last_hour_actual = $data[$table][$machine]['actual']['value'] - $last_hour_actual;
                        $last_hour_opr = round($last_hour_actual/$last_hour_target * 100, 1);
                    } else {
                        $last_hour_opr = 0;
                    }
                    $data[$table][$machine]['last_hour_opr']['value'] = $last_hour_opr;
                } else {
                    if($table == "LOW_PRESSURE_CASTING") {
                        $EDMs = array('EDM1', 'EDM2', 'EDM3', 'EDM4', 'EDM5', 'EDM6');
                    }
                    else {
                        $EDMs = array('H1', 'H2');
                    }

                    $actual = 0;
                    foreach ($EDMs as $EDM){
                        $data[$table][$EDM]['value'] = 0;
                        $settings = get_tag_setting($table, $EDM);
                        if(isset($settings['actual_tag']) && !empty($settings['actual_tag'])) {
                            $value = get_actual_value($settings['actual_tag'], $start_time, $end_time, true);
                            $data[$table][$EDM]['value'] = $value;
                            $actual += $value;

                            $tags = array();
                            $value_name = 'shift_line_stop';
                            $data[$table][$EDM]['shift_line_stop'] = 0;
                            $tag_field = $value_name.'_tag';
                            if(isset($settings[$tag_field]) && !empty($settings[$tag_field])) {
                                //Fault Tag
                                $fault_tag = $value_name."_fault_tag";
                                $line_stop_fault_tags = explode(",", $settings[$fault_tag]);
                                foreach ($line_stop_fault_tags as $line_stop_fault_tag_tag)
                                    array_push($tags, $line_stop_fault_tag_tag);
                            }

                            if(count($tags) > 0) {
                                $names = join("','",$tags);
                                $query = "SELECT `name`, MAX(`value`) as value FROM {$tblLive} WHERE `name` IN ('$names') GROUP BY `name`";
                                $result = $db->query($query);
                                while($row=mysqli_fetch_object($result)) {
                                    $value = $row->value;
                                    //Line Stop Fault Tags
                                    if(isset($line_stop_fault_tags) && !empty($line_stop_fault_tags) && in_array($row->name, $line_stop_fault_tags) ) {
                                        if(isset($data[$table][$EDM]['shift_line_stop']))
                                            $data[$table][$EDM]['shift_line_stop'] += $value;
                                        else
                                            $data[$table][$EDM]['shift_line_stop'] = $value;
                                    }
                                }
                            }

                            $line_stop_val = $data[$table][$EDM]['shift_line_stop'];
                            $hour = (int) ($line_stop_val / 60);
                            $min = $line_stop_val % 60;
                            if($hour < 10)
                                $hour = '0'.$hour;
                            if($min < 10)
                                $min = '0'.$min;
                            $data[$table][$EDM]['shift_line_stop'] = $hour . ':'. $min;
                        }
                    }

                    $data[$table][$machine]['actual']['value'] = $actual;
                    $data[$table][$machine]['live']['value'] = $actual - $data[$table][$machine]['target']['value'];

                    $red_value = '';
                    $yellow_value = '';
                    $head_settings = get_tag_setting($table, 'HEAD');
                    if(isset($head_settings['live_red']))
                        $red_value = $head_settings['live_red'];
                    if(isset($head_settings['live_yellow']))
                        $yellow_value = $head_settings['live_yellow'];
                    if(!empty($yellow_value) && !empty($red_value)) {
                        $data[$table][$machine]['live']['style'] = get_td_style($data[$table]['HEAD']['live']['value'], $red_value, $yellow_value);
                    }

                    $red_value = '';
                    $yellow_value = '';
                    if(isset($head_settings['actual_red']))
                        $red_value = $head_settings['actual_red'];
                    if(isset($head_settings['actual_yellow']))
                        $yellow_value = $head_settings['actual_yellow'];
                    if(!empty($yellow_value) && !empty($red_value)) {
                        $data[$table][$machine]['actual']['style'] = get_td_style($data[$table]['HEAD']['actual']['value'], $red_value, $yellow_value);
                    }

                    $last_hour_actual = 0;
                    foreach ($EDMs as $EDM){
                        $settings = get_tag_setting($table, $EDM);
                        if(isset($settings['actual_tag']) && !empty($settings['actual_tag'])) {
                            $value = get_actual_value($settings['actual_tag'], $start_time, $last_start_time, true);
                            $value = $data[$table][$EDM]['value'] - $value;
                            $last_hour_actual += $value;
                        }
                    }

                    if($last_hour_target != 0) {
                        $last_hour_opr = round($last_hour_actual/$last_hour_target * 100, 1);
                    } else {
                        $last_hour_opr = 0;
                    }
                    $data[$table][$machine]['last_hour_opr']['value'] = $last_hour_opr;
                }

                $settings = get_tag_setting($table, $machine);
                //Get last_hour_opr Shift OPR
                $red_value = '';
                $yellow_value = '';
                if(isset($settings['last_hour_opr_red']))
                    $red_value = $settings['last_hour_opr_red'];
                if(isset($settings['last_hour_opr_yellow']))
                    $yellow_value = $settings['last_hour_opr_yellow'];
                if(!empty($yellow_value) && !empty($red_value)) {
                    $data[$table][$machine]['last_hour_opr']['style'] = get_td_style($last_hour_opr, $red_value, $yellow_value);
                }

                //Get Shift OPR
                if(isset($data[$table][$machine]['live']['value']) && $data[$table][$machine]['live']['value'] == 0) {
                    $shift_opr = get_tag_setting($table, $machine, 'target');
                } else {
                    $target_opr_percentage = get_tag_setting($table, $machine, 'target');
                    if($target_opr_percentage == "") $target_opr_percentage = 100;
                    if($data[$table][$machine]['target']['value'] != 0) {
                        $shift_opr = round($data[$table][$machine]['actual']['value'] / $data[$table][$machine]['target']['value'] * $target_opr_percentage, 2);
                    }
                    else
                        $shift_opr = $target_opr_percentage;
                }
                /*if($data[$table][$machine]['target']['value'] != 0)
                    $shift_opr = round($data[$table][$machine]['actual']['value'] / $data[$table][$machine]['target']['value']  * 100,  2);
                else
                    $shift_opr = 100;*/
                $data[$table][$machine]['shift_opr']['value'] = $shift_opr;

                $red_value = '';
                $yellow_value = '';
                if(isset($settings['shift_opr_red']))
                    $red_value = $settings['shift_opr_red'];
                if(isset($settings['shift_opr_yellow']))
                    $yellow_value = $settings['shift_opr_yellow'];
                if(!empty($yellow_value) && !empty($red_value)) {
                    $data[$table][$machine]['shift_opr']['style'] = get_td_style($shift_opr, $red_value, $yellow_value);
                }
            } else {
                $data[$table][$machine]['value'] = 0;
                $data[$table][$machine]['style'] = '';
                $red_value = '';
                $yellow_value = '';
                if(isset($settings['actual_tag']) && !empty($settings['actual_tag'])) {
                    $actual_tag = $settings['actual_tag'];
                    $value = get_actual_value($actual_tag, $start_time, $end_time);
                    $data[$table][$machine]['value'] = $value;
                    if(isset($settings['actual_red']))
                        $red_value = $settings['actual_red'];
                    if(isset($settings['actual_yellow']))
                        $yellow_value = $settings['actual_yellow'];
                    if(!empty($yellow_value) && !empty($red_value)) {
                        $data[$table][$machine]['style'] = get_td_style($value, $red_value, $yellow_value);
                    }
                }
            }
        }
    }
    return $data;
}

function read_live_values($post_data)
{
    $page = $post_data['page'];
    $data = get_main_data($page);

    /*
     * Get page cycle
     */
    if($page == 'live1') {
        $page_cycle = get_first_page_cycle();
        if (!empty($page_cycle)) {
            $data['page_url'] = $page_cycle->page_url;
            $data['page_seconds'] = $page_cycle->seconds;
        } else {
            $data['page_url'] = '';
            $data['page_seconds'] = 0;
        }
    }
    echo json_encode($data, true);
}

function read_history_values($post_data)
{
    $page = $post_data['page'];
    $g_date = convert_date_string($post_data['date']);
    $g_shift = $post_data['shift'];
    $data = read_history($g_date, $g_shift, $page);
    echo json_encode($data, true);
}

function get_period_cumulative($post_data)
{
    global $current, $today, $g_period_cumulative;
    $period_start_date = get_setting('period_start_date');
    $period_end_date = get_setting('period_end_date');
    $data = array();
    $page = $post_data['page'];
    if($page == 'assembly') {
        $period_machines = ['ASSY'];
    } else if($page == 'machining') {
        $period_machines = ['CRANK', 'BLOCK', 'HEAD', 'HOUSING', 'ROD', 'CAM'];
    } else if($page == 'casting') {
        $period_machines = ['L/P CAST', 'HP CAST'];
    } else {
        $period_machines = $g_period_cumulative;
    }
    foreach ($period_machines as $machine) {
        $data[$machine]['actual'] = 0;
        $data[$machine]['plan_period'] = 0;
        $data[$machine]['plan_to_date'] = 0;
    }

    if(!empty($period_start_date))
        $star_date = convert_date_string($period_start_date);

    if(!empty($period_end_date))
        $end_date = convert_date_string($period_end_date);

    $shifts = array('shift1', 'shift2', 'shift3');
    if(isset($star_date) && isset($end_date) && $star_date < $end_date) {
        /*if($end_date > $today)
            $end_date = $today;*/
        while($star_date <= $end_date) {
            foreach ($period_machines as $machine) {
                $shift_pattern = get_setting($machine . " shift pattern");
                if($shift_pattern == null)
                    $shift_pattern = 'shift2';
                foreach ($shifts as $shift) {
                    if($shift <= $shift_pattern) {
                        if($machine == 'L/P CAST' || $machine == 'HP CAST') {
                            $page = 'live2';
                        } else {
                            $page = 'live1';
                        }
                        $shift_info = get_shift_by_date($star_date, $shift, $shift_pattern);
                        if($shift_info['start'] > $current) {
                            $actual = 0;
                            $plan_date = date('d-M', strtotime($star_date));
                            if($machine == 'L/P CAST') {
                                $shift_plan = get_shift_plan($plan_date, $shift, 'LP HEAD', 'shift_plan');
                            } else if($machine == 'HP CAST'){
                                $shift_plan = get_shift_plan($plan_date, $shift, 'HP BLOCK', 'shift_plan');
                            } else {
                                $shift_plan = get_shift_plan($plan_date, $shift, $machine, 'shift_plan');
                            }
                        } else {
                            $h_data = read_history($star_date, $shift, $page);
                            if($machine == 'L/P CAST') {
                                $actual = $h_data['LOW_PRESSURE_CASTING']['LP HEAD']['actual']['value'];
                                $shift_plan = $h_data['LOW_PRESSURE_CASTING']['LP HEAD']['shift_plan']['value'];
                            } else if($machine == 'HP CAST'){
                                $actual = $h_data['HIGH_PRESSURE_CASTING']['HP BLOCK']['actual']['value'];
                                $shift_plan = $h_data['HIGH_PRESSURE_CASTING']['HP BLOCK']['shift_plan']['value'];
                            } else if($machine == 'ASSY') {
                                $actual = $h_data['ASSEMBLY']['ASSY']['actual']['value'];
                                $shift_plan = $h_data['ASSEMBLY']['ASSY']['shift_plan']['value'];
                            } else {
                                $actual = $h_data['MACHINING'][$machine]['actual']['value'];
                                $shift_plan = $h_data['MACHINING'][$machine]['shift_plan']['value'];
                            }
                        }
                        $data[$machine]['actual'] += $actual;
                        $data[$machine]['plan_period'] += $shift_plan;
                        if($star_date <= $today)
                            $data[$machine]['plan_to_date'] += $shift_plan;
                    }
                }
            }
            $star_date = date('Y-m-d', strtotime("+1 day", strtotime($star_date)));
        }
    }

    echo json_encode($data);
}

function get_td_style($value, $red_value, $yellow_value, $sort='asc')
{
    if($sort == 'asc') {
        if($value <= $red_value)
            $style = 'red-td';
        else if($value > $red_value && $value <= $yellow_value)
            $style = 'yellow-td';
        else
            $style = 'green-td';
    } else {
        if($value < $yellow_value)
            $style = 'green-td';
        else if($value >= $yellow_value && $value < $red_value)
            $style = 'yellow-td';
        else
            $style = 'red-td';
    }
    return $style;
}

function get_target($opr, $start, $end, $shift_info, $machine)
{
    global $current;
    if($end > $current)
        $end = $current;

    $shift_pattern = get_setting($machine . ' shift pattern');
    if($shift_pattern == null)
        $shift_pattern = 'shift2';

    $total_past_time = strtotime($end) - strtotime($start);

    //Get shift setting
    $shift_settings = get_setting($shift_pattern);
    if($shift_settings != null)
        $shifts = json_decode($shift_settings, true);
    else{
        $string = file_get_contents("./shift.json");
        $shifts = json_decode($string, true);
    }

    $date = $shift_info['date'];
    $next_date = date("Y-m-d", strtotime("+1 days", strtotime($date)));
    $shift_kind = $shift_info['shift'];

    //Break Time
    $firstBreakStart = $date . " " . $shifts[$shift_kind]['breaks']['start1'];
    $firstBreakEnd = $date . " " . $shifts[$shift_kind]['breaks']['end1'];
    if($firstBreakEnd < $firstBreakStart)
        $firstBreakEnd = $next_date . " " . $shifts[$shift_kind]['breaks']['end1'];

    $secondBreakStart = $date . " " . $shifts[$shift_kind]['breaks']['start2'];
    if($secondBreakStart < $firstBreakEnd) {
        $secondBreakStart = $next_date . " " . $shifts[$shift_kind]['breaks']['start2'];
        $secondBreakEnd = $next_date . " " . $shifts[$shift_kind]['breaks']['end2'];
    } else {
        $secondBreakEnd = $date . " " . $shifts[$shift_kind]['breaks']['end2'];
    }

    if($secondBreakEnd < $secondBreakStart)
        $secondBreakEnd = $next_date . " " . $shifts[$shift_kind]['breaks']['end2'];

    $thirdBreakStart = $date . " " . $shifts[$shift_kind]['breaks']['start3'];
    if($thirdBreakStart < $secondBreakEnd) {
        $thirdBreakStart = $next_date . " " . $shifts[$shift_kind]['breaks']['start3'];
        $thirdBreakEnd = $next_date . " " . $shifts[$shift_kind]['breaks']['end3'];
    } else {
        $thirdBreakEnd = $date . " " . $shifts[$shift_kind]['breaks']['end3'];
    }

    if($thirdBreakEnd < $thirdBreakStart)
        $thirdBreakEnd = $next_date . " " . $shifts[$shift_kind]['breaks']['end3'];

    $fourthBreakStart = $date . " " . $shifts[$shift_kind]['breaks']['start4'];
    if($fourthBreakStart < $thirdBreakEnd) {
        $fourthBreakStart = $next_date . " " . $shifts[$shift_kind]['breaks']['start4'];
        $fourthBreakEnd = $next_date . " " . $shifts[$shift_kind]['breaks']['end4'];
    } else {
        $fourthBreakEnd = $date . " " . $shifts[$shift_kind]['breaks']['end4'];
    }

    if($fourthBreakEnd < $fourthBreakStart)
        $fourthBreakEnd = $next_date . " " . $shifts[$shift_kind]['breaks']['end4'];

    $total_break_time = 0;

    if($end > $firstBreakStart) {
        // First Break Start to End
        if($start < $firstBreakStart && $end < $firstBreakEnd)
            $total_break_time += strtotime($end) - strtotime($firstBreakStart);
        if($start > $firstBreakStart && $end < $firstBreakEnd)
            $total_break_time += strtotime($end) - strtotime($start);
        if($start< $firstBreakStart && $end > $firstBreakEnd)
            $total_break_time += strtotime($firstBreakEnd) - strtotime($firstBreakStart);

        // Second Break
        if($end > $secondBreakStart) {
            // First Break Start to End
            if($start < $secondBreakStart && $end < $secondBreakEnd)
                $total_break_time += strtotime($end) - strtotime($secondBreakStart);
            if($start > $secondBreakStart && $end < $secondBreakEnd)
                $total_break_time += strtotime($end) - strtotime($start);
            if($start< $secondBreakStart && $end > $secondBreakEnd)
                $total_break_time += strtotime($secondBreakEnd) - strtotime($secondBreakStart);

            // Third Break
            if($end > $thirdBreakStart) {
                // First Break Start to End
                if($start < $thirdBreakStart && $end < $thirdBreakEnd)
                    $total_break_time += strtotime($end) - strtotime($thirdBreakStart);
                if($start > $thirdBreakStart && $end < $thirdBreakEnd)
                    $total_break_time += strtotime($end) - strtotime($start);
                if($start< $thirdBreakStart && $end > $thirdBreakEnd)
                    $total_break_time += strtotime($thirdBreakEnd) - strtotime($thirdBreakStart);

                // Forth Break
                if($end > $fourthBreakStart) {
                    // First Break Start to End
                    if($start < $fourthBreakStart && $end < $fourthBreakEnd)
                        $total_break_time += strtotime($end) - strtotime($fourthBreakStart);
                    if($start > $fourthBreakStart && $end < $fourthBreakEnd)
                        $total_break_time += strtotime($end) - strtotime($start);
                    if($start< $fourthBreakStart && $end > $fourthBreakEnd)
                        $total_break_time += strtotime($fourthBreakEnd) - strtotime($fourthBreakStart);

                }
            }
        }
    }
    $total_opr_time = $total_past_time - $total_break_time;
    return round($total_opr_time / $opr);
}

function get_actual_value($tag, $start, $end, $emd = false)
{
    global $current, $db, $tblLive;
    if($emd == true) {
        //Previous shift value
        $pre_val = 0;
        $query = "SELECT `value` FROM {$tblLive} WHERE `name` = '{$tag}' AND `timestamp` >= '{$start}' ORDER BY `timestamp` ASC limit 1";
        $result = $db->query($query);
        $row = mysqli_fetch_object($result);
        if($row)
            $pre_val = $row->value;

        if($end > $current)
            $end = $current;

        $query = "SELECT `value` FROM {$tblLive} WHERE `name` = '{$tag}' AND `timestamp` >= '{$start}' AND `timestamp` <= '{$end}' ORDER BY `timestamp` DESC limit 1";
        $result = $db->query($query);
        $row = mysqli_fetch_object($result);
        if($row) {
            if ($row->value > $pre_val)
                $value = $row->value - $pre_val;
            else
                $value = $row->value;
            return $value;
        }
        else
            return 0;
    } else {
        $query = "SELECT `value` FROM {$tblLive} WHERE `name` = '{$tag}' AND `timestamp` >= '{$start}' AND `timestamp` <= '{$end}' ORDER BY `timestamp` DESC limit 1";
        $result = $db->query($query);
        $row = mysqli_fetch_object($result);
        if($row)
            return $row->value;
        else
            return 0;
    }
}

function get_shift_plan($plan_date, $shift, $machine, $value_name)
{
    global $db, $tblShiftPlan;
    $check_query = "SELECT * FROM {$tblShiftPlan} WHERE `plan_date` ='{$plan_date}' AND `machine` = '{$machine}' AND `shift` = '{$shift}'";
    $check_result = $db->query($check_query);
    $check = mysqli_num_rows($check_result);
    $plan = 0;
    if($check > 0) {
        $p = mysqli_fetch_object($check_result);
        if($value_name == 'shift_plan')
            $plan = $p->shift_plan;
        else if($value_name == 'ot_plan')
            $plan = $p->ot_plan;
        else
            $plan = $p->opr;
    }
    return $plan;
}

function set_shift_plan($plan_date, $shift, $machine, $plan, $plan_name)
{
    global $db, $tblShiftPlan;
    if($machine == 'ASSY') {
        $machines = array(
            'ASSY',
            'SHORT BLOCK',
            'HEAD SUB',
            'CAM HSG',
        );
    } else {
        $machines = array($machine);
    }

    foreach ($machines as $r_machine) {
        $check_query = "SELECT * FROM {$tblShiftPlan} WHERE `plan_date` ='{$plan_date}' AND `machine` = '{$r_machine}' AND `shift` = '{$shift}'";
        $check_result = $db->query($check_query);
        $check = mysqli_num_rows($check_result);
        if($check == 0) {
            if($plan_name == 'shift_plan')
                $sql = "INSERT INTO {$tblShiftPlan} (`plan_date`,`shift_plan`, `ot_plan`, `opr`, `shift`, `machine`) 
                            VALUES ('{$plan_date}', '{$plan}', 0, 0, '{$shift}', '{$r_machine}')";
            else if($plan_name == 'ot_plan')
                $sql = "INSERT INTO {$tblShiftPlan} (`plan_date`,`shift_plan`, `ot_plan`, `opr`, `shift`, `machine`) 
                            VALUES ('{$plan_date}', 0, '{$plan}', 0, '{$shift}', '{$r_machine}')";
            else
                $sql = "INSERT INTO {$tblShiftPlan} (`plan_date`,`shift_plan`, `ot_plan`, `opr`, `shift`, `machine`) 
                            VALUES ('{$plan_date}', 0, 0, '{$plan}', '{$shift}', '{$r_machine}')";

            $res = $db->query($sql);
        } else {
            if($plan_name == 'shift_plan')
                $sql = "UPDATE {$tblShiftPlan} SET `shift_plan` = '{$plan}' WHERE `plan_date` ='{$plan_date}' AND `machine` = '{$r_machine}' AND `shift` = '{$shift}'";
            else if($plan_name == 'ot_plan')
                $sql = "UPDATE {$tblShiftPlan} SET `ot_plan` = '{$plan}' WHERE `plan_date` ='{$plan_date}' AND `machine` = '{$r_machine}' AND `shift` = '{$shift}'";
            else
                $sql = "UPDATE {$tblShiftPlan} SET `opr` = '{$plan}' WHERE `plan_date` ='{$plan_date}' AND `machine` = '{$r_machine}' AND `shift` = '{$shift}'";

            $res = $db->query($sql);
        }
    }



    return $res;
}

function get_page_cycles()
{
    global $db, $tblPageCycles;
    $query = "SELECT * FROM {$tblPageCycles}";
    $result = $db->query($query);
    $page_cycles = array();
    while($page_cycle = mysqli_fetch_object($result)) {
        array_push($page_cycles, $page_cycle);
    }
    return $page_cycles;
}

function get_first_page_cycle()
{
    global $db, $tblPageCycles;
    $query = "SELECT * FROM {$tblPageCycles} LIMIT 1";
    $result = $db->query($query);
    $page_cycle = mysqli_fetch_object($result);
    return $page_cycle;
}

function save_page_cycle($post_data)
{
    global $db, $tblPageCycles;
    $id = $post_data['id'];
    $page_name = $post_data['page_name'];
    $page_url = $post_data['page_url'];
    $seconds = $post_data['seconds'];
    if($id > 0) {
        $query = "UPDATE {$tblPageCycles} SET `page_name` = '{$page_name}', `page_url` = '{$page_url}', `seconds` = '{$seconds}' WHERE id = {$id}";
    } else{
        $query = "INSERT INTO {$tblPageCycles} (`page_name`, `page_url`, `seconds`) VALUES ('{$page_name}', '{$page_url}', '{$seconds}')";
    }

    $result = $db->query($query);
    if($result)
        echo 'OK';
    else
        echo 'FAIL';
}

function delete_page_cycle($post_data)
{
    global $db, $tblPageCycles;
    $id = $post_data['id'];
    $query = "DELETE FROM {$tblPageCycles} WHERE id = {$id}";
    $result = $db->query($query);
    if($result)
        echo 'OK';
    else
        echo 'FAIL';
}

function save_header_link($post_data)
{
    $set_type = $post_data['set_type'];
    $set_value = $post_data['set_value'];
    $result = update_setting($set_type, $set_value);
    if($result)
        echo 'ok';
    else
        echo 'failed';
}

/*
 * Administration Users
 */

function read_users($post_data)
{
    global $tblUsers, $db;
    $query = "SELECT * FROM {$tblUsers} WHERE is_admin = 0";
    $result = $db->query($query);
    echo '<table class="table table-bordered table-striped" id="user_table">
            <thead>
            <tr>
                <th>Member #</th>
                <th>Name</th>
                <th></th>
            </tr>
            </thead>
            <tbody>';

    while($row = mysqli_fetch_object($result)){
        echo '<tr data-user="'.$row->id.'">';
        echo '<td>'.$row->user_no.'</td>';
        echo '<td>'.$row->username.'</td>';
        echo '<td><button type="button" class="btn btn-primary btn-xs edit-user">EDIT</button>&nbsp;<button type="button" class="btn btn-danger btn-xs delete-user">DELETE</button></td>';
        echo '</tr>';
    }

    echo '</tbody></table>';
}

function save_user($post_data)
{
    global $tblUsers, $db;
    $user_id = $post_data['user_id'];
    $user_no = $post_data['user_no'];
    $username = $post_data['username'];

    if($user_id == 0){
        $query = "INSERT INTO {$tblUsers} (user_no, username, is_admin) 
                  VALUES ('{$user_no}', '{$username}', 0 )";
    } else {
        $query = "UPDATE {$tblUsers} SET user_no = '{$user_no}', username = '{$username}' WHERE id = {$user_id}";
    }

    $result = $db->query($query);

    if($result)
        echo "ok";
    else
        echo "fail";
}

function get_user_info($post_data)
{
    global $tblUsers, $db;
    $user_id = $post_data['user_id'];
    $query = "SELECT * FROM {$tblUsers} WHERE id = '{$user_id}'";
    $result = $db->query($query);
    $user = mysqli_fetch_object($result);
    echo json_encode($user, true);
}

function delete_user($post_data)
{
    global $tblUsers, $db;
    $user_id = $post_data['user_id'];
    $query = "DELETE FROM {$tblUsers} WHERE id = {$user_id}";
    $result = $db->query($query);
    if($result)
        echo "ok";
    else
        echo "fail";
}

function check_duplicate_user_no($post_data)
{
    global $tblUsers, $db;
    $user_no = $post_data['user_no'];
    $user_id = $post_data['user_id'];
    $query = "SELECT user_no FROM {$tblUsers} WHERE user_no = '{$user_no}' AND id != '{$user_id}'";
    $result = $db->query($query);
    $rows = mysqli_num_rows($result);
    if($rows == 0)
        echo "ok";
    else
        echo "fail";
}