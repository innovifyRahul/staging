<?php
//GIt Test
error_reporting(0);
include 'header.php';

?>
        <!-- content_wrapper -->
        <div class="content_wrapper wrap_100">
            <!--fullscreen_slider-->
            <div class="full_content">
                <div class="fullscreen_slider">
                	<div class="flexslider">
                      <ul class="slides">
                       
                        <li>
                            <img src="img/slider/fullwidth/2.png" class="slide_bg" />
                            <div class="fullscreen_caption">
                            	<div class="fullscreen_capt_in">
                                    <div class="fullscreen_sublayer1black">Ever Wondered to</div>
                                    <div class="fullscreen_sublayer2black">have<span>GLASS</span> on <span>WALLS</span></div>
                                    <div class="slider_separate"></div>
                                    
                                   
                           		</div>
                            </div>
                        </li>
                        <li>
                            <img src="img/slider/fullwidth/3.jpg" class="slide_bg" />
                            <div class="fullscreen_caption">
                            	<div class="fullscreen_capt_in">
                                    <div class="fullscreen_sublayer1">Fresh</div>
                                    <div class="fullscreen_sublayer2"><span>&amp;Clean</span></div>
                                    <div class="slider_separate"></div>
                                    <div class="fullscreen_sublayer3">Solid &amp; Clean code,<br/>framework with all features on board.</div>
                                   
                            	</div>
                            </div>
                        </li>
                        <li>
                            <img src="img/slider/fullwidth/4.jpg" class="slide_bg" />
                            <div class="fullscreen_caption">
                            	<div class="fullscreen_capt_in">
                                   <?php /*?> <div class="fullscreen_sublayer1">Responsive</div>
                                    <div class="fullscreen_sublayer2">&amp;<span>Retina</span>ready</div>
                                    <div class="slider_separate"></div>
                                    <div class="fullscreen_sublayer3">We care about our clients<br/>&amp; can make their life easier!</div><?php */?>
                                   
                            	</div>
                            </div>
                        </li>
                        <li>
                            <img src="img/slider/fullwidth/5.jpg" class="slide_bg" />
                            <div class="fullscreen_caption">
                            	<div class="fullscreen_capt_in">
                                   <?php /*?> <div class="fullscreen_sublayer1">Exclusive</div>
                                    <div class="fullscreen_sublayer2">&amp;<span>user</span>friendly</div>
                                    <div class="slider_separate"></div>
                                    <div class="fullscreen_sublayer3">flexible, transparent<br/>&amp; customer-focused.</div><?php */?>
                                   
                            	</div>
                            </div>
                        </li>
						 <li>
                            <img src="img/slider/fullwidth/6.jpg" class="slide_bg" />
                            <div class="fullscreen_caption">
                            	<div class="fullscreen_capt_in">
                                    <div class="fullscreen_sublayer1">Exclusive</div>
                                    <div class="fullscreen_sublayer2">&amp;<span>user</span>friendly</div>
                                    <div class="slider_separate"></div>
                                    <div class="fullscreen_sublayer3">Discover elegant solution</div>
                                    
                            	</div>
                            </div>
                        </li>
                      </ul>
                    </div>
                    
                     <script type="text/javascript" src="js/jquery.flexslider.js"></script>
                     <script type="text/javascript">
                     	jQuery(window).load(function() {
							jQuery('.flexslider').flexslider({
								animation: "slide",
								controlNav: false,
								pauseOnHover: true	
							});
						});						
                     </script>
                </div>
            </div>
            <!--//fullscreen_slider-->
        </div>
        <!-- //content_wrapper --> 
        
       <?php

include 'footer.php';

?>