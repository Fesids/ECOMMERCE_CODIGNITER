<?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger alert-dismissible fade show">
        <?= $this->session->flashdata('error') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<?php if($this->session->flashdata('success')): ?>
    <div class="alert alert-success alert-dismissible fade show">
        <?= $this->session->flashdata('success') ?>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
<?php endif; ?>

<head>
    <title>Gerenciar Cupons</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<div class="card checkout-card">
    <div class="card-header bg-primary text-white">
        <h3 class="mb-0"><i class="fas fa-shopping-cart mr-2"></i>Finalizar Compra</h3>
    </div>
    
    <div class="card-body">
        <form method="post" action="<?= site_url('checkout/processar') ?>" id="checkout-form">
           
            <div class="form-section">
                <h5 class="section-title"><i class="fas fa-map-marker-alt mr-2"></i>Endereço de Entrega</h5>
                
                <div class="form-group">
                    <label for="cep">CEP <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="text" id="cep" name="cep" class="form-control" required 
                               placeholder="00000-000" pattern="\d{5}-?\d{3}">
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" id="cep-search-btn">
                                <i class="fas fa-search"></i> Buscar
                            </button>
                        </div>
                    </div>
                    <small class="form-text text-muted">Digite seu CEP para autocompletar o endereço</small>
                </div>
                
               
                <div id="cep-loading" class="text-center my-3" style="display:none;">
                    <div class="spinner-border text-primary" role="status">
                        <span class="sr-only">Buscando CEP...</span>
                    </div>
                    <p class="mt-2">Buscando endereço...</p>
                </div>
                
               
                <div id="cep-error" class="alert alert-danger mt-2" style="display:none;"></div>
                
              
                <div id="endereco_fields" class="address-fields" style="display:none;">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="form-group">
                                <label for="logradouro">Logradouro <span class="text-danger">*</span></label>
                                <input type="text" id="logradouro" name="logradouro" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="numero">Número <span class="text-danger">*</span></label>
                                <input type="text" name="numero" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="complemento">Complemento</label>
                        <input type="text" name="complemento" class="form-control" placeholder="Apto, bloco, etc.">
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="bairro">Bairro <span class="text-danger">*</span></label>
                                <input type="text" id="bairro" name="bairro" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="cidade">Cidade <span class="text-danger">*</span></label>
                                <input type="text" id="cidade" name="cidade" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="uf">Estado <span class="text-danger">*</span></label>
                                <input type="text" id="uf" name="uf" class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="form-section mt-4">
                <h5 class="section-title"><i class="fas fa-user mr-2"></i>Informações Pessoais</h5>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="nome">Nome Completo <span class="text-danger">*</span></label>
                            <input type="text" name="nome" class="form-control" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email">E-mail <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                    </div>
                </div>
            </div>
            
            
            <div class="text-center mt-4">
                <button type="submit" id="submit-btn" class="btn btn-primary btn-lg" style="display:none;">
                    <i class="fas fa-check-circle mr-2"></i>Finalizar Compra
                </button>
            </div>
            
            
            <div id="form-loading" class="text-center my-3" style="display:none;">
                <div class="spinner-border text-primary" role="status">
                    <span class="sr-only">Processando...</span>
                </div>
                <p class="mt-2">Processando seu pedido...</p>
            </div>
        </form>
    </div>
</div>

<style>
.checkout-card {
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    margin-bottom: 30px;
}

.section-title {
    color: #2c3e50;
    border-bottom: 2px solid #f1f1f1;
    padding-bottom: 10px;
    margin-bottom: 20px;
}

.form-section {
    background: #f9f9f9;
    padding: 20px;
    border-radius: 8px;
    margin-bottom: 20px;
}

.address-fields {
    background: #fff;
    padding: 20px;
    border-radius: 8px;
    border: 1px solid #eee;
}

.btn-primary {
    background-color: #3498db;
    border-color: #3498db;
    padding: 10px 30px;
    font-weight: 600;
}

.btn-primary:hover {
    background-color: #2980b9;
    border-color: #2980b9;
}

#cep-error {
    border-radius: 5px;
}

.form-control {
    border-radius: 5px;
    padding: 12px 15px;
}

.input-group-append .btn {
    border-radius: 0 5px 5px 0;
}
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const cepInput = document.getElementById('cep');
        const cepSearchBtn = document.getElementById('cep-search-btn');
        const cepLoading = document.getElementById('cep-loading');
        const cepError = document.getElementById('cep-error');
        const enderecoFields = document.getElementById('endereco_fields');
        const submitBtn = document.getElementById('submit-btn');
        const checkoutForm = document.getElementById('checkout-form');
        const formLoading = document.getElementById('form-loading');
        
        
        cepInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.substring(0,5) + '-' + value.substring(5,8);
            }
            this.value = value;
        });
        
        
        function searchCEP() {
            const cep = cepInput.value.replace(/\D/g, '');
            
            if(cep.length !== 8) {
                showCepError('CEP inválido. Digite 8 números.');
                return;
            }
            
            
            cepLoading.style.display = 'block';
            cepError.style.display = 'none';
            
            fetch(`https://viacep.com.br/ws/${cep}/json/`)
                .then(response => {
                    if(!response.ok) throw new Error('Erro na requisição');
                    return response.json();
                })
                .then(data => {
                    cepLoading.style.display = 'none';
                    
                    if(data.erro) {
                        showCepError('CEP não encontrado. Verifique e tente novamente.');
                        return;
                    }
                    
                    
                    document.getElementById('logradouro').value = data.logradouro || '';
                    document.getElementById('bairro').value = data.bairro || '';
                    document.getElementById('cidade').value = data.localidade || '';
                    document.getElementById('uf').value = data.uf || '';
                    
                    
                    enderecoFields.style.display = 'block';
                    submitBtn.style.display = 'inline-block';
                    
                    
                    document.querySelector('input[name="numero"]').focus();
                })
                .catch(error => {
                    cepLoading.style.display = 'none';
                    showCepError('Erro ao buscar CEP. Tente novamente mais tarde.');
                    console.error('CEP search error:', error);
                });
        }
        
        
        cepSearchBtn.addEventListener('click', searchCEP);
        cepInput.addEventListener('blur', searchCEP);
        
        
        function showCepError(message) {
            cepError.textContent = message;
            cepError.style.display = 'block';
            enderecoFields.style.display = 'none';
            submitBtn.style.display = 'none';
        }
        
        
        checkoutForm.addEventListener('submit', function(e) {
            
            submitBtn.style.display = 'none';
            formLoading.style.display = 'block';
            
            
        });
    });
</script>