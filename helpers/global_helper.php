<?php
// check admin user login return true or false
if (!function_exists('check_admin_login'))
{
    function check_admin_login()
    {
        $ci = &get_instance();

        // check if user data to the session
        if ((!$ci->session->user_id) && (!$ci->input->cookie('user_id')))
        {
            return FALSE;
        }

        $user_id = $ci->session->user_id;
        if (!$user_id)
        {
            $user_id = $ci->input->cookie('user_id');
        }

        // get the specific user information
        $user = $ci->global_model->get_row('users', array('user_id' => $user_id));

        if (!$user) { return FALSE; }

        $user_data = array(
            'user_id'=>$user->user_id,
            'user_name'=>$user->user_name,
            'user_login'=>$user->user_login,
            'user_email'=>$user->user_email,
            'user_phone'=>$user->user_phone,
            'user_type'=>$user->user_type,
            'user_status'=>$user->user_status,
            'registered_date'=>$user->registered_date,
            'updated_date'=>$user->updated_date
        );
        $ci->session->set_userdata($user_data);
        return TRUE;
    }
}

// generate the password and secret
if (!function_exists('geneSecurePass'))
{
    function geneSecurePass($password, $secret = FALSE)
    {
        if ($secret)
        {
            // create the salt using secret
            list($salt1, $salt2) = str_split($secret, ceil(strlen($secret) / 2));
            $code = md5($salt1 . $password . $salt2);
        }
        else
        {
            // generate the randomcode
            $code['secret']   = $secret           = rand(100000, 999999);
            // create the salt using secret
            list($salt1, $salt2) = str_split($secret, ceil(strlen($secret) / 2));
            // generate the password
            $code['password'] = md5($salt1 . $password . $salt2);
        }

        return $code;
    }
}

// generate password
if (!function_exists('generate_access_token'))
{
    function generate_access_token($user_id)
    {
        $token = uniqid() . $user_id . time();
        return md5($token);
    }
}

// create paggination configuratin
if (!function_exists('createPagging')) {

    function createPagging($page_url, $total_rows, $per_page, $num_links = 2) {
        $ci                   = &get_instance();
        //load the pagging library
        $ci->load->library('pagination');
        // set the configuration
        $config['base_url']   = site_url($page_url);
        $config['total_rows'] = $total_rows;
        $config['per_page']   = $per_page;
        $config['num_links']  = $num_links;

        $config['page_query_string']    = TRUE;
        $config['reuse_query_string']   = TRUE;
        $config['query_string_segment'] = 'page';
        $config['use_page_numbers']     = TRUE;

        // pagging design section
        //full tag
        $config['full_tag_open']  = '<ul class="pagination justify-content-center">';
        $config['full_tag_close'] = '</ul>';

        // first tag
        $config['first_link']      = '<i class="fa fa-angle-double-left" aria-hidden="true"></i>';
        $config['first_tag_open']  = '<li>';
        $config['first_tag_close'] = '</li>';

        //Last Link
        $config['last_link']      = '<i class="fa fa-angle-double-right" aria-hidden="true"></i>';
        $config['last_tag_open']  = '<li>';
        $config['last_tag_close'] = '</li>';

        //“Next” Link
        $config['next_link']      = '<i class="fa fa-angle-right" aria-hidden="true"></i>';
        $config['next_tag_open']  = '<li>';
        $config['next_tag_close'] = '</li>';

        //"privious" link
        $config['prev_link']      = '<i class="fa fa-angle-left" aria-hidden="true"></i>';
        $config['prev_tag_open']  = '<li>';
        $config['prev_tag_close'] = '</li>';


        //"Current Page" Link
        $config['cur_tag_open']  = '<li class = "active"><a href = "javascript:void(0)">';
        $config['cur_tag_close'] = '</a></li>';

        // "Digit" Link
        $config['num_tag_open']  = '<li>';
        $config['num_tag_close'] = '</li>';

        // Produces: class="myclass"
        //        $config['attributes'] = array('class' => 'page-link next_page');


        $ci->pagination->initialize($config);
    }

}

