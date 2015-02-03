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
                <div>Classification</div>
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

          </div>
      </div>
      
    </div>
    
  </div>
  
</div>