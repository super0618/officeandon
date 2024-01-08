<?php
require_once ("db_config.php");
require_once ("functions.php");

$page_name = "history_1";

require_once ("assets_inc.php");

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
                    <form class="form-horizontal" method="post" action="export_excel.php">
                        <div class="box box-primary">
                            <div class="box-header with-border">
                                <div class="col-md-4">
                                    <label class="col-sm-5 control-label">Select Date</label>
                                    <div class="col-sm-7">
                                        <input name="date" id="date" class="form-control date-picker" type="text" autocomplete="off" value="<?php echo date('d/m/Y');?>">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-sm-5 control-label">Select Shift</label>
                                    <div class="col-sm-7">
                                        <select class="form-control" id="select_shift" name="select_shift">
                                            <option value="shift1" selected>Shift 1</option>
                                            <option value="shift2">Shift 2</option>
                                            <option value="shift3">Shift 3</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="button" class="btn btn-primary" id="load_data">Load Data</button>
                                    <button type="submit" class="btn btn-default" id="export_data">Export Data</button>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="page" id="page" value="live1">
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <table class="table table-bordered" id="ASSEMBLY">
                        <tr>
                            <td style="border-top: 1px solid #808080;border-left: 1px solid #808080; "></td>
                            <td colspan="5" class="title-td" style="font-size: 30px;font-weight: bold;">ASSEMBLY</td>
                        </tr>
                        <tr>
                            <td class="title-td" style="font-weight: bold; font-size: 24px">ANDON</td>
                            <td class="title-td">
                                <?php
                                $header_link = get_setting('ASSY LINK');
                                if(empty($header_link))
                                    $header_link = '#';
                                echo '<a href="'.$header_link.'" style="color: #FFF;" target="_blank">ASSY</a>';
                                ?>
                            </td>
                            <td style="width: 50px;" rowspan="12" class="title-td"></td>
                            <td class="title-td">
                                <?php
                                $header_link = get_setting('SHORT BLOCK LINK');
                                if(empty($header_link))
                                    $header_link = '#';
                                echo '<a href="'.$header_link.'" style="color: #FFF;" target="_blank">S/BLOCK</a>';
                                ?>
                            </td>
                            <td class="title-td">
                                <?php
                                $header_link = get_setting('HEAD SUB LINK');
                                if(empty($header_link))
                                    $header_link = '#';
                                echo '<a href="'.$header_link.'" style="color: #FFF;" target="_blank">HEAD SUB</a>';
                                ?>
                            </td>
                            <td class="title-td">
                                <?php
                                $header_link = get_setting('CAM HSG LINK');
                                if(empty($header_link))
                                    $header_link = '#';
                                echo '<a href="'.$header_link.'" style="color: #FFF;" target="_blank">CAM HSG</a>';
                                ?>
                            </td>
                        </tr>
                        <?php
                        foreach ($g_items as $item){
                            echo '<tr>';
                            echo '<td class="title-td">'.$item.'</td>';
                            $value_name = str_replace(" +/-", "", $item);
                            $value_name = str_replace("/", "", $value_name);
                            $value_name = str_replace(" ", "_", strtolower($value_name));
                            $unit = '';
                            if(strpos($value_name, "opr") !== false)
                                $unit = ' %';
                            foreach ($g_andon as $machine){
                                echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="'.$machine.'"><span class="'.$value_name.'"></span>'.$unit.'</td>';
                            }
                            echo '</tr>';
                        }
                        ?>
                    </table>
                </div>
                <div class="col-md-6">
                    <table class="table table-bordered" id="MACHINING">
                        <tr>
                            <td style="border-top: 1px solid #808080;border-left: 1px solid #808080; border-bottom: 1px solid #808080"></td>
                            <td colspan="6" class="title-td" style="font-size: 30px; font-weight: bold;">MACHINING</td>
                        </tr>
                        <?php
                        echo '<tr>';
                        echo '<td style="border-top: 1px solid #808080;border-left: 1px solid #808080; "></td>';
                        foreach ($g_machines as $machine) {
                            $header_link = get_setting($machine . ' LINK');
                            if(empty($header_link))
                                $header_link = '#';
                            echo '<td class="title-td"><a href="'.$header_link.'" style="color: #FFF;" target="_blank">'.$machine.'</a></td>';
                        }
                        echo '</tr>';

                        foreach ($g_items as $item) {
                            echo '<tr>';
                            echo '<td class="title-td">' . $item . '</td>';
                            $value_name = str_replace(" +/-", "", $item);
                            $value_name = str_replace("/", "", $value_name);
                            $value_name = str_replace(" ", "_", strtolower($value_name));
                            $unit = '';
                            if(strpos($value_name, "opr") !== false)
                                $unit = ' %';
                            foreach ($g_machines as $machine) {
                                echo '<td class="value-td" style="border: 1px solid #373737;" data-machine="' . $machine . '"><span class="'.$value_name.'"></span>'.$unit.'</td>';
                            }
                            echo '</tr>';
                        }
                        ?>
                    </table>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-1 col-md-10">
                    <table class="table table-bordered" id="Period_Cumulative">
                        <tr>
                            <td></td>
                            <?php
                            $period_start_date = get_setting('period_start_date');
                            $period_end_date = get_setting('period_end_date');
                            ?>
                            <td colspan="9" class="title-td" style="font-size: 30px;font-weight: bold ">Period Cumulative from <?php echo $period_start_date; ?> to <?php echo $period_end_date; ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="title-td">K</td>
                            <td colspan="6" class="title-td">M</td>
                            <td colspan="2" class="title-td">C</td>
                        </tr>
                        <?php
                        echo '<tr>';
                        echo '<td></td>';
                        foreach ($g_period_cumulative as $machine) {
                            echo '<td class="title-td">'.$machine.'</td>';
                        }
                        echo '</tr>';

                        echo '<tr>';
                        echo '<td style="background-color: #FFF;">Actual to Date<br>Period Actual<br>Period Plan</td>';
                        foreach ($g_period_cumulative as $machine) {
                            echo '<td class="value-td" data-machine="'.$machine.'"></td>';
                        }
                        echo '</tr>';
                        ?>
                    </table>
                </div>
                <div class="col-md-1"></div>
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
        read_history_values();
        get_period_cumulative();

        $("#load_data").on('click', function () {
            read_history_values();
        });

        $(".date-picker").datetimepicker({
            format: "DD/MM/YYYY",
            maxDate: moment(),
            useCurrent: false
        })

        function read_history_values()
        {
            $("#loading").fadeIn(500);
            var date = $("#date").val()
            var shift = $("#select_shift").val()
            var page = $("#page").val()
            $.ajax({
                url: "actions.php",
                method: "post",
                data: {
                    action: "read_history_values",
                    page: page,
                    date: date,
                    shift: shift
                },
                dataType: "JSON"
            }).done(function (result) {
                if(result['error'] !== undefined && result['error'] != "") {
                    alert(result['error']);
                    $("#loading").fadeOut(500);
                } else {
                    $("#loading").fadeOut(500);
                    for(const table in result) {
                        if(table != 'Period_Cumulative') {
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
                }
            });
        }

        function get_period_cumulative()
        {
            $.ajax({
                url: "actions.php",
                method: "post",
                data: {
                    action: "get_period_cumulative",
                    page: "index",
                },
                dataType: "JSON"
            }).done(function (result) {
                for(const machine in result) {
                    var td = $(document).find('table[id="Period_Cumulative"]').find('td[data-machine="' + machine + '"]')
                    var html = result[machine]['actual'] + '<br/>' + result[machine]['plan_to_date'] + '<br/>' + result[machine]['plan_period'];
                    td.html(html);
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