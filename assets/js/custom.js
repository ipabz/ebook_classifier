$(function() {
  $('.progress-holder').hide();
  
  $('#fileupload').fileupload({
      url: upload_url,
      dataType: 'text',
      done: function (e, data) { 
        
           setTimeout(function() {
             $('.progress-holder .text').html('<span class="glyphicon glyphicon-ok"></span> Training is done.');
           }, 1000);
           
      },
      success: function(data) { 
       console.log(data);
      },
      progressall: function (e, data) {
        /*
        $('.progress-holder').removeClass('hide');
        $('.progress-holder').show();
        var progress = parseInt(data.loaded / data.total * 100, 10);
        $('#progress .progress-bar').css(
            'width',
            progress + '%'
        );
        */
      }
  }).prop('disabled', !$.support.fileInput)
      .parent().addClass($.support.fileInput ? undefined : 'disabled');
      
  $('.form-class-select').change(function(e) {
    
    var cl = $(this).val();
    class_name = cl;
    
    upload_url = __upload_url + class_name;
    
  });
  
});