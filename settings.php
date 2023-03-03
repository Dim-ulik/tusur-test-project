<?php

$settings->add(new admin_setting_heading('block_equation_heading',
    get_string('settings_heading', 'block_equation'),
    get_string('settings_content', 'block_equation')));

$settings->add(new admin_setting_configtext('block_equation/Label',
    get_string('label', 'block_equation'),
    get_string('label_desc', 'block_equation'), '', PARAM_TEXT));