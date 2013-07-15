<?php

class lr_list {

    public $lr_array = array(); /* nested array of resources for manipulation into various formats */
    public $raw_list; /* list as stored in the settings */
    public $html_array = array(); /* array of html-formatted links to visible resources */
    public $html_list;
    public $keys = array('text', 'url', 'show', 'id', 'position'); /* keys to apply to rows */
    public $link_target = '';

    // build the learning resources object
    public function __construct() {
        
        // get the raw list from the database
        $this->raw_list = get_config('learningresources', 'link_list');

        // get the anchor target preference
        $this->link_target = get_config('learningresources', 'new_window');
        // and set the target appropriately
        if ($this->link_target == 1) { $this->link_target = "_blank"; }
        else { $this->link_target = "_self"; }

        // break the raw list into rows based on linux newlines
        $rows = explode("\n", $this->raw_list);

        // break each row into an array based on '|' separators
        foreach ($rows as $key => $row) {
            // first get rid of newlines at end of each row
            $row = rtrim($row);
            // then split
            $row_items = explode('|', $row);
            // add the numeric key at the end as a basis for ordering
            array_push($row_items, $key);
            // combine the keys with the rows to create an associative array
            $keys_and_values = array_combine($this->keys, $row_items);
            // add each array to the bigger list array using the ID as a key
            $this->lr_array[$keys_and_values['id']] = $keys_and_values;
        }

        $this->sort_lr_array();

        // build the array of html-formatted anchor tags
        $this->html_array = $this->get_html_array();
        $this->html_list = html_writer::alist($this->html_array);
    }

    public function get_lr_array() {
        return $this->lr_array;
    }

    public function get_html_array() {
        foreach ($this->lr_array as $key => $row) {
            if ($row['show'] != 'show') { continue; }
            //$this->html_array[$key] = "<a href='$row[1]'>$row[0]</a>"; 
            $this->html_array[$key] = html_writer::link($row['url'], $row['text'], array('target'=>$this->link_target)); 
        }
        return $this->html_array;
    }

    public function get_html_list() {
        return $this->html_list;
    }

    public function sort_lr_array() {
        uasort($this->lr_array, array($this, 'my_cmp'));
    }

    public function my_cmp($a, $b) {
        if ($a['position'] == $b['position']) {
            return 0;
        }
        return ($a['position'] < $b['position']) ? -1 : 1;
    }
}
