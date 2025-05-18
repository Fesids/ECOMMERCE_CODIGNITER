<?php
class Cart extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Product_model');
        $this->load->model('Estoque_model');
        $this->load->model('Pedido_model');
         $this->load->model('Cupom_model');
    }

   
    public function add($product_id) {
        $product = $this->Product_model->get_product_with_variations($product_id);
        $variacao = $this->input->post('variacao');
        $tamanho = $this->input->post('tamanho');
        $quantidade = $this->input->post('quantidade') ?? 1;
        
        $estoque = $this->Estoque_model->get_variation_stock($product_id, $variacao, $tamanho);
        
        if($estoque && $estoque->quantidade >= $quantidade) {
            $cart = $this->session->userdata('cart') ?? [];
            
            $key = $this->find_cart_item($cart, $product_id, $variacao, $tamanho);
            
            if($key !== false) {
                $cart[$key]['quantidade'] += $quantidade;
            } else {
                $cart[] = [
                    'id' => $product_id,
                    'nome' => $product->nome,
                    'preco' => $product->preco,
                    'variacao' => $variacao,
                    'tamanho' => $tamanho,
                    'quantidade' => $quantidade
                ];
            }
            
            $this->session->set_userdata('cart', $cart);
            $this->Estoque_model->decrement_stock($product_id, $variacao, $tamanho, $quantidade);
        } else {
            $this->session->set_flashdata('error', 'Quantidade indisponível em estoque');
        }
        
        redirect('cart');
    }

  
    

    private function find_cart_item($cart, $product_id, $variacao, $tamanho) {
        foreach($cart as $key => $item) {
            if($item['id'] == $product_id && 
               $item['variacao'] == $variacao && 
               $item['tamanho'] == $tamanho) {
                return $key;
            }
        }
        return false;
    }



    public function view() {
        $cart = $this->session->userdata('cart') ?? [];
        
        // calcular valores
        $data['subtotal'] = $this->calculate_subtotal($cart);
        $data['frete'] = $this->calculate_frete($data['subtotal']);
        $data['total'] = $data['subtotal'] + $data['frete'];
        $data['cart_items'] = $cart;
        
        $this->load->view('cart/view', $data);
    }

    private function calculate_subtotal($cart) {
        return array_reduce($cart, function($total, $item) {
            return $total + ($item['preco'] * $item['quantidade']);
        }, 0);
    }

    private function calculate_frete($subtotal) {
        if ($subtotal >= 52 && $subtotal <= 166.59) {
            return 15.00;
        } elseif ($subtotal > 200) {
            return 0;
        } else {
            return 20.00;
        }
    }

    public function update() {
        $quantities = $this->input->post('quantidade');
        $cart = $this->session->userdata('cart');
        
        foreach($quantities as $key => $qty) {
            if(isset($cart[$key])) {
                $old_qty = $cart[$key]['quantidade'];
                $cart[$key]['quantidade'] = $qty;
                
                // Atualizar estoque
                $this->Estoque_model->adjust_stock(
                    $cart[$key]['id'],
                    $cart[$key]['variacao'],
                    $cart[$key]['tamanho'],
                    $qty - $old_qty
                );
            }
        }
        
        $this->session->set_userdata('cart', $cart);
        redirect('cart');
    }

    public function remove($index) {
        $cart = $this->session->userdata('cart');
        
        if(isset($cart[$index])) {
            // Restaurar estoque
            $this->Estoque_model->increment_stock(
                $cart[$index]['id'],
                $cart[$index]['variacao'],
                $cart[$index]['tamanho'],
                $cart[$index]['quantidade']
            );
            
            unset($cart[$index]);
            $this->session->set_userdata('cart', array_values($cart));
        }
        
        redirect('cart');
    }


    public function aplicar_cupom() {
        $this->load->library('form_validation');
        $this->form_validation->set_rules('codigo', 'Código do Cupom', 'required');
        
        if($this->form_validation->run()) {
            $codigo = $this->input->post('codigo');
            $cart = $this->session->userdata('cart') ?? [];
            $subtotal = $this->calculate_subtotal($cart);
            
            $cupom = $this->Cupom_model->validar_cupom($codigo, $subtotal);
            
            if($cupom) {
                $this->session->set_userdata('cupom_aplicado', $cupom);
                $this->session->set_flashdata('success', 'Cupom aplicado com sucesso!');
            } else {
                $this->session->set_flashdata('error', 'Cupom inválido, expirado ou não atende aos requisitos');
            }
        } else {
            $this->session->set_flashdata('error', validation_errors());
        }
        
        redirect('cart');
    }

    public function remover_cupom() {
        $this->session->unset_userdata('cupom_aplicado');
        redirect('cart');
    }

    private function calculate_discount($subtotal, $cupom) {
        if(!$cupom) return 0;
        
        if($cupom->tipo == 'porcentagem') {
            return $subtotal * ($cupom->valor / 100);
        }
        return min($cupom->valor, $subtotal);
    }
}