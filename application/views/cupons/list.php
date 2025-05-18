<!DOCTYPE html>
<html>
<head>
    <title>Gerenciar Cupons</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Gerenciar Cupons</h2>
        <a href="<?= site_url('cupons/create') ?>" class="btn btn-primary mb-3">Novo Cupom</a>
        
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Tipo</th>
                    <th>Valor</th>
                    <th>Valor Mínimo</th>
                    <th>Validade</th>
                    <th>Utilizações</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($cupons as $cupom): ?>
                <tr>
                    <td><?= $cupom->codigo ?></td>
                    <td><?= $cupom->tipo == 'porcentagem' ? 'Porcentagem' : 'Valor Fixo' ?></td>
                    <td><?= $cupom->tipo == 'porcentagem' ? $cupom->valor.'%' : 'R$ '.number_format($cupom->valor, 2, ',', '.') ?></td>
                    <td>R$ <?= number_format($cupom->valor_minimo, 2, ',', '.') ?></td>
                    <td><?= date('d/m/Y', strtotime($cupom->data_validade)) ?></td>
                    <td><?= $cupom->utilizacoes ?>/<?= $cupom->max_utilizacoes ?? 'Ilimitado' ?></td>
                    <td>
                        <a href="<?= site_url('cupons/delete/'.$cupom->id) ?>" class="btn btn-danger btn-sm" 
                           onclick="return confirm('Tem certeza que deseja excluir este cupom?')">Excluir</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>