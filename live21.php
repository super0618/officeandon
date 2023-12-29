<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<?php
require_once("db_config.php");
require_once("functions.php");
$page_name = "live_2";
require_once("assets_inc.php");
$shift = get_shift($current, 'shift2');
$live_shift = $shift['shift'];
$live_date = $shift['date'];

?>
<style>
    .container {
        width: 100%;
        margin: 0;
        padding: 0;
        max-width:5000px;
        height: 87%;
    }

    .p-5 {
        height: 100%;
    }

    .pressure {
        height: 100%;
    }

    .body {
        border: 5px rgb(149, 149, 149) solid;
        border-radius: 5px;
        position: relative;
    }

    .smallbody {
        border: 3px rgb(149, 149, 149) solid;
        border-radius: 5px;
        position: relative;
        padding-top: 30px;
		height: 117px;
    }

  .title {
    position: absolute;
    font-size: 46px;
    font-weight: bold;
    top: -51px;
    left: 51%;
    height: 55px;
    transform: translateX(-50%);
    background-color: black;
    width: 83%;
}

    .start {
        background-color: black;

    }

    .text01 {
        font-size: 35px;
        font-weight: bold;
        margin: 0px;
    }

   .text02 {
    font-size: 193px;
    font-weight: bold;
    margin: 0px;
    padding-top: 55px;
    line-height: 35px;
}
.col-sm-6.text-white.text-center {
    padding: 120px 0px 0px 0px;
}

