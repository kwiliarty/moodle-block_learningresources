<?php

/**
 * Require the file to define the block_learningresources_list class
 */
require_once(dirname(__FILE__) . '/learningresources.class.php');

/** 
 * Create the instance preferences form 
 *
 * Extends the native block_edit_form through which Moodle
 * provides lots of magic.
 */
class block_learningresources_edit_form extends block_edit_form { 

    /**
     * Build the resource checklist 
     *
     * get the list of default items
     * create variable to hold the nested array of items and attributes
     * set the title for the checkbox list
     * loop through the list of default resources
     * format a link to each resource
     * format a fieldname for a corresponding checkbox, must begin with "config_"
     * Moodle will apply instance preferences if they have been set
     * Otherwise use the visibility preference for the item from the default list
     */
    protected function specific_definition($mform) {

        $lr_resources = new block_learningresources_list();
        $lr_array = $lr_resources->get_lr_array();

        $mform->addElement('header', 'configheader', get_string('blocksettings', 'block_learningresources'));

        foreach ($lr_array as $lr) {
            $anchor = html_writer::link($lr['url'], $lr['text'], array('target'=>'_blank'));
            $fieldname = "config_" . $lr['id'];
            $mform->addElement('advcheckbox', /* allow unchecked box to send a value */
                               $fieldname,
                               $lr['id'], /* displays before the checkbox */
                               $anchor, /* displays after checkbox */
                               null, /* potential group for checkbox controller */
                               array('hide', 'show')); /* assigns values to "off" and "on" */
            $mform->setDefault($fieldname, $lr['show']);
        }
    }
}