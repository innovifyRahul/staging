<?php
error_reporting(0);
include 'header.php';

?>
     <!-- C O N T E N T -->
        <div class="content_wrapper">
            <div class="container">
                <div class="content_block no-sidebar row">
                    <div class="fl-container span12">
                        <div class="row">
                            <div class="posts-block span12">
                                <div class="contentarea">
                                
                                    <div class="row-fluid">
                                        <div class="span12 module_cont module_text_area">
                                            <h1 class="headInModule">Wooden Flooring</h1>
                                        
                                          
                                            </p>
                                            <hr class="content_type">
                                        </div>								
                                    </div><!-- .row-fluid -->
                                    
                                    <div class="row-fluid">
                                        <div class="span12 module_cont module_portfolio">
                                            <div class="filter_block">
                                                <div class="filter_navigation">
                                                    <ul id="options" class="splitter">
                                                        <li>
                                                            <ul data-option-key="filter" class="optionset">
                                                                <li class="selected"><a data-option-value="*" href="#filter">All Works</a></li>
                                                                <li><a title="View all post filed under Red" data-option-value=".red" href="#filter">Juno Floors</a></li>
                                                                </ul>
                                                        </li>
                                                    </ul>
                                                </div><!-- .filter_navigation -->
                                            </div><!-- .filter_block -->
                                            
                                            <div class="shaped_portfolio round_shape">
                                                <div class="portfolio_block image-grid columns4" id="list">   
                                                                                             
                                                    <div data-category="red" class="red element">
                                                        <div class="filter_img">
                                                            <div class="wrapped_img portfolio_item">
                                                                <img src="img/brands/juno.png" alt="" width="570" height="570">
                                                                <div class="portf_shape"></div>                                                                                  
                                                                <div class="portfolio_descr">
                                                                      <div class="portfolio_btns">
                                                                        <a href="http://junofloors.in" target="_blank" class="link_ico">link</a>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>  
                                                        </div>
                                                    </div><!-- .element --> 
                                                    
                                                   
                                                    
                                                </div><!-- .portfolio_block -->
                                            </div><!-- //.simple_portfolio -->
                                            <div class="clear"></div>
                                            <div class="load_more_cont"><a href="javascript:void(0)" class="btn_load_more get_portfolio_works_btn shortcode_button btn_normal btn_type1">Load more Works</a></div>
                                            <script>
                                                items_set = [	//Gallery Data
												
                                                    {src : 'img/portfolio/square/13.jpg', url : 'portfolio_post1.html', post_zoom : 'img/portfolio/square/13.jpg', category: 'red', title : 'Cum sociis', description: '<p>Curabitur bibendum, ante sed bibendum.</p>'},

                                                    {src : 'img/portfolio/square/14.jpg', url : 'portfolio_post1.html', post_zoom : 'img/portfolio/square/14.jpg', category: 'green', title : 'Aenean quis', description: '<p>Lorem ipsum dolor sit amet, consectetur.</p>'},

                                                    {src : 'img/portfolio/square/15.jpg', url : 'portfolio_post1.html', post_zoom : 'img/portfolio/square/15.jpg', category: 'yellow', title : 'In habitasse', description: '<p>Curabitur bibendum, ante sed bibendum.</p>'},

                                                    {src : 'img/portfolio/square/16.jpg', url : 'portfolio_post1.html', post_zoom : 'img/portfolio/square/16.jpg', category: 'blue', title : 'Vivamus aliquet', description: '<p>Lorem ipsum dolor sit amet, consectetur.</p>'}
													
                                                ];
                                                jQuery('#list').portfolio_addon({
                                                    type : 2, // 2-4 columns shaped portfolio
                                                    load_count : 4,
                                                    items : items_set
                                                });
                                            </script>
                                        </div><!-- .module_portfolio -->
                                    </div><!-- .row-fluid -->                                       
                                    
                                
                                </div><!-- .contentarea -->
                            </div>                                                                
                            <div class="left-sidebar-block span3">
								<aside class="sidebar">
                                </aside>
                            </div><!-- .left-sidebar -->
                        </div>

                        <div class="clear"><!-- ClearFix --></div>
                    </div><!-- .fl-container -->
                    <div class="right-sidebar-block span3">
                        <aside class="sidebar">
                        </aside>
                    </div><!-- .right-sidebar -->
                    <div class="clear"><!-- ClearFix --></div>
                </div>
            </div><!-- .container -->
        </div>
        <!-- .content_wrapper -->   
    
  <?php

include 'footer.php';

?>