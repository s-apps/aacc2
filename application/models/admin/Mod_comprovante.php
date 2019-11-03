<?php

class Mod_comprovante extends CI_Model {

    public function listar($limit, $offset, $sort, $order, $search, $total = false){
        if(!empty($search)){
             $this->db->where("(comprovante LIKE '%$search%')", null, false);
        }
        if($total){
            return $this->db->count_all_results('comprovante');    
        }
	    $this->db->order_by($sort, $order);
        return $this->db->get('comprovante', $limit, $offset)->result_array();
    }

    public function salvar($acao, $comprovante_id, $comprovante){
        if($acao == 'adicionar'){
            $this->db->where('comprovante', $comprovante);
            $num_rows = $this->db->count_all_results('comprovante');
            if($num_rows == 0){
                $this->db->set('comprovante', $comprovante);
                $this->db->insert('comprovante');
                return $this->db->affected_rows();
            }                
        }elseif($acao == 'editar'){
            $this->db->select('comprovante_id, comprovante');
            $this->db->where('comprovante', $comprovante);
            $resultado = $this->db->get('comprovante')->row_array();
            if($resultado['comprovante_id'] == $comprovante_id && $resultado['comprovante'] == $comprovante){
                return true;
            }else{
                $this->db->select('comprovante');
                $this->db->where('comprovante', $comprovante);
                $num_rows = $this->db->count_all_results('comprovante');
                if($num_rows == 0){
                    $this->db->set('comprovante', $comprovante);
                    $this->db->where('comprovante_id', $comprovante_id);
                    return $this->db->update('comprovante');
                }
            }
        }
        return false;
    }

    public function getById($comprovante_id){
        $this->db->where('comprovante_id', $comprovante_id);
        return $this->db->get('comprovante')->row_array();
    }

    public function getAll(){
        return $this->db->get("comprovante")->result_array();
    }    

    public function excluir($ids){
        $this->db->where_in('comprovante_id', $ids);
        $this->db->delete('comprovante');
        return $this->db->affected_rows();
    }

    public function getComprovanteByModalidade($modalidade_id){
        $this->db->select('comprovante.*');
        $this->db->join('comprovante', 'comprovante.comprovante_id = modalidade.comprovante_id');
        $this->db->where('modalidade.modalidade_id', $modalidade_id);
        return $this->db->get('modalidade')->row_array();
    }

}
