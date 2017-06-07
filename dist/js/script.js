$(document).ready(function(){
     $('#json_click_handler').click(function(){
          doAjaxRequest();
     });
});
function doAjaxRequest(){
	$.ajax({
		url: 'http://memoireselectriques.fr/dev/wp-admin/admin-ajax.php',
		data:{
			'action':'do_ajax',
			'fn':'get_latest_posts',
			'count':10
		},
		dataType: 'JSON',
		success:function(data){
			//console.log(data[0].ID);
			$("#json_response_box").html(data[0].ID);
		},
		error: function(errorThrown){
			alert('error');
			console.log(errorThrown);
		}
	});
}