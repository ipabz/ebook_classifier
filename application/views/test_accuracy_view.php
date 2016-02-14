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
                	<th class="text-center pointer"></th>
                	<th class="text-center pointer">Actual_004</th>
                    <th class="text-center pointer">Actual_005</th>
                    <th class="text-center pointer">Actual_006</th>
                    <th class="text-center pointer"></th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>Predicted_004</strong></td>
                    <td class="text-center"><?php print $evaluation['004_004']; ?></td>
                    <td class="text-center"><?php print $evaluation['004_005']; ?></td>
                    <td class="text-center"><?php print $evaluation['004_006']; ?></td>
                    <td><strong>TotalPredicted_004 =</strong> <?php print $evaluation['TotalPredicted_004'] ?></td>
                </tr>
                <tr>
                    <td><strong>Predicted_005</strong></td>
                    <td class="text-center"><?php print $evaluation['005_004']; ?></td>
                    <td class="text-center"><?php print $evaluation['005_005']; ?></td>
                    <td class="text-center"><?php print $evaluation['005_006']; ?></td>
                    <td><strong>TotalPredicted_005 =</strong> <?php print $evaluation['TotalPredicted_005'] ?></td>
                </tr>
                <tr>
                    <td><strong>Predicted_006</strong></td>
                    <td class="text-center"><?php print $evaluation['006_004']; ?></td>
                    <td class="text-center"><?php print $evaluation['006_005']; ?></td>
                    <td class="text-center"><?php print $evaluation['006_006']; ?></td>
                    <td><strong>TotalPredicted_006 =</strong> <?php print $evaluation['TotalPredicted_006'] ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td></td>
                    <td class="text-center"><strong>TotalActual_004 =</strong> <?php print $evaluation['TotalGoldLabel_004'] ?></td>
                    <td class="text-center"><strong>TotalActual_005 =</strong> <?php print $evaluation['TotalGoldLabel_005'] ?></td>
                    <td class="text-center"><strong>TotalActual_006 =</strong> <?php print $evaluation['TotalGoldLabel_006'] ?></td>
                    <td></td>
                </tr>  
            </tfoot>
          </table>
          <br />

          
        </div>
      </div>
    </div>
  </div>
</div>
