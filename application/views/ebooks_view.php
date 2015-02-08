<div class="main-content">
  <div class="container-fluid">
 <br />
<div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Ebooks</strong><sub>( <?php print $corpus; ?> )</sub></h3>
          </div>
  <div class="panel-body">
    
    <table class="table table-bordered table-hover">
      <thead>
        <tr>
          <th>#</th>
          <th>File Name</th>
          <th>Title</th>
          <th>Author</th>
          <th>Pages</th>
          <th>Publisher</th>
          <th>Published Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $counter = 1;
        foreach($ebooks->result() as $row) {
          if ($row->meta_data !== '') {
            $meta_data = unserialize($row->meta_data);
          } else {
            $meta_data = array();
          }
        ?>
        <tr>
          <td class="text-center"><?php print $counter; ?></td>
          <td class="text-left"><?php print $row->filename; ?></td>
          <td>
          <?php
          print @$meta_data['title'];
          ?>
          </td>
          <td>
          <?php
          print @$meta_data['author'];
          ?>
          </td>
          <td>
          <?php
          print @$meta_data['pages'];
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