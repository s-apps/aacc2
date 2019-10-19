<?php

class Mod_curso extends CI_Model {

    public function listar($limit, $offset, $sort, $order, $search, $total = false) {
        if (!empty($search)) {
            $this->db->where("(curso LIKE '%$search%')", null, false);
        }
        if ($total) {
            return $this->db->count_all_results('curso');
        }
        $this->db->order_by($sort, $order);
        return $this->db->get('curso', $limit, $offset)->result_array();
    }

    public function salvar($acao, $curso_id, $curso) {
        if ($acao == 'adicionar') {
            $this->db->where('curso', $curso);
            $num_rows = $this->db->count_all_results('curso');
            if ($num_rows == 0) {
                $this->db->set('curso', $curso);
                return $this->db->insert('curso');
            }
        } elseif ($acao == 'editar') {
            $this->db->select('curso_id, curso');
            $this->db->where('curso', $curso);
            $resultado = $this->db->get('curso')->row_array();
            if ($resultado['curso_id'] == $curso_id && $resultado['curso'] == $curso) {
                return true;
            } else {
                $this->db->select('curso');
                $this->db->where('curso', $curso);
                $num_rows = $this->db->count_all_results('curso');
                if ($num_rows == 0) {
                    $this->db->set('curso', $curso);
                    $this->db->where('curso_id', $curso_id);
                    return $this->db->update('curso');
                }
            }
        }
        return false;
    }

    public function getAll() {
        return $this->db->get('curso')->result_array();
    }
    
    public function getById($curso_id){
        $this->db->where('curso_id', $curso_id);
        return $this->db->get('curso')->row_array();
    }   
    
    public function getByIdProfessor($usuario_id){
        $this->db->select('professor_leciona.curso_id');
        $this->db->join('curso', 'curso.curso_id = professor_leciona.curso_id');
        $this->db->where('professor_id', $usuario_id);
        $cursos = $this->db->get('professor_leciona')->result_array();
        $cursosProfessor = array();
        foreach($cursos as $curso){
            $cursosProfessor[] = $curso['curso_id'];
        }
        return $cursosProfessor;
    }        

    public function salvarExtra($curso) {
        $this->db->where('curso', $curso);
        $num_rows = $this->db->count_all_results('curso');
        if ($num_rows == 0) {
            $this->db->set('curso', $curso);
            $this->db->insert("curso");
            return array('curso_id' => $this->db->insert_id(), 'curso' => $curso);
        }
        return '';
    }
    
    public function excluir($ids){
        $this->db->where_in('curso_id', $ids);
        $this->db->delete('curso');
        return $this->db->affected_rows();
    }
    

}
