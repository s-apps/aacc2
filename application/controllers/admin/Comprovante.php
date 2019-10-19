<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Comprovante extends CI_Controller {
    
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
        $this->load->model('admin/mod_comprovante');
    }

    public function index(){
        $this->load->view('admin/comprovante');
    }

    public function listar(){
        $limit = $this->input->get("limit");
        $offset = $this->input->get("offset");
        $sort = $this->input->get("sort");
        $order = $this->input->get("order");
        $search = $this->input->get("search");
        $total = $this->mod_comprovante->listar($limit, $offset, $sort, $order, $search, true);
        $comprovantes = $this->mod_comprovante->listar($limit, $offset, $sort, $order, $search);
        $data = array("total" => $total, "comprovantes" => $comprovantes);
        echo json_encode($data);
    }

    public function adicionar(){
        $data['acao'] = 'adicionar';
        $this->load->view('admin/formulario-comprovante', $data);
    }

    public function editar($comprovante_id){
        $data['acao'] = 'editar';
        $data['comprovante'] = $this->mod_comprovante->getById($comprovante_id);
        $this->load->view('admin/formulario-comprovante', $data);
    }

    public function salvar(){
        $acao = $this->input->post('acao');
        $comprovante = $this->input->post('comprovante');
        $comprovante_id = ($acao == 'editar') ? $this->input->post('comprovante_id') : 0;
        $data['sucesso'] = $this->mod_comprovante->salvar($acao, $comprovante_id, $comprovante);
        echo json_encode($data);
    }    

    public function excluir(){
        $ids = $this->input->post("ids");
        $data["sucesso"] = $this->mod_comprovante->excluir($ids);
        echo json_encode($data);
    }   


}