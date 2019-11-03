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
        $this->load->model('admin/mod_aluno');
        $this->load->model('admin/mod_categoria');
        $this->load->model('admin/mod_modalidade');
        $this->load->model('admin/mod_comprovante');
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

    public function adicionar(){
        $data['acao'] = 'adicionar';
        $data['alunos'] = $this->mod_aluno->getAll();
        $data['categorias'] = $this->mod_categoria->getAll();
        // $data['modalidades'] = $this->mod_modalidade->getAll();
        // $data['comprovantes'] = $this->mod_comprovante->getAll();
        $this->load->view('admin/formulario-atividade', $data);
    }

    public function getModalidadesByCategoria($categoria_id){
        $data['modalidades'] = $this->mod_modalidade->getByCategoria($categoria_id);
        echo json_encode($data);
    }

    public function getComprovanteByModalidade($modalidade_id){
        $data['comprovante'] = $this->mod_comprovante->getComprovanteByModalidade($modalidade_id);
        echo json_encode($data);
    }

}