if (!function_exists('longDateHuman'))
{
    function longDateHuman($dateTime, $format = 'pl') {
        if ($dateTime == '0000-00-00 00:00:00' || $dateTime == '')
        {
            return '';
        }
        $intdbTime = (!ctype_digit($dateTime)) ? strtotime($dateTime) : $dateTime;

        $intTime = system_time($intdbTime);
        if ($intTime)
        {
            switch ($format)
            {
                case 'datetime':
                    return date('jS M, Y \a\t h:i:s a', $intTime);
                case 'date_time':
                    return date('j M y, h:i A', $intTime);
                case 'date':
                    return date('jS F, Y', $intTime);
                case 'time':
                    return date('h:i', $intTime);
                case 'short':
                    return date('jS M, y', $intTime);
                case 'MY':
                    return date('F Y', $intTime);
                case 'MdY':
                    return date('M d, Y', $intTime);
                case 'Y':
                    return date('Y', $intTime);
                case 'M':
                    return date('F', $intTime);
                case 'full':
                    return date('j M Y, h:i a', $intTime);
                case 'pl':
                    return date('M j Y, h:ia', $intTime);
                case 'plt':
                    return date('F j, Y, h:i a', $intTime);
                case 'pl_ago':
                    // Check if the order was created within the last 24 hours, and not in the future.
                    $current_time = system_time(time());
                    if ($intTime > strtotime('-1 day', $current_time) && $intTime <= $current_time)
                    {
                        $show_date = getHumanTimeDiff($intTime);
                    }
                    else
                    {
                        $show_date = date('M j, Y', $intTime);                      
                    }
                    return '<time datetime="' . $intTime . '" title="' . date('F j Y, h:i a', $intTime) . '">' . $show_date . '</time>';
                case 'md':
                    return date('j M, h:i a', $intTime);
                case 'j':
                    return date('j', $intTime);
                case 'jFy':
                    return date('j F Y', $intTime);
                case 'jFyhia':
                    return date('j F Y h:ia', $intTime);
               case 'pd':
                    return date('M j, Y @ H:i', $intTime);
                default:
                    break;
            }
        }
        else
        {
            return "Not yet";
        }
    }

}

// user roles
if (!function_exists('get_user_roles'))
{
    function get_user_roles()
    {
        return array(
            'super-admin'       => 'Super Admin',
            'admin'             => 'Admin',
            'shop-manager'      => 'Shop Manager',
            'product-manager'   => 'Product Manager',
            'dealer'            => 'Dealer',
            'customer'          => 'Customer'
        );
    }
}

// user data by
if (!function_exists('get_user_by'))
{
    function get_user_by($id, $field = 'displayname')
    {
        $roles = array();
        $ci    = &get_instance();
        $item  = $ci->global_model->get_row('user', array('id' => $id), 'id,' . $field);
        if ($item) {
            return $item->{$field};
        } else {
            return '--';
        }
    }
}

// get current user id
if (!function_exists('get_current_user_id'))
{
    function get_current_user_id()
    {
        $ci = &get_instance();
        if ($ci->session->userdata('user_id'))
        {
            return $ci->session->userdata('user_id');
        }
    }
}

// get the module list
if (!function_exists('getModules'))
{
    function getModules($params = array())
    {
        $ci = &get_instance();
        return $ci->global_model->get('modules', $params);
    }
}

// get action based on module
if (!function_exists('getActions'))
{
    function getActions($params = array())
    {
        $ci = &get_instance();
        return $ci->global_model->get('actions', $params, '*', FALSE, array(
            'field' => 'action_id',
            'order' => 'ASC'
        ));
    }
}

