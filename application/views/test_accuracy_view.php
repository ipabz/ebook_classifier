<div class="main-content">
  <div class="container-fluid">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title"><strong>Evaluation</strong></h3>
      </div>
      <div class="panel-body">
        <div class="container-fluid">
          <table class="table table-striped table-evaluation">
          	<thead>
            	<tr>
                	<th class="text-center pointer">#</th>
                	<th class="text-left pointer">File Name</th>
                    <th class="text-center pointer">Class</th>
                    <th class="text-center pointer">Evaluation</th>
                    <th class="text-center pointer">Date Tested</th>
                </tr>
            </thead>
            <tbody>
            <?php
			$count = 1;
			$total = 0;
			$total_correct = 0;
			
            $tp = 0;
            $fp = 0;
            $fn = 0;
            
			foreach($query->result() as $row) {
			?>
            	<tr>
                	<td class="text-center"><?php print $count; ?></td>
                    <td><?php print $row->filename; ?></td>
                    <td class="text-center"><?php print $row->classification; ?></td>
                    <td class="text-center">
                    <?php
					$total = $total + $row->is_accurate;
					
					if ($row->is_accurate == 1) {
						$total_correct++;
					}
					
                    /*
					print (($row->is_accurate == 1) ? "<label class='label label-success'>Yes</label>" : "<label class='label label-danger'>No</label>");
                     * 
                     */
                    
                    if ($row->is_accurate == 1) {
                      print "<label class='label label-success'>TP</label>";
                      $tp++;
                    } else if ($row->is_accurate == 2) {
                      print "<label class='label label-primary'>FP</label>";
                      $fp++;
                    } else if ($row->is_accurate == 3) {
                      print "<label class='label label-danger'>FN</label>";
                      $fn++;
                    }
                    
					?>
                    </td>
                    <td class="text-center"><?php print date('F d, Y h:i a', $row->date_tested); ?></td>
                </tr>
            <?php
			$count++;
			}
			?>
            </tbody>
          </table>
          <br />
          <hr />
        <dl class="dl-horizontal">
            
            <dt style="text-align: left;">Total TP</dt>
            <dd>
            <?php
			print number_format($tp);
			?>
            </dd>
            <dt style="text-align: left;">Total FP</dt>
            <dd>
            <?php
			print number_format($fp);
			?>
            </dd>
            <dt style="text-align: left;">Total FN</dt>
            <dd>
            <?php
			print number_format($fn);
			?>
            </dd>
            
        </dl>
          
        </div>
      </div>
    </div>
  </div>
</div>
