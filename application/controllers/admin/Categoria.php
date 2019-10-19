<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Categoria extends CI_Controller {
    
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
        $this->load->model('admin/mod_categoria');
    }

    public function index(){
        $this->load->view('admin/categoria');
    }

    public function listar(){
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $search = $this->input->get('search');
        $total = $this->mod_categoria->listar($limit, $offset, $sort, $order, $search, true);
        $categorias = $this->mod_categoria->listar($limit, $offset, $sort, $order, $search);
        $data = array('total' => $total, 'categorias' => $categorias);
        echo json_encode($data);
    }

    public function adicionar(){
        $data['acao'] = 'adicionar';
        $this->load->view('admin/formulario-categoria', $data);
    }

    public function editar($categoria_id){
        $data['acao'] = 'editar';
        $data['categoria'] = $this->mod_categoria->getById($categoria_id);
        $this->load->view('admin/formulario-categoria', $data);
    }

    public function salvar(){
        $acao = $this->input->post('acao');
        $categoria = $this->input->post('categoria');
        $categoria_id = ($acao == 'editar') ? $this->input->post('categoria_id') : 0;
        $data['sucesso'] = $this->mod_categoria->salvar($acao, $categoria_id, $categoria);
        echo json_encode($data);
    }

    public function excluir(){
        $ids = $this->input->post('ids');
        $data['sucesso'] = $this->mod_categoria->excluir($ids);
        echo json_encode($data);
    }    

}