<?php if ( ! defined( 'ABSPATH' ) ) { die; } // Cannot access directly.
/**
 *
 * Field: icon
 *
 * @since 1.0.0
 * @version 1.0.0
 *
 */
if ( ! class_exists( 'KPSHG_Field_icon' ) ) {
  class KPSHG_Field_icon extends KPSHG_Fields {

    public function __construct( $field, $value = '', $unique = '', $where = '', $parent = '' ) {
      parent::__construct( $field, $value, $unique, $where, $parent );
    }

    public function render() {

      $args = wp_parse_args( $this->field, array(
        'button_title' => esc_html__( 'Add Icon', 'kpshg' ),
        'remove_title' => esc_html__( 'Remove Icon', 'kpshg' ),
      ) );

      echo $this->field_before();

      $nonce  = wp_create_nonce( 'kpshg_icon_nonce' );
      $hidden = ( empty( $this->value ) ) ? ' hidden' : '';

      echo '<div class="kpshg-icon-select">';
      echo '<span class="kpshg-icon-preview'. esc_attr( $hidden ) .'"><i class="'. esc_attr( $this->value ) .'"></i></span>';
      echo '<a href="#" class="button button-primary kpshg-icon-add" data-nonce="'. esc_attr( $nonce ) .'">'. $args['button_title'] .'</a>';
      echo '<a href="#" class="button kpshg-warning-primary kpshg-icon-remove'. esc_attr( $hidden ) .'">'. $args['remove_title'] .'</a>';
      echo '<input type="hidden" name="'. esc_attr( $this->field_name() ) .'" value="'. esc_attr( $this->value ) .'" class="kpshg-icon-value"'. $this->field_attributes() .' />';
      echo '</div>';

      echo $this->field_after();

    }

    public function enqueue() {
      add_action( 'admin_footer', array( 'KPSHG_Field_icon', 'add_footer_modal_icon' ) );
      add_action( 'customize_controls_print_footer_scripts', array( 'KPSHG_Field_icon', 'add_footer_modal_icon' ) );
    }

    public static function add_footer_modal_icon() {
    ?>
      <div id="kpshg-modal-icon" class="kpshg-modal kpshg-modal-icon hidden">
        <div class="kpshg-modal-table">
          <div class="kpshg-modal-table-cell">
            <div class="kpshg-modal-overlay"></div>
            <div class="kpshg-modal-inner">
              <div class="kpshg-modal-title">
                <?php esc_html_e( 'Add Icon', 'kpshg' ); ?>
                <div class="kpshg-modal-close kpshg-icon-close"></div>
              </div>
              <div class="kpshg-modal-header">
                <input type="text" placeholder="<?php esc_html_e( 'Search...', 'kpshg' ); ?>" class="kpshg-icon-search" />
              </div>
              <div class="kpshg-modal-content">
                <div class="kpshg-modal-loading"><div class="kpshg-loading"></div></div>
                <div class="kpshg-modal-load"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    <?php
    }

  }
}
