<?php

class lr_list {

    public $lr_array = array();
    public $raw_list;
    public $html_array = array();
    public $html_list;
    public $link_target = '';

    public function __construct($raw_list) {
        $this->link_target = get_config('learningresources', 'new_window');
        if ($this->link_target == 1) { $this->link_target = "_blank"; }
        else { $this->link_target = "_self"; }
//        echo "<pre>Debug: ";
//        print_r($this->link_target);
//        echo "</pre>";
//        die();
        $this->raw_list = $raw_list;
        $rows = preg_split('/\n/', $this->raw_list);
        foreach ($rows as $key => $row) {
            $row_items = explode('|', $row);
            $this->lr_array[$row_items[3]] = $row_items;
        }
        $this->html_array = $this->get_html_array();
        $this->html_list = html_writer::alist($this->html_array);
    }

    public function get_html_array() {
        foreach ($this->lr_array as $key => $row) {
            // Not sure why, but a simple test for equality failed, maybe line ending?
            // The regular expression test gets the desired behavior
            if (!(preg_match('/show/', $row[2]))) { continue; }
            //$this->html_array[$key] = "<a href='$row[1]'>$row[0]</a>"; 
            $this->html_array[$key] = html_writer::link($row[1], $row[0], array('target'=>$this->link_target)); 
        }
        return $this->html_array;
    }

    public function get_html_list() {
        return $this->html_list;
    }
}
