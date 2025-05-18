<?php
class Cupom_model extends CI_Model {
    public function get_by_codigo($codigo) {
        return $this->db->get_where('cupons', ['codigo' => $codigo])->row();
    }

    public function validar_cupom($codigo, $subtotal) {
        $cupom = $this->db->get_where('cupons', ['codigo' => $codigo])->row();
        
        if(!$cupom) return false;
        
        // Verifica validade
        if(strtotime($cupom->data_validade) < time()) {
            return false;
        }
        
        // Verifica valor mínimo
        if($subtotal < $cupom->valor_minimo) {
            return false;
        }
        
        // Verifica utilizações máximas
        if($cupom->max_utilizacoes !== null && $cupom->utilizacoes >= $cupom->max_utilizacoes) {
            return false;
        }
        
        return $cupom;
    }

    public function registrar_uso($id) {
        $this->db->set('utilizacoes', 'utilizacoes + 1', false)
                ->where('id', $id)
                ->update('cupons');
    }

    public function get_all() {
        return $this->db->get('cupons')->result();
    }

    
    public function create($data) {
        return $this->db->insert('cupons', $data);
    }

   
    public function delete($id) {
        return $this->db->delete('cupons', ['id' => $id]);
    }

  
   

}