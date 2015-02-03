<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="<?=base_url();?>" id="base_url">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ebook Classifier</title>

    <!-- Bootstrap -->
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    
    <?php
    if (defined('TRAINING')) :
      // The below CSS file(s) is loaded only for pages that requires uploading of files.
      // This is to maintain fast loading of pages.
    ?>
    <link rel="stylesheet" href="assets/css/jquery.fileupload.css">
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
  
  
  <header id="main-header">
    <div class="container-fluid">
      <a href="<?php print site_url(); ?>" class="title">Ebook Classifier</a>
      
      <div class="pull-right nav-container">
        
        <a href="train" class="btn btn-info"><span class="glyphicon glyphicon-plus"></span> &nbsp;Train</a>
        <a class="btn btn-info"><span class="glyphicon glyphicon-ok"></span> &nbsp;Test</a>
        <div class="btn-group">
          <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
            <span class="glyphicon glyphicon-list-alt"></span> &nbsp;Corpus <span class="caret"></span>
          </button>
          <ul class="dropdown-menu pull-right" role="menu">
            <?php
            foreach($classifications->result() as $row) {
            ?>
            <li><a href="<?php print site_url('training/show_results?corpus='.$row->class_name); ?>"><?php print $row->class_name; ?></a></li>
            <?php
            }
            ?>            
          </ul>
        </div>
      </div>
      
    </div>    
  </header>
  
  <div id="main-header-shadow"></div>
  