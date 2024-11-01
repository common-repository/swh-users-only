<?php
add_action('admin_menu', 'swh_uo_settings_submenu');

function swh_uo_settings_submenu() {
    add_submenu_page(
            'options-general.php', __('SWH Users Only', 'swh_uo'), __('SWH Users Only', 'swh_uo'), 'manage_options', 'swh-uo-settings', 'swh_uo_settings_display'
    );
}

function swh_uo_settings_display() {
    ?>
    <div class="wrap">
        <h2><?php echo __('SWH Users Only Settings', 'swh_uo'); ?></h2>
        <form method="post" action="options.php">
            <?php
            settings_fields('swh_uo_settings_group');
            do_settings_sections('swh_uo_settings_section');

            submit_button();
            ?>  
        </form>
    </div>
    <div class="clear"></div>
    <?php
}

add_action('admin_init', 'swh_uo_settings');

function swh_uo_settings() {
    register_setting('swh_uo_settings_group', 'swh_uo_options');

    add_settings_section('swh_uo_options_section_id', __('Default Output', 'swh_uo'), '', 'swh_uo_settings_section');
    add_settings_field('help', __('Help', 'swh_uo'), 'swh_uo_settings_help_fn', 'swh_uo_settings_section', 'swh_uo_options_section_id');
    add_settings_field('default', __('Default Output', 'swh_uo'), 'swh_uo_settings_default_fn', 'swh_uo_settings_section', 'swh_uo_options_section_id');
    add_settings_field('replacement_text', __('Replacement Text', 'swh_uo'), 'swh_uo_settings_replacement_text_fn', 'swh_uo_settings_section', 'swh_uo_options_section_id');
    add_settings_field('show_replacement_text_before_login_form', __('Text Before Login Form', 'swh_uo'), 'swh_uo_settings_replacement_text_before_login_form_fn', 'swh_uo_settings_section', 'swh_uo_options_section_id');
    add_settings_field('show_only_one_login_form', __('Login Forms', 'swh_uo'), 'swh_uo_settings_one_login_form_fn', 'swh_uo_settings_section', 'swh_uo_options_section_id');
}

function swh_uo_settings_help_fn() {
    ?>
    <p class="description" id="tagline-description">
        <b><?php echo __('Use shortcode in this way:', 'swh_uo'); ?></b>
        <br>
        Text:       [swh-users-only]Text[/swh-users-only]<br>
        Image:      [swh-users-only]&lt;img src="file.jpg" /&gt;[/swh-users-only]<br>
        Video:      [swh-users-only]Text[/swh-users-only]<br>
        Shortcode:  [swh-users-only][contact-form-7 id="1234" title="Contact form 1"][/swh-users-only]<br>
        HTML:       [swh-users-only]&lt;a href="file.jpg" &gt;Link&lt;/a&gt;[/swh-users-only]
    </p>
    <?php
}

function swh_uo_settings_default_fn() {
    $options = get_option('swh_uo_options');
    ?>
    <select name='swh_uo_options[default]'>
        <option value='wp_login_form' <?php selected($options['default'], 'wp_login_form'); ?>><?php echo __('Wordpress Login Form', 'swh_uo') ?></option>
        <option value='replacement_text' <?php selected($options['default'], 'replacement_text'); ?>><?php echo __('Replacement Text', 'swh_uo') ?></option>
    </select>
    <p class="description" id="tagline-description">
        <?php echo __('If you select replacement text, the text below will be shown instead of Login Form.', 'swh_uo'); ?>
    </p>
    <?php
}

function swh_uo_settings_replacement_text_fn() {
    $options = get_option('swh_uo_options');
    if (isset($options['replacement_text'])) {
        $replacement_text = $options['replacement_text'];
    } else {
        $replacement_text = '';
    }
    echo "<textarea name='swh_uo_options[replacement_text]' rows='10' cols='50' class='large-text code'>{$replacement_text}</textarea>";
}

function swh_uo_settings_replacement_text_before_login_form_fn() {
    $options = get_option('swh_uo_options');
    if (isset($options['show_replacement_text_before_login_form'])) {
        $before = $options['show_replacement_text_before_login_form'];
    } else {
        $before = '';
    }
    ?>

    <label for="show_replacement_text_before_login_form">
        <input name='swh_uo_options[show_replacement_text_before_login_form]' id="show_replacement_text_before_login_form" type='checkbox' value='1' <?php checked($before, 1); ?> />
        <?php echo __('Show replacement text before login form', 'swh_uo'); ?>
    </label>
    <?php
}

function swh_uo_settings_one_login_form_fn() {
    $options = get_option('swh_uo_options');
    if (isset($options['show_only_one_login_form'])) {
        $only_one = $options['show_only_one_login_form'];
    } else {
        $only_one = '';
    }
    ?>

    <label for="show_only_one_login_form">
        <input name='swh_uo_options[show_only_one_login_form]' id="show_only_one_login_form" type='checkbox' value='1' <?php checked($only_one, 1); ?> />
        <?php echo __('Show only one login form in content and show replacement text instead of other items', 'swh_uo'); ?>
    </label>
    <?php
}
