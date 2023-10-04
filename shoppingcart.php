<?php

/** Display the title for the shoppingcart page. */
function showShoppingCartTitle() {
    echo 'Shopping cart';
}

/** Display the header for the shoppingcart page. */
function showShoppingCartHeader() {
    echo 'Shopping Cart';
}

/** Display the content for the shoppingcart page. */
function showShoppingCartContent($data) {
    echo '
    <div class="shopping-cart">
        <table class="table table-striped table-hover align-middle">
            <thead>
                <tr>
                    <th></th>
                    <th>Artikel</th>
                    <th>Prijs</th>
                    <th>Aantal</th>
                    <th>Subtotaal</th>
                </tr>
            </thead>
            <tbody class="table-group-divider">';

    $total = 0;
    foreach ($data['products'] as $product) {
        extract($product);
        $quantity = $_SESSION['shoppingcart'][$id];
        $subtotal = $price * $quantity;
        $total += $subtotal;

    echo '
    <tr>
        <td><a href="index.php?page=productpage&productid=' . $id . '"><img src="images/' . $filenameimage . '" alt="' . $name . '" class="shoppingcart-img"></a></td>
        <td><a href="index.php?page=productpage&productid=' . $id . '">' . $name . '</a></td>
        <td>€' . number_format($price, 2) . '</td>
        <td>
            <form method="post" action="index.php">
                <input type="hidden" name="id" value=' . $id . '>
                <input type="hidden" name="page" value="shoppingcart">
                <button type="submit" name="action" value="removefromcart" class="btn btn-sm btn-danger">-</button>
                ' . $quantity . '
                <button type="submit" name="action" value="addtocart" class="btn btn-sm btn-success">+</button>
            </form>
        </td>
        <td>€' . number_format($subtotal, 2) . '</td>
    </tr>';
}

    echo '
            </tbody>
            <tfoot>
                <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th>Totaalprijs: €' . number_format($total, 2) . '</th>
                </tr>
            </tfoot>
        </table>
        <form method="post" action="index.php" class="d-flex justify-content-end me-5">
            <input type="hidden" name="id" value=' . $id . '>
            <button type="submit" name="page" value="checkout" class="btn btn-primary" id="button-invert">Afrekenen</button>
        </form>
    </div>';
}

function showEmptyShoppingCart() {
    echo '<h3>Uw winkelmandje is leeg.</h3>';
}

function showOrderSucces() {
    echo '<h3>Bedankt voor uw bestelling! Check uw mail voor de orderinfo.</h3>';
}

?>