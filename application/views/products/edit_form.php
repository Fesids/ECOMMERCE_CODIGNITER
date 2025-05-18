<!DOCTYPE html>
<html>
<head>
    <title>Editar Produto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Editar Produto</h2>
        <form method="post">
            <div class="form-group">
                <label>Nome do Produto</label>
                <input type="text" name="nome" class="form-control" value="<?= $product->nome ?>" required>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Preço</label>
                        <input type="number" step="0.01" name="preco" class="form-control" 
                               value="<?= $product->preco ?>" required>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Descrição</label>
                        <input type="text" name="descricao" class="form-control" 
                               value="<?= $product->descricao ?>">
                    </div>
                </div>
            </div>
            
            <h5>Variações</h5>
            <div id="variations-container">
                <?php foreach($product->variacoes as $variacao): ?>
                <div class="variation-row row mb-2">
                    <input type="hidden" name="estoque_id[]" value="<?= $variacao->id ?>">
                    <div class="col-md-3">
                        <input type="text" name="variacoes[]" class="form-control" 
                               value="<?= $variacao->variacao ?>" placeholder="Cor" required>
                    </div>
                    <div class="col-md-3">
                        <select name="tamanhos[]" class="form-control" required>
                            <option value="PP" <?= $variacao->tamanho == 'PP' ? 'selected' : '' ?>>PP</option>
                            <option value="P" <?= $variacao->tamanho == 'P' ? 'selected' : '' ?>>P</option>
                            <option value="M" <?= $variacao->tamanho == 'M' ? 'selected' : '' ?>>M</option>
                            <option value="G" <?= $variacao->tamanho == 'G' ? 'selected' : '' ?>>G</option>
                            <option value="GG" <?= $variacao->tamanho == 'GG' ? 'selected' : '' ?>>GG</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="number" name="estoque[]" class="form-control" 
                               value="<?= $variacao->quantidade ?>" placeholder="Estoque" required>
                    </div>
                    <div class="col-md-2">
                        <button type="button" class="btn btn-danger btn-remove">×</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            
            <button type="button" id="add-variation" class="btn btn-secondary mb-3">+ Adicionar Variação</button>
            <button type="submit" class="btn btn-primary">Atualizar Produto</button>
        </form>
    </div>

    <script>
        
        document.getElementById('add-variation').addEventListener('click', function() {
            const container = document.getElementById('variations-container');
            const newRow = document.createElement('div');
            newRow.className = 'variation-row row mb-2';
            newRow.innerHTML = `
                <input type="hidden" name="estoque_id[]" value="new">
                <div class="col-md-3">
                    <input type="text" name="variacoes[]" class="form-control" placeholder="Cor" required>
                </div>
                <div class="col-md-3">
                    <select name="tamanhos[]" class="form-control" required>
                        <option value="">Tamanho</option>
                        <option value="PP">PP</option>
                        <option value="P">P</option>
                        <option value="M">M</option>
                        <option value="G">G</option>
                        <option value="GG">GG</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <input type="number" name="estoque[]" class="form-control" placeholder="Estoque" required>
                </div>
                <div class="col-md-2">
                    <button type="button" class="btn btn-danger btn-remove">×</button>
                </div>
            `;
            container.appendChild(newRow);
        });

        document.addEventListener('click', function(e) {
            if(e.target.classList.contains('btn-remove')) {
                e.target.closest('.variation-row').remove();
            }
        });
    </script>
</body>
</html>