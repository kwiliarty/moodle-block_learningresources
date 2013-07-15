<?php

require_once(dirname(__FILE__) . '/learningresources.class.php');

class block_learningresources_edit_form extends block_edit_form {

    protected function specific_definition($mform) {

        $lr_resources = new lr_list();
        $lr_array = $lr_resources->get_lr_array();

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block_learningresources'));

        foreach ($lr_array as $lr) {
            $anchor = "<a href='" . $lr['url'] . "' target='_blank' >" . $lr['text'] . "</a>";
            $fieldname = "config_" . $lr['id'];
            $mform->addElement('advcheckbox',
                               $fieldname,
                               $lr['id'],
                               $anchor,
                               null,
                               array('hide', 'show'));
        }

        foreach ($lr_array as $lr) {
        echo "<pre>Debug: Learning Resource";
        print_r($lr);
        echo "</pre>";
        }

    }
}
