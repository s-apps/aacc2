<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

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
        $this->load->model('admin/mod_dashboard');        
    }

    public function index(){
       $this->load->view('admin/dashboard');
    }

    public function listarAvisos() {
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $search = $this->input->get('search');
        $total = $this->mod_dashboard->listarAvisos($limit, $offset, $sort, $order, $search, true);
        $avisos = $this->mod_dashboard->listarAvisos($limit, $offset, $sort, $order, $search);
        $data = array('total' => $total, 'avisos' => $avisos);
        echo json_encode($data);
    }

    public function limiteDeHorasAtividades(){
        $data = $this->mod_dashboard->limiteDeHorasAtividades();
        echo json_encode($data);
    }

    public function setLimiteDeHorasAtividades(){
        $limite = $this->input->post('limite');
        $data['sucesso'] = $this->mod_dashboard->setLimiteDeHorasAtividades($limite);
        echo json_encode($data);
    }

    public function salvarAviso() {
        $acao = $this->input->post('acao');
        $data_aviso = viewToMysql($this->input->post('data_aviso'));
        $aviso_id = ($acao == 'editar') ? $this->input->post('aviso_id') : 0;
        $titulo = $this->input->post('titulo');
        $aviso = $this->input->post('aviso');
        $data['sucesso'] = $this->mod_dashboard->salvarAviso($acao, $data_aviso, $titulo, $aviso, $aviso_id);
        echo json_encode($data);
    }

    public function editarAviso($aviso_id) {
        $data['aviso'] = $this->mod_dashboard->getAvisoById($aviso_id);
        echo json_encode($data);
    }

    public function excluirAviso() {
        $ids = $this->input->post('ids');
        $data['sucesso'] = $this->mod_dashboard->excluirAviso($ids);
        echo json_encode($data);
    }    
}