<div class="main-content">
  <div class="container-fluid">
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title"><strong>Evaluation</strong></h3>
      </div>
      <div class="panel-body">
        <div class="container-fluid">
          <table class="table table-striped">
          	<thead>
            	<tr>
                	<th class="text-center">#</th>
                	<th class="text-left">File Name</th>
                    <th class="text-center">Classification</th>
                    <th class="text-center">Is Accurate?</th>
                    <th class="text-center">Date Tested</th>
                </tr>
            </thead>
            <tbody>
            <?php
			$count = 1;
			$total = 0;
			$total_correct = 0;
			
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
					
					print (($row->is_accurate == 1) ? "<label class='label label-success'>Yes</label>" : "<label class='label label-danger'>No</label>");
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
            
            <dt style="text-align: left;">Correct results</dt>
            <dd>
            <?php
			print $total_correct;
			?>
            </dd>
            <dt style="text-align: left;">Incorrect results</dt>
            <dd>
            <?php
			print ($count - 1) - $total_correct;
			?>
            </dd>
            <dt style="text-align: left;">Accuracy</dt>
            <dd>
            <?php
			print number_format(($total / ($count - 1)) * 100, 3) . '%';
			?>
            </dd>
            
        </dl>
          
        </div>
      </div>
    </div>
  </div>
</div>
