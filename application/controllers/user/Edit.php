<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Edit extends CI_Controller {

	public function __construct()
    {
        parent::__construct();
        $this->load->model('User_model');
	}
	
	public function index($id)
	{
		$data = $this->User_model->getUser($id);
		$this->load->view('user/edit', $data);
	}

	public function update($id)
	{
		$fullName = $this->input->post('fullName');
		$email = $this->input->post('email');
		$password = $this->input->post('password');
		$repeatPassword = $this->input->post('repeatPassword');

		$data = $this->User_model->getUser($id);

		$validateEmail = '';

		if($email != $data->email) {
			$validateEmail = '|is_unique[user.email]';
		}

		$this->form_validation->set_rules('fullName', 'Nombre completo', 'required');
		$this->form_validation->set_rules('email', 'Email', 'required|valid_email'.$validateEmail);
		$this->form_validation->set_rules('password', 'Password', 'required|min_length[5]');
		$this->form_validation->set_rules('repeatPassword', 'Confirmar password', 'required|matches[password]');

		if ($this->form_validation->run() == FALSE) {
			//$data = $this->User_model->getUser($id);
			//$this->load->view('user/edit', $data);
			$this->index($id);
		} else {
			$data = array(
				"full_name" => $fullName,
				"email"    => $email,
				"password" => md5($password),
				"modified_at" => date('Y-m-d H:i:s')
			);
	
			$this->User_model->update($data, $id);
			$this->session->set_flashdata('success', 'Se actualizo correctamente.');
			redirect(base_url().'usuarios');
		}
	}
}