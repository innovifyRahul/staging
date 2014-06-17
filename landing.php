
        
        <!-- content_wrapper -->
        <div class="content_wrapper wrap_100">
            <div class="full_content">
            	
                <div class="module_grid_portfolio">
                	<ul>
                    	<li><a href="img/portfolio/grid/1.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/1.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/2.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/2.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/3.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/3.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/4.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/4.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/5.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/5.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/6.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/6.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/7.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/7.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/8.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/8.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/9.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/9.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/10.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/10.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/11.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/11.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/12.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/12.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/13.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/13.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/14.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/14.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/15.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/15.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/16.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/16.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/17.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/17.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/18.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/18.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/19.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/19.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/20.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/20.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/5.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/5.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/4.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/4.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/1.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/1.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/2.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/2.jpg" alt="" /></a></li>
                        <li><a href="img/portfolio/grid/3.jpg" class="prettyPhoto" rel="prettyPhoto[portfgrid1]"><img src="img/portfolio/grid/3.jpg" alt="" /></a></li>                        
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
        
       