<?php
require_once('../config.php');
Class Register extends DBConnection {
	private $settings;
	public function __construct(){
		global $_settings;
		$this->settings = $_settings;
		parent::__construct();
	}
	public function __destruct(){
		parent::__destruct();
	}
	public function save_users(){
        // Import variables from data array which is passed when the register function is being called
		extract($_POST);
		$data = '';
		foreach($_POST as $k => $v){
			if(!in_array($k,array('id','password'))){
				if(!empty($data)) $data .=" , ";
				$data .= " {$k} = '{$v}' ";

                if ($k == 'role') {
                    $role = $v;
                }
			}
		}

        // Generate md5 string of the password
		if(!empty($password)){
			$password = md5($password);
			if(!empty($data)) $data .=" , ";
			$data .= " `password` = '{$password}' ";
		}
 
        // Check whether the email is alreadt exists
        $check = $this->conn->query("SELECT * FROM `users` where `email` = '{$email}' and deleted_date is null ")->num_rows;
		if($check > 0){
			$resp['status'] = 'failed';
			$resp['msg'] = " Email already exists in the system.";
			return json_encode($resp);
			exit;
		}

        // Insert data to users table
        $qry = $this->conn->query("INSERT INTO users set {$data}");
        if($qry){
            // Get the inserted id of the row
            $id=$this->conn->insert_id;
            $agent_data = '';
            $agent_data .= " `user_id` = '{$id}' ";
            if ($role == 'Agent') {

                // Insert data to agents table
                $agent_qry = $this->conn->query("INSERT INTO agents set {$agent_data}");

                if ($agent_qry) {
                    $this->settings->set_flashdata('success','Agent Details successfully saved.');
                } else {
                    return 2;
                }
            } else {
                $this->settings->set_flashdata('success','User Details successfully saved.');
            }
            return 1;
        } else{
            return 2;
        }
	}
}


$users = new Register();
$action = !isset($_GET['f']) ? 'none' : strtolower($_GET['f']);
switch ($action) {
	case 'save':
		echo $users->save_users();
	break;
	default:
		break;
}