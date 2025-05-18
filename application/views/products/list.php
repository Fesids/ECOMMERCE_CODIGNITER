<!DOCTYPE html>
<html>
<head>
    <title>Lista de Produtos</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
    <h2>Produtos</h2>
    <a href="<?php echo site_url('products/create'); ?>" class="btn btn-primary mb-3">Novo Produto</a>
    <a href="<?php echo site_url('cupons/create'); ?>" class="btn btn-primary mb-3">Novo Cupom</a>
 
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Produto</th>
                <th>Preço</th>
                <th>Variações/Estoque</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($products as $product): ?>
            <tr>
                <td><?= $product->id ?></td>
                <td><?= $product->nome ?></td>
                <td>R$ <?= number_format($product->preco, 2, ',', '.') ?></td>
                <td>
                    <div class="variations">
                        <?php 
                        $variations = $this->Estoque_model->get_by_product($product->id);
                        foreach($variations as $var): ?>
                        <div class="variation-item">
                            <span class="badge bg-primary">
                                <?= $var->variacao ?> - <?= $var->tamanho ?>
                            </span>
                            <span class="stock"><?= $var->quantidade ?> unid.</span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </td>
                <td>
                    <a href="<?= site_url('products/edit/'.$product->id) ?>" class="btn btn-sm btn-warning">Editar</a>
                </td>

               
             


            <td>
                <form method="post" action="<?= site_url('cart/add/'.$product->id) ?>">
                    <div class="form-group">
                        <?php if (!empty($product->variacoes)): ?>
                            <select name="variacao" class="form-control mb-2" required>
                                <option value="">Selecione a Cor</option>
                                <?php foreach($product->variacoes as $variacao): ?>
                                    <option value="<?= $variacao->variacao ?>">
                                        <?= $variacao->variacao ?> (<?= $variacao->quantidade ?>)
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            
                            <select name="tamanho" class="form-control mb-2" required>
                                <option value="">Selecione o Tamanho</option>
                                <?php foreach($product->variacoes as $variacao): ?>
                                    <option 
                                        value="<?= $variacao->tamanho ?>"
                                        data-variacao="<?= $variacao->variacao ?>"
                                        data-estoque="<?= $variacao->quantidade ?>">
                                        <?= $variacao->tamanho ?> (<?= $variacao->quantidade ?> disponíveis)
                                    </option>
                                <?php endforeach; ?>
                            </select>


                          
                            <input 
                                type="number" 
                                name="quantidade" 
                                class="form-control mb-2" 
                                min="1" 
                                value="1" 
                                max="<?= max(array_column($product->variacoes, 'quantidade')) ?>" 
                                required>
                            
                            <button type="submit" class="btn btn-success btn-block">Comprar</button>
                        <?php else: ?>
                            <div class="alert alert-warning">Sem variações disponíveis</div>
                        <?php endif; ?>
                    </div>
                </form>
            </td>




            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<style>
.variations {
    display: flex;
    flex-wrap: wrap;
    gap: 5px;
}
.variation-item {
    display: flex;
    align-items: center;
    gap: 3px;
    background: #f8f9fa;
    padding: 3px 8px;
    border-radius: 4px;
}
.stock {
    font-size: 0.8em;
    color: #666;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sincroniza selects e atualiza quantidade máxima
    const variacaoSelect = document.querySelector('select[name="variacao"]');
    const tamanhoSelect = document.querySelector('select[name="tamanho"]');
    const quantidadeInput = document.querySelector('input[name="quantidade"]');
    
    function updateQuantidadeMax() {
        const selectedVariacao = variacaoSelect.options[variacaoSelect.selectedIndex];
        const selectedTamanho = tamanhoSelect.options[tamanhoSelect.selectedIndex];
        
        // Pega o menor estoque entre os selecionados
        const estoqueVariacao = selectedVariacao ? parseInt(selectedVariacao.dataset.estoque) : 0;
        const estoqueTamanho = selectedTamanho ? parseInt(selectedTamanho.dataset.estoque) : 0;
        const estoqueDisponivel = Math.min(estoqueVariacao, estoqueTamanho);
        
        if (estoqueDisponivel > 0) {
            quantidadeInput.max = estoqueDisponivel;
            quantidadeInput.disabled = false;
        } else {
            quantidadeInput.disabled = true;
        }
    }
    
    variacaoSelect.addEventListener('change', updateQuantidadeMax);
    tamanhoSelect.addEventListener('change', updateQuantidadeMax);
    
    // Inicializa
    updateQuantidadeMax();
});
</script>
</body>
</html>