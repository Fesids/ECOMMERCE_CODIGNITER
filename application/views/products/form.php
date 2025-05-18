<!DOCTYPE html>
<html>
<head>
    <title>Cadastro de Produto</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Cadastrar Produto</h2>
        <form method="post">
            <div class="form-group">
                <label>Nome do Produto</label>
                <input type="text" name="nome" class="form-control" required>
            </div>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Preço</label>
                        <input type="number" step="0.01" name="preco" class="form-control" required>
                    </div>
                </div>
            </div>

             
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Descricao do produto</label>
                        <input type="text" name="descricao" class="form-control" required>
                    </div>
                </div>
            </div>
            
            <h5>Variações</h5>
            <div id="variations-container">
                <div class="variation-row row mb-2">
                    <div class="col-md-3">
                        <input type="text" name="cores[]" class="form-control" placeholder="Cor" required>
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
                </div>
            </div>
    
            <button type="button" id="add-variation" class="btn btn-secondary mb-3">+ Adicionar Variação</button>
            <button type="submit" class="btn btn-primary">Salvar Produto</button>
        </form>
    </div>

   <script>
document.getElementById('add-variation').addEventListener('click', function() {
    const container = document.getElementById('variations-container');
    const newRow = document.createElement('div');
    newRow.className = 'variation-row row mb-2';
    newRow.innerHTML = `
        <div class="col-md-3">
            <input type="text" name="cores[]" class="form-control" placeholder="Cor" required>
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
</script>
</body>
</html>