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
    <div class="shoppingcart">
        <table>
            <tr>
                <th>plaatje</th>
                <th>naam</th>
                <th>aantal</th>
                <th>prijs</th>
            </tr>';

            foreach ($data['products'] as $product) {
                extract($product);
                
                echo '
                <tr>
                    <td><img src="images/' . $filenameimage . '"</td>
                    <td>' . $name . '</td>
                    <td>placeholder</td>
                    <td>' . $price . '</td>
                </tr>';
            }
            
            echo '
            <tr>
                <th>Subtotaal:</th>
            </tr>
        </table>
    </div>';
}

?>