$(function() {
  $('.progress-holder').hide();
  /*
  $('#fileupload').fileupload({
      url: upload_url,
      dataType: 'json',
      done: function (e, data) { 

           $('.progress-holder .text').html('<span class="glyphicon glyphicon-ok"></span> Training is done.');
             
           
      },
      success: function(data) { 
        var tempurl = site_url + 'training/show_results?ids='+data.inserted_ids;
        var html = '<br /><div class="text-center"><a class="btn btn-primary" href="'+tempurl+'">Show Results</a></div>';
        $('.linkholder').html(html);
      },
      progressall: function (e, data) {
        
        $('.progress-holder').removeClass('hide');
        $('.progress-holder').show();
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
        
      }
  }).prop('disabled', !$.support.fileInput)
      .parent().addClass($.support.fileInput ? undefined : 'disabled'); */
      
  $('.form-class-select').change(function(e) {
    
    var cl = $(this).val();

    var url = site_url + 'training/set_category/'+cl;
    $.get(url, function(data) {console.log(data);});
  });
  
  $(document).delegate('.do-training-now', 'click', function(e) {
    
    $('.delete-here').remove();
    
    
    
  });
  
});