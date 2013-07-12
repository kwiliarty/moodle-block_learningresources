<?php

$settings->add(new admin_setting_configcheckbox('learningresources/new_window', 'Open links in an new window',
                        '', 'learningresources', 1));

$settings->add(new admin_setting_configtextarea('learningresources/link_list', 'List of learning resources', 'display text|url|show or hide', '', PARAM_RAW, 120, 20));
