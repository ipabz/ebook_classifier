$(function() {
  
  $('.showmoreresults').click(function(e) {
    e.preventDefault();
    
    var value = $(this).val();
    
    if (value === 'Show Details') {
      $('.result-table').show('slow');
      $(this).val('Hide Details');
    } else {
      $('.result-table').hide('slow');
      $(this).val('Show Details');
    }
    
  });
  
  $(document).delegate('.do_ajax', 'click', function(e) {
	e.preventDefault();
	$('.feedback').html('<strong>Thank you! Your feedback would be a great help.</strong>');
	var token = $('#finaltokens_encoded').html();
	var d = { tokens: token };
	
	$.post($(this).attr('href'), d, function(data) { console.log(data); });
	
	return false;  
  });
  
  $('.starttesting').click(function(e) {
    
	$('.testuploadform').attr('style', 'visibility: hidden');
	$('.fileupload-buttonbar').append('<div class="text-center"><h2>Please wait while we process the file...</h2><br /><img src="assets/images/ajax-loading.gif" /><br /><br /><br />&nbsp;</div>');  
  });
  
  $('.ebook_view_tokens').click(function(e) {
    e.preventDefault();
    
    $('.modal-body').html('<div class="text-center"><br /><img src="assets/images/ajax-loading.gif" /><br />&nbsp;</div>');
    var url = $(this).attr('data-url');
    var filename = $(this).attr('data-filename');
    
    $('.modal-title').html(filename);
    
    $.get(url, function(data) {
      //$('.modal-body').html(data);
      setTimeout(function() {$('.modal-body').html(data);}, 1000);
    });
    
  });
  
});