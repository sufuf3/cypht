<?php

/* servers page */
Hm_Handler_Modules::add('servers', 'load_pop3_servers_from_config',  true, 'date', 'after');
Hm_Handler_Modules::add('servers', 'process_add_pop3_server', true, 'load_pop3_servers_from_config', 'after');
Hm_Handler_Modules::add('servers', 'add_pop3_servers_to_page_data', true, 'process_add_pop3_server', 'after');
Hm_Handler_Modules::add('servers', 'save_pop3_servers',  true, 'add_pop3_servers_to_page_data', 'after');

Hm_Output_Modules::add('servers', 'add_pop3_server_dialog', true, 'display_configured_imap_servers', 'after');
Hm_Output_Modules::add('servers', 'display_configured_pop3_servers', true, 'add_pop3_server_dialog', 'after');

/* ajax server setup callback data */
Hm_Handler_Modules::add('ajax_pop3_debug', 'login', false);
Hm_Handler_Modules::add('ajax_pop3_debug', 'load_user_data',  true);
Hm_Handler_Modules::add('ajax_pop3_debug', 'load_pop3_servers_from_config',  true);
Hm_Handler_Modules::add('ajax_pop3_debug', 'add_pop3_servers_to_page_data',  true);
Hm_Handler_Modules::add('ajax_pop3_debug', 'pop3_connect', true);
Hm_Handler_Modules::add('ajax_pop3_debug', 'pop3_connect', true);
Hm_Handler_Modules::add('ajax_pop3_debug', 'pop3_delete', true);
Hm_Handler_Modules::add('ajax_pop3_debug', 'pop3_forget', true);
Hm_Handler_Modules::add('ajax_pop3_debug', 'pop3_save', true);
Hm_Handler_Modules::add('ajax_pop3_debug', 'save_pop3_cache',  true);
Hm_Handler_Modules::add('ajax_pop3_debug', 'save_pop3_servers',  true);
Hm_Handler_Modules::add('ajax_pop3_debug', 'save_user_data',  true);
Hm_Handler_Modules::add('ajax_pop3_debug', 'date', true);

return array(
    'allowed_pages' => array(
        'ajax_pop3_debug'
    ),
    'allowed_post' => array(
        'new_pop3_name' => FILTER_SANITIZE_STRING,
        'new_pop3_address' => FILTER_SANITIZE_STRING,
        'new_pop3_port' => FILTER_SANITIZE_STRING,
        'pop3_connect' => FILTER_VALIDATE_INT,
        'submit_pop3_server' => FILTER_SANITIZE_STRING
    )
);

?>
