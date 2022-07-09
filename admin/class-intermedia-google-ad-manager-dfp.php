<?php

/**
 * The functionality of the plugin.
 *
 * @link       https://www.intermedia.com.au/
 * @since      1.0.0
 *
 * @package    Intermedia_Google_Ad_Manager
 * @subpackage Intermedia_Google_Ad_Manager/dfp
 */

/**
 * Class WordPress_Plugin_Settings_functionality
 *
 */
class IGAM_DFP {

    public function render_gam_head() {

      global $post;

      $ip = '';

      if( !empty( $_SERVER['HTTP_CLIENT_IP'] ) ) {

          $ip = $_SERVER['HTTP_CLIENT_IP'];

      } elseif ( !empty( $_SERVER['HTTP_X_FORWARDED_FOR'] ) ) {

          $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];

      } else {

          $ip = $_SERVER['REMOTE_ADDR'];

      }
    
      /* BEGIN HTML OUTPUT */
      ob_start(); // Turn on output buffering

      ?>

        <!-- STARTS JS for DFP GAM -->
        <script type='text/javascript'>  
          var googletag = googletag || {};
          googletag.cmd = googletag.cmd || [];
          ( function() {
            var gads = document.createElement('script');
            gads.async = true;
            gads.type = 'text/javascript';
            var useSSL = 'https:' == document.location.protocol;
            gads.src = (useSSL ? 'https:' : 'http:') + '//www.googletagservices.com/tag/js/gpt.js';
            var node = document.getElementsByTagName('script')[0];
            node.parentNode.insertBefore(gads, node);
          } ) ();

          googletag.cmd.push( function() {
            <?php $this->add_size_mapping_vars(); ?>
            //////////////////////////////////////////////the code inserted is from here
            //Insert google ads
            //SKINS
            <?php $this->render_ad_options( 'intermedia_google_ad_manager_skin_options' ); ?>
            //LEADERBOARD
            <?php $this->render_ad_options( 'intermedia_google_ad_manager_leaderboard_options' ); ?>
            //MREC
            <?php $this->render_ad_options( 'intermedia_google_ad_manager_mrec_options' ); ?>
            //HALFPAGE
            <?php $this->render_ad_options( 'intermedia_google_ad_manager_halfpage_options' ); ?>
            //////////////////////////////////////////////the code inserted is to here
            // Register event handlers to observe lazy loading behavior.
            googletag.pubads().addEventListener('slotRequested', function(event) {updateSlotStatus(event.slot.getSlotElementId(), 'fetched');});
            googletag.pubads().addEventListener('slotOnload', function(event) { updateSlotStatus(event.slot.getSlotElementId(), 'rendered');});
            console.log(event);
            function updateSlotStatus(slotId, state) { console.log(slotId + ': ' +state);}
            googletag.pubads().enableSingleRequest();
            googletag.pubads().collapseEmptyDivs();
            googletag.enableServices();

            googletag.cmd.push( function() { googletag.pubads().setTargeting( 'ip', '<?php echo $ip; ?>' ); } );
            <?php if( is_search() && isset( $_REQUEST['s'] ) ): ?>
            
                googletag.cmd.push( function() { googletag.pubads().setTargeting( "search_keyword", "<?php echo $_REQUEST['s']; ?>" ); } );
            
            <?php endif; ?>
            <?php if( is_category() ): $cat = single_cat_title( '', false ); ?>

                  googletag.cmd.push( function() { googletag.pubads().setTargeting( 'category', '<?php echo $cat; ?>' ); } );
                
            <?php endif; ?>
            <?php if( is_tag() ): $tag_title = single_tag_title( '', false ); ?>

                  googletag.cmd.push( function() { googletag.pubads().setTargeting( 'archive', '<?php echo $tag_title; ?>' ); } );

            <?php endif; ?>
            <?php if( is_page_template( 'dfp-tag-template-page.php' ) ): global $wp_query; ?>
          
              <?php  if( isset( $wp_query->query_vars['dfp_tag'] ) && !empty( $wp_query->query_vars['dfp_tag'] ) ): ?>

                      <?php 

                      $the_dfp_tag = strtolower( $wp_query->query_vars['dfp_tag'] );

                      $matched_dfp_tag_value = '';

                      $dfp_tags = get_option('dfp_tags'); 

                      foreach( $dfp_tags as $d ) {

                        $dfp_tag = strtolower( str_replace( ' ', '-', str_replace('&', '-', $d ) ) );

                        if( $dfp_tag == $the_dfp_tag ) {

                            $matched_dfp_tag_value = $d; 

                            break; 

                        }

                      }

                      ?>

                      <?php if( !empty($matched_dfp_tag_value) ): ?>
                
                        googletag.cmd.push(function() { googletag.pubads().setTargeting( 'dfp_tag', '<?php echo $matched_dfp_tag_value; ?>' ); } );

                      <?php endif; ?>

              <?php endif; ?>

            <?php endif; ?>
            <?php if( is_single() ): $post_dfp_tag = get_post_meta($post->ID, 'post_dfp_tag', true); ?>

            <?php if( !empty( $post_dfp_tag ) ): ?>

                googletag.cmd.push( function() { googletag.pubads().setTargeting( 'dfp_tag', '<?php echo $post_dfp_tag; ?>' ); } );

              <?php endif; ?>

            <?php endif; ?>

            <?php $post_type = get_post_type(); ?>
                googletag.cmd.push( function() { googletag.pubads().setTargeting( 'post_type', '<?php echo $post_type; ?>' ); } );
          } );
        </script>
      <!-- ENDS JS for DFP GAM -->

