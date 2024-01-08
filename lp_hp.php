<?php
require_once ("db_config.php");
require_once ("functions.php");

$_SESSION['prev_page'] = 'index.php';

$page_name = "lp_hp";

require_once ("assets_inc.php");
$shift = get_shift($current);

$start_time = $shift['start'];
$end_time = $shift['end'];
$live_shift = $shift['shift'];
$live_date = $shift['date'];

?>
<style>
    .shift_plan {
        cursor: pointer;
    }
</style>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse" onload="startTime()">
<div class="wrapper">
    <!-- Main Header -->
    <?php include("header.php"); ?>

    <!-- Left side column. contains the logo and sidebar -->
    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #808080">
        <!-- Main content -->
        <section class="content container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <form class="form-horizontal">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <div class="col-md-4">
                                    <label class="col-sm-5 control-label">Select Date</label>
                                    <div class="col-sm-7">
                                        <input name="date" id="date" class="form-control date-picker" type="text" autocomplete="off" value="<?php echo convert_date_string($live_date);?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-sm-5 control-label">Select Shift</label>
                                    <div class="col-sm-7">
                                        <select class="form-control" id="select_shift" name="select_shift">
                                            <option value="shift1">Shift 1</option>
                                            <option value="shift2">Shift 2</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary" id="load_data">Load Data</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="page" id="page" value="live2">
                        <input type="hidden" name="live_shift" id="live_shift" value="<?php echo $live_shift;?>">
                        <input type="hidden" name="live_date" id="live_date" value="<?php echo convert_date_string($live_date);?>">
                    </form>
                </div>

            </div>
            <div class="row">
                <div class="col-md-5">
                    <table class="table table-bordered" id="LOW_PRESSURE_CASTING">
                        <tr>
                            <td style="border-top: 1px solid #808080;border-left: 1px solid #808080; border-bottom: 1px solid #808080;"></td>
                            <td colspan="5" class="title-td" style="font-size: 30px;font-weight: bold ">LOW PRESSURE CASTING</td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #808080;border-left: 1px solid #808080; "></td>
                            <td class="title-td">HEAD</td>
                            <td rowspan="11" style="width: 30px;" class="title-td"></td>
                            <td rowspan="2" colspan="2" class="title-td">EDM ACTUAL</td>
                        </tr>
                        <?php
                        foreach($g_items as $item){
                            echo '<tr>';
                            echo '<td class="title-td">'.$item.'</td>';
                            $value_name = str_replace(" +/-", "", $item);
                            $value_name = str_replace("/", "", $value_name);
                            $value_name = str_replace(" ", "_", strtolower($value_name));
                            $unit = '';
                            if(strpos($value_name, "opr") !== false)
                                $unit = ' %';
                            echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="HEAD"><span class="'.$value_name.'"></span>'.$unit.'</td>';

                            if($item == 'TARGET') {
                                echo '<td class="title-td">EDM1</td>';
                                echo '<td class="title-td">EDM4</td>';
                            }

                            if($item == 'ACTUAL') {
                                echo '<td class="value-td" rowspan="2" style="border: 1px solid #373737; font-size: 34px;" data-machine="EDM1"></td>';
                                echo '<td class="value-td" rowspan="2" style="border: 1px solid #373737; font-size: 34px;" data-machine="EDM4"></td>';
                            }

                            if($item == 'SHIFT LINE STOP') {
                                echo '<td class="title-td">EDM2</td>';
                                echo '<td class="title-td">EDM5</td>';
                            }

                            if($item == 'SHIFT OPR IN') {
                                echo '<td class="value-td" rowspan="2" style="border: 1px solid #373737; font-size: 34px;" data-machine="EDM2"></td>';
                                echo '<td class="value-td" rowspan="2" style="border: 1px solid #373737; font-size: 34px;" data-machine="EDM5"></td>';
                            }

                            if($item == 'LAST HOUR OPR') {
                                echo '<td class="title-td">EDM3</td>';
                                echo '<td class="title-td">EDM6</td>';
                            }

                            if($item == 'O/T PLAN') {
                                echo '<td class="value-td" rowspan="2" style="border: 1px solid #373737; font-size: 34px;" data-machine="EDM3"></td>';
                                echo '<td class="value-td" rowspan="2" style="border: 1px solid #373737; font-size: 34px;" data-machine="EDM6"></td>';
                            }
                            echo '</tr>';
                        }
                        ?>
                    </table>
                </div>

                <div class="col-md-5">
                    <table class="table table-bordered" id="HIGH_PRESSURE_CASTING">
                        <tr>
                            <td style="border-top: 1px solid #808080;border-left: 1px solid #808080; border-bottom: 1px solid #808080;"></td>
                            <td colspan="5" class="title-td" style="font-size: 30px;font-weight: bold;">HIGH PRESSURE CASTING</td>
                        </tr>
                        <tr>
                            <td style="border-top: 1px solid #808080;border-left: 1px solid #808080; "></td>
                            <td class="title-td">BLOCK</td>
                            <td rowspan="11" style="width: 30px;" class="title-td"></td>
                            <td rowspan="2" colspan="2" class="title-td">H1/H2 ACTUAL</td>
                        </tr>
                        <?php
                        foreach($g_items as $item){
                            echo '<tr>';
                            echo '<td class="title-td">'.$item.'</td>';
                            $value_name = str_replace(" +/-", "", $item);
                            $value_name = str_replace("/", "", $value_name);
                            $value_name = str_replace(" ", "_", strtolower($value_name));
                            $unit = '';
                            if(strpos($value_name, "opr") !== false)
                                $unit = ' %';
                            echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="HEAD"><span class="'.$value_name.'"></span>'.$unit.'</td>';

                            if($item == 'TARGET') {
                                echo '<td class="title-td">H1</td>';
                                echo '<td class="title-td">H2</td>';
                            }

                            if($item == 'ACTUAL') {
                                echo '<td class="value-td" rowspan="2" style="border: 1px solid #373737; font-size: 34px;" data-machine="H1"></td>';
                                echo '<td class="value-td" rowspan="2" style="border: 1px solid #373737; font-size: 34px;" data-machine="H2"></td>';
                            }

                            if($item == 'SHIFT LINE STOP') {
                                echo '<td rowspan="6" colspan="2" style="border-right: 1px solid #808080; border-bottom: 1px solid #808080;"></td>';
                            }
                            echo '</tr>';
                        }
                        ?>


                    </table>
                </div>
                <div class="col-md-2">
                    <table class="table table-bordered" id="SHIFT_PATTERN">
                        <tr><td colspan="2" class="title-td" style="font-size: 30px;font-weight: bold;">SHIFT PATTERN</td></tr>
                        <?php
                        foreach ($g_shift_patterns as $machine){
                            echo '<tr>';
                            if($machine == 'TMAB 5' || $machine == 'TMAB 10' || $machine == 'TMAB 15' || $machine == 'TBU 30')
                                echo '<td class="title-td">'.$machine.'`</td>';
                            else
                                echo '<td class="title-td">'.$machine.'</td>';
                            echo '<td class="value-td" style="border-bottom: 1px solid #373737;width:120px;" data-machine="'.$machine.'"></td>';
                            echo '</tr>';
                        }
                        ?>
                    </table>
                </div>
            </div>




        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Main Footer -->
    <?php include ("footer.php"); ?>
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
    $(function () {
        read_values();

        $("#load_data").on('click', function () {
            read_values();
        });

        $(".date-picker").datetimepicker({
            format: "DD/MM/YYYY",
            maxDate: moment()

        })

        setInterval(function () {
            var date = $("#date").val()
            var shift = $("#select_shift").val()
            var live_date = $("#live_date").val()
            var live_shift = $("#live_shift").val()
            if(live_date == date && live_shift == shift)
                read_values()
            else
                console.log('Reading history data')
        }, 1000 * 60);

        function read_values()
        {
            var date = $("#date").val()
            var shift = $("#select_shift").val()
            var page = $("#page").val()
            $.ajax({
                url: "actions.php",
                method: "post",
                data: {
                    action: "read_live_values",
                    page: page,
                    date: date,
                    shift: shift
                },
                dataType: "JSON"
            }).done(function (result) {
                console.log(result);
                for(const table in result) {
                    if(table != 'SHIFT_PATTERN') {
                        for(const machine in result[table]) {
                            for(const item in result[table][machine]) {
                                var span = $(document).find('table[id='+ table +']').find('td[data-machine="' + machine + '"]').find('span.'+item);
                                var td = span.closest('td');
                                span.text(result[table][machine][item]['value'])
                                td.removeClass('red-td');
                                td.removeClass('yellow-td');
                                td.removeClass('green-td');
                                td.addClass(result[table][machine][item]['style']);
                            }
                        }

                        if(table == 'LOW_PRESSURE_CASTING') {
                            var edms = ['EDM1', 'EDM2', 'EDM3', 'EDM4', 'EDM5', 'EDM6']
                            for(var index in edms){
                                var td = $(document).find('table[id='+ table +']').find('td[data-machine="' + edms[index] + '"]')
                                td.text(result[table][edms[index]]['value'])
                            }
                        }

                        if(table == 'HIGH_PRESSURE_CASTING') {
                            var hs = ['H1', 'H2']
                            for(var index in hs){
                                var td = $(document).find('table[id='+ table +']').find('td[data-machine="' + hs[index] + '"]')
                                td.text(result[table][hs[index]]['value'])
                            }
                        }

                    } else {
                        for(const machine in result[table]) {
                            var td = $(document).find('table[id='+ table +']').find('td[data-machine="' + machine + '"]')
                            td.text(result[table][machine]['value'])
                            td.removeClass('red-td');
                            td.removeClass('yellow-td');
                            td.removeClass('green-td');
                            td.addClass(result[table][machine]['style']);
                        }
                    }
                }
            });
        }

        $(document).on('click', '.shift_plan', function () {
            var value = $(this).text();
            var td = $(this).closest('td');
            var machine = td.data('machine');
            var table = $(this).closest('table').attr('id');
            $("#table").val(table);
            $("#machine").val(machine);
            $("#shift_plan").val(value);
            $("#shift_plan_modal").modal()
        });

        $('#shift_plan').keydown(function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $("#save_shift_plan").click();
            }
        });

        $("#save_shift_plan").on('click', function () {
            var shift_plan = $("#shift_plan").val()
            if(shift_plan == '' || shift_plan < 0) {
                $("#shift_plan").focus();
                return false;
            }

            var table_name = $("#table").val();
            var machine = $("#machine").val();
            var value = $("#shift_plan").val();
            var g_date = $("#date").val()
            var shift = $("#select_shift").val()
            $.ajax({
                url: "actions.php",
                method: "post",
                data: {
                    action: "save_tag_setting",
                    table_name: table_name,
                    machine: machine,
                    field_name: "shift_plan",
                    g_date:g_date,
                    g_shift:shift,
                    value: value,
                },
            }).done(function (result) {
                if(result == "OK") {
                    $("#shift_plan_modal").modal('hide');
                    $(document).find('table[id='+ table_name +']').find('td[data-machine="' + machine + '"]').find('span.shift_plan').text(value)
                } else {
                    alert("Save failed");
                }
            });
        });
    });
</script>

</body>
</html>