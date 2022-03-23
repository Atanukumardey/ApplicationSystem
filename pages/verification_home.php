<?php
include "../php/session/session.php";

sessionStart(0, '/', 'localhost', true, true);
if (!isset($_SESSION['Email']) || !isset($_SESSION['RoleID'])) {
    if ($_SESSION['Role'] != 'verifier') {
        header('Location: ../index.php');
    }
} else {
?>
    <!DOCTYPE html>
    <html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title>University of Chittagong</title>
        <link rel="shortcut icon" type="image/png" sizes="16x16" href="../assets/image/culogolightblue_lite.png">

        <!-- Bootstrap CSS CDN -->
        <link rel="stylesheet" href="../css/bootstrap.min.css">

        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">
        <!-- Our Custom CSS -->
        <link rel="stylesheet" href="../css/style1.css">
        <link rel="stylesheet" href="../css/log_reg_footer.css">

    </head>

    <style>
        .card {
            box-shadow: 0 0 5px #ccc;
            background-color: #fff;
            color: #293253;
            padding: 10px 10px;
        }

        #content {
            padding: 0px;
            min-height: 89.7vh;
            height: auto;
            transition: all 0.0s;
            width: 100%;
        }
    </style>

    <body style="overflow-x: hidden;">

        <div class="wrapper">
            <!-- Sidebar Holder -->
            <!-- Page Content Holder -->
            <div id="content">
                <div class="row" align="center">
                    <div class="col-0 col-sm-3 col-md-4 col-lg-4 col-xl-4"></div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                        <a href="../index.php">
                            <img style="margin-top: 10px;" src="../assets/image/culogolightblue_lite.png" width="50" />

                            <h4 style="margin-top: 10px;">University of Chittagong</h4>
                        </a>
                    </div>
                    <div class="col-0 col-sm-3 col-md-4 col-lg-4 col-xl-4"></div>

                </div>

                <div class="" style="position:relative;top:18%">
                    <div style="text-align:center;">
                        <h3>No Objection Certificate</h3>
                    </div>
                    <div class="row">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" align="center">
                            <form id="noc_form" method="post" action="">
                                <div class="input-group mb-3" id="noc_search_box" style="box-shadow: 0 0 10px #ccc;">
                                    <input type="text" id="noc_ref_input" name="noc_ref_input" class="form-control" placeholder="Reference number...">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit" style="background-color:#001733;color:white" id="noc_go_button">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-3"></div>
                    </div>
                    <?php if (isset($_POST['noc_ref_input'])) {
                        if ($_POST['noc_ref_input'] === "1234") { ?>
                            <div class="row" style="padding:5%;padding-bottom:8%">
                                <div class="col-md-3"></div>
                                <div class="col-md-6 card" id="noc_display">
                                    <div class="row  card-body">
                                        <div class="col-md-5 col-sm-4" align="left">
                                            <p>Refno:<span id="noc_refno"><?= $_POST['noc_ref_input'] ?></span></p>
                                        </div>
                                        <div class="col-md-7 col-sm-8" id="publish_date">
                                            <p>Publish Date:<span id="noc_publish_date"><?= $_POST['noc_ref_input'] ?></span></p>
                                        </div>
                                        <div class="col-md-12" id="peoplenamediv">
                                            <p>Name: <a target="_blank" id="noc_peoplename"><?= $_POST['noc_ref_input'] ?></a></p>
                                        </div>
                                        <div class="col-md-12" id="attachment">
                                            <p>Attachment:<br><a target="_blank" id="noc_attachment"><?= $_POST['noc_ref_input'] ?></a></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="row" style="margin-top:-0%;padding-bottom:0%">
                                <div class="col-md-4"></div>
                                <div class="col-md-4 card" id="noc_message_display" style="box-shadow: rgb(204, 204, 204) 0px 0px 10px; display: inline;">
                                    <div class="row  card-body">
                                        <div class="col-md-12">
                                            <p id="noc_message" style="text-align: center;">No data found for this reference no!</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3"></div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>
        </div>
        <!-- Footer - Start -->
        <footer class="mainfooter" role="contentinfo">
            <div class="social-media">
                <div class="social-icons">
                    <ul id="horizontal-list">
                        <li>
                            <a alt="Facebook" target="_blank" aria-hidden="true" aria-label="bed" href="https://www.facebook.com/ictcu/">
                                <i class="fab fa-facebook"></i>
                            </a>
                        </li>
                        <!-- <li><a alt="YouTube" aria-hidden="true" aria-label="bed" href="https://www.youtube.com/user/universitytoronto"><i class="fa fa-youtube"></i></a></li> -->
                        <!--<li>-->
                        <!--    <a alt="LinkedIn" target="_blank" aria-hidden="true" aria-label="bed" href="">-->
                        <!--        <i class="fab fa-linkedin"></i>-->
                        <!--    </a>-->
                        <!--</li>-->
                        <li>
                            <a alt="Twitter" target="_blank" aria-hidden="true" aria-label="bed" href="https://twitter.com/UChittagong">
                                <i class="fab fa-twitter"></i>
                            </a>
                        </li>
                        <li>
                            <a alt="Youtube" target="_blank" aria-hidden="true" aria-label="bed" href="https://www.youtube.com/channel/UClQg__wc5h3uW_YHSD-iMbg/featured">
                                <i class="fab fa-youtube"></i>
                            </a>
                        </li>
                        <!--li><a href="/social-media-directory/all">SOCIAL MEDIA DIRECTORY</a></li-->
                    </ul>
                </div>
            </div>
            <div class="copyright" style='margin-bottom:0;'>
                UNIVERSITY OF CHITTAGONG - SINCE NOVEMBER 18, 1966
            </div>
            <div class="copyright">
                <p style="padding-top: 0px; margin-bottom: 0px;">Developed by</p>
                <p class="text-xs-center">Noobs</p>
            </div>
        </footer>
    </body>

    </html>
<?php } ?>