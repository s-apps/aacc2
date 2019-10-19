<?php

class Mod_modalidade extends CI_Model {

    public function listar($limit, $offset, $sort, $order, $search, $total = false){
        if(!empty($search)){
             $this->db->where("(modalidade LIKE '%$search%')", null, false);
        }
        if($total){
            return $this->db->count_all_results('modalidade');    
        }
	    $this->db->order_by($sort, $order);
        return $this->db->get('modalidade', $limit, $offset)->result_array();
    }

    public function salvar($acao, $modalidade_id, $categoria_id, $modalidade, $duracao, $limite, $comprovante_id){
        if($acao == 'adicionar'){
            $this->db->where('modalidade', $modalidade);
            $num_rows = $this->db->count_all_results('modalidade');
            if($num_rows == 0){
                $this->db->set('modalidade', $modalidade);
                $this->db->set('categoria_id', $categoria_id);
                $this->db->set('duracao', date('h:i', strtotime($duracao)));
                $this->db->set('limite', $limite);
                $this->db->set('comprovante_id', $comprovante_id);
                return $this->db->insert('modalidade');
            }
        }elseif($acao == 'editar'){
            $this->db->select('modalidade_id, modalidade');
            $this->db->where('modalidade', $modalidade);
            $resultado = $this->db->get('modalidade')->row_array();
            if($resultado['modalidade_id'] == $modalidade_id && $resultado['modalidade'] == $modalidade){
                $this->db->set('modalidade', $modalidade);
                $this->db->set('categoria_id', $categoria_id);
                $this->db->set('duracao', $duracao);
                $this->db->set('limite', $limite);
                $this->db->set('comprovante_id', $comprovante_id);
                $this->db->where('modalidade_id', $modalidade_id);
                return $this->db->update('modalidade');
            }else{
                $this->db->select('modalidade');
                $this->db->where('modalidade', $modalidade);
                $num_rows = $this->db->count_all_results('modalidade');
                if($num_rows == 0){
                    $this->db->set('modalidade', $modalidade);
                    $this->db->set('categoria_id', $categoria_id);
                    $this->db->set('duracao', $duracao);
                    $this->db->set('limite', $limite);
                    $this->db->set('comprovante_id', $comprovante_id);
                    $this->db->where('modalidade_id', $modalidade_id);
                    return $this->db->update('modalidade');
                }
            }
        }
        return false;
    }
    
    public function getById($modalidade_id){
        $this->db->where('modalidade_id', $modalidade_id);
        return $this->db->get('modalidade')->row_array();
    }

    public function getByCategoria($categoria_id){
        $this->db->select('modalidade_id, modalidade');
        $this->db->where('categoria_id', $categoria_id);
        return $this->db->get('modalidade')->result_array();
    }
    
    public function getAll(){
        $this->db->order_by('modalidade');
        return $this->db->get('modalidade')->result_array();
    }

    public function excluir($ids){
        $this->db->where_in('modalidade_id', $ids);
        $this->db->delete('modalidade');
        return $this->db->affected_rows();
    }    
}
