<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Professor extends CI_Controller {

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
        $this->load->model('admin/mod_professor');
        $this->load->model('admin/mod_curso');
    }

    public function index(){
       $this->load->view('admin/professor');
    }
    
    public function listar() {
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $search = $this->input->get('search');
        $total = $this->mod_professor->listar($limit, $offset, $sort, $order, $search, true);
        $professores = $this->mod_professor->listar($limit, $offset, $sort, $order, $search);
        $data = array('total' => $total, 'professores' => $professores);
        echo json_encode($data);
    }    

    public function adicionar(){
        $data['acao'] = 'adicionar';
        $data['cursos'] = $this->mod_curso->getAll();
        $this->load->view('admin/formulario-professor', $data);
    }

    public function editar($usuario_id){
        $data['acao'] = 'editar';
        $data['usuario'] = $this->mod_professor->getById($usuario_id);
        $data['cursos'] = $this->mod_curso->getAll();
        $data['cursosProfessor'] = $this->mod_curso->getByIdProfessor($usuario_id);
        $this->load->view('admin/formulario-professor', $data);
    }    

    public function salvar(){
        $acao = $this->input->post('acao');
        $nome = $this->input->post('nome');
        $email = $this->input->post('email');
        $senha = md5($this->input->post('senha'));
        $usuario_id = ($acao == 'editar') ? $this->input->post('usuario_id') : 0;
        $cursos = $this->input->post('cursos');
        $data['sucesso'] = $this->mod_professor->salvar($acao, $usuario_id, $nome, $email, $senha, $cursos);
        echo json_encode($data);
    }

    public function excluir(){
        $ids = $this->input->post('ids');
        $data['sucesso'] = $this->mod_professor->excluir($ids);
        echo json_encode($data);
    }    
        
}
