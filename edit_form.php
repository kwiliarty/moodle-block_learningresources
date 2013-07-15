<?php

require_once(dirname(__FILE__) . '/learningresources.class.php');

class block_learningresources_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        $raw_defaults = get_config('learningresources', 'link_list');
        $default_lr_array = new lr_list();

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block_learningresources'));

        echo "<pre>Debug: ";
        print_r($default_lr_array);
        echo "</pre>";

    }
}
