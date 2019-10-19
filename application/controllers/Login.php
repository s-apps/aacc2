<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

	public function __construct(){
		parent::__construct();
		$this->load->helper('sessao_usuario');
		define('USUARIO_LOGADO', usuarioLogado());
        if(USUARIO_LOGADO) {
            redirect('area');
		}	
		define('BASE_URL', base_url());
		$this->load->model('mod_usuario');
	}	

	public function index(){
		$this->load->view('login');
	}

	public function entrar(){
		$email = $this->input->post('email');
		$senha = $this->input->post('senha');
		$usuario = $this->mod_usuario->getUsuario($email, $senha);
		if($usuario){
			$sessao = array(
                'usuario_id' => $usuario['usuario_id'],
				'nome_usuario' => $usuario['nome'],
				'email_usuario' => $usuario['email'],
				'nivel_usuario' => $usuario['nivel'],
				'aluno_ra' => (!$usuario['aluno_ra'] == null ) ? $usuario['aluno_ra'] : null,
                'usuario_logado' => true
			);			
			setSessao($sessao);
			$data['sucesso'] = true;
		}else{
			$data['sucesso'] = false;			
		}
		echo json_encode($data);
	}
}
