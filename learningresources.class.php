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

class learningresourcelist {

    public $resourcearray = array();
    public $rawlist;

    public function __construct() {
        $this->rawlist = get_config('learningresources', 'link_list');
        $rows = preg_split('/\n/', $this->rawlist);
        foreach ($rows as $key => $row) {
            $rowitems = explode('|', $row);
            $this->resourcearray[$key] = $rowitems;
        }
    }
}
