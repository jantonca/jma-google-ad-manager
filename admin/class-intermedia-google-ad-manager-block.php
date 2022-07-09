<?php

/**
 * The Block class
 *
 * @link       https://www.intermedia.com.au/
 * @since      1.0.0
 *
 * @package    Intermedia_Google_Ad_Manager
 * @subpackage Intermedia_Google_Ad_Manager/admin
 */

/**
 * Class class-intermedia-google-ad-manager-block
 *
 */
class IGAM_Block {

    /**
     * Enqueue Gutenberg block assets for both frontend + backend.
     *
     * Assets enqueued:
     * 1. blocks.style.build.css - Frontend + Backend.
     * 2. blocks.build.js - Backend.
     * 3. blocks.editor.build.css - Backend.
     *
     * @uses {wp-blocks} for block type registration & related functions.
     * @uses {wp-element} for WP Element abstraction — structure of blocks.
     * @uses {wp-i18n} to internationalize the block's text.
     * @uses {wp-editor} for WP editor styles.
     * @since 1.0.0
     */

    public function intermedia_google_ad_manager_blocks_cgb_block_assets() { // phpcs:ignore
        // Register block styles for both frontend + backend.
        wp_register_style(
            'intermedia_google_ad_manager_blocks-cgb-style-css', // Handle.
            plugins_url( 'dist/blocks.style.build.css', dirname( __FILE__ ) ), // Block style CSS.
            is_admin() ? array( 'wp-editor' ) : null, // Dependency to include the CSS after it.
            null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.style.build.css' ) // Version: File modification time.
        );

        // Register block editor script for backend.
        wp_register_script(
            'intermedia_google_ad_manager_blocks-cgb-block-js', // Handle.
            plugins_url( '/dist/blocks.build.js', dirname( __FILE__ ) ), // Block.build.js: We register the block here. Built with Webpack.
            array( 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ), // Dependencies, defined above.
            null, // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.build.js' ), // Version: filemtime — Gets file modification time.
            true // Enqueue the script in the footer.
        );

        // Register block editor styles for backend.
        wp_register_style(
            'intermedia_google_ad_manager_blocks-cgb-block-editor-css', // Handle.
            plugins_url( 'dist/blocks.editor.build.css', dirname( __FILE__ ) ), // Block editor CSS.
            array( 'wp-edit-blocks' ), // Dependency to include the CSS after it.
            null // filemtime( plugin_dir_path( __DIR__ ) . 'dist/blocks.editor.build.css' ) // Version: File modification time.
        );

        // WP Localized globals. Use dynamic PHP stuff in JavaScript via `cgbGlobal` object.
        wp_localize_script(
            'intermedia_google_ad_manager_blocks-cgb-block-js',
            'igamGlobalObject', // Array containing dynamic data for a JS Global.
            [
                'pluginDirPath' => plugin_dir_path( __DIR__ ),
                'pluginDirUrl'  => plugin_dir_url( __DIR__ ),
                // Add more data here that you want to access from `cgbGlobal` object.
                'ads_type_options' => $this->ad_types_to_show(),
                'ads_tags_options' => $this->get_tags_options(),
            ]
        );

        /**
         * Register Gutenberg block on server-side.
         *
         * Register the block on server-side to ensure that the block
         * scripts and styles for both frontend and backend are
         * enqueued when the editor loads.
         *
         * @link https://wordpress.org/gutenberg/handbook/blocks/writing-your-first-block-type#enqueuing-block-scripts
         * @since 1.16.0
         */
        $block = json_decode(
            file_get_contents( __DIR__ . '/../src/block/block.json' ), // phpcs:ignore WordPress.WP.AlternativeFunctions.file_get_contents_file_get_contents
            true
        );
        register_block_type(
            'cgb/block-intermedia-google-ad-manager-blocks', array(
                // Enqueue blocks.style.build.css on both frontend & backend.
                'style'           => 'intermedia_google_ad_manager_blocks-cgb-style-css',
                // Enqueue blocks.build.js in the editor only.
                'editor_script'   => 'intermedia_google_ad_manager_blocks-cgb-block-js',
                // Enqueue blocks.editor.build.css in the editor only.
                'editor_style'    => 'intermedia_google_ad_manager_blocks-cgb-block-editor-css',
                // Callback function for the dynamic block front-end
			    'render_callback' => array( $this, 'render_dynamic_intermedia_google_ad'),
                // Attributes
                'attributes'      => $block['attributes'],
            )
        );

    }

    public function render_dynamic_intermedia_google_ad( $attributes ) {

        /* BEGIN HTML OUTPUT */

        ob_start(); // Turn on output buffering

        //$options = get_option('intermedia_google_ad_manager_leaderboard_options');

        ?>
        <?php if( $attributes['adType'] !== '' && $attributes['adTag'] !== '' ): ?>
        <div class="<?php echo $attributes['classNamesContainer'] ?>">
            <div>
                <div id="div-gpt-ad-<?php echo $attributes['adTag'] ?>-0">
                    <script>
                        googletag.cmd.push(function() { googletag.display('div-gpt-ad-<?php echo $attributes['adTag'] ?>-0'); });
                    </script>
                </div>
                <?php if( $attributes['adLabel'] !== ' '): ?>
                    <span class="ad-label"><?php echo $attributes['adLabel'] ?></span>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>
        <?php

        /* END HTML OUTPUT */
        $output = ob_get_contents(); // collect output

        ob_end_clean(); // Turn off ouput buffer

        return $output; // Print output

    }
    public function ad_types_to_show() {
        
        $options = get_option('intermedia_google_ad_manager_general_settings');
        $output[] = array(
            'value' => '',
            'label' => 'Select the type...',
        );
        foreach ($options as $key => $value) {

            if( $key !== 'show_skins' && $key !== 'show_dfp_tags' && $key !== 'gam_network_code' ) {

                $output[] = array(
                    'value' => $key,
                    'label' => ucwords( str_replace('_', ' ', $key) ),
                );

            } 

        }
        return $output;
    }
    public function get_tags_options() {
        
        $options = get_option('intermedia_google_ad_manager_mrec_options');
        //var_dump($options);
        $output['mrec'][] = array(
            'value' => '',
            'label' => 'Select the tag...',
        );
        $i = 1;
        foreach ($options as $key => $value) {

            if( $value !== '' && strpos( $key, 'slot_' ) ) {

                $output['mrec'][] = array(
                    'value' => $value,
                    'label' => 'MREC '.$i,
                );
                $i++;
            } 

        }
        $options = get_option('intermedia_google_ad_manager_leaderboard_options');
        $output['leaderboard'][] = array(
            'value' => '',
            'label' => 'Select the tag...',
        );
        $i = 1;
        foreach ($options as $key => $value) {

            if( $value !== '' && strpos( $key, 'slot_' ) ) {

                $output['leaderboard'][] = array(
                    'value' => $value,
                    'label' => 'Leaderboard '.$i,
                );
                $i++;
            } 

        }
        $options = get_option('intermedia_google_ad_manager_halfpage_options');
        //var_dump($options);
        $output['halfpage'][] = array(
            'value' => '',
            'label' => 'Select the tag...',
        );
        $i = 1;
        foreach ($options as $key => $value) {

            if( $value !== '' && strpos( $key, 'slot_' ) ) {

                $output['halfpage'][] = array(
                    'value' => $value,
                    'label' => 'Half-Page '.$i,
                );
                $i++;
            } 

        }
        return $output;
    }
}