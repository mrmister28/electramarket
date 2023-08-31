<?php

include 'components/connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
   header('location:user_login.php');
};

if (isset($_POST['order'])) {

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $number = $_POST['number'];
   $number = filter_var($number, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $method = $_POST['method'];
   $method = filter_var($method, FILTER_SANITIZE_STRING);
   $address = 'flat no. ' . $_POST['flat'] . ', ' . $_POST['street'] . ', ' . $_POST['city'] . ', ' . $_POST['state'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code'];
   $address = filter_var($address, FILTER_SANITIZE_STRING);
   $total_products = $_POST['total_products'];
   $total_price = $_POST['total_price'];

   $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
   $check_cart->execute([$user_id]);

   if ($check_cart->rowCount() > 0) {

      $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, number, email, method, address, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
      $insert_order->execute([$user_id, $name, $number, $email, $method, $address, $total_products, $total_price]);

      $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
      $delete_cart->execute([$user_id]);

      $message[] = 'order placed successfully!';
   } else {
      $message[] = 'your cart is empty';
   }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>checkout</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>

<body>

   <?php include 'components/user_header.php'; ?>

   <section class="checkout-orders">

      <form action="" method="POST">

         <h3>your orders</h3>

         <div class="display-orders">
            <?php
            $grand_total = 0;
            $cart_items[] = '';
            $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $select_cart->execute([$user_id]);
            if ($select_cart->rowCount() > 0) {
               while ($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                  $cart_items[] = $fetch_cart['name'] . ' (' . $fetch_cart['price'] . ' x ' . $fetch_cart['quantity'] . ') - ';
                  $total_products = implode($cart_items);
                  $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
            ?>
                  <p> <?= $fetch_cart['name']; ?> <span>(<?= '₹' . $fetch_cart['price'] . '/- x ' . $fetch_cart['quantity']; ?>)</span> </p>
            <?php
               }
            } else {
               echo '<p class="empty">your cart is empty!</p>';
            }
            ?>
            <input type="hidden" name="total_products" value="<?= $total_products; ?>">
            <input type="hidden" name="total_price" value="<?= $grand_total; ?>" value="">
            <div class="grand-total">grand total : <span>₹<?= $grand_total; ?>/-</span></div>
         </div>

         <h3>place your orders</h3>

         <div class="flex">
            <div class="inputBox">
               <span>your name :</span>
               <input type="text" name="name" placeholder="enter your name" class="box" maxlength="20" required>
            </div>
            <div class="inputBox">
               <span>your number :</span>
               <input type="number" name="number" placeholder="enter your number" class="box" min="0" max="9999999999" onkeypress="if(this.value.length == 10) return false;" required>
            </div>
            <div class="inputBox">
               <span>your email :</span>
               <input type="email" name="email" placeholder="enter your email" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>payment method :</span>
               <select name="method" class="box" required id="payment-method">
                  <option value="" disabled selected>Select payment method</option>
                  <option value="paypal">paypal</option>
                  <option value="credit card">credit card</option>
                  <option value="cash on delivery">cash on delivery</option>
               </select>
            </div>
            <div class="inputBox">
               <span>address line 01 :</span>
               <input type="text" name="flat" placeholder="e.g. flat number" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>address line 02 :</span>
               <input type="text" name="street" placeholder="e.g. street name" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>city :</span>
               <input type="text" name="city" placeholder="e.g. mumbai" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>state :</span>
               <input type="text" name="state" placeholder="e.g. maharashtra" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>country :</span>
               <input type="text" name="country" placeholder="e.g. India" class="box" maxlength="50" required>
            </div>
            <div class="inputBox">
               <span>pin code :</span>
               <input type="number" min="0" name="pin_code" placeholder="e.g. 123456" min="0" max="999999" onkeypress="if(this.value.length == 6) return false;" class="box" required>
            </div>
         </div>

         <div style="text-align: center;">
            <div style="display: inline-block; text-align: left;">

               <!-- PayPal SDK script -->
               <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=USD"></script>
               <div id="paypal-button-container"></div>
               <script>
                  // Render the PayPal button into #paypal-button-container
                  paypal.Buttons({

                     // Set up the transaction
                     createOrder: function(data, actions) {
                        return actions.order.create({
                           purchase_units: [{
                              amount: {
                                 value: '<?php echo $grand_total; ?>'
                              }
                           }]
                        });
                     },

                     // Finalize the transaction
                     onApprove: function(data, actions) {
                        return actions.order.capture().then(function(details) {
                           // Show a success message to the buyer
                           alert('Transaction completed by ' + details.payer.name.given_name + '!');
                           var placeOrderBtn = document.getElementsByName('order')[0];
                           placeOrderBtn.click();
                        });
                     }

                  }).render('#paypal-button-container');
                  <?php if ($grand_total <= 1) { ?>
                     // Disable the PayPal button if the grand total is less than or equal to 1
                     document.querySelector('#paypal-button-container button').disabled = true;
                  <?php } ?>
               </script>


               <style>
                  #paypal-btn {
                     display: none;
                  }
               </style>
               <input type="submit" name="order" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" value='Place Order' id="paypal-btn">
               <input type="submit" name="order" class="btn <?= ($grand_total > 1) ? '' : 'disabled'; ?>" value='Cash on Delivery' id="cod-btn">
               <script>
                  const paymentMethod = document.getElementById('payment-method');
                  const codBtn = document.getElementById('cod-btn');
                  const paypalButton = document.getElementById('paypal-button-container');

                  paymentMethod.addEventListener('change', () => {
                     if (paymentMethod.value === 'paypal') {
                        codBtn.disabled = true;
                     } else {
                        codBtn.disabled = false;
                     }


                     if (paymentMethod.value === 'cash on delivery') {
                        paypalButton.style.display = 'none'; // hide the PayPal button
                     } else {
                        paypalButton.style.display = 'block'; // show the PayPal button
                     }


                     if (paymentMethod.value === 'credit card') {
                        paypalButton.style.display = 'block'; // show the PayPal button
                     }
                  });
               </script>
      </form>

   </section>













   <?php include 'components/footer.php'; ?>

   <script src="js/script.js"></script>

</body>

</html>