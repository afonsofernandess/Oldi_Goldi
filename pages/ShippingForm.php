<?php 

require_once('../templates/common.php');
$db = getDatabaseConnection();
output_header($db);
$item_id = intval(urldecode($_GET['item_id']));

$item = getSoldItem($db, $item_id);
$transaction = getTransaction($db, $item_id);
$buyer = getUser($db, $transaction['buyer']);
$barcodeNumber = str_pad(rand(0, 999999999999), 12, '0', STR_PAD_LEFT);
?>
<main id="SF">
    <a  id="BShopping" href="../index.php">Back to Shopping</a>
<section class="label">
        <section class="sender">
            <p>Sender: ZWAT, Portugal</p>
        </section>
        <section class="recipient">
            <p class="name"><?= htmlspecialchars($buyer['name'])?></p>
            <p><?= htmlspecialchars($buyer['Adress']) ?></p>
            <p><?= htmlspecialchars($buyer['Cidade']) ?></p>
            <p><?= htmlspecialchars($buyer['Zip_code']) ?></p>
            <p><?= htmlspecialchars($buyer['Country']) ?></p>
        </section>
        <section class="item-info">
            <p><strong>Item:</strong><?= htmlspecialchars($item['item_name']) ?></p>
            <p><strong>Price:</strong> <?= htmlspecialchars($transaction['total_value']) ?>€</p>
        </section>
        <section class="details">
            <p>Reference: <?= htmlspecialchars($transaction['transaction_id']) ?></p>
        </section>
        <section class="barcode">
            <img src="../images/barcode.jpg" alt="Barcode">
            <p class="barcode-number"><?= htmlspecialchars($barcodeNumber) ?></p>
        </section>

        
</section>
<button id="printButton" onclick="window.print()">Print Shipping Label</button>
</main>

<?php

output_footer();

?>