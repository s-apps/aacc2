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

  

}
