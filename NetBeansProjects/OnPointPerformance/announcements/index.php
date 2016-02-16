<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Announcements</title>
        <?php include ("../assets/virtual/mainBootstrap2.inc"); ?>
    </head>
    <body>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">On Point Performance Center</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="../index.php">Home</a></li>
                        <li class="active"><a><span class="sr-only">(current)</span>Announcements</a></li>
                        <li><a href="../aboutUs.php">About Us</a></li>
                        <li><a href="../apply/">Apply</a></li>
                        <li><a href="../events/">Events</a></li>
                        <li><a href="../merchandise.php">Merchandise</a></li>
                        <li><a href="../contactUs.php">Contact Us</a></li>
                        
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../login/">Log in</a></li>
                        <li><a href="#">Portal page</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="jumbotron">
            <h1>Announcement 1</h1>
            <p>Announcement text will go here.</p>
            <p><a class="btn btn-primary btn-lg">Learn more</a></p>
            <div>
                
            </div>
        </div>
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-3">
                    <img src="../assets/images/ph_300x300.gif" alt="placeholder">
                </div>
                <div class="col-lg-9">
                    <div class="jumbotron">
                        <h1>Announcement 2</h1>
                        <p>Announcement text will go here.</p>
                        <p><a class="btn btn-primary btn-lg">Learn more</a></p>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-lg-9">
                    <div class="jumbotron">
                        <h1>Announcement 3</h1>
                        <p>Announcement text will go here.</p>
                        <p><a class="btn btn-primary btn-lg">Learn more</a></p>
                    </div>
                </div>
                <div class="col-lg-3">
                    <img src="../assets/images/ph_300x300.gif" alt="placeholder">
                </div>
            </div>    
        </div>
        
        
        
        <div class="panel panel-default">
            <div class="panel-footer">
                <?php include ("../assets/virtual/footer.inc"); ?>
            </div>
        </div>
    </body>
</html>
