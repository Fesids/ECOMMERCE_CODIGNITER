
<?php
class Products extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('Product_model');
        $this->load->model('Estoque_model');
        
    }

    public function index() {
        $data['products'] = $this->Product_model->get_all();
        $this->load->view('products/list', $data);
    }

    
   public function create() {
    if($this->input->post()) {
        $product_data = [
            'nome' => $this->input->post('nome'),
            'preco' => $this->input->post('preco'),
            'descricao' => $this->input->post('descricao')
        ];
        
       
        $variations = [];
        foreach($this->input->post('cores') as $key => $cor) {
            $variations[] = [
                'cor' => $cor,
                'tamanho' => $this->input->post('tamanhos')[$key],
                'estoque' => $this->input->post('estoque')[$key]
            ];
        }
        
        if($this->Product_model->create_product($product_data, $variations)) {
            redirect('products');
        }
    }
    
        $this->load->view('products/form');
    }

    public function edit($product_id) {
        if ($this->input->post()) {
            // Atualiza produto principal
            $product_data = array(
                'nome' => $this->input->post('nome'),
                'preco' => $this->input->post('preco'),
                'descricao' => $this->input->post('descricao')
            );
            $this->Product_model->update($product_id, $product_data);

            // Processa variações
            foreach($this->input->post('variacoes') as $key => $variacao) {
                $estoque_data = array(
                    'produto_id' => $product_id,
                    'variacao' => $variacao,
                    'tamanho' => $this->input->post('tamanhos')[$key],
                    'quantidade' => $this->input->post('estoque')[$key]
                );

                // Verifica se é uma variação existente ou nova
                $estoque_id = $this->input->post('estoque_id')[$key];
                if($estoque_id != 'new') {
                    
                    $this->Estoque_model->update($estoque_id, $estoque_data);
                } else {
                    
                    $this->Estoque_model->create($estoque_data);
                }
            }

            redirect('products');
        }

        $data['product'] = $this->Product_model->get_product_with_variations($product_id);
        $this->load->view('products/edit_form', $data);
    }

   
}