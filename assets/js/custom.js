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
  
});