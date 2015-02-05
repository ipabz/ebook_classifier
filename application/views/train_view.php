<div class="main-content">
  
  <div class="container-fluid">
    
    <div class="train-dialog">
      
      <div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Train</strong></h3>
          </div>
          <div class="panel-body">

            <div class="row">
              <div class="col-md-12">
                <div>Corpus</div>
                <select class="form-control form-class-select">
                  <?php
                  foreach($classifications->result() as $row) {
                  ?>
                  <option value="<?php print $row->class_name; ?>">
                  <?php
                  print $row->class_name;
                  ?>
                  </option>
                  <?php
                  }
                  ?>   
                </select>
              </div>
            </div>
            <hr />
            
            <div class="text-right">
              <span class="btn btn-success fileinput-button">
                  <i class="glyphicon glyphicon-plus"></i>
                  <span>Select files and do training</span>
                  <!-- The file input field used as target for the file upload widget -->
                  <input id="fileupload" type="file" name="userfile" multiple>
              </span>
            </div>

            
            <!-- The global progress bar -->
            <div class="hide progress-holder">
              <br />
              <div class="text">Training...</div>
              <div id="progress" class="progress">
                  <div class="progress-bar progress-bar-success"></div>
              </div>
              <div class="linkholder"></div>
            </div>

            <!-- The container for the uploaded files -->
            <div id="files" class="files"></div>
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            
            <!-- The file upload form used as target for the file upload widget -->
    <form id="fileupload" action="<?php print base_url('server/php'); ?>" method="POST" enctype="multipart/form-data">

        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
        <div class="row fileupload-buttonbar">
            <div class="col-lg-7">
                <!-- The fileinput-button span is used to style the file input field as button -->
                <span class="btn btn-success fileinput-button">
                    <i class="glyphicon glyphicon-plus"></i>
                    <span>Add files...</span>
                    <input type="file" name="files[]" multiple>
                </span>
                <button type="submit" class="btn btn-primary start">
                    <i class="glyphicon glyphicon-upload"></i>
                    <span>Start upload</span>
                </button>
                <button type="reset" class="btn btn-warning cancel">
                    <i class="glyphicon glyphicon-ban-circle"></i>
                    <span>Cancel upload</span>
                </button>
                <button type="button" class="btn btn-danger delete">
                    <i class="glyphicon glyphicon-trash"></i>
                    <span>Delete</span>
                </button>
                <input type="checkbox" class="toggle">
                <!-- The global file processing state -->
                <span class="fileupload-process"></span>
            </div>
            <!-- The global progress state -->
            <div class="col-lg-5 fileupload-progress fade">
                <!-- The global progress bar -->
                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
                </div>
                <!-- The extended global progress state -->
                <div class="progress-extended">&nbsp;</div>
            </div>
        </div>
        <!-- The table listing the files available for upload/download -->
        <table role="presentation" class="table table-striped"><tbody class="files"></tbody></table>
    </form>
            
        <!-- The blueimp Gallery widget -->
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>    
            
            
            
            
            
            
            
            
            
            

          </div>
      </div>
      
    </div>
    
  </div>
  
</div>