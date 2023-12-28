<?php
require_once ("db_config.php");
require_once ("functions.php");
$page_name = "live_1";
require_once ("assets_inc.php");

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
    @keyframes blinkingBackground{
        0%		{ background-color: #ef0a1a; color: #fff;}
        25%		{ background-color: #ffffff; color: #000;}
        50%		{ background-color: #ef0a1a; color: #fff;}
        75%		{ background-color: #ffffff; color: #000;}
        100%	{ background-color: #ef0a1a; color: #fff;}
    }
    .blink-bg1 {
        padding: 10px;
        /*display: inline-block;
        border-radius: 5px;*/
        animation: blinkingBackground1 4s infinite;
    }
    @keyframes blinkingBackground1{
        0%		{ background-color: #ef0a1a; color: #fff;}
        25%		{ background-color: black; color: #fff;}
        50%		{ background-color: #ef0a1a; color: #fff;}
        75%		{ background-color: black; color: #fff;}
        100%	{ background-color: #ef0a1a; color: #fff;}
    }
</style>
<body class="hold-transition skin-blue sidebar-mini sidebar-collapse" onload="startTime()">
<div class="wrapper">
    <!-- Main Header -->
    <?php include("header.php"); ?>

    <!-- Left side column. contains the logo and sidebar -->
    <?php include("menu.php"); ?>

    <div class="content-wrapper" style="background-color: white">
        
    </div>
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
<iframe src="about:blank" id="page_cycle_frame"
        style="display: none; position:fixed; top:0; left:0; bottom:0; right:0; width:100%; height:100%; border:none; margin:0; padding:0; overflow:hidden;">
</iframe>

<?php
$page_cycle = get_page_cycles();
$index = 0;
// printf("%s, %s, %s", $page_cycle[0]->page_url, $page_cycle[1]->page_url, $page_cycle[2]->page_url);
if(!empty($page_cycle)){
    $page_cycle_page = $page_cycle[$index]->page_url;
    $page_cycle_seconds = $page_cycle[$index]->seconds;
} else {
    $page_cycle_page = '';
    $page_cycle_seconds = 0;
}
?>
<input type="hidden" id="page_cycle_page" value="<?php echo $page_cycle_page; ?>">
<input type="hidden" id="page_cycle_seconds" value="<?php echo $page_cycle_seconds; ?>">


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
        <?php
            $js_array = json_encode($page_cycle);
            echo "var page_cycle = ". $js_array . ";\n";
        ?>
        var page_cycle_seconds = $("#page_cycle_seconds").val();
        var page_cycle_page = $("#page_cycle_page").val();
        var index = 0;

        if(page_cycle_seconds > 0 && page_cycle_page !="") {
            $("#page_cycle_frame").attr('src', $("#page_cycle_page").val());
            $("#page_cycle_frame").show();
            setInterval(function () {
                if($("#page_cycle_frame").is(":visible"))
                    console.log('Iframe loaded')
                else {
                    $("#page_cycle_frame").attr('src', page_cycle_page);
                    $("#page_cycle_frame").show();
                }
                page_cycle_seconds -= 1;
                if(page_cycle_seconds == 0) {
                    index ++;
                    if(index == page_cycle.length)
                        index = 0;
                    page_cycle_page = page_cycle[index].page_url;
                    page_cycle_seconds = page_cycle[index].seconds;
                    $("#page_cycle_frame").attr('src', page_cycle_page);
                }
            }, 1000);
        } else {
        }

        function read_values()
        {
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
            }).done(function (result) {
                console.log(result);
                for(const table in result) {
                    for(const machine in result[table]) {
                        for(const item in result[table][machine]) {
                            var span = $(document).find('table[id='+ table +']').find('td[data-machine="' + machine + '"]').find('span.'+item);
                            var td = span.closest('td');

                            if(item === "shift_line_stop"){
                                if(result[table][machine]['shift_line_stop']['value']!='00:00' && span.text() != '' ) {
                                    if(result[table][machine]['shift_line_stop']['value'] != span.text()) {
                                        td.addClass('blink-bg');
                                        $(td.closest('tr')).find('.title-td').addClass('blink-bg1');
                                    } else {
                                        td.removeClass('blink-bg');
                                        $(td.closest('tr')).find('.title-td').removeClass('blink-bg1');
                                    }
                                }
                            }

                            span.text(result[table][machine][item]['value'])
                            td.removeClass('red-td');
                            td.removeClass('yellow-td');
                            td.removeClass('green-td');
                            td.addClass(result[table][machine][item]['style']);
                        }

                        if(table == 'ASSEMBLY'){
                            if(result[table][machine]['shift_line_stop_finish']['value'] == 1 && result[table][machine]['shift_line_stop_start']['value'] != 0) {
                                var span = $(document).find('table[id='+ table +']').find('td[data-machine="' + machine + '"]').find('span.shift_line_stop');
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
                //console.log(result);
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