// get the permissin
if (!function_exists('has_permission'))
{
    function has_permission($module, $action, $role = NULL)
    {
        $ci = &get_instance();
        $params      = array(
            'role'   => !empty($role) ? $role : $ci->session->user_type,
            'module' => $module,
            'action' => $action
        );
        $permission = $ci->global_model->get_row('permissions', $params);
        if ($permission)
        {
            if ($permission->have_access == 'yes')
            {
                return TRUE;
            }
            else
            {
                return FALSE;
            }
        }
        else
        {
            return FALSE;
        }
    }
}

// get client ip
if (!function_exists('get_client_ip'))
{
    function get_client_ip()
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP')) {
            $ipaddress = getenv('HTTP_CLIENT_IP');
        } else if (getenv('HTTP_X_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        } else if (getenv('HTTP_X_FORWARDED')) {
            $ipaddress = getenv('HTTP_X_FORWARDED');
        } else if (getenv('HTTP_FORWARDED_FOR')) {
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        } else if (getenv('HTTP_FORWARDED')) {
            $ipaddress = getenv('HTTP_FORWARDED');
        } else if (getenv('REMOTE_ADDR')) {
            $ipaddress = getenv('REMOTE_ADDR');
        }
        return $ipaddress;
    }
}

// get sortable url
if (!function_exists('get_sorted_url'))
{
    function get_sorted_url($action, $orderby, $order = 'asc')
    {
        $ci = &get_instance();
        if ($ci->input->get('orderby') == $orderby)
        {
            $order = ($ci->input->get('order') == 'asc') ? 'desc' : 'asc';
        }
        $url = $action . '?orderby=' . $orderby . '&order=' . $order;
        return site_url($url);
    }
}

// get the sortable class
if (!function_exists('get_sorted_class'))
{
    function get_sorted_class($orderby, $order = 'asc')
    {
        $ci = &get_instance();
        if ($ci->input->get('orderby') == $orderby)
        {
            $order = ($ci->input->get('order') == 'asc') ? 'sorted desc' : 'sorted asc';
        }
        return $order;
    }
}

// add deleted data to recycle bin
if (!function_exists('add_to_recycle_bin'))
{
    function add_to_recycle_bin($table_name, $table_id)
    {
        $ci = &get_instance();
        $data['table_name']     = $table_name;
        $data['table_id']       = $table_id;
        $data['user_id']        = $ci->session->user_id;
        $data['created_time']   = date('Y-m-d H:i:s');

        return $ci->global_model->insert('recyclebin', $data);
    }
}

// add deleted data to recycle bin
if (!function_exists('update_to_recycle_bin'))
{
    function update_to_recycle_bin($table_name, $table_id)
    {
        $ci = &get_instance();
        $data['table_name']     = $table_name;
        $data['table_id']       = $table_id;
          $data['recyclebin_status']       = 1;
        $data['user_id']        = $ci->session->user_id;
        $data['created_time']   = date('Y-m-d H:i:s');

        return $ci->global_model->insert('recyclebin', $data);
    }
}


// order status
if (!function_exists('get_order_status'))
{
    function get_order_status()
    {
        return array(
            'new'           => 'New', 
            'pending'       => 'Pending', 
            'processing'    => 'Processing', 
            'completed'     => 'Completed'
        );
    }
}



