<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Aluno extends CI_Controller {

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
        $this->load->model('admin/mod_aluno');
        $this->load->model('admin/mod_curso');
    }

    public function index(){
       $this->load->view('admin/aluno');
    }

    public function listar(){
        $limit = $this->input->get('limit');
        $offset = $this->input->get('offset');
        $sort = $this->input->get('sort');
        $order = $this->input->get('order');
        $search = $this->input->get('search');
        $total = $this->mod_aluno->listar($limit, $offset, $sort, $order, $search, true);
        $alunos = $this->mod_aluno->listar($limit, $offset, $sort, $order, $search);
        $data = array('total' => $total, 'alunos' => $alunos);
        echo json_encode($data);
    }     
    
    public function adicionar(){
        $data['acao'] = 'adicionar';
        $data['cursos'] = $this->mod_curso->getAll();
        $this->load->view('admin/formulario-aluno', $data);
    }

    public function editar($usuario_id){
        $data["acao"] = "editar";
        $data["usuario"] = $this->mod_aluno->getById($usuario_id);
        $data["cursos"] = $this->mod_curso->getAll();
        $this->load->view("admin/formulario-aluno", $data);
    }      

    public function salvar(){
        $acao = $this->input->post('acao');
        $nome = $this->input->post('nome');
        $email = $this->input->post('email');
        $senha = md5($this->input->post('senha'));
        $aluno_ra = $this->input->post('aluno_ra');
        $curso_id = $this->input->post('curso_id');
        $usuario_id = ($acao == 'editar') ? $this->input->post('usuario_id') : 0;
        $data['sucesso'] = $this->mod_aluno->salvar($acao, $aluno_ra, $usuario_id, $nome, $email, $senha, $curso_id);
        echo json_encode($data);
    }

    public function excluir(){
        $ids = $this->input->post('ids');
        $data['sucesso'] = $this->mod_aluno->excluir($ids);
        echo json_encode($data);
    }    

}