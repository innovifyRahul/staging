function enableSelectBoxes(){
	jQuery('div.selectBox').each(function(){
		jQuery(this).children('span.selected').html(jQuery(this).children('div.selectOptions').children('span.selectOption:first').html());
		jQuery(this).attr('value',jQuery(this).children('div.selectOptions').children('span.selectOption:first').attr('value'));
		
		jQuery(this).children('span.selected,span.selectArrow').click(function(){
			if(jQuery(this).parent().children('div.selectOptions').css('display') == 'none'){
				jQuery(this).parent().children('div.selectOptions').css('display','block');
			}
			else
			{
				jQuery(this).parent().children('div.selectOptions').css('display','none');
			}
		});
		
		jQuery(this).find('span.selectOption').click(function(){
			jQuery(this).parent().css('display','none');
			jQuery(this).closest('div.selectBox').attr('value',jQuery(this).attr('value'));
			jQuery(this).parent().siblings('span.selected').html(jQuery(this).html());
		});
	});				
}

jQuery(document).ready(function() {
	/*Shop Scripts*/
	
	//Custom select
	enableSelectBoxes();
	
	// Products grid sort
	jQuery('.grid_btn').click(function(){
		jQuery('.shop_order_grid li').removeClass('current');
		jQuery(this).parent().addClass('current');
		jQuery('.module_shop').find('.module_shop_wrapper').removeClass('list_grid');		
	});
	jQuery('.list_btn').click(function(){
		jQuery('.shop_order_grid li').removeClass('current');
		jQuery(this).parent().addClass('current');
		jQuery('.module_shop').find('.module_shop_wrapper').removeClass('list_grid');
		jQuery('.module_shop').find('.module_shop_wrapper').addClass('list_grid');		
	});
	
	jQuery('.plus').click(function(){
		qty_field = jQuery(this).parent('.quantity').find('.qty');
		qty_count = parseInt(qty_field.val())+1;
		qty_field.val(qty_count);
	});
	
	jQuery('.minus').click(function(){
		qty_field = jQuery(this).parent('.quantity').find('.qty');
		qty_count = parseInt(qty_field.val())-1;
		if (qty_count < parseInt(qty_field.attr('data-min'))) {
			qty_count = parseInt(qty_field.attr('data-min'));
		}
		qty_field.val(qty_count);
	});
	
	/*Shop Colors check*/
    jQuery(".colors_block li a").click(function () {
		jQuery('.colors_block li').removeClass("current");
		jQuery(this).parent().toggleClass("current");
	});	
	
	/* Product item preview */
	jQuery('.product_thumbs li a').click(function(){
		jQuery('.product_thumbs li a').removeClass("current");
		jQuery(this).addClass("current");		
		jQuery('#largeImage').attr('src',$(this).find('img').attr('src').replace('product_thumb','product_large'));
		$('#zoom_product').attr('href',$(this).find('img').attr('src').replace('product_thumb','product_large'));	
	});	
	
});