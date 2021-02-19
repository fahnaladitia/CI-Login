<?php
defined("BASEPATH") or exit("No direct script access allowed");

class Auth extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->library("form_validation");
	}
	public function index()
	{
		$this->form_validation->set_rules(
			"email",
			"Email",
			"trim|required|valid_email"
		);
		$this->form_validation->set_rules(
			"password",
			"Password",
			"trim|required"
		);
		if ($this->form_validation->run() == false) {
			$data["title"] = "User - Login";
			$this->load->view("templates/auth_header", $data);
			$this->load->view("auth/login");
			$this->load->view("templates/auth_footer");
		} else {
			$this->_login();
		}
	}

	public function registration()
	{
		$this->form_validation->set_rules("name", "Name", "required|trim");
		$this->form_validation->set_rules(
			"email",
			"Email",
			"required|trim|valid_email|is_unique[user.email]",
			[
				"is_unique" => "This email has already registered!",
			]
		);
		$this->form_validation->set_rules(
			"password1",
			"Password",
			"required|trim|min_length[6]|matches[password2]",
			[
				"matches" => "Password dont Match!",
				"min_length" => "Password too short!",
			]
		);
		$this->form_validation->set_rules(
			"password2",
			"Password",
			"required|trim|matches[password1]"
		);
		if ($this->form_validation->run() == false) {
			$data["title"] = "User - Registration";
			$this->load->view("templates/auth_header", $data);
			$this->load->view("auth/registration");
			$this->load->view("templates/auth_footer");
		} else {
			$data = [
				"name" => htmlspecialchars($this->input->post("name", true)),
				"email" => htmlspecialchars($this->input->post("email", true)),
				"image" => "default.jpg",
				"password" => password_hash(
					$this->input->post("password1"),
					PASSWORD_DEFAULT
				),
				"role_id" => 2,
				"is_actived" => 1,
				"date_created" => time(),
			];

			$this->db->insert("user", $data);
			$this->session->set_flashdata(
				"message",
				'<div class="alert alert-success font-weight-bold" role="alert">Congratulation! your account has been created. Please Login</div>'
			);
			redirect("auth");
		}
	}
	private function _login()
	{
		$email = $this->input->post("email");
		$password = $this->input->post("password");

		$user = $this->db->get_where("user", ["email" => $email])->row_array();

		// jika user ada
		if ($user) {
			// jika usernya aktif
			if ($user["is_actived"] == 1) {
				// cek password
				if (password_verify($password, $user["password"])) {
					$data = [
						"email" => $user["email"],
						"role_id" => $user["role_id"],
					];
					$this->session->set_userdata($data);
					if ($user["role_id"] == 1) {
						redirect("admin");
					} else {
						redirect("user");
					}
				} else {
					$this->session->set_flashdata(
						"message",
						'<div class="alert alert-danger font-weight-bold" role="alert">Wrong Password!</div>'
					);
					redirect("auth");
				}
			} else {
				$this->session->set_flashdata(
					"message",
					'<div class="alert alert-danger font-weight-bold" role="alert">Email has not been Activated!</div>'
				);
				redirect("auth");
			}
		} else {
			$this->session->set_flashdata(
				"message",
				'<div class="alert alert-danger font-weight-bold" role="alert">Email Is not Registered!</div>'
			);
			redirect("auth");
		}
	}

	public function logout()
	{
		$this->session->unset_userdata("email");
		$this->session->unset_userdata("role_id");

		$this->session->set_flashdata(
			"message",
			'<div class="alert alert-success font-weight-bold" role="alert">You have been logged out!</div>'
		);
		redirect("auth");
	}

	public function blocked()
	{
		$this->load->view("auth/blocked");
	}
}