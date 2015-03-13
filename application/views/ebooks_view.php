<div class="main-content">
  <div class="container-fluid">
 <br />
<div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Ebooks</strong> <sub>( <?php print $corpus; ?> )</sub></h3>
          </div>
  <div class="panel-body">
    
    <table class="table table-bordered table-hover table-striped">
      <thead>
        <tr class="warning">
          <th>#</th>
          <th>File Name</th>
          <th>Title</th>
          <th>Author</th>
          <th>Publisher</th>
          <th>Published Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $counter = 1;
        foreach($ebooks->result() as $row) {
          if ($row->meta_data !== '') {
            $meta_data = (array)json_decode($row->meta_data);
          } else {
            $meta_data = array();
          }
          
        ?>
        <tr data-filename="<?php print ellipsize($row->filename, 50, .5); ?>" data-tokens="" data-toggle="modal" data-target="#myModal" data-url="<?php print site_url('training/view_tokens/'.$row->id); ?>" class="book_table_row ebook_view_tokens" title="Click a row to view tokens for that book.">
          <td class="text-center"><?php print $counter; ?></td>
          <td class="text-left"><?php print ellipsize($row->filename, 50, .5); ?></td>
          <td>
          <?php
          print ellipsize(@$meta_data['title'], 40, .5);
          ?>
          </td>
          <td>
          <?php
          print @$meta_data['author'];
          ?>
          </td>

          <td>
          <?php
          print @$meta_data['creator'];
          ?>
          </td>
          <td>
          <?php
          print @$meta_data['creationdate'];
          ?>
          </td>
        </tr>
        <?php
        $counter++;
        }
        ?>
      </tbody>
    </table>
   
  </div>
</div>
     <br />
  </div>
</div>


<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>