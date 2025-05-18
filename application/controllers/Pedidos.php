<?php
class Pedidos extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Pedido_model');
        $this->load->model('Cupom_model');
        $this->load->library('email');
    }
    
    public function checkout() {
        $data['cart'] = $this->session->userdata('cart') ?? [];
        $this->load->view('pedidos/checkout', $data);
    }

    public function process_checkout() {  
         if(!$this->input->post()) {
            redirect('checkout');
        }

        // Validação
        $this->load->library('form_validation');
        $this->form_validation->set_rules('nome', 'Nome', 'required');
        
        if($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('error', validation_errors());
            redirect('checkout');
        }

      
        $cart = $this->session->userdata('cart') ?? [];
        
       
        if(empty($cart)) {
            $this->session->set_flashdata('error', 'Seu carrinho está vazio');
            redirect('checkout');
        }

        // Processamento do pedido
        $pedido_id = $this->Pedido_model->create_order(
            $cart, 
            $this->input->post(),
            $this->session->userdata('cupom_aplicado')
        );

        if($pedido_id) {
            $this->enviar_email_confirmacao($pedido_id);
           
            $this->session->unset_userdata('cart');
            $this->session->unset_userdata('cupom_aplicado');
            redirect('pedidos/confirmacao/'.$pedido_id);
        } else {
            $this->session->set_flashdata('error', 'Erro ao processar pedido');
            redirect('checkout');
        }
    }

    public function confirmacao($pedido_id) {
        $data['pedido'] = $this->Pedido_model->get_order($pedido_id);
        $this->load->view('pedidos/confirmacao', $data);
    }


    private function enviar_email_confirmacao($pedido_id) {
        $pedido = $this->Pedido_model->get_order($pedido_id);
        
        if (!$pedido) {
            log_message('error', "Pedido não encontrado para ID: $pedido_id");
            return false;
        }

        $config = [
            'protocol'    => 'smtp',
            'smtp_host'   => 'smtp.gmail.com',
            'smtp_port'   => 587,
            'smtp_user'   => 'seuemail@gmail.com',
            'smtp_pass'   => 'sua_chave',
            'smtp_crypto' => 'tls',
            'mailtype'    => 'html',
            'charset'     => 'utf-8',
            'newline'     => "\r\n",
            'smtp_timeout' => 30,
            'debug'       => TRUE  
        ];
        
        $this->email->initialize($config);
        
        $this->email->from('seuemail@gmail.com', 'Loja teste');
        $this->email->to($pedido->cliente_email);
        $this->email->subject('Confirmação de Pedido #'.$pedido->id);
        
        $message = $this->load->view('emails/confirmacao_pedido', ['pedido' => $pedido], TRUE);
        $this->email->message($message);
        
       
        $result = $this->email->send();
        
        if (!$result) {
           
            $debug_messages = $this->email->print_debugger();
            
          
            log_message('error', 'Falha no envio de email: ' . $debug_messages);
            
            
            $error_log = date('Y-m-d H:i:s') . " - Email Error:\n" . $debug_messages . "\n\n";
            file_put_contents(APPPATH . 'logs/email_errors.log', $error_log, FILE_APPEND);
            
            return false;
        }
        
        return true;
    }

    
}