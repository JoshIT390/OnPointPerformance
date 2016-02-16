<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>About Us</title>
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
                        <li><a href="../">Home</a></li>
                        <li><a href="../announcements/">Announcements</a></li>
                        <li class="active"><a><span class="sr-only">(current)</span>About Us</a></li>
                        <li><a href="../apply/">Apply</a></li>
                        <li><a href="../events/">Events</a></li>
                        <li><a href="../merchandise/">Merchandise</a></li>
                        <li><a href="../contact/">Contact Us</a></li>
                        
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="../login/">Log in</a></li>
                        <li><a href="#">Portal page</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        <div class="jumbotron">
            <h1>On Point Performance Center</h1>
            <p>Description of the business goes here.</p>
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
                        <h1>Rusty Pugh</h1>
                        <p>Information about Rusty.</p>
                        <p><a class="btn btn-primary btn-lg">Learn more</a></p>
                    </div>
                </div>
            </div>
        
            <div class="row">
                <div class="col-lg-9">
                    <div class="jumbotron">
                        <h1>John Sheetz</h1>
                        <p>Information about John.</p>
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

