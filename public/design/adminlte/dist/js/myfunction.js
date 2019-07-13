function check_all(){
	//item checkbox 
	$('input[class="check_all"]:checkbox').each(function(){
		if($('.item_checkbox').filter(":checked").length == 0){
			$(this).prop('checked',false);
			alert('false');
		}else{
			$(this).prop('checked',true);
			alert('false');
		}
	});
}
function delete_all(){
	$(document).on('click','.del_all',function(){
		$('#form_data').submit();
	});

	$(document).on('click','.delBtn',function(){
		var item_checked = $('.item_checkbox').filter(":checked").length;
		if (item_checked > 0 ){
			$('.record_count').text(item_checked + ' record');
			$('.not_empty_record').removeClass('hidden');
			$('.empty_record').addClass('hidden');
		}else{
			$('.record_count').text('');
			$('.not_empty_record').addClass('hidden');
			$('.empty_record').removeClass('hidden');
		}
		$('#mutlipleDelete').modal('show');
	});
}