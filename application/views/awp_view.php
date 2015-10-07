<div class="main-content">
  <div class="container-fluid">
 <br />
<div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title text-center"><strong>All Words with Pruning (AWP)</strong></h3>
          </div>
  <div class="panel-body">
    
    <table class="table table-bordered table-hover table-striped">
      <thead>
        <tr class="warning">
          <th colspan="2" class="text-center"><h3>004</h3></th>
          <th colspan="2" class="text-center"><h3>005</h3></th>
          <th colspan="2" class="text-center"><h3>006</h3></th>
          
        </tr>
        <tr>
          <td class="text-center"><strong>Word</strong></td>
          <td class="text-center"><strong>F</strong></td>
          <!--<td class="text-center"><strong>P</strong></td>-->
          <td class="text-center"><strong>Word</strong></td>
          <td class="text-center"><strong>F</strong></td>
          <!--<td class="text-center"><strong>P</strong></td>-->
          <td class="text-center"><strong>Word</strong></td>
          <td class="text-center"><strong>F</strong></td>
          <!--<td class="text-center"><strong>P</strong></td>-->
        </tr>
      </thead>
      <tbody>
      <?php
      
      $class_004 = $class004->result_array();
      $class_005 = $class005->result_array();
      $class_006 = $class006->result_array();
      
      $ftotal004 = $this->training_model->frequency_sum('004', TABLE_TRAINING_MODEL);
      $ftotal005 = $this->training_model->frequency_sum('005', TABLE_TRAINING_MODEL);
      $ftotal006 = $this->training_model->frequency_sum('006', TABLE_TRAINING_MODEL);
      
      if ($type === '+1') {
        $ftotal004 = $ftotal004 + $class004->num_rows() + 1;
        $ftotal005 = $ftotal005 + $class005->num_rows() + 1;
        $ftotal006 = $ftotal006 + $class006->num_rows() + 1;
      }
      
      for($x=0; $x < $row_count; $x++) {
        
        if ($type === '+1') {
          if ($x < count($class_004)) {
            $class_004[$x]['count'] = $class_004[$x]['count'] + 1;
          }
          
          if ($x < count($class_005)) {
            $class_005[$x]['count'] = $class_005[$x]['count'] + 1;
          }
          
          if ($x < count($class_006)) {
            $class_006[$x]['count'] = $class_006[$x]['count'] + 1;
          }
        }
        
      ?>
        <tr>
          <td>
          <?php
          if ($x < count($class_004)) {
            print ucwords($class_004[$x]['item_raw']);
          }
          ?>
          </td>
          <td class="text-center">
          <?php
          if ($x < count($class_004)) {
            print $class_004[$x]['count'];
          }
          ?>
          </td>
          <!--
          <td class="text-center">
          <?php
          if ($x < count($class_004)) {
            print number_format(($class_004[$x]['count'] / $ftotal004), 3) . '%';
          }
          ?>
          </td>
          -->
          <td>
          <?php
          if ($x < count($class_005)) {
            print ucwords($class_005[$x]['item_raw']);
          }
          ?>
          </td>
          <td class="text-center">
          <?php
          if ($x < count($class_005)) {
            print $class_005[$x]['count'];
          }
          ?>
          </td>
          <!--
          <td class="text-center">
          <?php
          if ($x < count($class_005)) {
            print number_format(($class_005[$x]['count'] / $ftotal005), 3) . '%';
          }
          ?>
          </td>
          -->
          <td>
          <?php
          if ($x < count($class_006)) {
            print ucwords($class_006[$x]['item_raw']);
          }
          ?>
          </td>
          <td class="text-center">
          <?php
          if ($x < count($class_006)) {
            print $class_006[$x]['count'];
          }
          ?>
          </td>
          <!--
          <td class="text-center">
          <?php
          if ($x < count($class_006)) {
            print number_format(($class_006[$x]['count'] / $ftotal006), 3) . '%';
          }
          ?>
          </td>
          -->
        </tr>
      <?php
      }
      ?>
      </tbody>
      <tfoot>
        <?php
        if ($type === '+1') {
        ?>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td><strong>others wikeiksie</strong></td>
          <td class="text-center">1</td>
          <td class="text-center">
          <?php
          print number_format((1 / $ftotal004), 3) . '%';
          ?>
          </td>
          <td></td>
          <td class="text-center">1</td>
          <td class="text-center">
          <?php
          print number_format((1 / $ftotal005), 3) . '%';
          ?>
          </td>
          <td></td>
          <td class="text-center">1</td>
          <td class="text-center">
          <?php
          print number_format((1 / $ftotal005), 3) . '%';
          ?>
          </td>
        </tr>
        <?php
        }
        ?>
        <tr>
          <td>&nbsp;</td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        <tr class="info">
          <td class="text-center">
          <?php
          print number_format($class004->num_rows());
          ?>
          </td>
          <td class="text-center">
          <?php
          print number_format($ftotal004);
          ?>
          </td>
          <!--
          <td class="text-center">
          <?php
          //print @number_format((($ftotal004/($ftotal004+$ftotal005+$ftotal006)) * 100), 3). '%';
          ?>
          </td>
          -->
          <td class="text-center">
          <?php
          print number_format($class005->num_rows());
          ?>
          </td>
          <td class="text-center">
          <?php
          print number_format($ftotal005);
          ?>
          </td>
          <!--
          <td class="text-center">
          <?php
          //print @number_format((($ftotal005/($ftotal004+$ftotal005+$ftotal006)) * 100), 3). '%';
          ?>
          </td>
          -->
          <td class="text-center">
          <?php
          print number_format($class006->num_rows());
          ?>
          </td>
          <td class="text-center">
          <?php
          print number_format($ftotal006);
          ?>
          </td>
          <!--
          <td class="text-center">
          <?php
          //print @number_format((($ftotal006/($ftotal004+$ftotal005+$ftotal006)) * 100), 3). '%';
          ?>
          </td>
          -->
        </tr>
      </tfoot>
    </table>
   
  </div>
</div>
     <br />
  </div>
</div>