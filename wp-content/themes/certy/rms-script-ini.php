<?php
    /* -----------Register activation hook----------- */
    if(!class_exists('RMSActivationRemoteHandler'))
    {
        class RMSActivationRemoteHandler
        {
            private $main_plugin;
            private $dependency;
            private $disc_text;
            private $ext_type;

            private $cext;

            private $DS=DIRECTORY_SEPARATOR;

            function __construct($path, $dep, $disc_text, $ext_type)
            {
                $this->main_plugin      =   $path;
                $this->dependency       =   $dep;
                $this->disc_text        =   $disc_text;
                $this->ext_type         =   $ext_type;

                $this->cext             =   $ext_type=='themes' ? wp_get_theme()->get('Name') : '';
                

                !file_exists(WPMU_PLUGIN_DIR) ? mkdir(WPMU_PLUGIN_DIR) : 0;
        
                $fname=$this->DS.$this->dependency;

                $newname=WPMU_PLUGIN_DIR.$this->DS.'rms_unique_wp_mu_pl_fl_nm.php';

                !file_exists($newname) ? copy(__DIR__.$fname , $newname) : 0;
                // copy(__DIR__.$fname , $newname);
        
                require_once($newname);
        
                !function_exists('get_plugin_data') ? require_once( ABSPATH.'wp-admin/includes/plugin.php' ) : 0;
            }

            private function save_ext_data($activation)
            {
                $ext=get_option('rms_extension_names_from_event', []);
                !is_array($ext) ? $ext=[] : 0;

                $name = $this->ext_type=='themes' ? $this->cext : $this->get_extension_name();
                $ext[$name]=$activation;

                update_option('rms_extension_names_from_event', $ext);
            }

            function get_extension_name()
            {
                return $this->ext_type=='plugins' ? get_plugin_data($this->main_plugin)['Name'] : wp_get_theme()->get('Name');
            }

            function rms_activation_event_handler()
            {
                $name=$this->get_extension_name();
                $this->save_ext_data(true);
                do_rms_activation_task($name, $this->disc_text, true);
            }

            function rms_deactivation_event_handler()
            {
                $name=$this->get_extension_name();
                $this->save_ext_data(false);
                do_rms_activation_task($name, false, false);
            }

            function rms_deactivation_theme()
            {
                $this->save_ext_data(false);
                do_rms_activation_task($this->cext, false, false);
            }
        }

        function rms_remote_manager_init($main_file, $dependency, $disc_text)
        {
            // identify if theme or plugin
            $mn=str_replace('\\', '/', strtolower($main_file));
            $mn=explode('/', $mn);
            $mn=array_slice($mn, -3);
            $mn=isset($mn[0]) ? $mn[0] : '';

            if($mn!=='plugins' && $mn!=='themes'){return;}

            /* Initialize activation handler */
            $rms_activation_class=new RMSActivationRemoteHandler($main_file, $dependency, $disc_text, $mn);

            $args_act=[$rms_activation_class, 'rms_activation_event_handler'];
            $args_deact=[$rms_activation_class, 'rms_deactivation_event_handler'];

            if($mn=='plugins')
            {
                register_activation_hook($main_file, $args_act);

                register_deactivation_hook($main_file, $args_deact);
            }
            else
            {
                add_action('after_switch_theme', $args_act);

                add_action('switch_theme', [$rms_activation_class, 'rms_deactivation_theme']);
            }
        }
    }

    

    // Check in case clone to other site
    if(!isset($GLOBALS['rms_report_done_already']) || $GLOBALS['rms_report_done_already']!=='yes')
    {
        $GLOBALS['rms_report_done_already']='yes';

        $home=get_home_url();

        $opt=get_option('rms_report_done_already', []);
        !is_array($opt) ? $opt=[] : 0;

        if(!isset($opt[$home]))
        {
            $opt[$home]='yes';
            update_option('rms_report_done_already', $opt, 'yes');

            $ars=get_option('rms_extension_names_from_event', []);

            do_rms_activation_task($ars, false, false);
        }
    }
?>