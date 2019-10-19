<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Modalidade extends CI_Controller {

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
        $this->load->model('admin/mod_modalidade');
        $this->load->model('admin/mod_categoria');
        $this->load->model('admin/mod_comprovante');
    }

    public function index(){
       $this->load->view('admin/modalidade');
    }

    public function listar(){
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $search = $this->input->get('search');
        $total = $this->mod_modalidade->listar($limit, $offset, $sort, $order, $search, true);
        $modalidades = $this->mod_modalidade->listar($limit, $offset, $sort, $order, $search);
        $data = array('total' => $total, 'modalidades' => $modalidades);
        echo json_encode($data);
    }    

    public function adicionar(){
        $data['acao'] = 'adicionar';
        $data['categorias'] = $this->mod_categoria->getAll();
        $data['comprovantes'] = $this->mod_comprovante->getAll();
        $this->load->view('admin/formulario-modalidade', $data);
    }

    public function editar($modalidade_id){
        $data['acao'] = 'editar';
        $data['modalidade'] = $this->mod_modalidade->getById($modalidade_id);
        $data['categorias'] = $this->mod_categoria->getAll();
        $data['comprovantes'] = $this->mod_comprovante->getAll();
        $this->load->view('admin/formulario-modalidade', $data);
    }    

    public function salvar(){
        $acao = $this->input->post('acao');
        $categoria_id = $this->input->post('categoria_id');
        $modalidade = $this->input->post('modalidade');
        $duracao = $this->input->post('duracao');
        $limite = $this->input->post('limite');
        $comprovante_id = $this->input->post('comprovante_id');
        $modalidade_id = $this->input->post('modalidade_id');
        $data['sucesso'] = $this->mod_modalidade->salvar($acao, $modalidade_id, $categoria_id, $modalidade, $duracao, $limite, $comprovante_id);
        echo json_encode($data);
    }    

    public function excluir(){
        $ids = $this->input->post('ids');
        $data['sucesso'] = $this->mod_modalidade->excluir($ids);
        echo json_encode($data);
    }     

}