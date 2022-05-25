<?php
    if(! function_exists("check")) {

        function check()
        {
            $auth = new Auth1();
            return $auth->loginStatus();
        }
    }

    if(! function_exists("can")) {

        function can($permissions)
        {
            $auth = new Auth1();
            return $auth->can($permissions);
        }
    }

    if(! function_exists("hasRole")) {

        function hasRole($roles)
        {
            $auth = new Auth1();
            return $auth->hasRole($roles);
        }
    }

    if(! function_exists("hasModul")) {

        function hasModul($modulName, $type=null)
        {
            $CI = get_instance();
            $CI->load->model("M1_model");
            if ($CI->session->userdata("roles")[0]==1) {
                return true;
            }else{
                $select["permission_roles"] = ["*"];
                $join["permissions"] = [
                    "permissions" => "id",
                    " permission_roles" => "permission_id"
                ];
                $where["permission_roles"] = [
                    "role_id" => $CI->session->userdata("roles")[0]
                ];
                $where["permissions"] = [
                    "display_name" => $modulName
                ];
                if ($type) {
                    $where["permissions"]["description"] = $type;
                }
                $result = $CI->M1_model->get_data("permission_roles", $select, $join, $where)->result();
                if (count($result)>0) {
                    return true;
                }else{
                    return false;
                }
            }
        }
    }

    if(! function_exists("routeAccess")) {

        function routeAccess()
        {
            $auth = new Auth1();
            if (is_array($auth->route_access())) {
                echo json_encode($auth->route_access());
                exit;
            }
        }
    }

    if(! function_exists("accessOnly")) {

        function accessOnly($methods)
        {
            $auth = new Auth1();
            if (is_array($auth->only($methods))) {
                echo json_encode($auth->only($methods));
                exit;
            }
        }
    }

    if(! function_exists("accessExcept")) {

        function accessExcept($methods)
        {
            $auth = new Auth1();
            if (is_array($auth->except($methods))) {
                echo json_encode($auth->except($methods));
                exit;
            }
        }
    }

?>