<?php
// Prevent direct file access.
if ( ! defined( 'CWCJS_FILE' ) ) {
    die();
}

/**
 * Show error/update messages
 * 
 */
if ( isset( $_GET['settings-updated'] ) ) {
    add_settings_error( 'cwcjs_messages', 'cwcjs_message', __( 'Settings Saved', CWCJS_DOMAIN ), 'updated' );
}
settings_errors( 'cwcjs_messages' );

/**
 * Form Field Function
 * 
 */
function custom_form_field( $data ) {

    /**
     * Validate Field Values
     * 
     */
    $options = get_option( CWCJS_OPTION );
    $check_required = $data->required ? 'required' : '';
    $field_value = isset( $options[ $data->name ] ) && ! empty( $options[ $data->name ] ) ? $options[ $data->name ] : '';

    $field_html = '<div class="field-wrap '. $data->wrapper_class .'">';

        if ( !empty($data->label) ) $field_html .= '<label class="field-label" for="'. $data->id .'">'. $data->label .' <small>'. $data->label_info .'</small></label>';

        if ( $data->type === 'text' ) {
            $field_html .= '<input 
                                '. $check_required .'
                                type="text" 
                                name="'. $data->id .'"
                                id="'. $data->id .'" 
                                value="'. $field_value .'"
                                placeholder="'. $data->placeholder .'"
                                class="field-input '. $data->field_class .'"
                            />';
        }

        if ( $data->type === 'textarea' ) {
            $field_html .= '<textarea 
                                '. $check_required .'
                                name="'. $data->id .'"
                                id="'. $data->id .'"
                                class="field-input '. $data->field_class .'"
                                rows="4" 
                                placeholder="'. $data->placeholder .'"
                            >'. $field_value .'</textarea>';
        }

        if ( $data->type === 'select' ) {
            $options_html = '';
            $options_html .= '<option value>Select any one</option>';
            foreach ( $data->options as $option ) {
                $value = str_replace( ' ', '_', strtolower($option));
                $selected = ( $options[ $data->name ] === $value ) ? 'selected="selected"' : '';
                $options_html .= '<option value="'. $value .'" '. $selected .'>'. $option .'</option>';
            }

            $field_html .= '<select 
                                '. $check_required .'
                                name="'. $data->id .'" 
                                id="'. $data->id .'" 
                                class="field-select '. $data->field_class .'">
                                    '. $options_html .'
                            </select>';
        }

        if ( $data->type === 'radio' ) {
            if ( isset( $options[ $data->name ] ) && ! empty( $options[ $data->name ] ) ) {
                $checked = ( $options[$data->name] === $data->value ) ? 'checked' : '';
            } else {
                $checked = ( $data->checked ) ? 'checked' : '';
            }
            $field_html .= '<input 
                                '. $check_required .'
                                type="radio" 
                                name="'. $data->id .'"
                                id="'. $data->id .'" 
                                value="'. $data->value .'"
                                placeholder="'. $data->placeholder .'"
                                class="field-radio '. $data->field_class .'"
                                '. $checked .'
                            />';
        }

    $field_html .= '</div>';
    return $field_html;
}
?>

<div class="wrap">
    <div id="page__customStyle">
        <h1>
            <?php echo esc_html( get_admin_page_title() ); ?>
        </h1>

        <form class="page__customStyle-form" name="cwcjs-form" action="options.php" method="post" enctype="multipart/form-data">
            <?php settings_fields( 'cwcjs_settings_group' ); ?>

            <?php echo custom_form_field( (object) [
                    "type" => "textarea",
                    "name" => "cwcjs-css",
                    "placeholder" => "CSS code here",
                    "id" => "cwcjs_settings[cwcjs-css]",
                    "label" => "Custom CSS",
                    "label_info" => "(without style tag)",
                    "wrapper_class" => "",
                    "field_class" => "",
                    "required" => false
                ] ); ?>

            <h2>Admin Section</h2>

            <?php echo custom_form_field( (object) [
                    "type" => "textarea",
                    "name" => "cwcjs-admin-css",
                    "placeholder" => "Dashboard CSS code here",
                    "id" => "cwcjs_settings[cwcjs-admin-css]",
                    "label" => "Custom CSS (WP Dashboard)",
                    "label_info" => "(without style tag)",
                    "wrapper_class" => "",
                    "field_class" => "",
                    "required" => false
                ] ); ?>

            <h2>Script Section</h2>

            <fieldset>
                <div class="fieldset-label">JS Placement</div>
                <?php echo custom_form_field( (object) [
                        "type" => "radio",
                        "name" => "cwcjs-script-position",
                        "placeholder" => "",
                        "id" => "cwcjs_settings[cwcjs-script-position]",
                        "label" => "Header",
                        "label_info" => "",
                        "value" => "header",
                        "wrapper_class" => "",
                        "field_class" => "",
                        "required" => false,
                        "checked" => true
                    ] );
                ?>

                <?php echo custom_form_field( (object) [
                        "type" => "radio",
                        "name" => "cwcjs-script-position",
                        "placeholder" => "",
                        "id" => "cwcjs_settings[cwcjs-script-position]",
                        "label" => "Footer",
                        "label_info" => "",
                        "value" => "footer",
                        "wrapper_class" => "",
                        "field_class" => "",
                        "required" => false,
                        "checked" => false
                    ] );
                ?>
            </fieldset>

            <?php echo custom_form_field( (object) [
                    "type" => "textarea",
                    "name" => "cwcjs-script",
                    "placeholder" => "JS code here",
                    "id" => "cwcjs_settings[cwcjs-script]",
                    "label" => "Custom JS",
                    "label_info" => "(without script tag)",
                    "wrapper_class" => "",
                    "field_class" => "",
                    "required" => false
                ] ); ?>
                
            <?php submit_button( __( 'Save', CWCJS_DOMAIN ), 'primary field-button', 'submit', false ); ?>
        </form>
    </div>
</div>

<script>
window.addEventListener("load", (event) => {
    function applyCodeEditor($id, $type) {
        var editor = CodeMirror.fromTextArea( $id, {
            lineNumbers: true, 
            lineWrapping: true, 
            styleActiveLine: true, 
            matchBrackets: true, 
            mode: $type,
            tabSize: 1
        });
    }

    applyCodeEditor( document.getElementById( "cwcjs_settings[cwcjs-css]" ), "css" );
    applyCodeEditor( document.getElementById( "cwcjs_settings[cwcjs-admin-css]" ), "css" );
    applyCodeEditor( document.getElementById( "cwcjs_settings[cwcjs-script]" ), "javascript" );
});
</script>