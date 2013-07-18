<?php

/**
 * The learning resources list
 *
 * Includes the raw list and an articulated array
 * with methods to modify particular settings,
 * build relevant hyperlinks, and more.
 */
class block_learningresources_list {

    /**
     * The raw, flat list of resources
     *
     * One resource per line
     * Resource attributes are pipe-separated
     */
    public $raw_list; 

    /**
     * The "target" preference for all hyperlinks: "_blank" or "_self"
     */
    public $link_target = '';

    /**
     * An array of resources parsed from the raw list
     */
    public $lr_array = array();

    /**
     * An array of HTML-formatted links to resources
     *
     * By default the list includes only the links flagged as visible
     * after the defaults and instance config have applied
     */
    public $html_array = array();

    /**
     * An HTML-formatted (unordered) list of the visible resource links
     */
    public $html_list;

    /**
     * The array of keys to apply to the attributes of a resource from the raw list
     */
    public $keys = array('text', 'url', 'show', 'id', 'position'); /* keys to apply to rows */

    /** 
     * Build the learning resources object
     *
     * get the raw list from the global settings
     * get the target preference from the global settings
     * set the link_target property according to the global setting
     * break the raw list into an array of rows
     * break each row into an array of attributes for the resource
     * make sure the array is in the desired order
     */
    public function __construct() {
        $this->raw_list = get_config('learningresources', 'link_list');
        $this->link_target = get_config('learningresources', 'new_window');
        if ($this->link_target == 1) { 
            $this->link_target = "_blank"; 
        }
        else { 
            $this->link_target = "_self"; 
        }
        $rows = explode("\n", $this->raw_list);
        $this->parse_rows($rows);
        $this->sort_lr_array();
    }

    /**
     * Parse each row of the raw list
     *
     * ignore blank or ill-formed rows
     * delete newlines and whitespace at the end of each row
     * split the row using the pipe as a separator
     * use the list of $keys as keys for the elements of each row
     * add each row to an array of rows, using the id of the row as the key
     */
    public function parse_rows($rows) {
        foreach ($rows as $key => $row) {
            $row = rtrim($row);
            $row_items = explode('|', $row);
            array_push($row_items, $key);
            if (count($row_items) != count($this->keys)) { 
                continue; 
            }
            $keys_and_values = array_combine($this->keys, $row_items);
            $this->lr_array[$keys_and_values['id']] = $keys_and_values;
        }
    }

    
    /**
     * return the articulated array of learning resources
     */
    public function get_lr_array() {
        return $this->lr_array;
    }

    /**
     * set the visibility of an individual item in the array
     */
    public function set_visibility($id, $show='show') {
        if ($show != 'show') {
            $show = 'hide';
        }
        $this->lr_array[$id]['show']=$show;
    }

    /**
     * return the array of HTML formatted links to resources
     */
    public function get_html_array($visible='visible') {
        foreach ($this->lr_array as $key => $row) {
            if (($visible=='visible') && ($row['show'] != 'show')) { continue; }
            //$this->html_array[$key] = "<a href='$row[1]'>$row[0]</a>"; 
            $this->html_array[$key] = html_writer::link($row['url'], $row['text'], array('target'=>$this->link_target)); 
        }
        return $this->html_array;
    }

    /**
     * return the unordered list of links to resources
     */
    public function get_html_list() {
        $this->get_html_array();
        $this->html_list = html_writer::alist($this->html_array);
        return $this->html_list;
    }

    /**
     * sort the articulated array of resources according to the custom function
     */
    public function sort_lr_array() {
        uasort($this->lr_array, array($this, 'my_cmp'));
    }

    /**
     * compare the value of two resources 'position' attributes
     */
    public function my_cmp($a, $b) {
        if ($a['position'] == $b['position']) {
            return 0;
        }
        return ($a['position'] < $b['position']) ? -1 : 1;
    }
}
