<?php

class Mod_atividade extends CI_Model {

    public function listar($limit, $offset, $sort, $order, $search, $total = false) {
        $this->db->join('usuario', 'usuario.aluno_ra = atividade.aluno_ra');
        $this->db->join('modalidade', 'modalidade.modalidade_id = atividade.modalidade_id');
        if (!empty($search)) {
            $this->db->where("(aluno_ra LIKE '%$search%' OR usuario.nome LIKE '%$search%' OR usuario.email LIKE '%$search%')", null, false);
        }
        if ($total) {
            return $this->db->count_all_results('atividade');
        }
        $this->db->order_by($sort, $order);
        $atividades = $this->db->get('atividade', $limit, $offset)->result_array();
        foreach ($atividades as &$atividade) {
            $atividade['data'] = mysqlToView($atividade['data']);
        }
        return $atividades;
    }

    public function salvar($acao, $atividade_id, $data_atividade, $horas_inicio, $horas_termino, $aluno_ra, $atividade, $validacao, $categoria_id, $modalidade_id, $comprovante_id, $imagem_comprovante){
        $explode1 = explode(':', $horas_inicio);
        $explode2 = explode(':', $horas_termino);
        $h1 = $explode1[0];
        $m1 = $explode1[1];
        $h2 = $explode2[0];
        $m2 = $explode2[1];
        $t1 = ($h1 * 60) + $m1;
        $t2 = ($h2 * 60) + $m2;
        $t3 = $t2 - $t1;
        $t4 = floor($t3/60);
        $t5 = $t3 - ($t4*60);      
        $carga_horaria = sprintf('%02d:%02d', $t4, $t5);        

        if($acao == 'adicionar'){
            $this->db->where("atividade", $atividade);
            $num_rows = $this->db->count_all_results('atividade');
            if($num_rows == 0){
                $this->db->set('data', viewToMysql($data_atividade));
                $this->db->set('carga_horaria', $carga_horaria);
                $this->db->set('horas_inicio', $horas_inicio);
                $this->db->set('horas_termino', $horas_termino);
                $this->db->set('atividade', $atividade);
                $this->db->set('aluno_ra', $aluno_ra);
                $this->db->set('categoria_id', $categoria_id);
                $this->db->set('modalidade_id', $modalidade_id);
                $this->db->set('comprovante_id', $comprovante_id);
                $this->db->set('imagem_comprovante', $imagem_comprovante);
                $this->db->set('validacao', $validacao);   
                if($this->db->insert('atividade')){
                    return '';
                }else{
                    return 'Atividade já existe';
                }           
            }
        }elseif($acao == 'editar'){

        }
    }

    public function getById($atividade_id){
        $this->db->join('usuario', 'usuario.aluno_ra = atividade.aluno_ra');
        $this->db->where('atividade.atividade_id', $atividade_id);
        return $this->db->get('atividade')->row_array();
    }

  

}
