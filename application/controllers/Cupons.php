<?php
class Cupons extends CI_Controller {
    public function __construct() {
        parent::__construct();
        $this->load->model('Cupom_model');
        $this->load->helper('form');
    }

    public function index() {
        $data['cupons'] = $this->Cupom_model->get_all();
        $this->load->view('cupons/list', $data);
    }

    public function create() {
        if($this->input->post()) {
            $data = $this->input->post();
            $data['data_validade'] = date('Y-m-d', strtotime($data['data_validade']));
            
            if(empty($data['max_utilizacoes'])) {
                $data['max_utilizacoes'] = null;
            }
            
            if($this->Cupom_model->create($data)) {
                $this->session->set_flashdata('success', 'Cupom criado com sucesso!');
                redirect('cupons');
            }
        }
        $this->load->view('cupons/form');
    }

    public function delete($id) {
        if($this->Cupom_model->delete($id)) {
            $this->session->set_flashdata('success', 'Cupom excluído com sucesso!');
        }
        redirect('cupons');
    }
}