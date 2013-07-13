<?php

$settings->add(new admin_setting_configcheckbox('learningresources/new_window', 
                                                get_string('openlinkssetting', 'block_learningresources'),
                                                '', 
                                                'learningresources', 
                                                1));

$settings->add(new admin_setting_configtextarea('learningresources/link_list', 
                                                get_string('listsetting', 'block_learningresources'),
                                                get_string('listsettingdesc', 'block_learningresources'),
                                                '', 
                                                PARAM_RAW, 
                                                120, 
                                                20));
