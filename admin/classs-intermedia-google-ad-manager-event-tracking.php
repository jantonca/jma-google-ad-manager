<?php

/**
 * The Event tracking class
 *
 * @link       https://www.intermedia.com.au/
 * @since      1.0.0
 *
 * @package    Intermedia_Google_Ad_Manager
 * @subpackage Intermedia_Google_Ad_Manager/admin
 */

/**
 * Class classs-intermedia-google-ad-manager-event-tracking
 *
 */
class IGAM_Event_Tracking {

    public static function intermedia_ga_event($action, $category, $label, $value = 1) {

        $label = str_replace( '"', "", str_replace( "'", "", $label ) );
        $action = "'".$action."'";
        $category = "'".$category."'";
        $label = "'".$label."'";

        return "gtag('event', $action, {'event_category': $category,'event_label': $label,'value': $value});";

    }
    
    //must make sure google analytics there 
	public static function intermedia_dfp_ga_tracking( $dimension, $dfp_tag, $ga_id ) {

        $dimention = "'" . $dimension . "'";
        $dfp_tag = str_replace("'", "", str_replace('"','',$dfp_tag));

        return  "<script type='text/javascript'>
            jQuery(document).ready(function(){
            gtag('config', '".$ga_id."', {'custom_map': {'" . $dimension . "': 'dfp_dimension'}});
            gtag('event', 'dfp_dimension', {'dfp_dimension': '".$dfp_tag."'});
            });
            </script>";
    }

    public static function add_footer_tracking_code() {

        /* BEGIN HTML OUTPUT */
        ob_start(); // Turn on output buffering

        ?>
        <script type="text/javascript">
            //Intermedia Contact tracking
            window.addEventListener("load",function(){

                //Intermedia Contact tracking email
                jQuery("a[href*=\'mailto:\']").click(function(){
                    gtag("event","click",{
                        "event_category":"email",
                        "event_label":jQuery(this).text()
                    });
                });
                //Intermedia Contact tracking phone
                jQuery("a[href*=\'tel:\']").click(function(){
                    gtag("event","click",{
                        "event_category":"phone number",
                        "event_label":jQuery(this).text()
                    });
                });
                //Intermedia pdf download tracking
                jQuery("a[class*=\'download_pdf\']").click(function(){
                    gtag("event","click",{
                        "event_category":"download_pdf",
                        "event_label":jQuery(this).attr("title")
                    });
                });

            });

            jQuery(document).ready(function(){

                //Intermedia subscribe form tracking
                jQuery("form#subForm").submit(function(e){
                    gtag( "event", "signup", { "event_category": "sign up from campaign monitor form", "event_label": "signup CM newsletter", "value": 1 } );
                });

            });
        </script>
        <?php

        /* END HTML OUTPUT */
        $output = ob_get_contents(); // collect output
          
        ob_end_clean(); // Turn off ouput buffer
          
        echo $output; // Print output

    }
    
    public static function track_bloom_form_submit() {

        /* BEGIN HTML OUTPUT */
        ob_start(); // Turn on output buffering

        ?>
        <script type="text/javascript">
            jQuery(document).ready(function(){
                jQuery("button.et_bloom_submit_subscription").each(function(){
                    jQuery(this).click(function(){
                        gtag( "event", "signup", { "event_category": "sign up from bloom form " + jQuery(this).attr("data-optin_id"), "event_label": "signup CM newsletter", "value": 1 } );
                    });
                });
            });
        </script>
        <?php

        /* END HTML OUTPUT */
        $output = ob_get_contents(); // collect output

        ob_end_clean(); // Turn off ouput buffer

        echo $output; // Print output

    }

}