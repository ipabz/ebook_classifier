<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Force latest IE rendering engine or ChromeFrame if installed -->
    <!--[if IE]>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <![endif]-->
    <base href="<?=base_url();?>" id="base_url">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ebook Classifier</title>

    <!-- Bootstrap -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <?php
    if (defined('TRAINING') OR defined('JUST_CSS')) :
      // The below CSS file(s) is loaded only for pages that requires uploading of files.
      // This is to maintain fast loading of pages.
    ?>
    <!-- blueimp Gallery styles -->
    <link rel="stylesheet" href="assets/css/blueimp-gallery.min.css">
    <!-- CSS to style the file input field as button and adjust the Bootstrap progress bars -->
    <link rel="stylesheet" href="assets/css/jquery.fileupload.css">
    <link rel="stylesheet" href="assets/css/jquery.fileupload-ui.css">
    <!-- CSS adjustments for browsers with JavaScript disabled -->
    <noscript><link rel="stylesheet" href="assets/css/jquery.fileupload-noscript.css"></noscript>
    <noscript><link rel="stylesheet" href="assets/css/jquery.fileupload-ui-noscript.css"></noscript>
    <?php
    endif;
    ?>
    <!-- Custom Style -->
    <link href="assets/css/default.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    
  </head>
  
  <?php

  $currentURL = current_url();
  $urlSegment = explode('/', $currentURL);

  ?>
  
  <header id="main-header">
    <div class="container-fluid">
      <nav class="navbar navbar-fixed-top navbar-default header" id="navbar-example">
        <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="">Ebook Classifier</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            
            
            <ul class="nav navbar-nav navbar-right main">
              <li class="<?php print ((in_array('train', $urlSegment)) ? "active" : ""); ?>"><a href="train"><span class="glyphicon glyphicon-plus"></span> &nbsp;Train</a></li>
              <li class="<?php print ((in_array('test', $urlSegment)) ? "active" : ""); ?>"><a href="test"><span class="glyphicon glyphicon-ok"></span> &nbsp;Test</a></li>
                
                <li class="<?php print ((in_array('view_ebooks', $urlSegment)) ? "active" : ""); ?>"><a href="<?php print site_url('training/view_ebooks/all'); ?>"><span class="glyphicon glyphicon-file"></span> &nbsp;Ebooks</a></li>
                
                <!--
              <li class="dropdown <?php print ((in_array('view_ebooks', $urlSegment)) ? "active" : ""); ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-file"></span> &nbsp;Ebooks <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <?php
            
                  foreach($classifications->result() as $row) {
                  ?>
                  <li><a href="<?php print site_url('training/view_ebooks/'.$row->class_name); ?>">Class <?php print $row->class_name; ?></a></li>
                  <?php
                  }
                  ?> 

                  <li role="separator" class="divider"></li>
                  <li><a href="<?php print site_url('training/generate_awp'); ?>">Generate AWP</a></li>
                </ul>
              </li>
-->



              <li class="dropdown <?php print ((in_array('corpora', $urlSegment)) ? "active" : ""); ?>">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-list-alt"></span> &nbsp;Corpora <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="<?php print site_url('corpora/raw'); ?>">All Words (AW)</a></li>
                  <li><a href="<?php print site_url('corpora/awp'); ?>">Training Model (AWP)</a></li>
                </ul>
              </li>


              <li class="<?php print ((in_array('evaluation', $urlSegment)) ? "active" : ""); ?>"><a href="evaluation"><span class="glyphicon glyphicon-list"></span> &nbsp;Evaluation</a></li>
              
            </ul>
          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>
    </div>

  </header>
  
  <div id="main-header-shadow"></div>
  