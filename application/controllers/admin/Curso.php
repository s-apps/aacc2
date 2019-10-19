<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Curso extends CI_Controller {
    
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
        $this->load->model('admin/mod_curso');
    }

    public function index(){
        $this->load->view('admin/curso');
    }

    public function listar() {
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $search = $this->input->get('search');
        $total = $this->mod_curso->listar($limit, $offset, $sort, $order, $search, true);
        $cursos = $this->mod_curso->listar($limit, $offset, $sort, $order, $search);
        $data = array('total' => $total, 'cursos' => $cursos);
        echo json_encode($data);
    }    

    public function adicionar(){
        $data['acao'] = 'adicionar';
        $this->load->view('admin/formulario-curso', $data);
    }

    public function salvar() {
        $acao = $this->input->post('acao');
        $curso = $this->input->post('curso');
        $curso_id = ($acao == 'editar') ? $this->input->post('curso_id') : 0;
        $data['sucesso'] = $this->mod_curso->salvar($acao, $curso_id, $curso);
        echo json_encode($data);
    }    

    public function editar($curso_id){
        $data['acao'] = 'editar';
        $data['curso'] = $this->mod_curso->getById($curso_id);
        $this->load->view('admin/formulario-curso', $data);
    }        

    public function excluir(){
        $ids = $this->input->post('ids');
        $data['sucesso'] = $this->mod_curso->excluir($ids);
        echo json_encode($data);
    }    
}