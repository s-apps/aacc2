<?php

function setSessao($sessao){
    $ci = get_instance();
    $ci->session->set_userdata($sessao);
}

function getSessaoIdUsuario(){
    $ci = get_instance();
    return $ci->session->userdata('usuario_id');
}

function getNomeUsuario(){
    $ci = get_instance();
    return $ci->session->userdata('nome_usuario');
}

function getSessaoAlunoRA(){
    $ci = get_instance();
    return $ci->session->userdata('aluno_ra');
}

function getNivel(){
    $ci = get_instance();
    return $ci->session->userdata('nivel_usuario');
}

function usuarioLogado(){
    $ci = get_instance();
    return $ci->session->userdata('usuario_logado');
}
