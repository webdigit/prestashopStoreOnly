$(function(){
	
	//Cache le bouton 'Ajouter au panier' sur la page d'accueil
	//var buttonContainer = $('.button-container').closest('.right-block');
	//buttonContainer.find('a span:first').css('visibility','hidden');
	var buttonContainer = $('.right-block').find('.button-container');
	buttonContainer.find('a:first').remove();
	
	
	//Cache le bouton 'Ajouter au panier' sur la page article
	//$('#add_to_cart').css('visibility','hidden');
	$('#add_to_cart').remove();
	
	//Ajout du message pour la réservation
	$('#short_description_content p').after('<p style="font-size:18px;text-align:center;border:1px solid black;line-height:25px;color:black;">Article uniquement disponible en magasin. Pour réserver l\'article, il faut téléphoner au magasin.</p>');
	
});