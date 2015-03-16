<div class="main-content">
  <div class="container-fluid">
 <br />
<div class="panel panel-info">
          <div class="panel-heading">
            <h3 class="panel-title"><strong>Ebooks</strong> <sub>( <?php print $corpus; ?> )</sub></h3>
          </div>
  <div class="panel-body">
    
    <table class="table table-bordered table-hover table-striped table-evaluation">
      <thead>
        <tr class="warning">
          <th class="pointer">#</th>
          <th class="pointer">File Name</th>
          <th class="pointer">Title</th>
          <th class="pointer">Author</th>
          <th class="pointer">Publisher</th>
          <th class="pointer">Published Date</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $counter = $offset;
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
    
    <div>
    <?php
    print $this->pagination->create_links();
    ?>
      
      <nav class="pull-right">
         
        <ul class="pagination pagination-sm">
          <li class="disabled"><a><b>Item's per page:</b> </a></li>
          <li <?php print (($per_page == 25) ? 'class="active"' : ''); ?>><a href="<?php print site_url('training/view_ebooks/'.trim($corpus).'/25'); ?>">25</a></li>
          <li <?php print (($per_page == 50) ? 'class="active"' : ''); ?>><a href="<?php print site_url('training/view_ebooks/'.trim($corpus).'/50'); ?>">50</a></li>
          <li <?php print (($per_page == 100) ? 'class="active"' : ''); ?>><a href="<?php print site_url('training/view_ebooks/'.trim($corpus).'/100'); ?>">100</a></li>
          <li <?php print (($per_page == 200) ? 'class="active"' : ''); ?>><a href="<?php print site_url('training/view_ebooks/'.trim($corpus).'/200'); ?>">200</a></li>
          <li <?php print (($per_page == 400) ? 'class="active"' : ''); ?>><a href="<?php print site_url('training/view_ebooks/'.trim($corpus).'/400'); ?>">400</a></li>
        </ul>
      </nav>
      
    </div>
   
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