      <?php

      /* END HTML OUTPUT */
      $output = ob_get_contents(); // collect output
          
      ob_end_clean(); // Turn off ouput buffer
          
      echo $output; // Print output
  
    }

    public function add_size_mapping_vars() {

      /* BEGIN HTML OUTPUT */
      ob_start(); // Turn on output buffering

      ?>

        var lb_mapping = googletag.sizeMapping().addSize([1024, 768], [728, 90]).addSize([768, 1024], [728, 90]).addSize([800, 600], [728, 90]).addSize([0, 0], [320, 50]).build();
        var lb_mapping1 = googletag.sizeMapping().addSize([1024, 768], [600, 45]).addSize([0, 0], [300, 45], [320, 50]).build();
        var bb_mapping = googletag.sizeMapping().addSize([1024, 768], [970, 250]).addSize([768, 1024], [728, 90]).addSize([800, 600], [728, 90]).addSize([0, 0], [320, 50]).build();

      <?php

      /* END HTML OUTPUT */
      $output = ob_get_contents(); // collect output
    
      ob_end_clean(); // Turn off ouput buffer
          
      echo $output; // Print output

    }

    public function render_ad_options( $ad_type ) {
      $options_general_settings = get_option('intermedia_google_ad_manager_general_settings');
      $ad_options = get_option( $ad_type );
      /* BEGIN HTML OUTPUT */
      ob_start(); // Turn on output buffering
      ?>
      <?php if ( $ad_type === 'intermedia_google_ad_manager_leaderboard_options' && $ad_options['amount_slots'] !== 'default' ): ?>
        <?php for ($i=0; $i < $ad_options['amount_slots']; $i++): ?>
        var lb_mapping_<?php echo $i; ?> = googletag.sizeMapping().<?php echo $ad_options['define_size_mapping_'.$i]; ?>.build();
        googletag.defineSlot(
          '/<?php echo $options_general_settings['gam_network_code'] ?>/<?php echo $ad_options['define_slot_'.$i]; ?>', 
          [<?php echo $ad_options['define_sizes_'.$i]; ?>], 'div-gpt-ad-<?php echo $ad_options['define_slot_'.$i]; ?>-0'
          ).defineSizeMapping(lb_mapping_<?php echo $i; ?>).setCollapseEmptyDiv(true).addService(googletag.pubads());
        <?php endfor; ?>
      <?php else: ?>
        <?php for ($i=0; $i < $ad_options['amount_slots']; $i++): ?>
          <?php if ( $ad_options['define_slot_'.$i] !== '' || $ad_options['define_sizes_'.$i] !== '' ): ?>
        googletag.defineSlot(
          '/<?php echo $options_general_settings['gam_network_code'] ?>/<?php echo $ad_options['define_slot_'.$i]; ?>', 
          [<?php echo $ad_options['define_sizes_'.$i]; ?>], 'div-gpt-ad-<?php echo $ad_options['define_slot_'.$i]; ?>-0').addService(googletag.pubads());
        <?php endif; ?>
        <?php endfor; ?>
      <?php endif; ?>
      <?php
      /* END HTML OUTPUT */
      $output = ob_get_contents(); // collect output
      ob_end_clean(); // Turn off ouput buffer
          
      echo $output; // Print output

    }
 
    public function add_body_skin_class( $classes ){

      $options = get_option('intermedia_google_ad_manager_skin_options');
      if( isset( $options['define_slot_0'] ) ) {
        $tag_id= $options['define_slot_0'];
      } else {
        $tag_id = '';
      }
      if ( $tag_id !== '' ){

        $classes[] = 'is-skin';

        return $classes;

      }

    }

    public function render_skins() {

      $options = get_option('intermedia_google_ad_manager_skin_options');
      $tag_id = $options['define_slot_0'];

      /* BEGIN HTML OUTPUT */
      ob_start(); // Turn on output buffering
      ?>
      <?php if( isset($options['activate_skin']) && $options['activate_skin'] === 'is-skin'  ): ?>
      <style>
        .skin-container {
          height: 1200px;
          left: 50%;
          right: 0;
          margin-left: -960px;
          position: fixed;
          width: 1920px;
          z-index: 0;
        }
        .is-skin #page {
          overflow: hidden;
          width: 100%;
          margin: auto;
          max-width: 90%;
          width: 1000px;
          background-color: #fff;
          position: relative;
        }
        .is-skin #page #primary {
            margin: auto;
            max-width: 100%;
            width: 1000px;
        }
      </style>
      <div class="skin-container">
          <div>
              <div id="div-gpt-ad-<?php echo $tag_id; ?>-0">
                  <script>
                      googletag.cmd.push(function() { googletag.display('div-gpt-ad-<?php echo $tag_id; ?>-0'); });
                  </script>
              </div>
          </div>
      </div>
      <?php endif; ?>
      <?php
      /* END HTML OUTPUT */
      $output = ob_get_contents(); // collect output
      ob_end_clean(); // Turn off ouput buffer
          
      echo $output; // Print output

    }

}