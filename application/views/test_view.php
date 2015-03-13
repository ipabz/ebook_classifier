<div class="main-content">
  <div class="container-fluid">
<div class="train-dialog">
<div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Test</strong></h3>
          </div>
  <div class="panel-body"> <div class="container-fluid">
<div>
  
      <?php
      $dc_digits = 5;
      if (@$error !== '') {
      ?>
      <div class="alert alert-danger" role="alert">
        <?php print @$error; ?>
      </div>
      <?php
      }
      ?>
      
      
        <?php
        if (@$sucess === '') {
          
        ?>
        <br>
        <div class="row fileupload-buttonbar text-center">
            <?php print form_open_multipart('testing/do_upload', 'class="testuploadform"');?>
            
            <span class="btn btn-success fileinput-button">
                <i class="glyphicon glyphicon-plus"></i>
                <span>Select file...</span>
                <input type="file" name="userfile" size="20" />
            </span>
          
            <button type="submit" class="btn btn-primary start starttesting">
                <i class="glyphicon glyphicon-upload"></i>
                <span>Start testing</span>
            </button>

            <?php print form_close(); ?>
        </div>
        <?php
        } else {
          /*
          print '<pre>';
          print_r($_data);
          print '</pre>';
          
           * 
           */
		?>
        <div class="text-center alert alert-success">
          This document ( <?php print $file_data['file_name'];  ?> ) is classified as <strong><?php print $_data['result']; ?></strong>.
        </div>
        <br />
        <div id="finaltokens_encoded" style="display: none;"><?php print json_encode($_data['pre_process']['final_tokens_raw']); ?></div>
        <div class="text-center feedback">
        	Is the result accurate? &nbsp;&nbsp; <a href="<?php print site_url('testing/accuracy/'.urlencode(base64_encode($file_data['file_name'])).'/'.$_data['result'].'/1'); ?>" class="btn btn-success do_ajax">Yes</a> <a href="<?php print site_url('testing/accuracy/'.urlencode(base64_encode($file_data['file_name'])).'/'.$_data['result'].'/0'); ?>" class="btn btn-danger do_ajax">No</a>
        </div>
        <?php
		}
        ?>
       
    
</div>
    </div>
          </div>
</div>
</div>
    
    </div>
</div>
