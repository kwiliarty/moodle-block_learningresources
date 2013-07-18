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

    /* title for the block on the course page
     */
    public function init() {
        $this->title = get_string('learningresources', 'block_learningresources');
    }
        
    /* content for the block on the course page
     */
    public function get_content() {

        /* get the default list of items
         * get the instance settings
         * if there are instance settings
         * loop through the settings
         * if a given setting matches an item in the defaults 
         * (it might not -- if the defaults have changed)
         * then modify the item's visibility according to the settings
         */
        $default_lr_array = new block_learningresources_list(); 
        $config = $this->config; 
        if ($config) { 
            foreach ($config as $key => $value) { 
                if (array_key_exists($key, $default_lr_array->lr_array)) { 
                    $default_lr_array->set_visibility($key, $value); 
                }
            }
        }

        /* create the object to hold the block's content
         * assign the HTML list (with instance preferences) as the text of the content
         */
        $this->content = new stdClass;
        $this->content->text = $default_lr_array->get_html_list();

        return $this->content;
    }

    /* tell Moodle to look for global settings
     */
    public function has_config() {
        return true;
    }
}
