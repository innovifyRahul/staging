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
                                 <h1 class="headInModule">Carpets and Rugs</h1>
                                               <center>   <img src="img/page_under.png"  alt="Page under construction" /></center>
                                    <?php /*?><div class="row-fluid">
                                        <div class="span12 module_cont module_text_area">
                                            <h1 class="headInModule">Portfolio</h1>
                                            <p>Vivamus quis mauris mauris. Cras quis eros neque. In rutrum accumsan ullamcorper. Vestibulum vitae mauris lectus, non cursus augue. Mauris vitae suscipit turpis. Duis alfaucibus laoreet ullamcorper commodo, neque purus rhoncus eros, non vulputate sapien velit et urna. Lorem ipsum dolor sit amet, consectetur adipiscing elit nulla pellentesque.</p>
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
                                                                <li><a title="View all post filed under Red" data-option-value=".red" href="#filter">red</a></li>
                                                                <li><a title="View all post filed under Yellow" data-option-value=".yellow" href="#filter">yellow</a></li>
                                                                <li><a title="View all post filed under Green" data-option-value=".green" href="#filter">green</a></li>
                                                                <li><a title="View all post filed under Blue" data-option-value=".blue" href="#filter">blue</a></li>
                                                                <li><a title="View all post filed under Other" data-option-value=".other" href="#filter">other</a></li>
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
                                                                <img src="img/portfolio/square/1.jpg" alt="" width="570" height="570">
                                                                <div class="portf_shape"></div>                                                                                  
                                                                <div class="portfolio_descr">
                                                                    <div class="portfolio_title"><h6><a href="portfolio_post1.html">Etiam sodales</a></h6></div>
                                                                    <div class="portfolio_text">Quisque ut nisl et neque blandit quistum.</div>
                                                                    <div class="portfolio_btns">
                                                                        <a href="img/portfolio/square/1.jpg" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a>
                                                                        <a href="portfolio_post1.html" class="link_ico">link</a>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>  
                                                        </div>
                                                    </div><!-- .element --> 
                                                    
                                                    <div data-category="yellow" class="yellow element">
                                                        <div class="filter_img">
                                                            <div class="wrapped_img portfolio_item">
                                                                <img src="img/portfolio/square/2.jpg" alt="" width="570" height="570">
                                                                <div class="portf_shape"></div>                                                                                  
                                                                <div class="portfolio_descr">
                                                                    <div class="portfolio_title"><h6><a href="portfolio_post1.html">Quisque ut nisl</a></h6></div>
                                                                    <div class="portfolio_text">Nullam at ligula eget dolor laoreet mollis.</div>
                                                                    <div class="portfolio_btns">
                                                                        <a href="img/portfolio/square/2.jpg" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a>
                                                                        <a href="portfolio_post1.html" class="link_ico">link</a>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>  
                                                        </div>
                                                    </div><!-- .element -->
    
                                                    <div data-category="green" class="green element">
                                                        <div class="filter_img">
                                                            <div class="wrapped_img portfolio_item">
                                                                <img src="img/portfolio/square/3.jpg" alt="" width="570" height="570"> 
                                                                <div class="portf_shape"></div>                                                                                 
                                                                <div class="portfolio_descr">
                                                                    <div class="portfolio_title"><h6><a href="portfolio_post1.html">Nullam at ligula</a></h6></div>
                                                                    <div class="portfolio_text">Proin posuere luctus lectus in sollicitudin.</div>
                                                                    <div class="portfolio_btns">
                                                                        <a href="img/portfolio/square/3.jpg" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a>
                                                                        <a href="portfolio_post1.html" class="link_ico">link</a>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>  
                                                        </div>                                                        
                                                    </div><!-- .element -->                                                    
    
                                                    <div data-category="blue" class="blue element">
                                                        <div class="filter_img">
                                                            <div class="wrapped_img portfolio_item">
                                                                <img src="img/portfolio/square/4.jpg" alt="" width="570" height="570">
                                                                <div class="portf_shape"></div>                                                                                  
                                                                <div class="portfolio_descr">
                                                                    <div class="portfolio_title"><h6><a href="portfolio_post1.html">Proin posuere</a></h6></div>
                                                                    <div class="portfolio_text">Proin dapibus arcu nec diam faucibus vestibulum.</div>
                                                                    <div class="portfolio_btns">
                                                                        <a href="img/portfolio/square/4.jpg" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a>
                                                                        <a href="portfolio_post1.html" class="link_ico">link</a>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>  
                                                        </div>                                                         
                                                    </div><!-- .element -->                      
    
                                                    <div data-category="other" class="other element">
                                                        <div class="filter_img">
                                                            <div class="wrapped_img portfolio_item">
                                                                <img src="img/portfolio/square/5.jpg" alt="" width="570" height="570">
                                                                <div class="portf_shape"></div>                                                                                  
                                                                <div class="portfolio_descr">
                                                                    <div class="portfolio_title"><h6><a href="portfolio_post1.html">Proin dapibus</a></h6></div>
                                                                    <div class="portfolio_text">Nullam at ligula eget dolor laoreet mollis.</div>
                                                                    <div class="portfolio_btns">
                                                                        <a href="img/portfolio/square/5.jpg" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a>
                                                                        <a href="portfolio_post1.html" class="link_ico">link</a>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>  
                                                        </div>
                                                    </div><!-- .element -->
                                                    
                                                    <div data-category="red" class="red element">
                                                        <div class="filter_img">
                                                            <div class="wrapped_img portfolio_item">
                                                                <img src="img/portfolio/square/6.jpg" alt="" width="570" height="570"> 
                                                                <div class="portf_shape"></div>                                                                                 
                                                                <div class="portfolio_descr">
                                                                    <div class="portfolio_title"><h6><a href="portfolio_post1.html">Nullam at ligula</a></h6></div>
                                                                    <div class="portfolio_text">Proin posuere luctus lectus in sollicitudin.</div>
                                                                    <div class="portfolio_btns">
                                                                        <a href="img/portfolio/square/6.jpg" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a>
                                                                        <a href="portfolio_post1.html" class="link_ico">link</a>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>  
                                                        </div>                                                        
                                                    </div><!-- .element -->
                                                                                                  
                                                    <div data-category="yellow" class="yellow element">
                                                        <div class="filter_img">
                                                            <div class="wrapped_img portfolio_item">
                                                                <img src="img/portfolio/square/7.jpg" alt="" width="570" height="570">
                                                                <div class="portf_shape"></div>                                                                                  
                                                                <div class="portfolio_descr">
                                                                    <div class="portfolio_title"><h6><a href="portfolio_post1.html">Faucibus vest</a></h6></div>
                                                                    <div class="portfolio_text">Proin dapibus arcu nec diam faucibus vestibulum.</div>
                                                                    <div class="portfolio_btns">
                                                                        <a href="img/portfolio/square/7.jpg" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a>
                                                                        <a href="portfolio_post1.html" class="link_ico">link</a>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>  
                                                        </div> 
                                                    </div><!-- .element -->
    
                                                    <div data-category="green" class="green element">
                                                        <div class="filter_img">
                                                            <div class="wrapped_img portfolio_item">
                                                                <img src="img/portfolio/square/8.jpg" alt="" width="570" height="570"> 
                                                                <div class="portf_shape"></div>                                                                                 
                                                                <div class="portfolio_descr">
                                                                    <div class="portfolio_title"><h6><a href="portfolio_post1.html">Blandit quistum</a></h6></div>
                                                                    <div class="portfolio_text">Quisque ut nisl et neque blandit quistum.</div>
                                                                    <div class="portfolio_btns">
                                                                        <a href="img/portfolio/square/8.jpg" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a>
                                                                        <a href="portfolio_post1.html" class="link_ico">link</a>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>  
                                                        </div>
                                                    </div><!-- .element -->  
    
                                                    <div data-category="blue" class="blue element">
                                                        <div class="filter_img">
                                                            <div class="wrapped_img portfolio_item">
                                                                <img src="img/portfolio/square/9.jpg" alt="" width="570" height="570">
                                                                <div class="portf_shape"></div>                                                                                  
                                                                <div class="portfolio_descr">
                                                                    <div class="portfolio_title"><h6><a href="portfolio_post1.html">Etiam sodales</a></h6></div>
                                                                    <div class="portfolio_text">Quisque ut nisl et neque blandit quistum.</div>
                                                                    <div class="portfolio_btns">
                                                                        <a href="img/portfolio/square/9.jpg" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a>
                                                                        <a href="portfolio_post1.html" class="link_ico">link</a>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>  
                                                        </div>                                                        
                                                    </div><!-- .element --> 
                                                    
                                                    <div data-category="other" class="other element">
                                                        <div class="filter_img">
                                                            <div class="wrapped_img portfolio_item">
                                                                <img src="img/portfolio/square/10.jpg" alt="" width="570" height="570">
                                                                <div class="portf_shape"></div>                                                                                  
                                                                <div class="portfolio_descr">
                                                                    <div class="portfolio_title"><h6><a href="portfolio_post1.html">Quisque ut nisl</a></h6></div>
                                                                    <div class="portfolio_text">Nullam at ligula eget dolor laoreet mollis.</div>
                                                                    <div class="portfolio_btns">
                                                                        <a href="img/portfolio/square/10.jpg" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a>
                                                                        <a href="portfolio_post1.html" class="link_ico">link</a>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>  
                                                        </div>                                                         
                                                    </div><!-- .element --> 
    
                                                    <div data-category="red" class="red element">
                                                        <div class="filter_img">
                                                            <div class="wrapped_img portfolio_item">
                                                                <img src="img/portfolio/square/11.jpg" alt="" width="570" height="570">
                                                                <div class="portf_shape"></div>                                                                                  
                                                                <div class="portfolio_descr">
                                                                    <div class="portfolio_title"><h6><a href="portfolio_post1.html">Nullam at ligula</a></h6></div>
                                                                    <div class="portfolio_text">Proin posuere luctus lectus in sollicitudin.</div>
                                                                    <div class="portfolio_btns">
                                                                        <a href="img/portfolio/square/11.jpg" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a>
                                                                        <a href="portfolio_post1.html" class="link_ico">link</a>
                                                                    </div>
                                                                </div>                                                                
                                                            </div>  
                                                        </div>
                                                    </div><!-- .element -->                                                    
    
                                                    <div data-category="blue" class="blue element">
                                                        <div class="filter_img">
                                                            <div class="wrapped_img portfolio_item">
                                                                <img src="img/portfolio/square/12.jpg" alt="" width="570" height="570">
                                                                <div class="portf_shape"></div>                                                                                  
                                                                <div class="portfolio_descr">
                                                                    <div class="portfolio_title"><h6><a href="portfolio_post1.html">Proin posuere</a></h6></div>
                                                                    <div class="portfolio_text">Proin dapibus arcu nec diam faucibus vestibulum.</div>
                                                                    <div class="portfolio_btns">
                                                                        <a href="img/portfolio/square/12.jpg" class="prettyPhoto zoom_ico" rel="prettyPhoto[portfolio1]">zoom</a>
                                                                        <a href="portfolio_post1.html" class="link_ico">link</a>
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
                                    
                                
                                </div><?php */?><!-- .contentarea -->
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