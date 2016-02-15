<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>On Point Performance Center</title>
        <link href="./bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" >
        <script href="./bootstrap/js/bootstrap.js" type="text/javascript" ></script>
        <script href="./bootstrap/js/bootstrap.min.js" type="text/javascript" ></script>
        <style type="text/css">
            .img-left{float: left;}
            .img-right{float: right;}
        </style>
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
                        <li><a href="index.php">Home</a></li>
                        <li><a href="aboutUs.php">About Us</a></li>
                        <li><a href="joinUs.php">Join Us</a></li>
                        <li><a href="eventCalendar.php">Event Calendar</a></li>
                        <li><a href="merchandise.php">Merchandise</a></li>
                        <li><a href="contactUs.php">Contact Us</a></li>
                        <!-- <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">Dropdown example<span class="caret"></span></a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a href="#">Action</a></li>
                                <li><a href="#">Another action</a></li>
                                <li><a href="#">Something else here</a></li>
                                <li class="divider"></li>
                                <li><a href="#">Separated link</a></li>
                                <li class="divider"></li>
                                <li><a href="#">One more separated link</a></li>
                            </ul>
                        </li>
                    </ul> -->
                    <!--<form class="navbar-form navbar-left" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form> -->
                    <ul class="nav navbar-nav navbar-right">
                        <li class="active"><a href="logIn.php">Log in<span class="sr-only">(current)</span></a></li>
                        <li><a href="#">Portal page</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        
        
        <div class="container-fluid">
        
        </div>
        <!--
        <div>
        <a href="#" class="btn btn-default">Default</a>
        <a href="#" class="btn btn-primary">Primary</a>
        <a href="#" class="btn btn-success">Success</a>
        <a href="#" class="btn btn-info">Info</a>
        <a href="#" class="btn btn-warning">Warning</a>
        <a href="#" class="btn btn-danger">Danger</a>
        <a href="#" class="btn btn-link">Link</a>
        </div> -->
        
        <div class="panel panel-default">
            <div class="panel-footer">
                <?php include ("./virtual/footer.inc"); ?>
            </div>
        </div>
    </body>
</html>
