<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Add extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
	}
	
	public function index()
	{
		$this->load->view('user/add');
	}

	public function save()
	{
		$fullName = $this->input->post('fullName');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$repeatPassword = $this->input->post('repeatPassword');

		$this->form_validation->set_rules('fullName', 'Nombre completo', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[user.email]');
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('repeatPassword', 'Confirmar password', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			$this->load->view('user/add');
		} else {
			$data = array(
				"full_name" => $fullName,
				"email"    => $email,
				"password" => md5($password)
			);
	
			$this->User_model->save($data);
			$this->session->set_flashdata('success', 'Se guardo correctamente el usuario.');
			redirect(base_url().'usuarios');
		}
	}
}