<?php
    include('includes/header.php');

    $adminLogin = isset($_SESSION['user_data']) && !isset($_SESSION['user_data']->client_login);
    $id = $adminLogin ? $_SESSION['user_data']['id'] : $_SESSION['user_data']->id;
    $intance = new Order;

    $orders = $adminLogin ? $intance->getOrders() : $intance->getUserOrders($id);
?>

<body>

<?php include('includes/sidebar.php'); ?>

<section class="home-section">
    <nav>
      <div class="sidebar-button">
        <i class='bx bx-menu sidebarBtn'></i>
        <span class="dashboard">Add Clients</span>
      </div>
    </nav>

<div class="container">
    <?php if( isset($_SESSION['user_data']->client_login) ) {?>   
        <div class="form-container left">
            <h2>Order Form</h2>
            <form class="order-form" action="queries/create_order.php" method="post">
                <div id="submit_btn" style="display: none;">
                    <input type="submit" value="Submit">
                </div>
                <div id="dynamicForm">
                    <fieldset id="fieldSet1" class="fieldSet">
                    
                    </fieldset>
                </div>
            </form>

            <button onclick="addFieldSet()">Add Fields</button>
            <button onclick="removeFieldSet()">Remove Fields</button>

            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
            <script>
                let fieldSetCount = 0;
                let productList = [];

                function populateSelectDropdown(fieldSetCount) {
                    $.ajax({
                        url: 'api/products.php',
                        type: 'GET',
                        success: function(response) {
                            productList = [...response.data]
                            productList.forEach(function(product) {
                                var productNameSentenceCase = product.productName.charAt(0).toUpperCase() + product.productName.slice(1).toLowerCase();
                                var optionText = productNameSentenceCase;
                                $('#id_' + fieldSetCount).append(new Option(optionText, product.id));
                                // $('#qty_' + fieldSetCount).val(product.qty);
                            });
                        }
                    });
                }

                function updateQtyOnChange(fieldSetCount) {
                    console.log('fieldSetCount', fieldSetCount)
                    $('#id_' + fieldSetCount).on('change', function() {
                        var selectedProductId = $(this).val();

                         console.log('selectedProductId', selectedProductId)
                         console.log('productList', productList)

                        var selectedProduct = productList.find(function(product) {
                            return +product.id === +selectedProductId;
                        });
                        console.log("selectedProduct", selectedProduct)
                        if (selectedProduct) {
                            $('#qty_' + fieldSetCount).val(selectedProduct.qty);
                        }
                    });
                }

                $(document).ready(function() {
                    populateSelectDropdown(fieldSetCount);
                });

                function addFieldSet() {
                    fieldSetCount++;
                    var newFieldSet = document.createElement('fieldset');
                    newFieldSet.innerHTML = `
                                <legend>Order Form ${fieldSetCount}</legend>
                                <select id="id_${fieldSetCount}" name="id_${fieldSetCount}" placeholder="">
                                    <option selected readonly disabled> Select Product </option>
                                </select required><br>
                                <input type="text" id="quantity_${fieldSetCount}" name="quantity_${fieldSetCount}" placeholder="Quantity" required><br>
                                <input type="text" id="office_${fieldSetCount}" name="office_${fieldSetCount}" placeholder="Office" required><br>
                                <textarea id="remarks_${fieldSetCount}" name="remarks_${fieldSetCount}" placeholder="Remarks"></textarea><br>
                                <label for="qty_${fieldSetCount}">Current Quantity</label>
                                <input type="text" id="qty_${fieldSetCount}" name="qty_${fieldSetCount}" placeholder="Current Quantity" readonly ><br>
                                <hr>
                            `;

                    newFieldSet.id = 'fieldSet' + fieldSetCount;
                    newFieldSet.className = 'fieldSet';
                    document.getElementById('dynamicForm').appendChild(newFieldSet);

                    populateSelectDropdown(fieldSetCount);
                    updateQtyOnChange(fieldSetCount);

                    if( document.querySelector('#submit_btn') ){
                        const submitBtn = document.querySelector('#submit_btn');
                        if(fieldSetCount){
                            submitBtn.style.display = 'block';
                        }
                    }
                }

                function removeFieldSet() {
                    if (fieldSetCount > 0) {
                        var fieldSetToRemove = document.getElementById('fieldSet' + fieldSetCount);
                        document.getElementById('dynamicForm').removeChild(fieldSetToRemove);
                        fieldSetCount--;

                        if( document.querySelector('#submit_btn') ){
                            const submitBtn = document.querySelector('#submit_btn');
                            if(!fieldSetCount){
                                submitBtn.style.display = 'none';
                            }
                        }
                    }
                }
            </script>



        </div>
    <?php }?>
    

    <div class="product-container" style="max-height: 500px; overflow: auto;">
        <table border="1">
            <tr>
                <th>Product</th>
                <th>Ordered Quantity</th>
                <th>Office</th>
                <th>Ordered By</th>
                <th>Remarks</th>
                <th>Status</th>
                <?php
                    if ( $adminLogin ){
                ?>
                <th>Action</th>
                <?php
                    }
                ?>

            </tr>
            <?php foreach ($orders as $order): ?>
            <tr>
                <td><?= ucwords($order['product_name']) ?></td>
                <td><?= $order['quantity']; ?></td>
                <td><?= $order['office']; ?></td>
                <td><?= ucwords($order['ordered_by_name']) ?></td>
                <td><?= $order['remarks']; ?></td>
                <td><?= ucfirst(strtolower($order['status']));?></td>


                <?php
                    if ( $adminLogin ){
                ?>
                    <td>
                        <?php 
                            if( $order['status'] == 'PENDING' ){
                        ?>
                            <form action="queries/update_order.php" method="post">
                                <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                <input type="hidden" name="product_id" value="<?= $order['product_id']; ?>">
                                <input type="hidden" name="ordered_quantity" value="<?= $order['quantity']; ?>">
                                <input type="hidden" name="status" value="APPROVED">
                                <input style="background-color: green;" type="submit" value="APRROVE">
                            </form>
                            <form action="queries/update_order.php" method="post">
                                <input type="hidden" name="order_id" value="<?= $order['id']; ?>">
                                <input type="hidden" name="status" value="REJECTED">
                                <input style="background-color: red;" type="submit" value="REJECT">
                            </form>
                        <?php
                            }
                        ?>
                    </td>
                <?php
                    }
                ?>  
            </tr>
            <?php endforeach; ?>
        </table>
    </div>

</div>
</section>




</body>
</html>