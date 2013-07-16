<?php

require_once(dirname(__FILE__) . '/learningresources.class.php');

class block_learningresources_edit_form extends block_edit_form { /* creates the instance preferences form */

    protected function specific_definition($mform) {

        $lr_resources = new lr_list(); /* get the default list */

        $lr_array = $lr_resources->get_lr_array(); /* variable to hold the resources array */

        // title for the checkbox section
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block_learningresources'));

        foreach ($lr_array as $lr) { /* loop through the default resources */
            $anchor = html_writer::link($lr['url'], $lr['text'], array('target'=>'_blank')); /* link to resource */
            $fieldname = "config_" . $lr['id']; /* fieldname for checkbox */
            $mform->addElement('advcheckbox', /* moodle applies preferences if they have been set already */
                               $fieldname,
                               $lr['id'], /* displays before the checkbox */
                               $anchor, /* displays after checkbox */
                               null, /* potential group for checkbox controller */
                               array('hide', 'show')); /* assigns values to "off" and "on" */
            $mform->setDefault($fieldname, $lr['show']); /* use defaults if no instance config */
        }
    }
}
