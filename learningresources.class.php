<?php

class lr_list {

    public $lr_array = array();
    public $raw_list;
    public $html_array = array();
    public $html_list;
    public $keys = array('text', 'url', 'show', 'id', 'position');
    public $link_target = '';

    public function __construct() {
        $this->raw_list = get_config('learningresources', 'link_list');
        $this->link_target = get_config('learningresources', 'new_window');
        if ($this->link_target == 1) { $this->link_target = "_blank"; }
        else { $this->link_target = "_self"; }
//        echo "<pre>Debug: ";
//        print_r($this->link_target);
//        echo "</pre>";
//        die();
        $rows = explode("\n", $this->raw_list);
        foreach ($rows as $key => $row) {
            $row = rtrim($row);
            $row_items = explode('|', $row);
            array_push($row_items, $key);
            $keys_and_values = array_combine($this->keys, $row_items);
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
