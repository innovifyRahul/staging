<?php
error_reporting(0);
include 'header.php';

?>

        
        <!-- content_wrapper -->
        <div class="content_wrapper wrap_100">
            <div class="full_content">
            	  <h1 class="headInModule">Clients</h1>
             
                <div class="module_grid_portfolio">
               
                	<ul>
                    	<li><img src="img/client_logo/11.jpg" alt="" /></li>
                        <li><img src="img/client_logo/22.jpg" alt="" /></li>
                        <li><img src="img/client_logo/33.jpg" alt="" /></li>
                        <li><img src="img/client_logo/44.jpg" alt="" /></li>
                        <li><img src="img/client_logo/55.jpg" alt="" /></li>
                        <li><img src="img/client_logo/66.jpg" alt="" /></li>
                        <li><img src="img/client_logo/77.jpg" alt="" /></li>
                        <li><img src="img/client_logo/88.jpg" alt="" /></li>
                        <li><img src="img/client_logo/111.jpg" alt="" /></li>
                        <li><img src="img/client_logo/222.jpg" alt="" /></li>
                        <li><img src="img/client_logo/333.jpg" alt="" /></li>
                        <li><img src="img/client_logo/444.jpg" alt="" /></li>
                        <li><img src="img/client_logo/555.jpg" alt="" /></li>
                        <li><img src="img/client_logo/666.jpg" alt="" /></li>
                        <li><img src="img/client_logo/777.jpg" alt="" /></li>
                                            
            		</ul>
                    <div class="clear"></div>
                </div><!-- //.module_grid_portfolio-->
                <script type="text/javascript">
					function grig_portf() {
						var count_inline = 5;
						
						jQuery('.module_grid_portfolio li').css('width', jQuery(window).width()/count_inline + 'px');
						var count_li = jQuery('.module_grid_portfolio > ul > li').length;						
						var count_line = Math.ceil(count_li/count_inline);
						var grid_container = jQuery('.module_grid_portfolio li').height()*count_line;
						jQuery('.module_grid_portfolio').css('height', grid_container + 'px');						
						jQuery('.module_grid_portfolio li').css('width', jQuery(window).width()/count_inline + 'px');						
					};
					
					jQuery(window).load(function() {
						grig_portf();
					});
					
					jQuery(window).resize(function(){
						grig_portf();		
					});
				</script>
                
            </div>	
        </div>
        <!-- //content_wrapper --> 
        
        <?php

include 'footer.php';

?>
      