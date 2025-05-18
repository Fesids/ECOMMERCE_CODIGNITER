<!DOCTYPE html>
<html>
<head>
    <title>Pedido Confirmado</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h2>Pedido Confirmado!</h2>
            </div>
            <div class="card-body">
                <h4>Número do Pedido: #<?= $pedido->id ?></h4>
                <p>Enviamos os detalhes do seu pedido para o e-mail: <strong><?= $pedido->cliente_email ?></strong></p>
                
                <h5 class="mt-4">Resumo do Pedido:</h5>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produto</th>
                            <th>Variação</th>
                            <th>Quantidade</th>
                            <th>Preço Unitário</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($pedido->itens as $item): ?>
                        <tr>
                            <td><?= $item->produto_nome ?></td>
                            <td><?= $item->variacao ?> - <?= $item->tamanho ?></td>
                            <td><?= $item->quantidade ?></td>
                            <td>R$ <?= number_format($item->preco_unitario, 2, ',', '.') ?></td>
                            <td>R$ <?= number_format($item->subtotal, 2, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <div class="row mt-4">
                    <div class="col-md-6">
                        <h5>Endereço de Entrega:</h5>
                        <p>
                            <?= $pedido->logradouro ?>, <?= $pedido->numero ?><br>
                            <?= $pedido->complemento ? 'Complemento: '.$pedido->complemento.'<br>' : '' ?>
                            <?= $pedido->bairro ?> - <?= $pedido->cidade ?>/<?= $pedido->uf ?><br>
                            CEP: <?= $pedido->cep ?>
                        </p>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h5>Total do Pedido</h5>
                                <dl class="row">
                                    <dt class="col-6">Subtotal:</dt>
                                    <dd class="col-6 text-right">R$ <?= number_format($pedido->subtotal, 2, ',', '.') ?></dd>
                                    
                                    <?php if($pedido->desconto > 0): ?>
                                    <dt class="col-6">Desconto:</dt>
                                    <dd class="col-6 text-right text-danger">- R$ <?= number_format($pedido->desconto, 2, ',', '.') ?></dd>
                                    <?php endif; ?>
                                    
                                    <dt class="col-6">Frete:</dt>
                                    <dd class="col-6 text-right">R$ <?= number_format($pedido->frete, 2, ',', '.') ?></dd>
                                    
                                    <dt class="col-6">Total:</dt>
                                    <dd class="col-6 text-right font-weight-bold">R$ <?= number_format($pedido->total, 2, ',', '.') ?></dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
                
                <a href="<?= site_url('products') ?>" class="btn btn-primary mt-3">Voltar à Loja</a>
            </div>
        </div>
    </div>
</body>
</html>