<?php

class Mod_categoria extends CI_Model {

    public function listar($limit, $offset, $sort, $order, $search, $total = false){
        if(!empty($search)){
             $this->db->where("(categoria LIKE '%$search%')", null, false);
        }
        if($total){
            return $this->db->count_all_results('categoria');    
        }
	    $this->db->order_by($sort, $order);
        return $this->db->get('categoria', $limit, $offset)->result_array();
    }

    public function salvar($acao, $categoria_id, $categoria){
        if($acao == 'adicionar'){
            $this->db->where('categoria', $categoria);
            $num_rows = $this->db->count_all_results('categoria');
            if($num_rows == 0){
                $this->db->set('categoria', $categoria);
                $this->db->insert('categoria');
                return $this->db->affected_rows();
            }                
        }elseif($acao == 'editar'){
            $this->db->select('categoria_id, categoria');
            $this->db->where('categoria', $categoria);
            $resultado = $this->db->get('categoria')->row_array();
            if($resultado['categoria_id'] == $categoria_id && $resultado['categoria'] == $categoria){
                return true;
            }else{
                $this->db->select('categoria');
                $this->db->where('categoria', $categoria);
                $num_rows = $this->db->count_all_results('categoria');
                if($num_rows == 0){
                    $this->db->set('categoria', $categoria);
                    $this->db->where('categoria_id', $categoria_id);
                    return $this->db->update('categoria');
                }
            }
        }
        return false;
    }

    public function salvarExtra($categoria){
        $this->db->where('categoria', $categoria);
        $num_rows = $this->db->count_all_results('categoria');
        if($num_rows == 0){
            $this->db->set('categoria', $categoria);
            $this->db->insert('categoria');
            return array('categoria_id' => $this->db->insert_id(), 'categoria' => $categoria);
        }  
        return '';
    }      

    public function getById($categoria_id){
        $this->db->where('categoria_id', $categoria_id);
        return $this->db->get('categoria')->row_array();
    }

    public function getAll(){
        return $this->db->get("categoria")->result_array();
    }    

    public function excluir($ids){
        $this->db->where_in('categoria_id', $ids);
        $this->db->delete('categoria');
        return $this->db->affected_rows();
    }


}