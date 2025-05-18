<?php

class Product_model extends CI_Model {
    public function create($data) {
        $this->db->insert('produtos', $data);
        return $this->db->insert_id();
    }

    public function update($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('produtos', $data);
    }

    public function get_all() {
        //return $this->db->get('produtos')->result();
       
        $products = $this->db->get('produtos')->result();
        
        foreach($products as $product) {
            $product->variacoes = $this->db->get_where('estoque', [
                'produto_id' => $product->id
            ])->result() ?? [];
        }
        
        return $products;

    }

    public function get($id) {
        return $this->db->get_where('produtos', ['id' => $id])->row();
    }

     public function create_product($product_data, $variations) {
        $this->db->trans_start();
        
        
        $this->db->insert('produtos', $product_data);
        $product_id = $this->db->insert_id();
        
        // variações mo stock
        foreach($variations as $variation) {
            $this->db->insert('estoque', [
                'produto_id' => $product_id,
                'variacao' => $variation['cor'],
                'tamanho' => $variation['tamanho'],
                'quantidade' => $variation['estoque']
            ]);
        }
        
        $this->db->trans_complete();
        return $this->db->trans_status();
    }

    public function get_product_with_variations($product_id) {
        $product = $this->db->get_where('produtos', ['id' => $product_id])->row();
        
        if($product) {
            $product->variacoes = $this->db->get_where('estoque', ['produto_id' => $product_id])->result();
        }
        
        return $product;
    }
}