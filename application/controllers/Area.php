<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Area extends CI_Controller {

    public function index(){
        $this->load->helper('sessao_usuario');
        if(usuarioLogado()){
            if(getNivel() == 0){
                redirect('admin/dashboard');
            }else{
                redirect('aluno/dashboard');
            }
        }else{
            redirect('login');
        }
    }

}