<?php
require_once("db_config.php");
require_once("functions.php");
$page_name = "live_1";
require_once("assets_inc.php");

?>
<style>
    .shift_plan {
        cursor: pointer;
    }

    .has-details {
        position: relative;
        cursor: pointer;
    }

    .details {
        position: absolute;
        top: 0;
        transform: translateY(70%) scale(0);
        transition: transform 0.1s ease-in;
        transform-origin: left;
        display: inline;
        background: white;
        z-index: 20;
        min-width: 100%;
        padding: 1rem;
        border: 1px solid black;
        color: #0a0a0a;
    }

    .has-details:hover span {
        transform: translateY(70%) scale(1);
    }

    .blink-bg {
        padding: 10px;
        /*display: inline-block;
        border-radius: 5px;*/
        animation: blinkingBackground 4s infinite;
    }

    @keyframes blinkingBackground {
        0% {
            background-color: #ef0a1a;
            color: #fff;
        }

        25% {
            background-color: #ffffff;
            color: #000;
        }

        50% {
            background-color: #ef0a1a;
            color: #fff;
        }

        75% {
            background-color: #ffffff;
            color: #000;
        }

        100% {
            background-color: #ef0a1a;
            color: #fff;
        }
    }

    .blink-bg1 {
        padding: 10px;
        /*display: inline-block;
        border-radius: 5px;*/
        animation: blinkingBackground1 4s infinite;
    }

    @keyframes blinkingBackground1 {
        0% {
            background-color: #ef0a1a;
            color: #fff;
        }

        25% {
            background-color: black;
            color: #fff;
        }

        50% {
            background-color: #ef0a1a;
            color: #fff;
        }

        75% {
            background-color: black;
            color: #fff;
        }

        100% {
            background-color: #ef0a1a;
            color: #fff;
        }
    }

    .blink {
        /* color: #f00 !important; */
        animation: blink-color 2s infinite;
    }

    @keyframes blink-color {
        0% { color: #fff; }
        25% { color: #fff; }
        50% { color: #f00; }
        75% { color: #fff; }
        100% { color: #fff; }
    }

    legend {
        border: 1px black solid;
        padding: 0.2em;
        width: auto;
        font-weight: bold;
        font-size: 3.5em;
        display: inline-block;
		margin-bottom: -31px;
        color: #9a9a9a;
    }

    fieldset {
        padding: 0.3em;
        text-align: center;
        display: block;
        border: 0.5em #9a9a9a solid;
        border-radius: 0.5em;
    }

    .t-label {
        font-size: 1em;
        font-weight: bold;
        color: #9a9a9a;
        margin: 0px;
    }

    .t1-value {
        font-size: 1.8em;
        font-weight: bold;
        color: white;
        margin: 0px;
    }






    .title {
        position: absolute;
        font-size: 20px;
        top: -25px;
        left: 50%;
        transform: translateX(-50%);
        background-color: black;
        width: 70%;
    }
	


    .start {
        background-color: black;

    }
	
	p.text1.text-white {
    padding: 16px;
	 font-size: 64px;
}

row.highcenter {
    padding: 21px 0px 0px 1px;
}

p.text1.text-white.text-center {
    font-size: 60px;
}

   .text1 {
    font-size: 36px;
    font-weight: bold;
    margin: 0px;
}

    .text2 {
        font-size: 66px;
        padding-bottom: 31px;
        font-weight: 700;
        padding-top: 12px;
        margin: -1px;
        line-height: 25px;
    }

 
		
		.text3 {
    font-size: 176px;
    padding-bottom: 36px;
    padding-top: 20px;
    line-height: 78px;
    font-weight: 700;
    color: white;
}


    .red {
        color: red !important;
    }
	
	
	.p-2 {
    padding: 0.5em;
    margin-top: -48px;
}
	

    .highcenter {
        display: flex;
		padding: 11px;
        align-items: center;
        /* Vertically centers the children */
        justify-content: center;

    }

 .text4 {
    font-size: 100px;
    padding-top: 37px;
    font-weight: bold;
    margin: 0px;
    padding-bottom: 46px;
    line-height: 80px;
    /* color: rgb(21, 234, 38); */
}

    .text5 {
        line-height: 40px;
    }

   .text6 {
    font-size: 125px;
    font-weight: bold;
    padding-top: 25px;
    line-height: 60px;
    color: rgb(21, 234, 38);
}

    .text7 {
    line-height: 50px;
    font-size: 115px;
    padding-top: 36px;
    font-weight: bold;
    color: rgb(21, 234, 38);
}

    .yellow {
        color: rgb(253, 235, 9)
    }

    .green {
        color: rgb(21, 234, 38)
    }

    .text {
        font-size: 20px;
    }

    .text-white {
        color: #9a9a9a;
    }

    .white {
        color: white;
    }

    .p-2 {
        padding: 0.5em;
    }

    .p-3 {
        padding: 10px;
    }

    .mtm-2 {
        margin-top: -20px;
    }

    div.red-td p:nth-child(2) {
        background-color: inherit;
        color: red;
    }

    div.red-td {
        background-color: inherit;
        color: #9a9a9a;
        /* color: red; */
    }

    div.yellow-td p:nth-child(2) {
        background-color: inherit;
        color: yellow;
    }

    div.yellow-td {
        background-color: inherit;
        color: #9a9a9a;
        /* color: yellow; */
    }

    div.green-td p:nth-child(2) {
        background-color: inherit;
        color: green;
    }

    div.green-td {
        background-color: inherit;
        color: #9a9a9a;
        /* color: green; */
    }
</style>

<body class="hold-transition skin-blue sidebar-mini sidebar-collapse" onload="startTime()">
    <div class="wrapper">
        <!-- Main Header -->
        <?php include("header.php"); ?>

        <!-- Left side column. contains the logo and sidebar -->
        <?php include("menu.php"); ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper" style="background-color: black">
            <!-- Main content -->
            <section class="content container-fluid">

                <div class="row p-5" id="MACHINING">
                    <div class="col-sm-4 col-md-2 p-2" data-machine="CRANK">
                        <fieldset>
                            <!-- <div class="title text-white text-center p-4 pt-2 pb-2">
                                ASSEMBLY
                            </div> -->
                            <legend>CRANK</legend>
                            <div class="row p-3 ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">PLAN</p>
                                        <p class="text2 white shift_plan">554</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">TARGET</p>
                                        <p class="text2 white target ">477</p>
                                        <!-- <p class="text2 details ">0%</p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="text1 text-white text-center ">ACTUAL</p>
                            </div>
                            <div class="row">
                                <p class="text3 text-center actual">444</p>
                            </div>
                            <div class="row">
                                <div class="text-center highcenter">
                                    <span class="text1 text-white p-3">+/-</span>
                                    <p class="text4 live">-33</p>
                                </div>
                            </div>
                            <div class="row highcenter ">
                                <div class="col-12 text-white text-center">
                                    <div>
                                        <p class="text1">SHIFT OPR</p>
                                        <p class="text6 shift_opr">90.9<span class="text">%</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row highcenter ">
                                <div class="col-12 text-white text-center">
                                    <div>
                                        <p class="text1">LAST HOUR OPR</p>
                                        <p class="text7 last_hour_opr">95.5</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-4 col-md-2 p-2" data-machine="BLOCK">
                        <fieldset>
                            <!-- <div class="title text-white text-center p-4 pt-2 pb-2">
                                ASSEMBLY
                            </div> -->
                            <legend>BLOCK</legend>
                            <div class="row p-3 ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">PLAN</p>
                                        <p class="text2 white shift_plan">554</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">TARGET</p>
                                        <p class="text2 white target ">477</p>
                                        <!-- <p class="text2 details ">0%</p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="text1 text-white text-center ">ACTUAL</p>
                            </div>
                            <div class="row">
                                <p class="text3 text-center actual">444</p>
                            </div>
                            <div class="row">
                                <div class="text-center highcenter">
                                    <span class="text1 text-white p-3">+/-</span>
                                    <p class="text4 live">-33</p>
                                </div>
                            </div>
                            <div class="row highcenter ">
                                <div class="col-12 text-white text-center">
                                    <div>
                                        <p class="text1">SHIFT OPR</p>
                                        <p class="text6 shift_opr">90.9<span class="text">%</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row highcenter ">
                                <div class="col-12 text-white text-center">
                                    <div>
                                        <p class="text1">LAST HOUR OPR</p>
                                        <p class="text7 last_hour_opr">95.5</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-4 col-md-2 p-2" data-machine="HEAD">
                        <fieldset>
                            <!-- <div class="title text-white text-center p-4 pt-2 pb-2">
                                ASSEMBLY
                            </div> -->
                            <legend>HEAD</legend>
                            <div class="row p-3 ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">PLAN</p>
                                        <p class="text2 white shift_plan">554</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">TARGET</p>
                                        <p class="text2 white target ">477</p>
                                        <!-- <p class="text2 details ">0%</p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="text1 text-white text-center ">ACTUAL</p>
                            </div>
                            <div class="row">
                                <p class="text3 text-center actual">444</p>
                            </div>
                            <div class="row">
                                <div class="text-center highcenter">
                                    <span class="text1 text-white p-3">+/-</span>
                                    <p class="text4 live">-33</p>
                                </div>
                            </div>
                            <div class="row highcenter ">
                                <div class="col-12 text-white text-center">
                                    <div>
                                        <p class="text1">SHIFT OPR</p>
                                        <p class="text6 shift_opr">90.9<span class="text">%</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row highcenter ">
                                <div class="col-12 text-white text-center">
                                    <div>
                                        <p class="text1">LAST HOUR OPR</p>
                                        <p class="text7 last_hour_opr">95.5</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-4 col-md-2 p-2" data-machine="HOUSING">
                        <fieldset>
                            <!-- <div class="title text-white text-center p-4 pt-2 pb-2">
                                ASSEMBLY
                            </div> -->
                            <legend>HOUSING</legend>
                            <div class="row p-3 ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">PLAN</p>
                                        <p class="text2 white shift_plan">554</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">TARGET</p>
                                        <p class="text2 white target ">477</p>
                                        <!-- <p class="text2 details ">0%</p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="text1 text-white text-center ">ACTUAL</p>
                            </div>
                            <div class="row">
                                <p class="text3 text-center actual">444</p>
                            </div>
                            <div class="row">
                                <div class="text-center highcenter">
                                    <span class="text1 text-white p-3">+/-</span>
                                    <p class="text4 live">-33</p>
                                </div>
                            </div>
                            <div class="row highcenter ">
                                <div class="col-12 text-white text-center">
                                    <div>
                                        <p class="text1">SHIFT OPR</p>
                                        <p class="text6 shift_opr">90.9<span class="text">%</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row highcenter ">
                                <div class="col-12 text-white text-center">
                                    <div>
                                        <p class="text1">LAST HOUR OPR</p>
                                        <p class="text7 last_hour_opr">95.5</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-4 col-md-2 p-2" data-machine="ROD">
                        <fieldset>
                            <!-- <div class="title text-white text-center p-4 pt-2 pb-2">
                                ASSEMBLY
                            </div> -->
                            <legend>ROD</legend>
                            <div class="row p-3 ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">PLAN</p>
                                        <p class="text2 white shift_plan">554</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">TARGET</p>
                                        <p class="text2 white target ">477</p>
                                        <!-- <p class="text2 details ">0%</p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="text1 text-white text-center ">ACTUAL</p>
                            </div>
                            <div class="row">
                                <p class="text3 text-center actual">444</p>
                            </div>
                            <div class="row">
                                <div class="text-center highcenter">
                                    <span class="text1 text-white p-3">+/-</span>
                                    <p class="text4 live">-33</p>
                                </div>
                            </div>
                            <div class="row highcenter ">
                                <div class="col-12 text-white text-center">
                                    <div>
                                        <p class="text1">SHIFT OPR</p>
                                        <p class="text6 shift_opr">90.9<span class="text">%</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row highcenter ">
                                <div class="col-12 text-white text-center">
                                    <div>
                                        <p class="text1">LAST HOUR OPR</p>
                                        <p class="text7 last_hour_opr">95.5</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-4 col-md-2 p-2" data-machine="CAM">
                        <fieldset>
                            <!-- <div class="title text-white text-center p-4 pt-2 pb-2">
                                ASSEMBLY
                            </div> -->
                            <legend>CAM</legend>
                            <div class="row p-3 ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">PLAN</p>
                                        <p class="text2 white shift_plan">554</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">TARGET</p>
                                        <p class="text2 white target ">477</p>
                                        <!-- <p class="text2 details ">0%</p> -->
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <p class="text1 text-white text-center ">ACTUAL</p>
                            </div>
                            <div class="row">
                                <p class="text3 text-center actual">444</p>
                            </div>
                            <div class="row">
                                <div class="text-center highcenter">
                                    <span class="text1 text-white p-3">+/-</span>
                                    <p class="text4 live green">-33</p>
                                </div>
                            </div>
                            <div class="row highcenter ">
                                <div class="col-12 text-white text-center">
                                    <div>
                                        <p class="text1">SHIFT OPR</p>
                                        <p class="text6 shift_opr">90.9<span class="text">%</span></p>
                                    </div>
                                </div>
                            </div>
                            <div class="row highcenter ">
                                <div class="col-12 text-white text-center">
                                    <div>
                                        <p class="text1">LAST HOUR OPR</p>
                                        <p class="text7 last_hour_opr">95.5</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <input type="hidden" name="page" id="page" value="live1">
                <!-- <div class="row">
                    <div class="col-md-12">
                        <?php
                        $shift_pattern = get_setting('CRANK shift pattern');
                        $show_items = $g_items;
                        // if($shift_pattern == "shift3") {
                        //     $show_items = array_splice($show_items, 0, -2);
                        // }
                        ?>
                        <table class="table table-bordered" id="MACHINING">
                            <tr>
                                <td style="border-top: 1px solid #fff;border-left: 1px solid #fff; border-bottom: 1px solid #fff"></td>
                                <td colspan="6" class="title-td" style="font-size: 30px; font-weight: bold;">MACHINING</td>
                            </tr>
                            <?php
                            echo '<tr>';
                            echo '<td style="border-top: 1px solid #808080;border-left: 1px solid #fff; "></td>';
                            foreach ($g_machines as $machine) {
                                $header_link = get_setting($machine . ' LINK');
                                if (empty($header_link))
                                    $header_link = '#';
                                echo '<td class="title-td"><a href="' . $header_link . '" style="color: #FFF;" target="_blank">' . $machine . '</a></td>';
                            }
                            echo '</tr>';

                            foreach ($show_items as $item) {
                                if ($item == 'O/T CALL')
                                    continue;
                                if ($item == 'O/T PLAN')
                                    continue;
                                echo '<tr>';
                                echo '<td class="title-td">' . $item . '</td>';
                                $value_name = str_replace(" +/-", "", $item);
                                $value_name = str_replace("/", "", $value_name);
                                $value_name = str_replace(" ", "_", strtolower($value_name));
                                $unit = '';
                                if (strpos($value_name, "opr") !== false)
                                    $unit = ' %';
                                foreach ($g_machines as $machine) {
                                    if ($value_name == 'target') {
                                        echo '<td class="value-td has-details" style="border: 1px solid #373737;" data-machine="' . $machine . '">';
                                        echo '<span class="' . $value_name . '"></span>' . $unit;
                                        echo '<span class="details">' . get_tag_setting("MACHINING", $machine, $value_name) . '%</span>';
                                        echo '</td>';
                                    } else
                                        echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="' . $machine . '"><span class="' . $value_name . '"></span>' . $unit . '</td>';
                                }
                                echo '</tr>';
                            }
                            ?>
                        </table>
                    </div>
                </div> -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- Main Footer -->
        <?php include("footer.php"); ?>
    </div>
    <!-- ./wrapper -->

    <!-----modal----->
    <div id="shift_plan_modal" class="modal fade" role="dialog">
        <div class="modal-dialog modal-sm">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Shift Plan</h4>
                </div>
                <div class="modal-body">
                    <form id="shift_plan_form" method="post">
                        <input type="hidden" id="table" name="table">
                        <input type="hidden" id="machine" name="machine">
                        <input type="number" id="shift_plan" name="shift_plan" class="form-control" style="font-size: 30px; height: 60px;">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id="save_shift_plan">Save</button>
                </div>
            </div>

        </div>
    </div>

    <!-- REQUIRED JS SCRIPTS -->
    <script src="components/jquery/dist/jquery.min.js"></script>
    <script src="components/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="assets/js/moment.min.js"></script>
    <script src="assets/js/adminlte.min.js"></script>
    <script src="components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <script src="assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="assets/js/custom.js"></script>
    <script>
        $(function() {       
            var old_value = -1;
            var is_flashing = false;
            read_values();            

            setInterval(function() {
                read_values();
            }, 15000);

            function time_to_str(val) {
                const pref = Math.floor(val / 60).toString().padStart(2, "0");
                const suff = (val % 60).toString().padStart(2, "0");
                return pref + ":" + suff;
            }

            function str_to_time(val) {
                const [min, sec] = val.split(':');
                return parseInt(min, 10) * 60 + parseInt(sec, 10);
            }

            function read_values() {
                //$("#loading").fadeIn(1000);
                var page = $("#page").val()

                $.ajax({
                    url: "actions.php",
                    method: "post",
                    data: {
                        action: "read_live_values",
                        page: page,
                    },
                    dataType: "JSON"
                }).done(function(result) {
                    console.log(result);
                    old_value++;
                    for (const table in result) {
                        for (const machine in result[table]) {
                            if (machine === 'shift_stop')
                                continue;
                            for (const item in result[table][machine]) {
                                if (result[table]['shift_stop'] === 1) {
                                    if (item === 'actual' || item === 'target' || item === 'shift_opr' || item === 'last_hour_opr')
                                        continue;
                                }

                                var span1 = $(document).find('div[id=' + table + ']').find('div[data-machine="' + machine + '"]').find('p.' + item);
                                var span = $(document).find('table[id=' + table + ']').find('td[data-machine="' + machine + '"]').find('span.' + item);

                                var td1 = span1.closest('div');
                                var td = span.closest('td');

                                let value = result[table][machine][item]['value']
                                if (item === "shift_line_stop") { 
                                    value = str_to_time(value);      
                                    span1.text(time_to_str(value));
                                    if (value != old_value) {
                                        if (old_value !== -1 && value > old_value ) {
                                            is_flashing = true;
                                        }
                                        old_value = value;
                                    }

                                    if (is_flashing) {                                        
                                        span1.addClass('blink');
                                        span1.removeClass('white');

                                        const removeRed = () => {
                                            const el = document.querySelector('p.text4.shift_line_stop.blink');
                                            try {
                                                el.classList.remove('blink');
                                                el.classList.add('white');
                                            } catch (e) {}
                                        }
                                        setTimeout(removeRed, 30000);
                                    }

                                } else if (item === 'shift_opr' || item === 'last_hour_opr') {
                                    value = Number(value);
                                    if(value >= 100){
                                        value = parseInt(value);
                                    } else if(value >= 10) {
                                        value = value.toFixed(1);
                                    } else {
                                        value = value.toFixed(2);
                                    }
                                    span1.html(value + "<span class='text'>%</span>");
                                } else if (item === 'target' || item === 'actual') {                                    
                                    span1.text(result[table][machine][item]['value']);
                                } else if (item === 'live') {
                                    value = result[table][machine]['actual']['value'] - result[table][machine]['target']['value']
                                    value = (value < 0) ? value : '+' + value;
                                    span1.text(value);
                                    if (value < 0) {
                                        span1.addClass('red')
                                        span1.removeClass('green')
                                    } else {
                                        span1.addClass('green')
                                        span1.removeClass('red')
                                    }
                                } else {
                                    span1.text(value);
                                }

                                // span.text(result[table][machine][item]['value'])
                                // span1.text(result[table][machine][item]['value'])

                                td.removeClass('red-td');
                                td.removeClass('yellow-td');
                                td.removeClass('green-td');
                                td.addClass(result[table][machine][item]['style']);

                                td1.removeClass('red-td');
                                td1.removeClass('yellow-td');
                                td1.removeClass('green-td');
                                td1.addClass(result[table][machine][item]['style']);
                            }

                            if (table == 'ASSEMBLY') {
                                if (result[table][machine]['shift_line_stop_finish']['value'] == 1 && result[table][machine]['shift_line_stop_start']['value'] != 0) {
                                    var span = $(document).find('table[id=' + table + ']').find('td[data-machine="' + machine + '"]').find('span.shift_line_stop');
                                    var td = span.closest('td');
                                    td.removeClass('red-td');
                                    td.removeClass('yellow-td');
                                    td.removeClass('green-td');
                                    td.addClass('blink-bg');
                                } else {
                                    td.removeClass('blink-bg');
                                    td.addClass(result[table][machine]['shift_line_stop']['style']);
                                }
                            }
                        }
                    }

                    is_flashing = false;
                });
            }

            get_period_cumulative();

            function get_period_cumulative() {
                $.ajax({
                    url: "actions.php",
                    method: "post",
                    data: {
                        action: "get_period_cumulative",
                        page: "machining",
                    },
                    dataType: "JSON"
                }).done(function(result) {
                    //console.log(result);
                    for (const machine in result) {
                        var td = $(document).find('table[id="Period_Cumulative"]').find('td[data-machine="' + machine + '"]')
                        var html = result[machine]['actual'] + '<br/>' + result[machine]['plan_to_date'] + '<br/>' + result[machine]['plan_period'];
                        td.html(html);
                    }
                });
            }

            $(document).on('click', '.shift_plan', function() {
                var value = $(this).text();
                var td = $(this).closest('td');
                var machine = td.data('machine');
                var table = $(this).closest('table').attr('id');
                $("#table").val(table);
                $("#machine").val(machine);
                $("#shift_plan").val(value);
                $("#shift_plan_modal").modal()
            });

            $('#shift_plan').keydown(function(e) {
                if (e.keyCode == 13) {
                    e.preventDefault();
                    $("#save_shift_plan").click();
                }
            });

            $("#save_shift_plan").on('click', function() {
                var shift_plan = $("#shift_plan").val()
                if (shift_plan == '' || shift_plan < 0) {
                    $("#shift_plan").focus();
                    return false;
                }

                var table_name = $("#table").val();
                var machine = $("#machine").val();
                var value = $("#shift_plan").val();
                $.ajax({
                    url: "actions.php",
                    method: "post",
                    data: {
                        action: "save_tag_setting",
                        table_name: table_name,
                        machine: machine,
                        field_name: "shift_plan",
                        value: value,
                    },
                }).done(function(result) {
                    if (result == "OK") {
                        $("#shift_plan_modal").modal('hide');
                        $(document).find('table[id=' + table_name + ']').find('td[data-machine="' + machine + '"]').find('span.shift_plan').text(value)
                    } else {
                        alert("Save failed");
                    }
                });
            });
        });
    </script>

</body>

</html>