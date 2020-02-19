<?php
require "../Util/navOtherPages.php";
session_start();
$_SESSION['current_page'] = 'admin_reports';
onlyAdmin();
?>
<html>
<head>
    <title>Ch1ldsplay Media Production | Reports</title>
    <link rel="icon" href="../Images/logo.png" type="image/gif" sizes="16x16">
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="../assets/css/main.css"/>

    <style>
       td{
           display: table-cell;
           vertical-align: middle;
        }
    </style>

</head>
<body class="is-preload">

<!-- Wrapper -->
<div id="wrapper">

    <?php
        nav();
    ?>

    <!-- Section -->
    <section class="main alt">
        <header>
            <h1>Report Generation</h1>
        </header>
        <div class="inner style2">
            <h3>Options</h3>

            <div class="row">
                <div class="col-6-large">
                    <strong>Report type</strong>
                    <select name="demo-category" id="select-report-type" class="row_1_opts">
                        <option value="">- Report type -</option>
                        <option value="summary">Summary</option>
                        <option value="detail">Detail</option>
                        <option value="exception">Exception</option>
                    </select>
                </div>
                <div class="col-6-large" style="padding-left:60px;">
                    <strong>Report subject</strong>
                    <select name="demo-category" id="select-report-subject" class="row_1_opts">
                        <option value="">- Report subject -</option>
                        <option value="user">User</option>
                        <option value="photo">Photo</option>
                        <option value="album">Album</option>
                    </select>
                </div>
            </div>
            <div id="ex_row" class="row" style="padding-top:30px;padding-bottom:30px;">
            </div>
            <a id="btn_generate" class="button">Generate</a>
            <div id="res">
            </div>
        </div>
    </section>

    <?php
    footer();
    ?>

</div>

<!-- Scripts -->
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/js/jquery.dropotron.min.js"></script>
<script src="../assets/js/jquery.scrollex.min.js"></script>
<script src="../assets/js/jquery.scrolly.min.js"></script>
<script src="../assets/js/browser.min.js"></script>
<script src="../assets/js/breakpoints.min.js"></script>
<script src="../assets/js/util.js"></script>
<script src="../assets/js/main.js"></script>

<script type="text/javascript">
    $(document).ready(function(){

        function show_ex_inputs(){
            if(rpt_type.options[rpt_type.selectedIndex].value == 'exception'){
                switch(rpt_subject.options[rpt_subject.selectedIndex].value){
                    case 'user':
                        ex_row.innerHTML =
                            '<div class="col-6-large">' +
                            '<strong>User type</strong>'+
                            '<select name="demo-category" id="select_user_type" class="row_2_opts">' +
                            '<option value="">- User type -</option>' +
                            '<option value="customer">Customer</option>' +
                            '<option value="collaborator">Collaborator</option>' +
                            '<option value="banned">Banned</option>' +
                            '</select>' +
                            '</div>' +
                            '<div class="col-6-large" style="padding-left:72px;">' +
                            '<strong>Order by</strong>'+
                            '<select name="demo-category" id="select_order_by" class="row_2_opts">' +
                            '<option value="">- Order by -</option>' +
                            '<option value="user_fname">First name</option>' +
                            '<option value="user_lname">Last name</option>' +
                            '<option value="user_email">Email Address</option>' +
                            '<option value="user_authentication">User Type</option>' +
                            '</select>' +
                            '</div>';
                        break;
                    case 'album':
                        ex_row.innerHTML =
                            '<div class="col-6-large">' +
                                '<strong>Sort by username</strong>'+
                                '<input type="text" id="enter_username" placeholder="Enter username">'+
                            '</div>';
                        break;
                    case 'photo':
                        //document.write('works3');
                        ex_row.innerHTML =
                            '<div class="col-6-large">' +
                            '<strong>Sort by username</strong>'+
                            '<input type="text" id="enter_username" placeholder="Enter username">'+
                            '</div>';
                        break;
                    default:
                        ex_row.innerHTML = '';
                        break;
                }
            }
            else{
                ex_row.innerHTML = '';
            }
        }

        var rpt_type = document.getElementById('select-report-type');
        var rpt_subject = document.getElementById('select-report-subject');
        var ex_row = document.getElementById('ex_row');

        var row_1_opts = document.getElementsByClassName('row_1_opts');
        row_1_opts[0].addEventListener('change', show_ex_inputs, false);
        row_1_opts[1].addEventListener('change', show_ex_inputs, false);

        var btn_generate = document.getElementById('btn_generate');
        btn_generate.addEventListener('click',function(){

            var type = document.getElementById('select-report-type').value;
            var subject = document.getElementById('select-report-subject').value;
            var input_1 = '';
            var input_2 = '';
            
            //here, get the data that will be sent over
            if(type == 'exception')
            //apparently, there's an unexpected token on this line according to the console
            {
                //i don't know where this unexpected token is...
                switch(document.getElementById('select-report-subject').value){
                    case 'user':
                        input_1 = document.getElementById('select_user_type').options[document.getElementById('select_user_type').selectedIndex].value;
                        input_2 = document.getElementById('select_order_by').options[document.getElementById('select_order_by').selectedIndex].value;
                        break;
                    case 'album':
                    case 'photo':
                        input_1 = document.getElementById('enter_username').value;
                        input_2 = 'n/a';
                        break;
                }
            }
            else if(type == 'summary' || type == 'detail'){
                input_1 = 'n/a';
                input_2 = 'n/a';
            }
            else{

            }

            $.ajax({
                url: '../Util/Reports_backend_V2.php',
                type: "POST",
                dataType:'json', // add json datatype to get json
                data: ({type: type,subject: subject,input_1: input_1,input_2: input_2}),
                success: function(data){
                    document.getElementById('res').innerHTML = data;
                }
            });

        });

    });
</script>
</body>
</html>