.row.pb-1 {
    margin: -54px 0px 69px 0px;
}
    .text03 {
        font-size: 120px;
        line-height: 78px;
        font-weight: bold;
        color: white;
    }

    .red {
        color: red;

    }

    .highcenter {
        display: flex;
        align-items: center;
        /* Vertically centers the children */
        justify-content: center;

    }

    .text04 {
        font-size: 80px;
        font-weight: bold;
        margin: 0px;
        line-height: 80px;
        color: rgb(21, 234, 38)
    }

    .text06 {
        font-size: 25px;
        font-weight: bold;
        color: rgb(21, 234, 38)
    }

    .text05 {
        font-size: 120px;
        font-weight: bold;
        line-height: 40px;
    }

    .text07 {
        line-height: 40px;
        font-size: 45px;
        font-weight: bold;
        color: rgb(21, 234, 38)
    }

    .text08 {

        font-size: 33px;
        font-weight: bold;
    }

    .yellow {
        color: rgb(253, 235, 9)
    }

    .green {
        color: rgb(21, 234, 38)
    }

    .text0 {
        font-size: 30px;
        font-weight: bold;
    }

    .grey {
        color: #9a9a9a;
    }

    .white {
        color: white;
    }

    hr {
        height: 8px;
        margin-top: 15px;
        margin-bottom: 0px;
        border: none;
    }

    .mbody {
        padding-top: 123px;
        padding-bottom: 30px;
    }
	.white.text-center.text04 {
    font-size: 140px;
}

    .shift_plan {
        cursor: pointer;
    }

    .blink-bg {
        padding: 10px;
        /*display: inline-block;
        border-radius: 5px;*/
        animation: blinkingBackground 4s infinite;
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
</style>

<body class="hold-transition skin-blue sidebar-mini sidebar-collapse" onload="startTime()"></body>
<div class="wrapper" id = "page" value = "live2">
    <!-- Main Header -->
    <?php include("header.php"); ?>

    <!-- Left side column. contains the logo and sidebar -->
    <?php include("menu.php"); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper" style="background-color: #000">
        <div class="container start">
            <div class="row name">
                <div></div>
            </div>
            <div class="row p-5">
                <div class="col-md-12 col-lg-6 p-2" id="LOW_PRESSURE_CASTING">
                    <div class="body p-3 pressure" data-machine="LP HEAD">
                        <div class="title grey text-center p-4 pt-2 pb-2">
                            LOW PRESSURE (HEAD)
                        </div>
                        <div class="row p-3 " style="height:15%">
                            <div class="col-sm-6  text-center">
                                <div>
                                    <p class="text01 grey">PLAN</p>
                                    <p class="text02 white shift_plan">498</p>
                                </div>
                            </div>
                            <div class="col-6 text-white text-center">
                                <div>
                                    <p class="text01 grey">TARGET</p>
                                    <p class="text02 white target">190</p>
                                    <!-- <p class="text2 details ">0%</p> -->
                                </div>
                            </div>
                        </div>
                        <div class="row " style="height:25%">
                            <div class="col-sm-6 text-white text-center">
                                <div>
                                    <p class="text01 grey">ACTUAL</p>
                                    <p class="text03 actual">195</p>
                                </div>
                            </div>
                            <div class="col-sm-6 text-white text-center">
                                <div>
                                    <p class="text01 grey">+/-</p>
                                    <p class="text04 live">+5</p>
                                </div>
                            </div>
                        </div>
                        <div class="row pb-1" style="height:25%">
                            <div class="col-sm-6 text-white text-center">
                                <div>
                                    <p class="text01 grey">SHIFT OPR</p>
                                    <p class="text04 shift_opr">98.9<span class="text0">%</span></p>
                                </div>
                            </div>
                            <div class="col-sm-6 text-white text-center">

                                <div>
                                    <p class="text01 grey">LAST HOUR OPR</p>
                                    <p class="text04 last_hour_opr">93.2<span class="text0">%</span></p>
                                </div>
                            </div>

                        </div>
                        <div class="row pb-3" style="height:35%">
                            <div class="col-sm-4 p-3">
                                <div class="smallbody " data-machine="EDM1">
                                    <div class="title grey text-center p-1 pt-2 pb-2">
                                        EDM1
                                    </div>
                                    <div class="white text-center text05">
                                        1
                                    </div>
                                    <hr class="grey">
                                    <!-- <div class="white text-center text06">00:00</div> -->
                                </div>
                            </div>
                            <div class="col-sm-4 p-3">
                                <div class="smallbody " data-machine="EDM2">
                                    <div class="title grey text-center p-1 pt-2 pb-2">
                                        EDM2
                                    </div>
                                    <div class="white text-center text05">
                                        1
                                    </div>
                                    <hr class="grey">
                                    <!-- <div class="white text-center text06">00:00</div> -->
                                </div>
                            </div>
                            <div class="col-sm-4 p-3">
                                <div class="smallbody " data-machine="EDM3">
                                    <div class="title grey text-center p-1 pt-2 pb-2">
                                        EDM3
                                    </div>
                                    <div class="white text-center text05">
                                        1
                                    </div>
                                    <hr class="grey">
                                    <!-- <div class="white text-center text06">00:00</div> -->
                                </div>
                            </div>
                            <div class="col-sm-4 p-3">
                                <div class="smallbody " data-machine="EDM4">
                                    <div class="title grey text-center p-1 pt-2 pb-2">
                                        EDM4
                                    </div>
                                    <div class="white text-center text05">
                                        1
                                    </div>
                                    <hr class="grey">
                                    <!-- <div class="white text-center text06">00:00</div> -->
                                </div>
                            </div>
                            <div class="col-sm-4 p-3">
                                <div class="smallbody " data-machine="EDM5">
                                    <div class="title grey text-center p-1 pt-2 pb-2">
                                        EDM5
                                    </div>
                                    <div class="white text-center text05">
                                        1
                                    </div>
                                    <hr class="grey">
                                    <!-- <div class="white text-center text06">00:00</div> -->
                                </div>
                            </div>
                            <div class="col-sm-4 p-3">
                                <div class="smallbody " data-machine="EDM6">
                                    <div class="title grey text-center p-1 pt-2 pb-2">
                                        EDM6
                                    </div>
                                    <div class="white text-center text05">
                                        1
                                    </div>
                                    <hr class="grey" />
                                    <!-- <div class="white text-center text06">00:00</div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-12 col-lg-6 p-2" id="HIGH_PRESSURE_CASTING">
                    <div class="body p-3 pressure" data-machine="HP BLOCK">
                        <div class="title grey text-center p-4 pt-2">
                            HIGH PRESSURE (BLOCK)
                        </div>
                        <div class="row p-3 " style="height:15%">
                            <div class="col-sm-6  text-center">
                                <div>
                                    <p class="text01 grey">PLAN</p>
                                    <p class="text02 white shift_plan">498</p>
                                </div>
                            </div>
                            <div class="col-6 text-white text-center">
                                <div>
                                    <p class="text01 grey">TARGET</p>
                                    <p class="text02 white target">36</p>
                                </div>
                            </div>
                        </div>
                        <div class="row " style="height:25%">
                            <div class="col-sm-6 text-white text-center">
                                <div>
                                    <p class="text01 grey">ACTUAL</p>
                                    <p class="text03 actual">195</p>
                                </div>
                            </div>
                            <div class="col-sm-6 text-white text-center">
                                <div>
                                    <p class="text01 grey">+/-</p>
                                    <p class="text04 live">+20</p>
                                </div>
                            </div>
                        </div>
                        <div class="row  " style="height:25%">
                            <div class="col-sm-6 text-white text-center">
                                <div>
                                    <p class="text01 grey">SHIFT OPR</p>
                                    <p class="text04 shift_opr">155.6<span class="text0">%</span></p>
                                </div>
                            </div>
                            <div class="col-sm-6 text-white text-center">

                                <div>
                                    <p class="text01 grey">LAST HOUR OPR</p>
                                    <p class="text04 last_hour_opr">93.2<span class="text0">%</span></p>
                                </div>
                            </div>

                        </div>
                        <div class="row mbody" style="height:35%">
                            <div class="col-sm-6 p-3">
                                <div class="smallbody " data-machine="H1">
                                    <div class="title grey text-center p-1 pt-2 pb-2">
                                        H1
                                    </div>
                                    <div class="white text-center text04">
                                        28
                                    </div>
                                    <hr class="grey">
                                    <!-- <div class="white text-center text08">00:00</div> -->
                                </div>
                            </div>
                            <div class="col-sm-6 p-3">
                                <div class="smallbody " data-machine="H2">
                                    <div class="title grey text-center p-1 pt-2 pb-2">
                                        H2
                                    </div>
                                    <div class="white text-center text04">
                                        28
                                    </div>
                                    <hr class="grey">
                                    <!-- <div class="white text-center text08">00:00</div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- Main content -->
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
        read_values2();

        setInterval(function() {
            read_values2();
        }, 60000);

        function read_values2() {
            //$("#loading").fadeIn(500);
            var page = $("#page").val();
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
                //$("#loading").fadeOut(500);
                for (const table in result) {
                    if (table != 'SHIFT_PATTERN') {
                        if (table == 'LOW_PRESSURE_CASTING') {
                            var edms = ['EDM1', 'EDM2', 'EDM3', 'EDM4', 'EDM5', 'EDM6']
                            for (var index in edms) {
                                var td = $(document).find('table[id=' + table + ']').find('td[data-machine="' + edms[index] + '"]')

                                var td1 = $(document).find('div[id=' + table + ']').find('div[data-machine="' + edms[index] + '"]')


                                var div1 = td.find('div').first();
                                var div2 = td.find('div').last();

                                var divv1 = td1.find('div:nth-child(2)');
                                var divv2 = td1.find('div:nth-child(3)');


                                div1.text(result[table][edms[index]]['value']);
                                divv1.text(result[table][edms[index]]['value']);
                                console.log(div2.text(), result[table][edms[index]]['shift_line_stop'])
                                if (div2.text() !== result[table][edms[index]]['shift_line_stop'] && result[table][edms[index]]['shift_line_stop'] != '00:00' && div2.text() != '') {
                                    div2.removeClass('red-td');
                                    div2.removeClass('yellow-td');
                                    div2.removeClass('green-td');
                                    div2.addClass('blink-bg');
                                } else {
                                    div2.removeClass('blink-bg');
                                }

                                if (divv2.text() !== result[table][edms[index]]['shift_line_stop'] && result[table][edms[index]]['shift_line_stop'] != '00:00' && divv2.text() != '') {
                                    divv2.removeClass('red-td');
                                    divv2.removeClass('yellow-td');
                                    divv2.removeClass('green-td');
                                    divv2.addClass('blink-bg');
                                } else {
                                    divv2.removeClass('blink-bg');
                                }


                                div2.text(result[table][edms[index]]['shift_line_stop']);
                                divv2.text(result[table][edms[index]]['shift_line_stop']);
                            }
                        }

                        if (table == 'HIGH_PRESSURE_CASTING') {
                            var hs = ['H1', 'H2']
                            for (var index in hs) {
                                var td = $(document).find('table[id=' + table + ']').find('td[data-machine="' + hs[index] + '"]')
                                var td1 = $(document).find('div[id=' + table + ']').find('div[data-machine="' + hs[index] + '"]')

                                var div1 = td.find('div').first();
                                var div2 = td.find('div').last();

                                
                                var divv1 = td1.find('div:nth-child(2)');
                                var divv2 = td1.find('div:nth-child(3)');


                                div1.text(result[table][hs[index]]['value']);
                                divv1.text(result[table][hs[index]]['value']);

                                if (div2.text() !== result[table][hs[index]]['shift_line_stop'] && result[table][hs[index]]['shift_line_stop'] != '00:00' && div2.text() != '') {
                                    div2.removeClass('red-td');
                                    div2.removeClass('yellow-td');
                                    div2.removeClass('green-td');
                                    div2.addClass('blink-bg');
                                } else {
                                    div2.removeClass('blink-bg');
                                    div2.addClass(result[table][hs[index]]['shift_line_stop']['style']);
                                }

                                if (divv2.text() !== result[table][hs[index]]['shift_line_stop'] && result[table][hs[index]]['shift_line_stop'] != '00:00' && divv2.text() != '') {
                                    divv2.removeClass('red-td');
                                    divv2.removeClass('yellow-td');
                                    divv2.removeClass('green-td');
                                    divv2.addClass('blink-bg');
                                } else {
                                    divv2.removeClass('blink-bg');
                                    divv2.addClass(result[table][hs[index]]['shift_line_stop']['style']);
                                }

                                div2.text(result[table][hs[index]]['shift_line_stop']);
                                divv2.text(result[table][hs[index]]['shift_line_stop']);
                            }
                        }
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
                                
                                // span.text(result[table][machine][item]['value'])
                                // span1.text(result[table][machine][item]['value'])
                                let value = result[table][machine][item]['value']
                                
                                if (item === 'shift_opr' || item === 'last_hour_opr') {
                                    value = Number(value);
                                    if(value >= 100){
                                        value = value.toString().substring(0, 3);
                                        value = Number(value);
                                    } else if(value >= 10) {
                                        value = value.toFixed(1);
                                    } else {
                                        value = value.toFixed(2);
                                    }
                                    span1.html(value + "<span class='text'>%</span>");
                                }
                                else {
                                    span1.html(value);
                                }
                                td.removeClass('red-td');
                                td.removeClass('yellow-td');
                                td.removeClass('green-td');
                                td.addClass(result[table][machine][item]['style']);

                                td1.removeClass('red-td');
                                td1.removeClass('yellow-td');
                                td1.removeClass('green-td');
                                td1.addClass(result[table][machine][item]['style']);
                            }
                        }

                    } else {
                        for (const machine in result[table]) {
                            var td = $(document).find('table[id=' + table + ']').find('td[data-machine="' + machine + '"]')
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

        get_period_cumulative();

        function get_period_cumulative() {
            $.ajax({
                url: "actions.php",
                method: "post",
                data: {
                    action: "get_period_cumulative",
                    page: "casting",
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