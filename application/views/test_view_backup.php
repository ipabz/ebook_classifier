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
            <?php print form_open_multipart('testing/do_upload', 'class="testuploadform"'); ?>
            
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

        }
        ?>
       <?php
          if (@$sucess !== '') {
              $class_004 = $class004->result_array();
              $class_005 = $class005->result_array();
              $class_006 = $class006->result_array();

              $ftotal004 = $this->training_model->frequency_sum('004');
              $ftotal005 = $this->training_model->frequency_sum('005');
              $ftotal006 = $this->training_model->frequency_sum('006');

              $ftotal004 = $ftotal004 + $class004->num_rows() + 1;
              $ftotal005 = $ftotal005 + $class005->num_rows() + 1;
              $ftotal006 = $ftotal006 + $class006->num_rows() + 1; ?>
          <br />
        <!-- The table listing the files available for upload/download -->
        <!--
          <table role="presentation" class="table table-striped"><tbody class="files">
          
              <tr>
                <td>
                  <?php print $file_data['file_name']; ?>
                </td>
                <td class="text-right">
                  <input type="button" value="Show Details" class="btn btn-success showmoreresults" />
                </td>
              </tr>
              
              <tr>
                <td colspan="2">
                  <table class="result-table table table-bordered table-striped">
                    <thead>
                      <tr>
                        <td class="text-center"><strong>Word</strong></td>
                        <td class="text-center"><strong>004</strong></td>
                        <td class="text-center"><strong>005</strong></td>
                        <td class="text-center"><strong>006</strong></td>
                      </tr>
                    </thead>
                    <tbody>
                    <?php

                    $total__004 = 0;
              $total__005 = 0;
              $total__006 = 0;
                    
              foreach ($datas['final_tokens_raw'] as $row) {
                  $exploded = explode(' ', $row);
                  $stemmed = '';
                      
                  foreach ($exploded as $s) {
                      $stemmed = $this->stemmer->stem($s). ' ';
                  }
                      
                  $stemmed = trim($stemmed);
                      
                  $key_004 = $this->string->search($stemmed, $class_004);
                  $key_005 = $this->string->search($stemmed, $class_005);
                  $key_006 = $this->string->search($stemmed, $class_006); ?>
                      <tr>
                        <td><?php print ucwords($row); ?></td>
                        <td class="text-center">
                        <?php
                        $temp_004 = @$class_004[$key_004]['count'];
                        
                  if (@$temp_004 !== '') {
                      $tmp = (($temp_004 + 1) / $ftotal004) / 100;
                      $total__004 = $total__004 + $tmp;
                          /*
                          if ($total__004 == 0) {
                            $total__004 = $tmp;
                          } else {
                            $total__004 = bcmul($total__004, $tmp, $dc_digits);
                          }
                          */
                          print number_format($tmp, $dc_digits);
                  } ?>
                        </td>
                        <td class="text-center">
                        <?php
                        $temp_005 = @$class_005[$key_005]['count'];
                        
                  if (@$temp_005 !== '') {
                      $tmp = (($temp_005 + 1) / $ftotal005) / 100;
                      $total__005 = $total__005 + $tmp;
                          /*
                          if ($total__005 == 0) {
                            $total__005 = $tmp;
                          } else {
                            $total__005 = bcmul($total__005, $tmp, $dc_digits);
                          }
                          */
                          print number_format($tmp, $dc_digits);
                  } ?>
                        </td>
                        <td class="text-center">
                        <?php
                        $temp_006 = @$class_006[$key_006]['count'];
                        
                  if (@$temp_006 !== '') {
                      $tmp = (($temp_006 + 1) / $ftotal006) / 100;
                      $total__006 = $total__006 + $tmp;
                          /*
                          if ($total__006 == 0) {
                            $total__006 = $tmp;
                          } else {
                            $total__006 = bcmul($total__006, $tmp, $dc_digits);
                          }
                          */
                          print number_format($tmp, $dc_digits);
                  } ?>
                        </td>
                      </tr>
                    <?php

              } ?>
                    </tbody>
                    <?php

                    $total__004 = $total__004 * 100;
              $total__005 = $total__005 * 100;
              $total__006 = $total__006 * 100; ?>
                    <tfoot>
                      <tr>
                        <td colspan="4">&nbsp;</td>
                      </tr>
                      <tr>
                        <td>&nbsp;</td>
                        <td class="text-center">
                        <?php
                          print number_format($total__004, $dc_digits); ?>
                        </td>
                        <td class="text-center">
                        <?php
                          print number_format($total__005, $dc_digits); ?>
                        </td>
                        <td class="text-center">
                        <?php
                          print number_format($total__006, $dc_digits); ?>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </td>
              </tr>
          
          </tbody></table> 
		-->
        <?php
        $result_category = '004';
        
              if ($total__004 < $total__005) {
                  $result_category = '005';
              }
        
              if ($total__005 < $total__006) {
                  $result_category = '006';
              } ?>
        
        <div class="text-center alert alert-success">
          This document ( <?php print $file_data['file_name']; ?> ) is classified as <strong><?php print $result_category; ?></strong>.
        </div>
		<br />
        <div id="finaltokens_encoded" style="display: none;"><?php print json_encode($datas['final_tokens_raw']); ?></div>
        <div class="text-center feedback">
        	Is the result accurate? &nbsp;&nbsp; <a href="<?php print site_url('testing/accuracy/'.urlencode(base64_encode($file_data['file_name'])).'/'.$result_category.'/1'); ?>" class="btn btn-success do_ajax">Yes</a> <a href="<?php print site_url('testing/accuracy/'.urlencode(base64_encode($file_data['file_name'])).'/'.$result_category.'/0'); ?>" class="btn btn-danger do_ajax">No</a>
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
