// Store ONLY the initial user values (before any defaults are added)
const _initial_values = {
    styles: '',
    scripts: '',
    fonts: '',
    images: '',
    connect: '',
    frames: '',
    worker: '',
    media: ''
};

// Object to store original field values when "None" is selected
const cspFieldBackups = {};

// Object to store original checkbox states when WP Defaults is toggled
const checkboxStateBackups = {};

jQuery(document).ready(function ($) {

    // Track user modifications to fields - need to use 'change' and 'blur' since programmatic .val() doesn't trigger 'input'
    $('[data-depend-id^="generate_csp_custom_"]').not('[data-depend-id$="_allow_unsafe"]').on('change blur keyup', function () {
        const fieldId = $(this).attr('data-depend-id');
        const key = fieldId.replace('generate_csp_custom_', '');
        if (_initial_values[key] !== undefined) {
            _initial_values[key] = $(this).val() || '';
        }
    });

    // get our access methods allow all
    var _amaa = jQuery('[data-depend-id="include_acam_methods"][value="*"]');

    // check the click event
    _amaa.on('click', function () {

        // hold the checked
        _ischecked = jQuery(this).is(':checked');

        // get the rest of the checkboxes for this
        _amacbs = jQuery('[data-depend-id="include_acam_methods"]');

        // set the other checkboxes based on this one
        _amacbs.prop("checked", _ischecked);

    });

    // get NONE from the CSP checkboxes
    var _none;

    // get our WP Defaults Switch
    var _iwd = jQuery('[data-depend-id="include_wordpress_defaults"]');

    // Wait for settings framework to populate fields, THEN capture initial values
    setTimeout(function () {
        // Re-capture the ACTUAL initial values from the populated fields
        _initial_values.styles = jQuery('[data-depend-id="generate_csp_custom_styles"]').val() || '';
        _initial_values.scripts = jQuery('[data-depend-id="generate_csp_custom_scripts"]').val() || '';
        _initial_values.fonts = jQuery('[data-depend-id="generate_csp_custom_fonts"]').val() || '';
        _initial_values.images = jQuery('[data-depend-id="generate_csp_custom_images"]').val() || '';
        _initial_values.connect = jQuery('[data-depend-id="generate_csp_custom_connect"]').val() || '';
        _initial_values.frames = jQuery('[data-depend-id="generate_csp_custom_frames"]').val() || '';
        _initial_values.worker = jQuery('[data-depend-id="generate_csp_custom_workers"]').val() || '';
        _initial_values.media = jQuery('[data-depend-id="generate_csp_custom_media"]').val() || '';

        // Backup the initial checkbox states
        backupAllCheckboxStates();

        // NOW apply defaults if switch is on
        set_csp_default(_iwd.val());
    }, 250);

    // on switch change
    _iwd.change(function () {

        // switch the value
        set_csp_default(_iwd.val());

    });

    // handle the NONE CSP checkboxes
    handleNoneCSP();

});


function backupAllCheckboxStates() {
    // Backup the current state of all CSP checkboxes
    const checkboxIds = [
        'generate_csp_custom_baseuri_allow_unsafe',
        'generate_csp_custom_connect_allow_unsafe',
        'generate_csp_custom_defaults_allow_unsafe',
        'generate_csp_custom_fonts_allow_unsafe',
        'generate_csp_custom_forms_allow_unsafe',
        'generate_csp_custom_frames_allow_unsafe',
        'generate_csp_custom_images_allow_unsafe',
        'generate_csp_custom_media_allow_unsafe',
        'generate_csp_custom_objects_allow_unsafe',
        'generate_csp_custom_scripts_allow_unsafe',
        'generate_csp_custom_styles_allow_unsafe'
    ];

    checkboxIds.forEach(function (id) {
        checkboxStateBackups[id] = [];
        jQuery(`[data-depend-id="${id}"]`).each(function () {
            if (jQuery(this).prop('checked')) {
                checkboxStateBackups[id].push(jQuery(this).val());
            }
        });
    });
}

