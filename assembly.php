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

    .has-details:hover p {
        transform: translateY(70%) scale(1);
    }

    .blink-bg {
        padding: 10px;
        /*display: inline-block;
        border-radius: 5px;*/
        animation: blinkingBackground 4s infinite;
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
        font-size: 4.5em;
        display: inline-block;
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
	p.text1.text-white.text-center {
    font-size: 37px;
	margin-top: -15px;
}

    .text1 {
        font-size: 1.2em;
        font-weight: bold;
        margin: 0px;
    }

    .text2 {
        font-size: 88px;
        font-weight: 700;
        margin: 22px 1px 20px 0px;
        line-height: 25px;
    }

   .text3 {
        font-size: 256px;
        line-height: 78px;
        margin: 45px 0px 0px 6px;
        font-weight: 700;
        color: white;
    }
    .text-center.highcenter {
        margin: 34px 0px -75px 0px;
    }

    fieldset {
        margin: -53px 1px 1px 1px;
    }

    .row.highcenter {
        margin: -36px -11px 0px 0px;
        font-size: 30px;
    }

    span.text1.text-white.p-3 {
        margin: 25px -28px 0px 0px;
        font-size: 40px;
    }

    .red {
        color: red !important;
    }

    .highcenter {
        display: flex;
        align-items: center;
        /* Vertically centers the children */
        justify-content: center;

    }

   .text4 {
        font-size: 149px;
        font-weight: bold;
        margin: 0px;    
    }

    .text5 {
        line-height: 40px;
    }

    .text6 {
        font-size: 83px;
        margin: 13px 0px 31px 1px;
        font-weight: bold;
        line-height: 40px;
        color: rgb(21, 234, 38);
    }

    .text7 {
        line-height: 40px;
        font-size: 83px;
		 margin: 13px 0px 31px 1px;
        font-weight: bold;
        color: rgb(21, 234, 38)
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
      padding: 0.8em;
    margin: -70px 0px 0px 0px;
    font-size: 25px;
    }

    div.red-td p:nth-child(2){
        background-color: inherit;
        color: red;
    }
    div.red-td{
        background-color: inherit;
        color: #9a9a9a;
        /* color: red; */
    }

    div.yellow-td p:nth-child(2){
        background-color: inherit;
        color: yellow;
    }
    div.yellow-td{
        background-color: inherit;
        color: #9a9a9a;
        /* color: yellow; */
    }

    div.green-td p:nth-child(2){
        background-color: inherit;
        color: green;
    }
    div.green-td{
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
                <div class="row p-5" id="ASSEMBLY">
                    <div class="col-sm-6 col-md-3 p-2" data-machine="ASSY">
                        <fieldset>
                            <!-- <div class="title text-white text-center p-4 pt-2 pb-2">
                                ASSEMBLY
                            </div> -->
                            <legend>ASSEMBLY</legend>
                            <div class="row p-3 ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">PLAN</p>
                                        <p class="text2 white shift_plan ">554</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center ">
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
                            <div class="row">
                                <div class="highcenter">
                                    <div class="p-2">
                                        <p class="text1 text-white">LINE</p>
                                        <p class="text1 text-white">STOP</p>
                                    </div>
                                    <div>
                                        <P class="text4 white shift_line_stop">00:20</P>
                                    </div>
                                </div>


                            </div>
                            <div class="row highcenter ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">SHIFT OPR</p>
                                        <p class="text6 shift_opr">90.9<span class="text">%</span></p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">

                                    <div>
                                        <p class="text1">LAST HR</p>
                                        <p class="text7 last_hour_opr">95.5</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">O/T PLAN</p>
                                        <p class="text6 white ot_plan">30</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">O/T CALL</p>
                                        <p class="text6 white ot_call">0</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-6 col-md-3 p-2" data-machine="SHORT BLOCK">
                        <fieldset>
                            <!-- <div class="title text-white text-center p-4 pt-2 pb-2">
                                ASSEMBLY
                            </div> -->
                            <legend>S/BLOCK</legend>
                            <div class="row p-3 ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">PLAN</p>
                                        <p class="text2 white shift_plan ">554</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">TARGET</p>
                                        <p class="text2 white target ">477</p>
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
                            <div class="row">
                                <div class="highcenter">
                                    <div class="p-2">
                                        <p class="text1 text-white">LINE</p>
                                        <p class="text1 text-white">STOP</p>
                                    </div>
                                    <div>
                                        <P class="text4 white shift_line_stop">00:20</P>
                                    </div>
                                </div>


                            </div>
                            <div class="row highcenter ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">SHIFT OPR</p>
                                        <p class="text6 shift_opr">90.9<span class="text">%</span></p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">

                                    <div>
                                        <p class="text1">LAST HR</p>
                                        <p class="text7 last_hour_opr">95.5</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">O/T PLAN</p>
                                        <p class="text6 white ot_plan">30</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">O/T CALL</p>
                                        <p class="text6 white ot_call">0</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-6 col-md-3 p-2" data-machine="HEAD SUB">
                        <fieldset>
                            <!-- <div class="title text-white text-center p-4 pt-2 pb-2">
                                ASSEMBLY
                            </div> -->
                            <legend>HEAD SUB</legend>
                            <div class="row p-3 ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">PLAN</p>
                                        <p class="text2 white shift_plan ">554</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">TARGET</p>
                                        <p class="text2 white target ">477</p>
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
                            <div class="row">
                                <div class="highcenter">
                                    <div class="p-2">
                                        <p class="text1 text-white">LINE</p>
                                        <p class="text1 text-white">STOP</p>
                                    </div>
                                    <div>
                                        <P class="text4 white shift_line_stop">00:20</P>
                                    </div>
                                </div>


                            </div>
                            <div class="row highcenter ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">SHIFT OPR</p>
                                        <p class="text6 shift_opr">90.9<span class="text">%</span></p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">

                                    <div>
                                        <p class="text1">LAST HR</p>
                                        <p class="text7 last_hour_opr">95.5</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">O/T PLAN</p>
                                        <p class="text6 white ot_plan">30</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">O/T CALL</p>
                                        <p class="text6 white ot_call">0</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <div class="col-sm-6 col-md-3 p-2" data-machine="CAM HSG">
                        <fieldset>
                            <!-- <div class="title text-white text-center p-4 pt-2 pb-2">
                                ASSEMBLY
                            </div> -->
                            <legend>CAM HSG</legend>
                            <div class="row p-3 ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">PLAN</p>
                                        <p class="text2 white shift_plan ">554</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">TARGET</p>
                                        <p class="text2 white target ">477</p>
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
                            <div class="row">
                                <div class="highcenter">
                                    <div class="p-2">
                                        <p class="text1 text-white">LINE</p>
                                        <p class="text1 text-white">STOP</p>
                                    </div>
                                    <div>
                                        <P class="text4 white shift_line_stop">00:20</P>
                                    </div>
                                </div>


                            </div>
                            <div class="row highcenter ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">SHIFT OPR</p>
                                        <p class="text6 shift_opr">90.9<span class="text">%</span></p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">

                                    <div>
                                        <p class="text1">LAST HR</p>
                                        <p class="text7 last_hour_opr">95.5</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row ">
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">O/T PLAN</p>
                                        <p class="text6 white ot_plan">30</p>
                                    </div>
                                </div>
                                <div class="col-sm-6 text-white text-center">
                                    <div>
                                        <p class="text1">O/T CALL</p>
                                        <p class="text6 white ot_call">0</p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
                <!-- <div class="row">
                    <div class="col-md-3">
                        <div>
                            <fieldset>

                                <legend>ASSEMBLY</legend>

                                <div class="row">
                                    <div class="col-md-6 text-center">
                                        <p class="t-label">
                                            PLAN
                                        </p>
                                        <p class="t1-value">
                                            554
                                        </p>
                                    </div>

                                    <div class="col-md-6 text-center">
                                        <p class="t-label">
                                            TARGET
                                        </p>
                                        <p class="t1-value">
                                            477
                                        </p>

                                    </div>
                                </div>
                            </fieldset>
                        </div>
                        1
                    </div>
                    <div class="col-md-3">
                        1
                    </div>
                    <div class="col-md-3">
                        1
                    </div>
                    <div class="col-md-3">
                        1
                    </div>
                </div> -->

            </section>
            <section class="content container-fluid">
                <input type="hidden" name="page" id="page" value="live1">
                <!-- <div class="row">
                    <div class="col-md-12">
                        <?php
                        $shift_pattern = get_setting('ASSY shift pattern');
                        $show_items = $g_items;
                        // if($shift_pattern == "shift3") {
                        //     $show_items = array_splice($show_items, 0, -2);
                        // }
                        ?>
                        <table class="table table-bordered" id="ASSEMBLY">
                            <tr>
                                <td style="border-top: 1px solid #fff;border-left: 1px solid #fff; "></td>
                                <td colspan="5" class="title-td" style="font-size: 30px;font-weight: bold;">ASSEMBLY</td>
                            </tr>
                            <tr>
                                <td class="title-td" style="font-weight: bold; font-size: 24px">ANDON</td>
                                <td class="title-td">
                                    <?php
                                    $header_link = get_setting('ASSY LINK');
                                    if (empty($header_link))
                                        $header_link = '#';
                                    echo '<a href="' . $header_link . '" style="color: #FFF;" target="_blank">ASSY</a>';
                                    ?>
                                </td>
                                <td style="width: 50px;" rowspan="<?php echo count($show_items) + 1 ?>" class="title-td"></td>
                                <td class="title-td">
                                    <?php
                                    $header_link = get_setting('SHORT BLOCK LINK');
                                    if (empty($header_link))
                                        $header_link = '#';
                                    echo '<a href="' . $header_link . '" style="color: #FFF;" target="_blank">S/BLOCK</a>';
                                    ?>
                                </td>
                                <td class="title-td">
                                    <?php
                                    $header_link = get_setting('HEAD SUB LINK');
                                    if (empty($header_link))
                                        $header_link = '#';
                                    echo '<a href="' . $header_link . '" style="color: #FFF;" target="_blank">HEAD SUB</a>';
                                    ?>
                                </td>
                                <td class="title-td">
                                    <?php
                                    $header_link = get_setting('CAM HSG LINK');
                                    if (empty($header_link))
                                        $header_link = '#';
                                    echo '<a href="' . $header_link . '" style="color: #FFF;" target="_blank">CAM HSG</a>';
                                    ?>
                                </td>
                            </tr>
                            <?php
                            foreach ($show_items as $item) {
                                echo '<tr>';
                                echo '<td class="title-td">' . $item . '</td>';
                                $value_name = str_replace(" +/-", "", $item);
                                $value_name = str_replace("/", "", $value_name);
                                $value_name = str_replace(" ", "_", strtolower($value_name));
                                $unit = '';
                                if (strpos($value_name, "opr") !== false)
                                    $unit = ' %';
                                foreach ($g_andon as $machine) {
                                    if ($value_name == 'target') {
                                        echo '<td class="value-td has-details" style="border: 1px solid #373737;" data-machine="' . $machine . '">';
                                        echo '<span class="' . $value_name . '"></span>' . $unit;
                                        echo '<span class="details">' . get_tag_setting("ASSEMBLY", $machine, $value_name) . '%</span>';
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
            }, 30000)

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

                    console.log("AAAAAAAAAAAAA", result);
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
                                    if (old_value !== -1) {
                                        if (value > str_to_time(old_value[table][machine][item]['value'])) {
                                            is_flashing = true;
                                        }
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
                                        setTimeout(removeRed, 15000);
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
                                } else if (item === 'ot_plan' || item === 'ot_call') {
                                    var hour = Math.floor(result[table][machine][item]['value']/100);
                                    var minute = result[table][machine][item]['value']%100;
                                    span1.text(hour.toString().padStart(2,'0') + ':' + minute.toString().padStart(2,'0'));
                                }else {
                                    span1.text(value);
                                }

                                // span.text(result[table][machine][item]['value'])
                                // let value = result[table][machine][item]['value']
                                // span1.html((item === 'shift_opr' || item === 'last_hour_opr') ? value + "<span class='text'>%</span>" : value)
                                

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
                                    var span1 = $(document).find('div[id=' + table + ']').find('div[data-machine="' + machine + '"]').find('p.shift_line_stop');

                                    var td = span.closest('td');
                                    var td1 = span1.closest('div');

                                    td.removeClass('red-td');
                                    td.removeClass('yellow-td');
                                    td.removeClass('green-td');
                                    td.addClass('blink-bg');

                                    td1.removeClass('red-td');
                                    td1.removeClass('yellow-td');
                                    td1.removeClass('green-td');
                                    td1.addClass('blink-bg');
                                } else {
                                    td.removeClass('blink-bg');
                                    td.addClass(result[table][machine]['shift_line_stop']['style']);

                                    td1.removeClass('blink-bg');
                                    td1.addClass(result[table][machine]['shift_line_stop']['style']);
                                }

                            }
                        }
                    }
                    old_value = result;

                    is_flashing = false;
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