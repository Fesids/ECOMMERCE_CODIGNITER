<?php

?>
<div class="order-summary">
    <h6>Itens do Carrinho</h6>
    <ul class="list-unstyled">
        <?php foreach($cart as $item): ?>
        <li class="d-flex justify-content-between py-2">
            <span><?= $item['nome'] ?></span>
            <span>R$ <?= number_format($item['preco'] * $item['quantidade'], 2, ',', '.') ?></span>
        </li>
        <li class="small text-muted">
            <?= $item['variacao'] ?> - <?= $item['tamanho'] ?> (<?= $item['quantidade'] ?> un.)
        </li>
        <?php endforeach; ?>
    </ul>
    
    <div class="total border-top pt-2">
        <div class="d-flex justify-content-between">
            <strong>Total:</strong>
            <strong>R$ <?= number_format(array_sum(array_map(function($item) {
                return $item['preco'] * $item['quantidade'];
            }, $cart)), 2, ',', '.') ?></strong>
        </div>
    </div>
</div>