<?php

require_once(dirname(__FILE__) . '/learningresources.class.php');

class block_learningresources_edit_form extends block_edit_form { /* creates the instance preferences form */

    protected function specific_definition($mform) {

        $lr_resources = new lr_list(); /* get the default list */

        $lr_array = $lr_resources->get_lr_array(); /* variable to hold the resources array */

        // title for the checkbox section
        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block_learningresources'));

        // loop through the default array
        foreach ($lr_array as $lr) {
            // format a link to the resource
            $anchor = "<a href='" . $lr['url'] . "' target='_blank' >" . $lr['text'] . "</a>";
            // variable to hold the specific fieldname
            $fieldname = "config_" . $lr['id'];
            // add a checkbox
            // Moodle will apply the preferences if they have been set
            $mform->addElement('advcheckbox', 
                               $fieldname,
                               $lr['id'], /* displays before the checkbox */
                               $anchor,
                               null,
                               array('hide', 'show')); /* assigns values to "off" and "on" */
            $mform->setDefault($fieldname, $lr['show']); /* use defaults if no instance config */
        }
    }
}
