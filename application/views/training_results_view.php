<div class="main-content">
  <div class="container-fluid">
    
    <h2 class="text-center">Word Frequency</h2>
    <?php print(($this->input->get('corpus')) ? "<div class='text-center'><strong>Corpus ".$this->input->get('corpus')."</strong></div>" : ""); ?>
    <hr />
    <?php
    $counter = 1;
    foreach ($query->result() as $row_file) {
        $counted = (array)json_decode($row_file->tokens_count);
        $raw = (array)json_decode($row_file->removed_stop_words);
        $class_file = 'class'.trim($row_file->classification).'.txt'; ?>
    <br />
    <div class="panel panel-info">
      <div class="panel-heading">
        <h3 class="panel-title"><strong># <?php print $counter; ?></strong></h3>
      </div>
      <div class="panel-body">
          <div class="row">
            <div class="col-md-5">
              <div class="book">
                <img src="assets/images/pdf.png" width="200" />
                <div>
                <?php
                print '<strong>File Name</strong> <br>'.$row_file->filename;
        print '<br><br><strong>Corpus</strong> <br>'.$row_file->classification; ?>
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
                   $raw_count = 0;
        foreach ($counted as $word => $count) {
            $raw_word = @$raw[$raw_count]; ?>
                  <tr>
                    <td class="text-left"><?php print ucwords($raw_word); ?></td>
                    <td class="text-center"><?php print $count; ?></td>
                  </tr>
                   <?php
                    $raw_count++;
        } ?>
                </tbody>
              </table>
            </div>
          </div>
      </div>
    </div>
    <?php
    $counter++;
    }
    ?>
    <br />
  </div>
</div>