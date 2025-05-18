<?php
class Pedido_model extends CI_Model {
    /*public function create_order($cart_items, $customer_data) {
        $this->db->trans_start();
        
        
        $order_data = [
            'total' => $this->calculate_total($cart_items),
            'status' => 'pendente',
            'cliente_nome' => $customer_data['nome'],
            'cliente_email' => $customer_data['email'],
            
        ];
        
        $this->db->insert('pedidos', $order_data);
        $order_id = $this->db->insert_id();
        
        
        foreach($cart_items as $item) {
            $this->db->insert('pedido_itens', [
                'pedido_id' => $order_id,
                'produto_id' => $item['id'],
                'variacao' => $item['variacao'],
                #'tamanho' => $item['tamanho'],
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $item['preco']
            ]);
        }
        
        $this->db->trans_complete();
        return $order_id;
    }

    public function get_order($order_id) {
        $order = $this->db->get_where('pedidos', ['id' => $order_id])->row();
        
        if($order) {
            $order->itens = $this->db->get_where('pedido_itens', ['pedido_id' => $order_id])->result();
        }
        
        return $order;
    }*/

    private function calculate_total($cart_items) {
        $total = 0;
        foreach($cart_items as $item) {
            $total += $item['preco'] * $item['quantidade'];
        }
        return $total;
    }




      public function create_order($cart_items, $customer_data) {
        $this->db->trans_start();
        
        // Calcular totais
        $subtotal = array_reduce($cart_items, function($total, $item) {
            return $total + ($item['preco'] * $item['quantidade']);
        }, 0);
        
        $cupom = $this->session->userdata('cupom_aplicado');
        $desconto = $this->calculate_discount($subtotal, $cupom);
        $frete = $this->calculate_frete($subtotal);
        
        // Criar pedido principal
        $pedido_data = [
            'total' => $subtotal - $desconto + $frete,
            'subtotal' => $subtotal,
            'desconto' => $desconto,
            'frete' => $frete,
            'cupom_id' => $cupom ? $cupom->id : null,
            'status' => 'pendente',
            'cliente_nome' => $customer_data['nome'],
            'cliente_email' => $customer_data['email'],
            'cep' => $customer_data['cep'],
            'logradouro' => $customer_data['logradouro'],
            'numero' => $customer_data['numero'],
            'complemento' => $customer_data['complemento'],
            'bairro' => $customer_data['bairro'],
            'cidade' => $customer_data['cidade'],
            'uf' => $customer_data['uf'],
            'created_at' => date('Y-m-d H:i:s')
        ];
        
        $this->db->insert('pedidos', $pedido_data);
        $pedido_id = $this->db->insert_id();
        
        // Adicionar itens do pedido
        foreach($cart_items as $item) {
            $item_data = [
                'pedido_id' => $pedido_id,
                'produto_id' => $item['id'],
                'produto_nome' => $item['nome'],
                'variacao' => $item['variacao'],
                'tamanho' => $item['tamanho'],
                'quantidade' => $item['quantidade'],
                'preco_unitario' => $item['preco'],
                'subtotal' => $item['preco'] * $item['quantidade']
            ];
            $this->db->insert('pedido_itens', $item_data);
        }
        
        $this->db->trans_complete();
        
        if($this->db->trans_status() === FALSE) {
            return false;
        }
        
        return $pedido_id;
    }

    private function calculate_discount($subtotal, $cupom) {
        if(!$cupom) return 0;
        
        if($cupom->tipo == 'porcentagem') {
            return $subtotal * ($cupom->valor / 100);
        }
        return min($cupom->valor, $subtotal);
    }

    private function calculate_frete($subtotal) {
        if($subtotal >= 52 && $subtotal <= 166.59) {
            return 15.00;
        } elseif($subtotal > 200) {
            return 0;
        }
        return 20.00;
    }

    public function get_order($pedido_id) {
        $pedido = $this->db->get_where('pedidos', ['id' => $pedido_id])->row();
        
        if($pedido) {
            $pedido->itens = $this->db->get_where('pedido_itens', ['pedido_id' => $pedido_id])->result();
        }
        
        return $pedido;
    }




}