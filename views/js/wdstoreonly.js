$(function(){
	
	if($('#buy_block').length > 0){
		var wd_product_id =  $('#product_page_product_id').val();
		if(storeOnly[wd_product_id] == '1'){
			$('#add_to_cart').hide();
			$('#add_to_cart').after('<p class="btn-reserve">Article uniquement disponible en magasin. Pour réserver l\'article, il faut téléphoner au magasin.</p>');
		}
	}
	
	if($('.button.ajax_add_to_cart_button').length > 0){
		$.each($('.button.ajax_add_to_cart_button'),function(i,e){
			var wd_product_id =  $(e).data('id-product');
			if(storeOnly[wd_product_id] == '1'){
				$(e).hide();
				$(e).after('<a class="button btn-reserve"><span>Sur réservation</span></a>');
			}
		});	
	}
	
});