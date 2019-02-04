$(function() {
    	$('img').on('click', function() {
			$('.enlargeImageModalSource').attr('src', $(this).attr('src'));
			$('#enlargeImageModal').modal('show');
		});
});


  function toggle(source) {
    var checkboxes = document.querySelectorAll('input[type="checkbox"]');
    for (var i = 0; i < checkboxes.length; i++) {
    if (checkboxes[i] != source)
    checkboxes[i].checked = source.checked;
    }
    };
	
	
	$("#checkAll").change(function () {
    $("input:checkbox").prop('checked', $(this).prop("checked"));
});

	$('#checkAll').click(function () {    
    $(':checkbox.checkItem').prop('checked', this.checked);    
 });
 
$("#choose").click(function(){
    $("#choose").hide();
	$("#chosen").show();
  });

  
  $("#chosen").hide();
  
  document.getElementById('choose').addEventListener('click',function(){
    document.getElementById('image').click();
});