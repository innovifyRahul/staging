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
                                        <div class="span12"><br>
                                            <h1 class="headInModule"><br>Contact us!</h1>
                                        </div>								
                                    </div><!-- .row-fluid -->
                                    <div class="row-fluid">
                                        <div class="span12 module_cont module_text_area">
                                            <p>Feel Free to contact us for any requirement of yours. </p>
                                            <hr class="content_type">
                                        </div>								
                                    </div><!-- .row-fluid -->
                                    
                                    <div class="row-fluid">
                                        <div class="span12 module_cont module_google_map">
                                            <div class="wrapped_video"><iframe width="600" height="450" frameborder="0" style="border:0" src="https://www.google.com/maps/embed/v1/place?q=210%2C%20Someshwara%20Complex-2%2C%20Opp%20Star%20Bazaar%2C%20Satellite%20Road%2C%20Satellite%2C%20Ahmedabad%20-%20380015&key=AIzaSyBkk-e1WlC6qbMdkF1ASA2CF-FZRRf8BmA"></iframe></div>
                                        </div><!-- .module_cont -->
                                    </div><!-- .row-fluid -->  
                                    
                                    <div class="row-fluid">
                                        <div class="span6 module_cont module_feedback_form">
                                        	<div class="bg_title"><h4 class="headInModule">Get in Touch!</h4></div>
                                            <form name="feedback_form" method="post" action="index.php" class="feedback_form">
                                                <div><label class="label-name"></label><input type="text" name="field-name" value="Name" title="Name" class="field-name form_field required_field"></div>
                                                <div><label class="label-email"></label><input type="text" name="field-email" value="Email" title="Email" class="field-email form_field required_field"></div>
                                                <div><label class="label-subject"></label><input type="text" name="field-subject" value="Subject" title="Subject" class="field-subject form_field required_field"></div>
                                                <div><label class="label-message"></label><textarea name="field-message" cols="45" rows="5" title="Message" class="field-message form_field required_field">Message</textarea></div>
                                                <input type="reset" name="reset" id="reset2" value="Clear form" class="feedback_reset">
                                                <input type="button" name="submit" class="feedback_go" id="submit2" value="Send!">
                                                <div class="ajaxanswer"></div>
                                            </form>
                                        </div><!-- .module_cont -->

                                        <div class="span6 module_cont module_contact_info">
                                            <div class="bg_title"><h4 class="headInModule">Contact Information</h4></div>
                                            <div class="continfo_item"><span class="ico_socialize_home ico_socialize type1"></span>210, Someshwara Complex-2, Opp Star Bazaar, Satellite Road, Satellite, Ahmedabad - 380015</div>
                                            <div class="continfo_item"><span class="ico_socialize_phone ico_socialize type1"></span>+91 79 26921101 , +91 8866041218</div>
                                            <div class="continfo_item"><span class="ico_socialize_mail ico_socialize type1"></span><a href="mailto:kamal@kaaleen.in">info@kaaleen.in</a></div>
                                            
                                            <div class="continfo_item"><span class="ico_socialize_twitter2 ico_socialize type1"></span><a href="http://www.twitter.com/kaaleenIndia" target="_blank">Twitter</a></div>
                                            <div class="continfo_item"><span class="ico_socialize_facebook1 ico_socialize type1"></span><a href="http://www.facebook.com/kaaleenIndia" target="_blank">Facebook</a></div>
                                         
                                        </div><!-- .module_cont -->           
                                    </div><!-- .row-fluid 
                                    
                                    <div class="row-fluid">
                                        <div class="span12 module_cont module_text_area">
                                        	<hr>
                                            <p>Quis vivamus mauris mauris. Cras quis eros neque. In rutrum accumsan ullamcorper. Vestibulum vitae mauris lectus, non cursus augue. Mauris vitae suscipit turpis duis alfaucibus laoreet ullamcorper commodo, neque purus rhoncus eros, non vulputate sapien velit et urna. Lorem ipsum dolor sit amet, consectetur adipiscing elit nulla pellentesque eget.</p>                                            
                                        </div>								
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
       </div><!-- .content_wrapper -->    
    
     <?php

include 'footer.php';

?>