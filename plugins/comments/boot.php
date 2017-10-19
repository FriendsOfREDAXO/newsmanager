<?php
if (rex_post('user_comm', 'string') != "") {
    rex_extension::register('OUTPUT_FILTER', array('NewsManagerWithComments', 'saveComment'), rex_extension::LATE);
}
