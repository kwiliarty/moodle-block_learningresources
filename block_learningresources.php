<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

require_once(dirname(__FILE__) . '/learningresources.class.php');

class block_learningresources extends block_base {

    // title for the block on the course page
    public function init() {
        $this->title = get_string('learningresources', 'block_learningresources');
    }
        
    // content for the block on the course page
    public function get_content() {

        // get the defaults
        $default_lr_array = new lr_list();

        // and get the instance settings
        $config = $this->config;
        // if there are instance settings
        if ($config) {
            // go through the list
            foreach ($config as $key => $value) {
                // if the setting corresponds to an item in the default list
                if (array_key_exists($key, $default_lr_array->lr_array)) {
                    // set the visibility in the list according to the instance preference
                    $default_lr_array->set_visibility($key, $value);
                }
            }
        }

        // create the object to hold the content
        $this->content = new stdClass;

        // assign the HTML list (with instance preferences) as the text of the content
        $this->content->text = $default_lr_array->get_html_list();

        return $this->content;
    }

    // tells Moodle to look for global settings
    public function has_config() {
        return true;
    }
}
