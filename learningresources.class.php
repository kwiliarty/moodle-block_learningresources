<?php

class lr_list {

    public $lr_array = array();
    public $raw_list; /* The list as stored in the settings */
    public $html_array = array();
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
            $this->lr_array[$row_items[3]] = $keys_and_values;
        }
        $this->html_array = $this->get_html_array();
        $this->html_list = html_writer::alist($this->html_array);
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
}
