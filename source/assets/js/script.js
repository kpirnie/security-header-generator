// we need the original values
const _csp_styles = jQuery( '[data-depend-id="generate_csp_custom_styles"]' ).val( ) || '';
const _csp_scripts = jQuery( '[data-depend-id="generate_csp_custom_scripts"]' ).val( ) || '';
const _csp_fonts = jQuery( '[data-depend-id="generate_csp_custom_fonts"]' ).val( ) || '';
const _csp_images = jQuery( '[data-depend-id="generate_csp_custom_images"]' ).val( ) || '';
const _csp_connect = jQuery( '[data-depend-id="generate_csp_custom_connect"]' ).val( ) || '';
const _csp_frames = jQuery( '[data-depend-id="generate_csp_custom_frames"]' ).val( ) || '';
const _csp_worker = jQuery( '[data-depend-id="generate_csp_custom_workers"]' ).val( ) || '';
const _csp_media = jQuery( '[data-depend-id="generate_csp_custom_media"]' ).val( ) || '';

// Object to store original field values when "None" is selected
const cspFieldBackups = {};

jQuery( document ).ready( function( $ ) {

    // get our access methods allow all
    var _amaa = jQuery( '[data-depend-id="include_acam_methods"][value="*"]' );
    
    // check the click event
    _amaa.on( 'click', function( ){

        // hold the checked
        _ischecked = jQuery( this ).is( ':checked' );

        // get the rest of the checkboxes for this
        _amacbs = jQuery( '[data-depend-id="include_acam_methods"]' );

        // set the other checkboxes based on this one
        _amacbs.prop( "checked", _ischecked );
        
    } );

    // get NONE from the CSP checkboxes
    var _none;

    // get our WP Defaults Switch
    var _iwd = jQuery( '[data-depend-id="include_wordpress_defaults"]' );
    
    // onload
    set_csp_default( _iwd.val( ) );

    // on switch change
    _iwd.change( function( ) {
        
        // switch the value
        set_csp_default( _iwd.val( ) );
        
    } );    

    // handle the NONE CSP checkboxes
    handleNoneCSP( );
    
} );


function backupAndClearFields(checkbox) {

    const checkboxId = checkbox.attr('data-depend-id');
    const fieldId = getFieldIdFromCheckboxId(checkboxId); // e.g., "generate_csp_custom_styles"
    const $field = jQuery(`[data-depend-id="${fieldId}"]`);

    // Backup the current value if not already stored
    if (!cspFieldBackups[fieldId]) {
        cspFieldBackups[fieldId] = $field.val();
    }

    // Clear the field
    $field.val('');
}

function restoreFields(checkbox) {
    const checkboxId = checkbox.attr('data-depend-id');
    const fieldId = getFieldIdFromCheckboxId(checkboxId); // e.g., "generate_csp_custom_styles"
    const $field = jQuery(`[data-depend-id="${fieldId}"]`);

    // Restore the original value if a backup exists
    if (cspFieldBackups[fieldId] !== undefined) {
        $field.val(cspFieldBackups[fieldId]);
        delete cspFieldBackups[fieldId]; // Clear backup
    }
}

function getFieldIdFromCheckboxId(checkboxId) {
    return checkboxId.replace('_allow_unsafe', '');
}

// set the CSP defaults
function set_csp_default( _iwd_val ) {

    // Configuration object for CSP fields and checkboxes
    const config = {
        fields: [
            { id: 'generate_csp_custom_styles', default: _csp_styles, additional: ' https: *.googleapis.com ' },
            { id: 'generate_csp_custom_scripts', default: _csp_scripts, additional: ' https: *.googleapis.com *.gstatic.com ' },
            { id: 'generate_csp_custom_fonts', default: _csp_fonts, additional: ' data: https: *.gstatic.com ' },
            { id: 'generate_csp_custom_images', default: _csp_images, additional: ' data: https: *.gravatar.com *.wordpress.org s.w.org ' },
            { id: 'generate_csp_custom_connect', default: _csp_connect, additional: ' https: ' },
            { id: 'generate_csp_custom_frames', default: _csp_frames, additional: ' https: *.youtube.com *.vimeo.com ' },
            { id: 'generate_csp_custom_media', default: _csp_media, additional: ' https: s.w.org ' },
            { id: 'generate_csp_custom_workers', default: _csp_worker, additional: '' }
        ],
        checkboxes: [
            { id: 'generate_csp_custom_baseuri_allow_unsafe', value: '0' },
            { id: 'generate_csp_custom_connect_allow_unsafe', value: '0' },
            { id: 'generate_csp_custom_defaults_allow_unsafe', value: '0' },
            { id: 'generate_csp_custom_fonts_allow_unsafe', value: '0' },
            { id: 'generate_csp_custom_forms_allow_unsafe', value: '0' },
            { id: 'generate_csp_custom_frames_allow_unsafe', value: '0' },
            { id: 'generate_csp_custom_images_allow_unsafe', value: '0' },
            { id: 'generate_csp_custom_media_allow_unsafe', value: '0' },
            { id: 'generate_csp_custom_objects_allow_unsafe', value: '3' },
            { id: 'generate_csp_custom_scripts_allow_unsafe', value: '0' },
            { id: 'generate_csp_custom_styles_allow_unsafe', value: '0' }
        ]
    };

    // Process fields
    config.fields.forEach( ( { id, default: defVal, additional } ) => {
        const value = _iwd_val === '1' ? ( defVal + additional ).remDups( ) : defVal.remDups( );
        jQuery(`[data-depend-id="${id}"]`).val( value );
    } );

    // Process checkboxes
    config.checkboxes.forEach( ( { id, value } ) => {
        jQuery( `[data-depend-id="${id}"][value="${value}"]` ).prop( 'checked', _iwd_val === '1' );
    } );

}

// get the grouped checkboxes
function getCheckboxGroupId(checkbox) {
    return checkbox.attr('data-depend-id').replace(/_allow_unsafe$/, '');
}

// make sure we're only unchecking the proper others
function handleNoneCSP( ) {

    jQuery(document).on('change', '[data-depend-id$="_allow_unsafe"]', function() {
        const $changedCheckbox = jQuery(this);
        const groupId = $changedCheckbox.attr('data-depend-id').replace('_allow_unsafe', '');
        const isValue3 = $changedCheckbox.attr('value') === '3';
        const isChecked = $changedCheckbox.prop('checked');

        const $groupCheckboxes = jQuery(`[data-depend-id="${groupId}_allow_unsafe"]`);

        // Case 1: "None" (value="3") is checked → clear other checkboxes + backup & clear fields
        if (isValue3 && isChecked) {
            $groupCheckboxes.not($changedCheckbox).prop('checked', false);
            backupAndClearFields($changedCheckbox); // Clear fields and backup values
        } 
        // Case 2: Another checkbox is checked → uncheck "None" and restore fields
        else if (!isValue3 && isChecked) {
            $groupCheckboxes.filter('[value="3"]').prop('checked', false);
            if (Object.keys(cspFieldBackups).length > 0) {
                restoreFields($changedCheckbox); // Restore original values
            }
        }
    });

}

// remove the duplciates
String.prototype.remDups = function( ) {
    const set = new Set( this.split( ' ') )
    return [...set].join( ' ' )
}
