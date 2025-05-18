<!DOCTYPE html>
<html>
<head>
    <title>Confirmação de Pedido</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .header { background-color: #28a745; color: white; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .total-box { background-color: #f8f9fa; padding: 15px; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Pedido Confirmado!</h1>
        <p>Número do Pedido: #<?= $pedido->id ?></p>
    </div>
    
    <div class="content">
        <p>Olá <?= $pedido->cliente_nome ?>,</p>
        <p>Seu pedido foi recebido e está sendo processado. Aqui estão os detalhes:</p>
        
        <h3>Itens do Pedido:</h3>
        <table>
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
        
        <div class="row">
            <div class="col-md-6">
                <h3>Endereço de Entrega:</h3>
                <p>
                    <?= $pedido->logradouro ?>, <?= $pedido->numero ?><br>
                    <?= $pedido->complemento ? 'Complemento: '.$pedido->complemento.'<br>' : '' ?>
                    <?= $pedido->bairro ?><br>
                    <?= $pedido->cidade ?> - <?= $pedido->uf ?><br>
                    CEP: <?= $pedido->cep ?>
                </p>
            </div>
            <div class="col-md-6">
                <div class="total-box">
                    <h3>Total do Pedido</h3>
                    <p>Subtotal: R$ <?= number_format($pedido->subtotal, 2, ',', '.') ?></p>
                    <?php if($pedido->desconto > 0): ?>
                    <p>Desconto: - R$ <?= number_format($pedido->desconto, 2, ',', '.') ?></p>
                    <?php endif; ?>
                    <p>Frete: R$ <?= number_format($pedido->frete, 2, ',', '.') ?></p>
                    <p><strong>Total: R$ <?= number_format($pedido->total, 2, ',', '.') ?></strong></p>
                </div>
            </div>
        </div>
        
        <p>Acompanhe seu pedido através do nosso site ou entre em contato conosco se tiver alguma dúvida.</p>
        
        <p>Atenciosamente,<br>Teste Loja</p>
    </div>
</body>
</html>