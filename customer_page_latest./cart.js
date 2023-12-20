
    document.addEventListener('DOMContentLoaded', function () {

        // Get the "All" checkbox
        const allCheckbox = document.getElementById('checkAllBoxes');

        // Get all other checkboxes
        const itemCheckboxes = document.querySelectorAll('.form-check-input');

        const closeCheckout = document.querySelectorAll('.close--checkout');
        // Get the totalItems element
        
        //const totalItemsElement = document.querySelector('.totalItems');

        const totalItemsElement = document.querySelector('.totalItems');

    // Get the totalItemsPrice element
        const totalItemsPriceElement = document.querySelector('.totalItemsPrice');

        const place_order = document.getElementById('placeOrderButton')

        const selectDelivery = document.querySelector('.delivery--select')

       // Check/uncheck all checkboxes when the "All" checkbox is clicked
        allCheckbox.addEventListener('change', function() {
            const isChecked = allCheckbox.checked;

            // Get all checkboxes and update their checked state
            itemCheckboxes.forEach(function(checkbox) {
                checkbox.checked = isChecked;
            });

            updateTotal(); // Update total when the "All" checkbox changes
        });  

            // Add event listener for the Remove button click
        const removeButton = document.querySelector('.removeButton');
        removeButton.addEventListener('click', function () {
            const selectedCount = this.getAttribute('data-selected-count');
            const modalBody = document.querySelector('.cart--items');
            modalBody.innerHTML = selectedCount;
        });

        // Add event listener for the confirmation modal's "Yes" button
        const confirmRemoveButton = document.getElementById('confirmRemoveButton');
        confirmRemoveButton.addEventListener('click', function () {
            // Get the selected order ids
            const selectedOrderIds = getSelectedOrderIds();
            const removeURL = "removeCartItems.php";
            //console.log(selectedOrderIds);

            // Check if any items are selected
            if (selectedOrderIds.length > 0) {
                // Call the function to remove items
                console.log(selectedOrderIds);
                console.log(JSON.stringify({"orderIds" : selectedOrderIds}));
                removeItems(selectedOrderIds, removeURL);
            } else {
                // Handle the case when no items are selected
                alert("Please select items to remove.");
            }

            const selectedCount = removeButton.getAttribute('data-selected-count');
            const modalBody = document.querySelector('.item--cart');
            modalBody.innerHTML = selectedCount;
        });

        // Update total when any checkbox is clicked
        itemCheckboxes.forEach(function(checkbox) {
            checkbox.addEventListener('change', function() {
                updateTotal();
            });
        });


        // Disable the minus button when the page loads if the initial quantity is 1
        const initialQuantities = document.querySelectorAll('.quantity--order');
        initialQuantities.forEach(function (quantityElement) {
            const initialQuantity = parseInt(quantityElement.innerText);
            const decreaseButton = quantityElement.closest('.container-fluid').querySelector('.min--order');
            decreaseButton.disabled = initialQuantity <= 1;
        });

        // Get all the add and decrease buttons
        const addButtons = document.querySelectorAll('.add--order');
        const decreaseButtons = document.querySelectorAll('.min--order');

        // Add click event listener to each add button
        addButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                console.log("Add")
                handleQuantityChange(this, 1);
                updateTotal();
            });
        });

        // Add click event listener to each decrease button
        decreaseButtons.forEach(function (button) {
            button.addEventListener('click', function () {
                handleQuantityChange(this, -1);
                updateTotal();
            });
        });


        // Function to handle quantity change
        function handleQuantityChange(button, change) {
            // Get the parent container of the button
            const container = button.closest('.container-fluid');

            // Get the quantity element
            const quantityElement = container.querySelector('.quantity--order');

            // Get the price element
            const priceElement = container.querySelector('.totalPrice');

            const productPrice = container.querySelector('.productPrice')

            const prodPrice = parseFloat(productPrice.innerText).toFixed(2);

            // Get the current quantity value
            let quantity = parseInt(quantityElement.innerText);

            // Update the quantity value
            quantity += change;

            // Disable the decrease button when quantity is 1 or less
            const decreaseButton = container.querySelector('.min--order');
            decreaseButton.disabled = quantity <= 1;

            // Update the quantity element
            quantityElement.innerText = quantity;

            // Update the total price
            const totalPrice = prodPrice * quantity;
            priceElement.innerText = totalPrice.toFixed(2); // Assuming you want to display the total price with 2 decimal places

            // Enable the add button when quantity is greater than 1
            const addButton = container.querySelector('.add--order');
            addButton.disabled = quantity <= 0; // Adjust this condition based on your specific requirements
        }

        // Function to update the total price and total items
        function updateTotal() {
            let totalPrice = 0;
            let totalItems = 0;
        
            // Get all checkboxes
            itemCheckboxes.forEach(function (checkbox) {
                if (checkbox.checked) {
                    // Find the closest row
                    const row = checkbox.closest('tr');
        
                    // Check if the row and .totalPrice element exist
                    if (row && row.querySelector('.totalPrice')) {
                        // Get the total price from the data attribute
                        const itemPrice = parseFloat(row.querySelector('.totalPrice').textContent);
        
                        // Update total price and total items
                        totalPrice += itemPrice;
                        totalItems++;
                    }
                }
            });
        
            // Display the calculated values
            totalItemsPriceElement.textContent = totalPrice.toFixed(2);
            totalItemsElement.textContent = "(" + totalItems + ")";
            

            // Enable or disable Remove and Checkout buttons based on the number of selected items
            const removeButton = document.querySelector('.removeButton');
            const checkoutButton = document.querySelector('.checkoutButton');

            if (totalItems > 0) {
                removeButton.removeAttribute('disabled');
                checkoutButton.removeAttribute('disabled');
            } else {
                removeButton.setAttribute('disabled', 'true');
                checkoutButton.setAttribute('disabled', 'true');
            }
            // Update the data-selected-count attribute
            removeButton.setAttribute('data-selected-count', totalItems);


            return {
                totalPrice: totalPrice.toFixed(2),
                totalItems: totalItems,
            }
        }
        // Function to remove items
        function removeItems(selectedOrderIds, removeURL) {
            // Assuming you have a removeItems.php endpoint
            //const url = 'removeCartItems.php';

            console.log(JSON.stringify(selectedOrderIds))

            // Using Fetch API to send a POST request
            fetch(removeURL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ "orderIds": selectedOrderIds }),
            })
                .then(response => response.json())
                .then(data => {
                    // Handle the response from the server
                    if (data.success) {
                        // Optionally update the UI or show a success message
                        console.log('Items removed successfully');
                    } else {
                        // Handle errors or show an error message
                        console.error('Error removing items:', data.message);
                    }
                })
                .catch(error => {
                    // Handle network errors
                    console.error('Network error:', error);
                });
        }

        //checkpoint
        function checkoutItems(checkout_items, checkoutURL) {
            // Assuming you have a removeItems.php endpoint
            //const url = 'removeCartItems.php';

            console.log(checkout_items)

            //console.log(JSON.stringify(checkout_items))

            // Using Fetch API to send a POST request
            fetch(checkoutURL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: checkout_items,
            })
                .then(response => response.json())
                .then(data => {
                    // Handle the response from the server
                    if (data.success) {
                        // Optionally update the UI or show a success message
                        console.log('Selected items updated successfully');
                        // Access the updated data
                        const updatedData = data.updatedData;
                        const overallPrice = data.overallPrice;
                        const overallItems = data.overallItems;
                        const checkoutDate = data.checkoutDate;
                        const latestCheckoutData = data.checkoutId;
                        const allOrderIds = data.allOrderIds;

                        const overallItemPrices = document.querySelectorAll('.checkout--overall--price');
                        const selectedItems = document.querySelector('.checkout--overall--items');

                        const codOption = selectDelivery.options[0].textContent; //get the type of payment or delivery

                        // Check if any option is selected
                        if (selectDelivery.selectedIndex !== -1) {
                            // Get the text content of the selected option
                            const selectedOptionText = selectDelivery.options[selectDelivery.selectedIndex].textContent;
                            
                            // Log the text content of the selected option to the console
                            console.log(selectedOptionText);
                        } else {
                            console.log('No option selected');
                        }

                        console.log()

                        console.log("Total ordered items: ", overallItems);

                        console.log("Total price: ", overallPrice);
                        console.log('Updated data:', updatedData);

                        console.log("Checkout ID: ", latestCheckoutData);

                        console.log("Order Id's of the selected checkout id: ", allOrderIds);

                        // Get the container element by its class name
                        const container = document.querySelector('.updateContainer');

                        // Clear existing content
                        container.innerHTML = '';

                        // Loop through the updated data and update the content of the container
                        updatedData.forEach(item => {
                            const itemContainer = document.createElement('div');
                            itemContainer.className = 'container-sm ms-0 p-2 text-bg-light border border-3 border-gray rounded-2 d-flex';

                            itemContainer.innerHTML = `
                                <img src="../${item.product_img}" alt="" width="140" height="154" class="rounded-2 border border-2 border-gray my-2 mx-2 checkout--order--imgs">
                                <div class="h6 fw-bold p-3 mt-3 py-1">
                                    <span class="h6 checkout--product--name">${item.product_type}</span>
                                    <span class="h6 fw-bold">${item.order_status}</span>
                                    <span class="h6">${item.order_id}</span>
                                    <div class="h6 mt-3">Order Type: 
                                        <span class="h6 fw-bold checkout--order--type">${item.order_type}</span>
                                    </div>
                                    <div class="h6 mt-3 d-flex">Php 
                                        <span class="h6 px-1 fw-bold checkout--unit--price">${getUnitPrice(item)}</span>
                                    </div>
                                    <div class="h6 mt-3 py-0">x 
                                        <span class="h6 checkout--items--quantity">${item.order_quantity}</span>
                                    </div>
                                </div>
                            `;

                            // Append the item container to the main container
                            container.appendChild(itemContainer);

                            // Add a line break after each item except the last one
                            // Add a line break after each item
                            container.appendChild(document.createElement('br'));
                        });

                        // Update Total Items Ordered
                        selectedItems.textContent = `(${overallItems} items)`;

                        // Update Total Price
                        overallItemPrices.forEach(element => {
                            element.textContent = parseFloat(overallPrice).toFixed(2); // Assuming priceToCheckout is a number
                        });
                        place_order.addEventListener('click', () => {
                            const payment_id_prefix = "205";
                            const payment_id = getGeneratedPaymentId(payment_id_prefix); // Generate a random id for payment id
                        
                            const orderData = {
                                payment_id: payment_id,
                                payment_type: codOption,
                                payment_total: overallPrice,
                                overall_items: overallItems,
                                payment_date: checkoutDate,
                                checkout_id: latestCheckoutData,
                                order_ids: allOrderIds,
                            };
                        
                            // Fetch request options for checkout update
                            const checkoutUpdateOptions = {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                },
                                body: JSON.stringify(orderData),
                            };
                        
                            const checkoutUpdateURL = "updateCheckout.php"; // Replace with the actual URL for updating checkout
                        
                            // Perform the fetch for checkout update
                            fetch(checkoutUpdateURL, checkoutUpdateOptions)
                                .then(response => response.json())
                                .then(checkoutUpdateData => {
                                    // Handle the response from the server
                                    if (checkoutUpdateData.success) {
                                        // Checkout update successful, now proceed with payment processing
                        
                                        // Fetch request options for payment processing
                                        const paymentOptions = {
                                            method: 'POST',
                                            headers: {
                                                'Content-Type': 'application/json',
                                            },
                                            body: JSON.stringify(orderData),
                                        };
                        
                                        const paymentURL = "payment.php";
                        
                                        // Perform the fetch for payment processing
                                        fetch(paymentURL, paymentOptions)
                                            .then(response => response.json())
                                            .then(paymentData => {
                                                // Handle the response from the server
                                                console.log(paymentData);
                        
                                                if (paymentData.success) {
                                                    const paymentTotal = paymentData.payment_total;
                                                    console.log(paymentTotal);
                                                    console.log('Order processed successfully');
                        
                                                    setTimeout(() => {
                                                        window.location.reload();
                                                    }, 1000);
                                                } else {
                                                    console.log('Failed to process order');
                                                    // Handle the case where order processing fails
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Error during payment fetch:', error);
                                            });
                                    } else {
                                        console.log('Failed to update checkout data');
                                        // Handle the case where checkout data update fails
                                    }
                                })
                                .catch(error => {
                                    console.error('Error during checkout update fetch:', error);
                                });
                        });
                        
                        closeCheckout.forEach(element => {
                            element.addEventListener('click', function () {
                                // Get the checkout_id associated with this checkout
                                const removeCheckoutId = {
                                    checkout_id: latestCheckoutData
                                    //paymentId: payment_id,
                                }

                                console.log(removeCheckoutId)

                                const checkoutIdJSON = JSON.stringify(removeCheckoutId);

                                console.log(checkoutIdJSON)
                        
                                // Assuming you have a deleteCheckout.php endpoint
                                const deleteCheckoutURL = 'removeCheckoutItemsOnClose.php';
                        
                                // Using Fetch API to send a POST request to delete the checkout
                                fetch(deleteCheckoutURL, {
                                    method: 'POST',
                                    headers: {
                                        'Content-Type': 'application/json',
                                    },
                                    body: checkoutIdJSON,
                                })
                                .then(response => response.json())
                                .then(data => {
                                    // Handle the response from the server
                                    if (data.success) {
                                        //console.log("Payment ID: ", data.paymentId);
                                        console.log(`Checkout with ID ${data.checkoutId} deleted successfully`); //${checkoutIdJSON}
                                        setTimeout(() => {
                                            window.location.reload();
                                        }, 1000)
                                        // Optionally, you can perform additional actions
                                    } else {
                                        console.error(`Error deleting checkout with ID ${data.checkoutId} : `, data.message);
                                    }
                                })
                                .catch(error => {
                                    console.error('Network error:', error);
                                });
                            });
                        })

                        // Function to calculate unit price based on order type
                        function getUnitPrice(item) {
                            switch(item.order_type) {
                                case 'Buy':
                                    return item.product_buy_price;
                                case 'Refill':
                                    return item.product_refill_price;
                                case 'Borrow':
                                    return item.product_borrow_price;
                                default:
                                    return 0;
                            }
                        }

                        function getGeneratedPaymentId(prefix) {;
                            const length = 8 - prefix.length;
                        
                            let randomId = prefix;
                        
                            for (let i = 0; i < length; i++) {
                                randomId += Math.floor(Math.random() * 10);
                            }
                        
                            return randomId;
                        }


                    } else {
                        // Handle errors or show an error message
                        console.error('Error checkouting items:', data.message);
                    }
                })
                .catch(error => {
                    // Handle network errors
                    console.error('Network error:', error);
                });
        }

                // Function to get selected order ids
        function getSelectedOrderIds() {
            const selectedOrderIds = [];
            itemCheckboxes.forEach(function (checkbox) {
                // Ensure that the checkbox and its attribute are not null or undefined
                if (checkbox.getAttribute('data-id')) {
                    if(checkbox.checked){
                        const orderId = checkbox.getAttribute('data-id').replace('order_', '');
                        selectedOrderIds.push(orderId);
                    }
                }
            });
            return selectedOrderIds;
        }

        const checkoutItemsButton = document.querySelector('.checkoutButton')


        // Add click event listener to the checkout button
        checkoutItemsButton.addEventListener('click', function () {
            // Get the selected order ids
            const selectedOrderIds = getSelectedOrderIds();
            console.log(selectedOrderIds);

            const totalInfo = updateTotal();

            const date = new Date(); //initialize a date object

            const checkout_date = date.toLocaleDateString('en-US'); //get the date in mm/dd/yyyy format

            // Build an object with a property named 'cart-item' containing the array of items
            const cartItems = {
                'cart-item': selectedOrderIds.map(orderId => {
                    const container = document.querySelector(`[data-order-id="order_id_${orderId}"]`);

                    // Debugging statements
                    console.log('orderId:', orderId);
                    console.log('container:', container);

                    // Check if the container is not null
                    if (container) {
                        const quantity = container.querySelector('.quantity--order').innerText;
                        const totalPrice = container.querySelector('.totalPrice').innerText;
                        const orderType = container.querySelector('.order--select').value;
                        const productId = container.querySelector('.product--id').innerText.split(': ')[1].trim();
                        const productPrice = container.querySelector('.productPrice').innerText;
                        const user_id = container.querySelector('.user--id').innerText.split(': ')[1].trim();

                        return {
                            orderId,
                            quantity: parseInt(quantity),
                            totalPrice: parseFloat(totalPrice).toFixed(2),
                            orderType,
                            productId,
                            productPrice: parseFloat(productPrice).toFixed(2),
                            user_id,
                        };
                    } else {
                        console.error(`Container not found for order ID: ${orderId}`);
                        return null;
                    }
                }),

                'overallPrice': totalInfo.totalPrice,
                'overallItems': totalInfo.totalItems,
                'checkoutDate': checkout_date,
            };

            // Filter out null values before converting to JSON
            const validItemsToUpdate = cartItems['cart-item'].filter(item => item !== null);
            console.log(validItemsToUpdate)

            // Convert the object to JSON
            const itemsJson = JSON.stringify(cartItems);
            const checkoutURL = "checkoutCartItems.php";

            //console.log(itemsJson);

            checkoutItems(itemsJson, checkoutURL);

        });

        const closeButton = document.querySelector('.close--button')
        const closeIcon = document.querySelector('.close--icon')

        

        //reload the page after successful removal of the items selected by the user
        closeButton.addEventListener('click', () => {
            setTimeout(() => {
                window.location.reload();
            }, 1000)
        })

        closeIcon.addEventListener('click', () => {
            setTimeout(() => {
                window.location.reload();
            }, 1000)
        })

        
        



        
          
                
})