<?php
class Estoque_model extends CI_Model {
    public function __construct(){

        parent::__construct();

        $this->load->database();
    }

     public function create($data) {
        return $this->db->insert('estoque', $data);
    }



    public function decrement($product_id, $quantidade) {
        $this->db->set('quantidade', "quantidade - $quantidade", false);
        $this->db->where('produto_id', $product_id);
        $this->db->update('estoque');
    }

    public function increment($product_id, $quantidade) {
        $this->db->set('quantidade', "quantidade + $quantidade", false);
        $this->db->where('produto_id', $product_id);
        $this->db->update('estoque');
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('estoque', $data);
    }

    public function update_product_total($product_id) {
    $total = $this->db->select_sum('quantidade')
                      ->where('produto_id', $product_id)
                      ->get('estoque')
                      ->row()->quantidade;
    
    $this->db->where('id', $product_id)
             ->update('produtos', ['quantidade_total' => $total ?: 0]);
    }


    public function get_by_product($product_id) {
          # return $this->db->get_where('estoque', ['produto_id' => $product_id])->row();
        return $this->db->get_where('estoque', ['produto_id' => $product_id])->result();
    }
    
    public function update_variation($product_id, $variation, $quantity) {
        // Verifica se já existe
        $existing = $this->db->get_where('estoque', [
            'produto_id' => $product_id,
            'variacao' => $variation
        ])->row();
        
        if($existing) {
            // Atualiza
            return $this->db->where('id', $existing->id)
                         ->update('estoque', ['quantidade' => $quantity]);
        } else {
            // Cria nova
            return $this->db->insert('estoque', [
                'produto_id' => $product_id,
                'variacao' => $variation,
                'quantidade' => $quantity
            ]);
        }
    }

    public function get_variation_stock($product_id, $variacao, $tamanho) {
    return $this->db->get_where('estoque', [
        'produto_id' => $product_id,
        'variacao' => $variacao,
            'tamanho' => $tamanho
        ])->row();
    }



    public function adjust_stock($product_id, $variacao, $tamanho, $difference) {
    $this->db->set('quantidade', "quantidade + ($difference)", false)
             ->where('produto_id', $product_id)
             ->where('variacao', $variacao)
             ->where('tamanho', $tamanho)
             ->update('estoque');
    }

    public function increment_stock($product_id, $variacao, $tamanho, $quantidade) {
        $this->adjust_stock($product_id, $variacao, $tamanho, $quantidade);
    }

    public function decrement_stock($product_id, $variacao, $tamanho, $quantidade) {
        $this->adjust_stock($product_id, $variacao, $tamanho, -$quantidade);
    }
}