<?php
    session_start();
    if($_SERVER['SERVER_PORT'] != '443') { 
        header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']); 
        exit();
    }
?>
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
        <?php include ("./assets/virtual/mainBootstrap.inc"); ?>
        <script src="./assets/slideshow/js/jquery-1.11.min.js"></script>
        <script src="assets/js/modernizr.js"></script>
        
        <!-- IMAGE SLIDESHOW IMPORTS -->
        <link rel="stylesheet" href="./assets/slideshow/css/supersized.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="./assets/slideshow/theme/supersized.shutter.css" type="text/css" media="screen" />
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.1/jquery.min.js"></script>
        <script type="text/javascript" src="./assets/slideshow/js/jquery.easing.min.js"></script>
        <script type="text/javascript" src="./assets/slideshow/js/supersized.3.2.7.js"></script>
        <script type="text/javascript" src="./assets/slideshow/theme/supersized.shutter.js"></script>
	<script type="text/javascript">
            jQuery(function($){
                $.supersized({
                    // Functionality
                    slideshow : 1, // Slideshow on/off
                    autoplay : 1, // Slideshow starts playing automatically
                    start_slide : 1, // Start slide (0 is random)
                    stop_loop :	0, // Pauses slideshow on last slide
                    random : 0, // Randomize slide order (Ignores start slide)
                    slide_interval : 5000, // Length between transitions
                    transition : 6, // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                    animationSpeed : 1000, // Speed of transition
                    initDelay: 0, //Integer: Set an initialization delay, in milliseconds
                    new_window : 1, // Image links open in new window/tab
                    pause_hover : 0, // Pause slideshow on hover
                    keyboard_nav : 0, // Keyboard navigation on/off
                    performance : 1, // 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
                    image_protect : 1, // Disables image dragging and right click with Javascript
													   
                    // Size & Position						   
                    min_width : 0, // Min width allowed (in pixels)
                    min_height : 0, // Min height allowed (in pixels)
                    vertical_center : 1, // Vertically center background
                    horizontal_center : 1, // Horizontally center background
                    fit_always : 0, // Image will never exceed browser width or height (Ignores min. dimensions)
                    fit_portrait : 1, // Portrait images will not exceed browser height
                    fit_landscape : 0, // Landscape images will not exceed browser width
															   
                    // Components							
                    slide_links	: 'blank', // Individual links for each slide (Options: false, 'num', 'name', 'blank')
                    thumb_links	: 1, // Individual thumb links for each slide
                    thumbnail_navigation : 0, // Thumbnail navigation
                    slides : [	 // Slideshow Images
                        {image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/kazvan-1.jpg', title : 'Image Credit: Maria Kazvan', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/kazvan-1.jpg'},
			{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/kazvan-2.jpg', title : 'Image Credit: Maria Kazvan', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/kazvan-2.jpg'},
			{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/kazvan-3.jpg', title : 'Image Credit: Maria Kazvan', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/kazvan-3.jpg'},
			{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/wojno-1.jpg', title : 'Image Credit: Colin Wojno', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/wojno-1.jpg'},
			{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/wojno-2.jpg', title : 'Image Credit: Colin Wojno', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/wojno-2.jpg'},
			{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/wojno-3.jpg', title : 'Image Credit: Colin Wojno', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/wojno-3.jpg'},
			{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/shaden-1.jpg', title : 'Image Credit: Brooke Shaden', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/shaden-1.jpg'},
			{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/shaden-2.jpg', title : 'Image Credit: Brooke Shaden', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/shaden-2.jpg'},
			{image : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/slides/shaden-3.jpg', title : 'Image Credit: Brooke Shaden', thumb : 'http://buildinternet.s3.amazonaws.com/projects/supersized/3.2/thumbs/shaden-3.jpg'}
                    ],

                    // Theme Options			   
                    progress_bar : 4, // Timer for each slide							
                    mouse_scrub	: 0	
		});
	    });
	</script>
        <!-- END IMAGE SLIDESHOW IMPORTS -->
        
        <!-- CAPTION SLIDESHOW IMPORTS -->
        <link rel="stylesheet" href="./assets/slideshow/css/flexslider.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="./assets/css/animate.css" type="text/css" media="all" />
        <script type="text/javascript" src="./assets/slideshow/js/move-top.js"></script>
        <script type="text/javascript" src="./assets/slideshow/js/easing.js"></script>	
	<script type="text/javascript">
		jQuery(document).ready(function($) {
			$(".scroll").click(function(event){		
				event.preventDefault();
				$('html,body').animate({scrollTop:$(this.hash).offset().top},1000);
			});
		});
	</script>
        <link href="./assets/slideshow/css/animate.css" rel="stylesheet" type="text/css" media="all">
        <script src="./assets/slideshow/js/wow.min.js"></script>
	<script>new WOW().init();</script>
        <!-- END CAPTION SLIDESHOW IMPORTS -->
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
                    <a class="navbar-brand">On Point Performance Center</a>
                </div>

                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li class="active"><a><span class="sr-only">(current)</span>Home</a></li>
                        <li><a href="./announcements/">Announcements</a></li>
                        <li><a href="./about/">About Us</a></li>
                        <li><a href="./apply/">Apply</a></li>
                        <li><a href="./events/">Events</a></li>
                        <li><a href="./merchandise/">Merchandise</a></li>
                        <li><a href="./contact/">Contact Us</a></li>
                    </ul>    
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                            if (isset($_SESSION['member_username'])){
                                echo '<li><a href="./members">' . $_SESSION['member_username'] . '</a></li>';
                                echo '<li><a href="./login/logout.php">Logout</a></li>';
                            }
                            if (isset($_SESSION['admin_username'])){
                                echo '<li><a href="./admin">' . $_SESSION['admin_username'] . '</a></li>';
                                echo '<li><a href="./login/logout.php">Logout</a></li>';                            
                            }
                            elseif (!isset($_SESSION['member_username']) && !isset($_SESSION['admin_username'])) {
                                echo '<li><a href="./login">Log In</a></li>';
                            }
                        ?>
                    </ul>
                </div>
            </div>
        </nav>
        <div class="container-fluid">
            
	
        <!--Arrow Navigation-->
        <a id="prevslide" class="load-item"></a>
        <a id="nextslide" class="load-item"></a>
	
        <div id="thumb-tray" class="load-item">
            <div id="thumb-back"></div>
            <div id="thumb-forward"></div>
	</div>
	
        <!-- END CAPTION SLIDER-->
        <section class="slider">
            	<div class="flexslider">
                    <ul class="slides">
                    	<li>
                            <h1>Dual Purpose Gym</h1>
                            <h4>We have our facility split into two sides, one for strength training and the other for military/tactical training</h4>
  	    		</li>
 	    		<li>
                            <h1>Strength Training</h1>
                            <h4>Our strength training section has all the equipment you needed to get stronger</h4>
  	    		</li>
 	    		<li>
                            <h1>Tactical Training</h1>
                            <h4>Our tactical section is set up for practicing military and police routines</h4>
  	    		</li>
                    </ul>
                    
        	</div>
            </section>
            <script>window.jQuery || document.write('<script src="./assets/slideshow/js/jquery-1.11.min.js">\x3C/script>')</script>
            <!--FlexSlider-->
            <script defer src="./assets/slideshow/js/jquery.flexslider.js"></script>
            <script type="text/javascript">
                $(function(){
                    SyntaxHighlighter.all();
    		});
    		$(window).load(function(){
                    $('.flexslider').flexslider({
                        animation: "slide",
        		start: function(slider){
                            $('body').removeClass('loading');
        		}
                    });
    		});
            </script>
            <!-- END CAPTION SLIDER-->
            
	<!--Time Bar-->
	<div id="progress-back" class="load-item">
            <div id="progress-bar"></div>
	</div>
	
	<!--Control Bar-->
	<div id="controls-wrapper" class="load-item">
            <div id="controls">
                <a id="play-button"><img id="pauseplay" src="./assets/slideshow/img/pause.png"/></a>
		
		<!--Slide counter-->
		<div id="slidecounter">
                    <span class="slidenumber"></span> / <span class="totalslides"></span>
		</div>
			
		<!--Slide captions displayed here-->
		<div id="slidecaption"></div>
			
		<!--Thumb Tray button-->
                <a id="tray-button"><img id="tray-arrow" src="./assets/slideshow/img/button-tray-up.png"/></a>
			
		<!--Navigation-->
		<ul id="slide-list"></ul>	
            </div>
	</div>
        </div>
        <!--
        <div class="panel panel-default" style="margin-bottom: 0px; padding-top: 2px;">
            <div class="panel-footer">
                <?php include ("./assets/virtual/footer.inc"); ?>
            </div>
        </div>-->
    </body>
</html>
