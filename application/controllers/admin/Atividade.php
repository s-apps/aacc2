<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Atividade extends CI_Controller {

	public function __construct(){
        parent::__construct();
        $this->load->helper('sessao_usuario');
        define('USUARIO_LOGADO', usuarioLogado());
        if(USUARIO_LOGADO){
            define('USUARIO_NIVEL', getNivel());
            if(USUARIO_NIVEL == 1){
                redirect('aluno/dashboard');
            }
        }else{
            redirect('login');
        }
        define('BASE_URL', base_url());
        define('USUARIO_NOME', getNomeUsuario());
        $this->load->helper('converte_data');
        $this->load->model('admin/mod_atividade');
    }
    
    public function index(){
        $this->load->view('admin/atividade');
    }

    public function listar(){
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $search = $this->input->get('search');
        $total = $this->mod_atividade->listar($limit, $offset, $sort, $order, $search, true);
        $atividades = $this->mod_atividade->listar($limit, $offset, $sort, $order, $search);
        $data = array('total' => $total, 'atividades' => $atividades);
        echo json_encode($data);
    }

}