<?php

?>
<div class="uppernavbar">
    <div class="page-logo">
        <div class="logo">
            <img src="../assets/image/culogolightblue_lite.png" alt="logo" style="height: 80%;">
        </div>
        <div class="main-title">
            <h2 class=" text-black" style="font-size: calc(18.1481px + 0.617284vw); font-family: kalpurush;">University
                Of Chittagong</h2>
        </div>
    </div>
    <div class="menu">
        <a href=<?php if ($_SESSION['Role'] == 'Applicant') echo "profile.php";
                else echo "#"; ?> style="text-decoration:none">
            <div class="row">
                <div class="col">
                    <i class="fa fa-user fa-3x" style="color:#002A5C"></i>
                    <?php echo " " . $_SESSION['UserName']; ?>
                    <br>
                    <?php echo " " . $_SESSION['Email']; ?>
                </div>
            </div>
        </a>
        <a href="#help" style="text-decoration:none">
            <div class="helplogout">
                <div class="row">
                    <i class="far fa-question-circle fa-3x" style="color:#002A5C"> </i>
                </div>
                <div class="row">
                    <p> Help</p>
                </div>
            </div>
        </a>
        <a href="../userManagement/logout.php" style="text-decoration:none">
            <div class="helplogout">
                <div class="row">
                    <i class="fa fa-sign-out-alt fa-3x" style="color:#002A5C"></i>
                </div>
                <div>
                    <p>LogOut</p>
                </div>
            </div>
        </a>
    </div>
</div>
<div style="width: 100vw;">
    <hr />
</div>