function restoreAllCheckboxStates() {
    // Restore the backed up checkbox states
    Object.keys(checkboxStateBackups).forEach(function (id) {
        // First uncheck all checkboxes in this group
        jQuery(`[data-depend-id="${id}"]`).prop('checked', false);

        // Then check only the ones that were originally checked
        checkboxStateBackups[id].forEach(function (value) {
            jQuery(`[data-depend-id="${id}"][value="${value}"]`).prop('checked', true);
        });
    });
}

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

    // Update _initial_values to reflect the cleared state
    const key = fieldId.replace('generate_csp_custom_', '');
    if (_initial_values[key] !== undefined) {
        _initial_values[key] = '';
    }
}

function restoreFields(checkbox) {
    const checkboxId = checkbox.attr('data-depend-id');
    const fieldId = getFieldIdFromCheckboxId(checkboxId); // e.g., "generate_csp_custom_styles"
    const $field = jQuery(`[data-depend-id="${fieldId}"]`);

    // Restore the original value if a backup exists
    if (cspFieldBackups[fieldId] !== undefined) {
        $field.val(cspFieldBackups[fieldId]);

        // Update _initial_values to reflect the restored state
        const key = fieldId.replace('generate_csp_custom_', '');
        if (_initial_values[key] !== undefined) {
            _initial_values[key] = cspFieldBackups[fieldId];
        }

        delete cspFieldBackups[fieldId]; // Clear backup
    }
}

function getFieldIdFromCheckboxId(checkboxId) {
    return checkboxId.replace('_allow_unsafe', '');
}

// set the CSP defaults
function set_csp_default(_iwd_val) {

    // Configuration object for CSP fields and checkboxes
    const config = {
        fields: [
            { id: 'generate_csp_custom_styles', default: _initial_values.styles, additional: ' https: *.googleapis.com ' },
            { id: 'generate_csp_custom_scripts', default: _initial_values.scripts, additional: ' https: *.googleapis.com *.gstatic.com ' },
            { id: 'generate_csp_custom_fonts', default: _initial_values.fonts, additional: ' data: https: *.gstatic.com ' },
            { id: 'generate_csp_custom_images', default: _initial_values.images, additional: ' data: https: *.gravatar.com *.wordpress.org s.w.org ' },
            { id: 'generate_csp_custom_connect', default: _initial_values.connect, additional: ' https: ' },
            { id: 'generate_csp_custom_frames', default: _initial_values.frames, additional: ' https: *.youtube.com *.vimeo.com ' },
            { id: 'generate_csp_custom_media', default: _initial_values.media, additional: ' https: s.w.org ' },
            { id: 'generate_csp_custom_workers', default: _initial_values.worker, additional: '' }
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
    config.fields.forEach(({ id, default: defVal, additional }) => {
        const value = _iwd_val === '1' ? (defVal + additional).remDups() : defVal.remDups();
        jQuery(`[data-depend-id="${id}"]`).val(value);

        // Update _initial_values after programmatically setting the value
        const key = id.replace('generate_csp_custom_', '');
        if (_initial_values[key] !== undefined) {
            _initial_values[key] = value;
        }
    });

    // Process checkboxes
    if (_iwd_val === '1') {
        // WP Defaults is ON - set to specific state
        config.checkboxes.forEach(({ id, value }) => {
            // First uncheck all checkboxes in this group
            jQuery(`[data-depend-id="${id}"]`).prop('checked', false);

            // Then check only the specified one
            jQuery(`[data-depend-id="${id}"][value="${value}"]`).prop('checked', true);
        });
    } else {
        // WP Defaults is OFF - restore original states
        restoreAllCheckboxStates();
    }

}

// get the grouped checkboxes
function getCheckboxGroupId(checkbox) {
    return checkbox.attr('data-depend-id').replace(/_allow_unsafe$/, '');
}

// make sure we're only unchecking the proper others
function handleNoneCSP() {

    jQuery(document).on('change', '[data-depend-id$="_allow_unsafe"]', function () {
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

// remove the duplicates
String.prototype.remDups = function () {
    const set = new Set(this.split(' '))
    return [...set].join(' ')
}