<?php

class User extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('usermodel');
	}

	// Function to add New User Login/SignUp Functionality
	public function adduser() {

		//Accepting values from post request
		$data['phone'] = $this->input->post('phone');

		//Checking for existing record by phone number
		$records = $this->usermodel->getuser($data['phone']);

		$result = array();
		if($records!=NULL) {
			$result['success'] = '1';
			$result['action'] = 'loggedin';
		}
		else {

			$query = $this->usermodel->addUser($data);
			if($query) {
				$result['success'] = '1';
				$result['action'] = 'signup';
			}
			else {
				$result['success'] = '0';
				$result['action'] = 'error';
			}
		}

		echo json_encode($result);

	}

	// Function to update user profile
	public function addProfile() {

		$data['name'] = $this->input->post('name');
		$data['email'] = $this->input->post('email');
		$phone = $this->input->post('phone');
		$records = $this->usermodel->getUser($phone);
		$result = array();
		if($records!=NULL) {
			foreach ($records as $r) {
			}
			$query = $this->usermodel->updateProfile($r->userid,$data);
			if($query) {
				$result['success'] = '1';
				$result['userid'] = $r->userid;
			}
			else {
				$result['success'] = '0';
				$result['userid'] = NULL;
			}
		}

		echo json_encode($result);
	}

	//Function to get user profile details
	public function getProfile() {
		$phone = $this->input->post('phone');
		$records = $this->usermodel->getUser($phone);
		$result = array();
		if($records!=NULL) {
			foreach ($records as $r) {
			}
			$result['success'] = '1';
			$result['data'] = $r;
			echo json_encode($result);
		}
	}
}

?>