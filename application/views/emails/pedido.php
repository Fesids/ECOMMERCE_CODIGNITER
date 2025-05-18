<!DOCTYPE html>
<html>
<head>
    <title>Confirmação de Pedido</title>
</head>
<body>
    <h1>Obrigado por sua compra!</h1>
    <p>Detalhes do pedido #<?= $pedido->id ?></p>
    
    <h3>Endereço de Entrega:</h3>
    <p>
        <?= $pedido->logradouro ?>, <?= $pedido->bairro ?><br>
        <?= $pedido->cidade ?> - <?= $pedido->uf ?>
    </p>
    
    <h3>Itens:</h3>
    <ul>
        <?php foreach($pedido->itens as $item): ?>
        <li><?= $item->nome ?> (<?= $item->variacao ?>/<?= $item->tamanho ?>) - <?= $item->quantidade ?> x R$ <?= number_format($item->preco_unitario, 2) ?></li>
        <?php endforeach; ?>
    </ul>
    
    <p>Total: R$ <?= number_format($pedido->total, 2) ?></p>
</body>
</html>