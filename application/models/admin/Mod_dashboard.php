<?php

class Mod_dashboard extends CI_Model {

    public function listarAvisos($limit, $offset, $sort, $order, $search, $total = false){
        if($total){
            return $this->db->count_all_results('aviso');    
        }
	    $this->db->order_by($sort, $order);
        $avisos = $this->db->get('aviso', $limit, $offset)->result_array();
        foreach($avisos as &$aviso){
            $aviso['data'] = mysqlToView($aviso['data']);
        }
        return $avisos;
    }    

    public function salvarAviso($acao, $data_aviso, $titulo, $aviso, $aviso_id){
        if($acao == 'adicionar'){
            $this->db->set('data', $data_aviso);
            $this->db->set('titulo', $titulo);
            $this->db->set('aviso', $aviso);
            return $this->db->insert('aviso');
        }else{
            $this->db->set('data', $data_aviso);
            $this->db->set('titulo', $titulo);
            $this->db->set('aviso', $aviso);
            $this->db->where('aviso_id', $aviso_id);
            return $this->db->update('aviso');
        }
    }

    public function getAvisoById($aviso_id){
        $this->db->where('aviso_id', $aviso_id);
        $aviso = $this->db->get('aviso')->row_array();
        $aviso['data'] = mysqlToView($aviso['data']);
        return $aviso;
    }

    public function excluirAviso($ids){
        $this->db->where_in('aviso_id', $ids);
        $this->db->delete('aviso');
        return $this->db->affected_rows();
    }    
    
    public function limiteDeHorasAtividades(){
        $this->db->select('horas_atividades');
        $this->db->where('config_id', 'padrao');
        return $this->db->get('limite')->row_array();
    }

    public function setLimiteDeHorasAtividades($limite){
        $this->db->set('horas_atividades', $limite);
        $this->db->where('config_id', 'padrao');
        return $this->db->update('limite');
    }

}