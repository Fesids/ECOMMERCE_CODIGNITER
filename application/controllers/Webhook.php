<?php
class Webhook extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Pedido_model');
        $this->load->model('Estoque_model');
    }

    public function atualizar_pedido() {
        $input = json_decode(file_get_contents('php://input'), true);
        
        if(!$this->validate_webhook($input)) {
            http_response_code(400);
            exit;
        }

        $pedido = $this->Pedido_model->get_order($input['id']);
        
        if($input['status'] == 'cancelado') {
            $this->restaurar_estoque($pedido);
            $this->Pedido_model->delete_order($pedido->id);
        } else {
            $this->Pedido_model->update_order_status($pedido->id, $input['status']);
        }
        
        http_response_code(200);
    }

    private function validar_webhook($input) {
        return isset($input['id']) && isset($input['status']);
    }

    private function restaurar_estoque($pedido) {
        foreach($pedido->itens as $item) {
            $this->Estoque_model->increment_stock(
                $item->produto_id,
                $item->variacao,
                $item->tamanho,
                $item->quantidade
            );
        }
    }
}