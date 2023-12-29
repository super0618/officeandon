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
        return '';
    }
}

function update_setting($set_type, $set_value)
{
    global $db, $tblSettings;
    $old_setting = get_setting($set_type);
    if($old_setting != '')
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

    if($field_name == "shift_plan") {
        if(isset($post_data['g_shift']) && isset($post_data['g_date'])){
            $live_shift = $post_data['g_shift'];
            $live_date = convert_date_string($post_data['g_date']);
            $plan_date = date('j-M', strtotime($live_date));
        } else {
            $shift = get_shift($current);
            $live_shift = $shift['shift'];
            $live_date = $shift['date'];
            $plan_date = date('j-M', strtotime($live_date));
        }

        set_shift_plan($plan_date, $live_shift, $machine, $value);
    }
    //Check setting
    $query = "SELECT id FROM {$tblTagSettings} WHERE `table_name` = '{$table_name}' AND `machine` = '{$machine}'";
    $result = $db->query($query);
    $row = mysqli_fetch_object($result);
    if($row) {
        $sql = "UPDATE {$tblTagSettings} SET `{$field_name}` = '{$value}' WHERE id = '{$row->id}'";
    } else {
        $sql = "INSERT INTO {$tblTagSettings} (`table_name`, `machine`, `{$field_name}`) VALUES ('{$table_name}', '{$machine}', '{$value}')";
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

function get_shift($datetime)
{
    $datetime_arr = explode(" ", $datetime);
    $date = $datetime_arr[0];
    $week_day = date('N', strtotime($date));
    $next_date = date("Y-m-d", strtotime("+1 days", strtotime($date)));
    $pre_date = date("Y-m-d", strtotime("-1 days", strtotime($date)));

    if($week_day == 5)
        $shift_settings = get_setting('friday_shift');
    else
        $shift_settings = get_setting('shift');

    if($shift_settings != '')
        $shifts = json_decode($shift_settings, true);
    else{
        $string = file_get_contents("./shift.json");
        $shifts = json_decode($string, true);
    }

    if($shifts['shift3']['start'] == '00:00:00' && $shifts['shift3']['end'] == '00:00:00') {
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
        $shift['shift3_active'] = false;
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
        $shift['shift3_active'] = true;
    }
    return $shift;
}

function get_shift_by_date($date, $shift)
{
    $week_day = date('N', strtotime($date));
    if($week_day == 5)
        $shift_settings = get_setting('friday_shift');
    else
        $shift_settings = get_setting('shift');

    if($shift_settings != '')
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
    if(mysqli_num_rows($result) > 0)
        return true;
    else
        return false;
}

function make_history($date, $shift, $page)
{
    global $db, $tblHistory;
    $shift_info = get_shift_by_date($date, $shift);
    $start_time = $shift_info['start'];
    $end_time = $shift_info['end'];
    $data = get_main_data($start_time, $end_time, $page);
    $history = json_encode($data, true);
    $target_stop_query = "INSERT INTO {$tblHistory} (`history_date`, `shift`, `page`, `data`) VALUES ('{$date}', '{$shift}', '{$page}', '{$history}')";
    $db->query($target_stop_query);
    return $data;
}

function read_history($date, $shift, $page)
{
    global $db, $tblHistory;
    $chk = chk_history($date, $shift, $page);
    if($chk == true) {
        $query = "SELECT * FROM {$tblHistory} WHERE `history_date` = '{$date}' AND `shift` = '{$shift}' AND `page` = '{$page}'";
        $result = $db->query($query);
        $d = mysqli_fetch_array($result);
        $data = json_decode($d['data'], true);
    } else {
        $data = make_history($date, $shift, $page);
    }
    return $data;
}

function get_main_data($start_time, $end_time, $page)
{
    global $current, $g_items, $g_andon, $g_machines, $g_period_cumulative, $g_shift_patterns;
    global $db, $tblLive, $tblTargetStop;

    if($current > $end_time)
        $current = $end_time;

    if($page == "live1"){
        $tables = array('ASSEMBLY', 'MACHINING', 'Period_Cumulative');
    } else{
        $tables = array('LOW_PRESSURE_CASTING', 'HIGH_PRESSURE_CASTING', 'SHIFT_PATTERN');
    }
    $data = array();

    foreach ($tables as $table) {
        if($table == 'ASSEMBLY')
            $machines = $g_andon;
        else if($table == 'MACHINING')
            $machines = $g_machines;
        else if($table == 'Period_Cumulative')
            $machines = $g_period_cumulative;
        else if($table == "SHIFT_PATTERN")
            $machines = $g_shift_patterns;
        else
            $machines = array('HEAD');

        foreach ($machines as $machine) {
            //Get tag setting for table and machine
            $settings = get_tag_setting($table, $machine);
            if(isset($settings['opr']))
                $opr = $settings['opr'];
            else
                $opr = 50;

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

                    if($value_name == 'shift_plan') {
                        $shift = get_shift($start_time);
                        $plan_shift = $shift['shift'];
                        $plan_date = $shift['date'];
                        $plan_date = date('j-M', strtotime($plan_date));
                        $data[$table][$machine][$value_name]['value'] = get_shift_plan($plan_date, $plan_shift, $machine);
                    }

                    if( $value_name == 'actual' ||
                        $value_name == 'shift_line_stop' ||
                        $value_name == 'shift_opr_in' ||
                        $value_name == 'shift_opr_out' ||
                        $value_name == 'ot_plan' ||
                        $value_name == 'ot_call'
                    ) {
                        $tag_field = $value_name.'_tag';
                        if(isset($settings[$tag_field]) && !empty($settings[$tag_field]))
                            array_push($tags, $settings[$tag_field]);
                    }
                }

                //Get Tag values from live table
                if(count($tags) > 0) {
                    $names = join("','",$tags);
                    $query = "SELECT `name`, MAX(`value`) as value FROM {$tblLive} WHERE `name` IN ('$names') AND `timestamp` >= '{$start_time}' AND `timestamp` <= '{$end_time}' GROUP BY `name`";
                    $result = $db->query($query);
                    while($row=mysqli_fetch_object($result)) {
                        $value = $row->value;
                        $red_value = '';
                        $yellow_value = '';
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

                        if(isset($settings['shift_line_stop_tag']) && $row->name == $settings['shift_line_stop_tag']) {
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

                if($target_stopped == false) {
                    //Get Target
                    $value = get_target($opr, $start_time, $end_time);
                    $data[$table][$machine]['target']['value'] = $value;

                    //Check actual and plan
                    if($data[$table][$machine]['actual']['value'] >= $data[$table][$machine]['shift_plan']['value']) {
                        if($data[$table][$machine]['target']['value'] > $data[$table][$machine]['shift_plan']['value'])
                            $data[$table][$machine]['target']['value'] = $data[$table][$machine]['shift_plan']['value'];
                        //Stop Target count
                        $target_stop_query = "INSERT INTO {$tblTargetStop} (`value`, `stop_time`, `table_name`, `machine`) VALUES ('{$data[$table][$machine]['target']['value']}', '{$current}', '{$table}', '{$machine}')";
                        $db->query($target_stop_query);
                    }

                } else {
                    $data[$table][$machine]['target']['value'] = $target_stopped_value;
                }

                $red_value = '';
                $yellow_value = '';
                if(isset($settings['target_red']))
                    $red_value = $settings['target_red'];
                if(isset($settings['target_yellow']))
                    $yellow_value = $settings['target_yellow'];
                if(!empty($yellow_value) && !empty($red_value)) {
                    $data[$table][$machine]['target']['style'] = get_td_style($value, $red_value, $yellow_value);
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
                $last_hour_opr = 0;
                if($table != "LOW_PRESSURE_CASTING" && $table != "HIGH_PRESSURE_CASTING") {
                    $last_start_time = date('Y-m-d H:i:s', strtotime("-1 hour", strtotime($current)));
                    $last_hour_target = get_target($opr, $last_start_time, $current);
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
                }

                $red_value = '';
                $yellow_value = '';
                if(isset($settings['last_hour_opr_red']))
                    $red_value = $settings['last_hour_opr_red'];
                if(isset($settings['last_hour_opr_yellow']))
                    $yellow_value = $settings['last_hour_opr_yellow'];
                if(!empty($yellow_value) && !empty($red_value)) {
                    $data[$table][$machine]['last_hour_opr']['style'] = get_td_style($last_hour_opr, $red_value, $yellow_value);
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

        if($table == "LOW_PRESSURE_CASTING" || $table == "HIGH_PRESSURE_CASTING") {
            if($table == "LOW_PRESSURE_CASTING")
                $EDMs = array('EDM1', 'EDM2', 'EDM3', 'EDM4', 'EDM5', 'EDM6');
            else
                $EDMs= array('H1', 'H2');

            $actual = 0;
            foreach ($EDMs as $EDM){
                $data[$table][$EDM]['value'] = 0;
                $settings = get_tag_setting($table, $EDM);
                if(isset($settings['actual_tag']) && !empty($settings['actual_tag'])) {
                    $value = get_actual_value($settings['actual_tag'], $start_time, $end_time, true);
                    $data[$table][$EDM]['value'] = $value;
                    $actual += $value;
                }
            }
            $data[$table]['HEAD']['actual']['value'] = $actual;
            $data[$table]['HEAD']['live']['value'] = $actual - $data[$table]['HEAD']['target']['value'];

            $red_value = '';
            $yellow_value = '';
            $head_settings = get_tag_setting($table, 'HEAD');
            if(isset($head_settings['live_red']))
                $red_value = $head_settings['live_red'];
            if(isset($head_settings['live_yellow']))
                $yellow_value = $head_settings['live_yellow'];
            if(!empty($yellow_value) && !empty($red_value)) {
                $data[$table]['HEAD']['live']['style'] = get_td_style($data[$table]['HEAD']['live']['value'], $red_value, $yellow_value);
            }

            $red_value = '';
            $yellow_value = '';
            if(isset($head_settings['actual_red']))
                $red_value = $head_settings['actual_red'];
            if(isset($head_settings['actual_yellow']))
                $yellow_value = $head_settings['actual_yellow'];
            if(!empty($yellow_value) && !empty($red_value)) {
                $data[$table]['HEAD']['actual']['style'] = get_td_style($data[$table]['HEAD']['actual']['value'], $red_value, $yellow_value);
            }

            //Last hour opr
            $last_start_time = date('Y-m-d H:i:s', strtotime("-1 hour", strtotime($current)));
            $last_hour_target = get_target($opr, $last_start_time, $current);
            $last_hour_actual = 0;
            foreach ($EDMs as $EDM){
                $settings = get_tag_setting($table, $EDM);
                if(isset($settings['actual_tag']) && !empty($settings['actual_tag'])) {
                    $value = get_actual_value($settings['actual_tag'], $start_time, $last_start_time, true);
                    $last_hour_actual += $value;
                }
            }

            if($last_hour_target != 0) {
                $last_hour_opr = round($last_hour_actual/$last_hour_target * 100, 1);
            } else {
                $last_hour_opr = 0;
            }
            $data[$table]['HEAD']['last_hour_opr']['value'] = $last_hour_opr;
        }
    }

    return $data;
}

function read_live_values($post_data)
{
    global $current, $db, $tblLive;
    $page = $post_data['page'];
    $shift = get_shift($current);
    $start_time = $shift['start'];
    $end_time = $shift['end'];

    /**
     * Check history for previous shift and then make history
     */
    $current_shift = $shift['shift'];
    $shift3_active = $shift['shift3_active'];
    if($current_shift == 'shift1') {
        if($shift3_active == true)
            $old_shift = 'shift3';
        else
            $old_shift = 'shift2';
        $old_date = date('Y-m-d', strtotime("-1 day", strtotime($shift['date'])));
    } else if($current_shift == "shift2") {
        $old_shift = 'shift1';
        $old_date = $shift['date'];
    } else {
        $old_shift = 'shift2';
        $old_date = $shift['date'];
    }
    $chk_history = chk_history($old_date, $old_shift, $page);
    if($chk_history == false) {
        make_history($old_date, $old_shift, $page);
    } else{
        //Delete old data from live table
        $old_shift_info = get_shift_by_date($old_date, $old_shift);
        $del = "DELETE FROM {$tblLive} WHERE `timestamp` >= '{$old_shift_info['start']}' AND `timestamp` < '{$old_shift_info['end']}'";
        $db->query($del);
    }

    $data = get_main_data($start_time, $end_time, $page);

    /*
     * Get page cycle
     */
    $page_cycle = get_first_page_cycle();
    if(!empty($page_cycle)){
        $data['page_url'] = $page_cycle->page_url;
        $data['page_seconds'] = $page_cycle->seconds;
    } else {
        $data['page_url'] = '';
        $data['page_seconds'] = 0;
    }
    echo json_encode($data, true);
}

function read_history_values($post_data)
{
    global $current, $db, $tblLive;
    $page = $post_data['page'];
    $g_date = convert_date_string($post_data['date']);
    $g_shift = $post_data['shift'];

    $shift = get_shift($current);
    $start_time = $shift['start'];
    $end_time = $shift['end'];

    if($start_time > $current)
        $data = get_main_data($start_time, $end_time, $page);
    else
        $data = read_history($g_date, $g_shift, $page);

    echo json_encode($data, true);
}

function get_td_style($value, $red_value, $yellow_value, $sort='asc')
{
    $style = '';
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

function get_target($opr, $start, $end)
{
    global $current;
    if($end > $current)
        $end = $current;

    $total_past_time = strtotime($end) - strtotime($start);

    //Get shift setting
    $shift = get_shift($start);
    $shift_settings = get_setting('shift');
    if($shift_settings != '')
        $shifts = json_decode($shift_settings, true);
    else{
        $string = file_get_contents("./shift.json");
        $shifts = json_decode($string, true);
    }

    $date = $shift['date'];
    $next_date = $next_date = date("Y-m-d", strtotime("+1 days", strtotime($date)));
    $shift_kind = $shift['shift'];

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
    global $db, $tblLive;
    if($emd == true) {
        //Previous shift value
        $pre_val = 0;
        $query = "SELECT `value` FROM {$tblLive} WHERE `name` = '{$tag}' AND `timestamp` >= '{$start}' ORDER BY `timestamp` ASC limit 1";
        $result = $db->query($query);
        $row = mysqli_fetch_object($result);
        if($row)
            $pre_val = $row->value;

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

function get_shift_plan($plan_date, $shift, $machine)
{
    global $db, $tblShiftPlan;
    $check_query = "SELECT * FROM {$tblShiftPlan} WHERE `plan_date` ='{$plan_date}' AND `machine` = '{$machine}' AND `shift` = '{$shift}'";
    $check_result = $db->query($check_query);
    $check = mysqli_num_rows($check_result);
    $plan = 0;
    if($check > 0) {
        $p = mysqli_fetch_object($check_result);
        $plan = $p->plan;
    }
    return $plan;
}

function set_shift_plan($plan_date, $shift, $machine, $plan)
{
    global $db, $tblShiftPlan;
    $check_query = "SELECT * FROM {$tblShiftPlan} WHERE `plan_date` ='{$plan_date}' AND `machine` = '{$machine}' AND `shift` = '{$shift}'";
    $check_result = $db->query($check_query);
    $check = mysqli_num_rows($check_result);
    if($check == 0) {
        $sql = "INSERT INTO {$tblShiftPlan} (`plan`, `plan_date`, `shift`, `machine`) 
                            VALUES ('{$plan}', '{$plan_date}', '{$shift}', '{$machine}')";
        $res = $db->query($sql);
    } else {
        $sql = "UPDATE {$tblShiftPlan} SET `plan` = '{$plan}' WHERE `plan_date` ='{$plan_date}' AND `machine` = '{$machine}' AND `shift` = '{$shift}'";
        $res = $db->query($sql);
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

function set_opr_time_set($machine, $opr)
{
    global $db, $tblTagSettings, $g_andon;

    $query = "SELECT id FROM {$tblTagSettings} WHERE `machine` = '{$machine}'";
    $result = $db->query($query);
    $row = mysqli_fetch_object($result);
    if($row) {
        $sql = "UPDATE {$tblTagSettings} SET `opr` = '{$opr}' WHERE id = '{$row->id}'";
    } else {
        if(in_array($machine, $g_andon))
            $table_name = 'ASSEMBLY';
        else
            $table_name = 'MACHINING';
        $sql = "INSERT INTO {$tblTagSettings} (`table_name`, `machine`, `opr`) VALUES ('{$table_name}', '{$machine}', '{$opr}')";
    }

    return $db->query($sql);
}