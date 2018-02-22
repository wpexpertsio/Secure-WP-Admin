<?php

if ( ! defined( 'ABSPATH' ) ) exit;
use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_fields_register_fields', 'wsa_attach_theme_options' );
function wsa_attach_theme_options() {
    $icon_url =  plugins_url( 'img/icon.png', dirname(__FILE__) );
    Container::make( 'theme_options', 'Secure WP Admin' )
        ->set_icon($icon_url)
        ->add_tab(__('Secure WP Admin','wp-admin'), array(
            Field::make('image', 'wpsp_logo_image', __("Upload your logo")),
            Field::make("checkbox", "wpsp_enable",__( "Enable Secure WP Admin Lock"))
                ->set_option_value('on'),
            Field::make('text', 'wpsp_logo_height', __("Logo Height (optional)"))->set_default_value( 100 ),
            Field::make('text', 'wpsp_logo_width', __("Logo Width (optional)"))->set_default_value( 100 ),
            Field::make('text', 'wpsp_pin', __("Password"))->set_required( true ),
            Field::make('text', 'wpsp_submit_label', __("Label for submit button (optional)")),
            Field::make('text', 'wpsp_pin_placeholder', __("Place Holder Text(optional)")),
            Field::make('text', 'wpsp_try_again_error', __("Error Text(optional)")),
        ));
}