<div class="main-content">
  <div class="container-fluid">
    
    <h2 class="text-center">Word Frequency</h2>
    <br />
    <?php
    foreach($query->result() as $row_file) {
      $counted = (array)json_decode($row_file->tokens_count); 
    ?>
    <hr /><br />
    <div class="row">
      <div class="col-md-5">
        <div class="book">
          <img src="assets/images/pdf.png" width="200" />
          <div>
          <?php
          print '<strong>File Name</strong> <br>'.$row_file->filename;
          print '<br><br><strong>Corpus</strong> <br>'.$row_file->classification;
          ?>
          </div>
        </div>
      </div>
      <div class="col-md-7">
        <table class="table customtable table-bordered">
          <thead>
            <tr>
              <th class="text-center"><strong>W<sub>i</sub> or W<sub>i-1</sub></strong></th>
              <th class="text-center"><strong>c(W<sub>i-1</sub>)</th>
            </tr>
          </thead>
          <tbody>
             <?php
             foreach($counted as $word => $count) {
             ?>
            <tr>
              <td class="text-left"><?php print $word; ?></td>
              <td class="text-center"><?php print $count; ?></td>
            </tr>
             <?php
             }
             ?>
          </tbody>
        </table>
      </div>
    </div>
    <?php
    }
    ?>
    <br />
  </div>
</div>