<?php if($this->session->flashdata('success')): ?>
<div class="alert alert-success">
    <?= $this->session->flashdata('success') ?>
</div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
<div class="alert alert-danger">
    <?= $this->session->flashdata('error') ?>
</div>
<?php endif; ?>


<!DOCTYPE html>
<html>
<head>
    <title>Carrinho de Compras</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h2>Seu Carrinho</h2>
        <?php if(!empty($cart_items)): ?>
        <table class="table">
            <thead>
                <tr>
                    <th>Produto</th>
                    <th>Variação</th>
                    <th>Tamanho</th>
                    <th>Preço</th>
                    <th>Quantidade</th>
                    <th>Total</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($cart_items as $key => $item): ?>
                <tr>
                    <td><?= $item['nome'] ?></td>
                    <td><?= $item['variacao'] ?></td>
                    <td><?= $item['tamanho'] ?></td>
                    <td>R$ <?= number_format($item['preco'], 2, ',', '.') ?></td>
                    <td><?= $item['quantidade'] ?></td>
                    <td>R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></td>
                    <td>
                        <a href="<?= site_url('cart/remove/'.$key) ?>" class="btn btn-danger btn-sm">Remover</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">Aplicar Cupom</h5>
                <form method="post" action="<?= site_url('cart/aplicar_cupom') ?>">
                    <div class="input-group">
                        <input type="text" name="codigo" class="form-control" placeholder="Código do cupom">
                        <button type="submit" class="btn btn-primary">Aplicar</button>
                    </div>
                </form>
                <?php if($cupom_aplicado = $this->session->userdata('cupom_aplicado')): ?>
                <div class="mt-2">
                    Cupom: <?= $cupom_aplicado->codigo ?> 
                    (<?= $cupom_aplicado->tipo == 'porcentagem' ? $cupom_aplicado->valor.'%' : 'R$ '.$cupom_aplicado->valor ?>)
                    <a href="<?= site_url('cart/remover_cupom') ?>" class="text-danger">[Remover]</a>
                </div>
                <?php endif; ?>
            </div>
        </div>


        
        <div class="row mt-4">
            <div class="col-md-4 offset-md-8">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Resumo do Pedido</h5>
                        <dl class="row">
                            <dt class="col-6">Subtotal:</dt>
                            <dd class="col-6 text-right">R$ <?= number_format($subtotal, 2, ',', '.') ?></dd>
                            
                            <dt class="col-6">Frete:</dt>
                            <dd class="col-6 text-right">R$ <?= number_format($frete, 2, ',', '.') ?></dd>
                            
                            <dt class="col-6">Total:</dt>
                            <dd class="col-6 text-right font-weight-bold">R$ <?= number_format($total, 2, ',', '.') ?></dd>
                        </dl>
                        <a href="<?= site_url('checkout') ?>" class="btn btn-primary btn-block">Finalizar Compra</a>
                    </div>
                </div>
            </div>
        </div>
        <a href="<?= site_url('products') ?>" class="btn btn-primary">Continuar comprando</a>
        <?php else: ?>
        <div class="alert alert-info">Seu carrinho está vazio</div>
        <?php endif; ?>
    </div>
</body>
</html>