// image resize
if (!function_exists('img_resize')) {

    function img_resize($ini_path, $dest_path, $params = array()) {
        $width        = !empty($params['width']) ? $params['width'] : NULL;
        $height       = !empty($params['height']) ? $params['height'] : NULL;
        $constraint   = !empty($params['constraint']) ? $params['constraint'] : FALSE;
        $rgb          = !empty($params['rgb']) ? $params['rgb'] : 0xFFFFFF;
        $quality      = !empty($params['quality']) ? $params['quality'] : 100;
        $aspect_ratio = isset($params['aspect_ratio']) ? $params['aspect_ratio'] : TRUE;
        $crop         = isset($params['crop']) ? $params['crop'] : TRUE;

        if (!file_exists($ini_path))
            return FALSE;

        if (!is_dir($dir = dirname($dest_path)))
            mkdir($dir);

        $img_info = getimagesize($ini_path);


        if ($img_info === FALSE)
            return FALSE;


        $ini_p = $img_info[0] / $img_info[1];
        if ($constraint) {
            $con_p  = $constraint['width'] / $constraint['height'];
            $calc_p = $constraint['width'] / $img_info[0];

            if ($ini_p < $con_p) {
                $height = $constraint['height'];
                $width  = $height * $ini_p;
            } else {
                $width  = $constraint['width'];
                $height = $img_info[1] * $calc_p;
            }
        } else {
            if (!$width && $height) {
                $width = ($height * $img_info[0]) / $img_info[1];
            } else if (!$height && $width) {
                $height = ($width * $img_info[1]) / $img_info[0];
            } else if (!$height && !$width) {
                $width  = $img_info[0];
                $height = $img_info[1];
            }
        }

        preg_match('/\.([^\.]+)$/i', basename($dest_path), $match);
        $ext           = strtolower($match[1]);
        $output_format = ($ext == 'jpg') ? 'jpeg' : $ext;

        $format = strtolower(substr($img_info['mime'], strpos($img_info['mime'], '/') + 1));
        $icfunc = "imagecreatefrom" . $format;

        $iresfunc = "image" . $output_format;

        if (!function_exists($icfunc))
            return FALSE;

        $dst_x = $dst_y = 0;
        $src_x = $src_y = 0;
        $res_p = $width / $height;
        if ($crop && !$constraint) {
            $dst_w = $width;
            $dst_h = $height;
            if ($ini_p > $res_p) {
                $src_h = $img_info[1];
                $src_w = $img_info[1] * $res_p;
                $src_x = ($img_info[0] >= $src_w) ? floor(($img_info[0] - $src_w) / 2) : $src_w;
            } else {
                $src_w = $img_info[0];
                $src_h = $img_info[0] / $res_p;
                $src_y = ($img_info[1] >= $src_h) ? floor(($img_info[1] - $src_h) / 2) : $src_h;
            }
        } else {
            if ($ini_p > $res_p) {
                $dst_w = $width;
                $dst_h = $aspect_ratio ? floor($dst_w / $img_info[0] * $img_info[1]) : $height;
                $dst_y = $aspect_ratio ? floor(($height - $dst_h) / 2) : 0;
            } else {
                $dst_h = $height;
                $dst_w = $aspect_ratio ? floor($dst_h / $img_info[1] * $img_info[0]) : $width;
                $dst_x = $aspect_ratio ? floor(($width - $dst_w) / 2) : 0;
            }
            $src_w = $img_info[0];
            $src_h = $img_info[1];
        }

        $isrc  = $icfunc($ini_path);
        $idest = imagecreatetruecolor($width, $height);
        if (($format == 'png' || $format == 'gif') && $output_format == $format) {
            imagealphablending($idest, FALSE);
            imagesavealpha($idest, TRUE);
            imagefill($idest, 0, 0, IMG_COLOR_TRANSPARENT);
            imagealphablending($isrc, TRUE);
            $quality = (int) ($quality / 10);
        } else {
            imagefill($idest, 0, 0, $rgb);
        }
        imagecopyresampled($idest, $isrc, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
        $res = $iresfunc($idest, $dest_path, $quality);


        //imagedestroy($isrc);
        //imagedestroy($idest);

        return $dest_path;
    }
}

if(!function_exists('get_photo'))
{
    function get_photo($filename, $path, $type = '')
    {
        // set the path base on type
        if($type != '')
        {
            $path .= $type . "/";
        }

        if (!empty($filename)) {

            if(file_exists($path . $filename))
            {
            	return base_url($path . $filename);
            }
            else
            {
            	$path = str_replace(array('list/', 'mini_list/', 'thumbs/', 'mini_thumbs/', 'original/'), '', $path);
            	return base_url($path . $filename);
            }
        } else {
            return base_url($path . 'nophoto.jpg');
        }
    }
}