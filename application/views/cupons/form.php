<!DOCTYPE html>
<html>
<head>
    <title>Novo Cupom</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2><?= isset($cupom) ? 'Editar' : 'Novo' ?> Cupom</h2>
        
        <form method="post">
            <div class="form-group">
                <label>Código</label>
                <input type="text" name="codigo" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Tipo</label>
                <select name="tipo" class="form-control" required>
                    <option value="porcentagem">Porcentagem</option>
                    <option value="fixo">Valor Fixo</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Valor</label>
                <input type="number" step="0.01" name="valor" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Valor Mínimo do Pedido</label>
                <input type="number" step="0.01" name="valor_minimo" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Data de Validade</label>
                <input type="date" name="data_validade" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Máximo de Utilizações (deixe em branco para ilimitado)</label>
                <input type="number" name="max_utilizacoes" class="form-control">
            </div>
            
            <button type="submit" class="btn btn-primary">Salvar</button>
            <a href="<?= site_url('cupons') ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</body>
</html>