$(function(){
	
	if($('#buy_block').length > 0){
		var wd_product_id =  $('#product_page_product_id').val();
		if(storeOnly[wd_product_id] == '1'){
			$('#add_to_cart').hide();
			$('#add_to_cart').after('<p class="btn-reserve">Ce produit ne peut être retiré qu\'en magasin.</p><p>Réservez ce produit dès maintenant soit :<ul><li>en appelant le +32(0)71/33.49.33</li><li>en envoyant un email à reservation@aquas.be</li></ul></p>');
		}
	}
	
	if($('.button.ajax_add_to_cart_button').length > 0){
		$.each($('.button.ajax_add_to_cart_button'),function(i,e){
			var wd_product_id =  $(e).data('id-product');
			if(storeOnly[wd_product_id] == '1'){
				$(e).hide();
				$(e).after('<a href="'+productLink[wd_product_id]+'" class="btn btn-default button button-small"><span>Sur réservation</span></a>');
			}
		});	
	}
	
	if($('.add_cart_slider').length > 0){
		$.each($('.add_cart_slider'),function(i,e){
			var wd_product_id = $(e).data('id-product');
			if(storeOnly[wd_product_id] == '1'){
				$(e).hide();
				$(e).after('<a href="'+productLink[wd_product_id]+'" class="add_cart_slider btn-reserve-slider">Sur réservation</a>');
			}
		});
	}
	
	if($('.button-small.ajax_add_to_cart_button').length > 0){
		$.each($('.button-small.ajax_add_to_cart_button'),function(i,e){
			var ajax_id_product = $(e).attr('rel');
			var wd_product_id = ajax_id_product.replace('ajax_id_product_','');
			if(storeOnly[wd_product_id] == '1'){
				$(e).hide();
				$(e).after('<a href="'+productLink[wd_product_id]+'" class="btn btn-default button button-small"><span>Sur réservation</span></a>')
			}
		});
	}
	
	
	
	
});