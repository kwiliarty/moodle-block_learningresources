<?php

//$resourcearray = array(
//    'lib_home'     => 'http://www.smith.edu/libraries',
//    'research'     => 'http://www.smith.edu/libraries/research/',
//    'apa_citation' => 'http://libguides.smith.edu/content.php?pid=31706&sid=231793#678041',
//    'services'     => 'http://www.smith.edu/libraries/services/ssw/',
//    'sw_resources' => 'http://www.smith.edu/libraries/research/class/sswspecialized.htm',
//    'fc_catalog'   => 'http://fcaw.library.umass.edu:8991/F/',
//    'journals'     => 'http://www.smith.edu/libraries/research/article.html',
//    'cite_guides'  => 'http://libguides.smith.edu/citation',
//    'refworks'     => 'http://libguides.smith.edu/refworks',
//    'ssw_subjects' => 'http://www.smith.edu/libraries/research/subject/socialwork.htm',
//    'lib_help'     => 'http://www.smith.edu/libraries/help/',
//    'luna_db'      => 'http://www.smith.edu/imaging/luna.htm'
//);

class lr_list {

    public $lr_array = array();
    public $raw_list;
    public $html_array;

    public function __construct($raw_list) {
        $this->raw_list = $raw_list;
        $rows = preg_split('/\n/', $this->raw_list);
        foreach ($rows as $key => $row) {
            $row_items = explode('|', $row);
            $this->lr_array[$key] = $row_items;
        }
    }

    public function get_html_array() {
        foreach ($this->lr_array as $key => $row) {
            if ($row[2] != "show") { continue; }
            $this->html_array[$key] = "<a href='$row[1]'>$row[0]</a>"; 
        }
        return $this->html_array;
    }
}
