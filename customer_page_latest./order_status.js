// Function to create HTML for a single order
function createOrderElement(order) {
    const orderElement = document.createElement('div');
    orderElement.className = 'container-sm w-70 ms-0 p-2 text-bg-light border border-black border-2 rounded-1 d-flex mt-2 h-50';

    // Set inner HTML for the order element
    orderElement.innerHTML = `
        <img src="../${order.product_img}" alt="" width="160" height="175" class="rounded-2 border border-1 border-black my-3 mx-3">
        <div class="h6 fw-bold p-3 mt-3 py-1 h-25 w-100 text-end">
            ${order.order_status}
            <div class="h6 text-start mt-3 fw-bold">${order.product_type}</div>
            <div class="h6 mt-2 d-flex">Order Type: 
                <span class="h6 px-1 fw-bold">${order.order_type}</span>
            </div>
            <div class="h6 mt-4 py-1">
                x <span class="h6">${order.order_quantity}</span>
            </div>
            <div class="h6 mt-0 py-0 text-danger">
                Php <span class="h6 text-danger">${parseFloat(order.total_price).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>
            </div>
        </div>
    `;

    return orderElement;
}

function createItemsAndPricesElement(orders, overallPrice){
    const itemPriceElement = document.createElement('div');
    itemPriceElement.className = 'container-sm w-70 ms-0 p-2 text-bg-light border border-2 border-black rounded-1 d-flex h-50';
    
    itemPriceElement.innerHTML = `
        <div class="h6 mt-2 w-50 mx-3 px-0">${orders.length}
            <span class="h6">item/s</span>
        </div>
        <div class="container d-flex justify-content-end mt-2">
            <div class="h6">Order Total: 
                <span class="h6 text-danger">Php</span>
            </div>
            <div class="h6 text-danger px-1">${overallPrice}</div>
        </div> 
    `;   
    
    return itemPriceElement;
}

function createDateElement(orders){
    const dateContainerElement = document.createElement('div');

    dateContainerElement.className = 'container-sm w-70 ms-0 p-2 d-flex mt-3 h-50 border-bottom border-3 justify-content-between';

    dateContainerElement.innerHTML = `
        <div class="h6 mt-2 w-50 mx-0 px-0 text-primary">Waiting for order confirmation
        </div>
        <div class="mt-2">
            ${orders[0].checkout_date}
        </div>  
        
    `;
    //dateContainer.appendChild(document.createElement('br'));
    return dateContainerElement;              
}

// Function to render orders
function renderOrders(orders, container, itemsAndPriceContainer, dateContainer, noOrderContainer, orderCancellation) {
    // Clear the container first
    container.innerHTML = '';

    // Calculate the total price
    let totalPrice = 0;

    // Check if there are orders
    if (orders.length > 0) {
        console.log("Meron pang orders!")
        // Loop through the ordersData and create HTML for each order
        orders.forEach(order => {
            totalPrice += parseFloat(order.total_price);
            const orderElement = createOrderElement(order);
            // Append the order element to the container
            
            container.appendChild(orderElement);
            //container.appendChild(document.createElement('br'))
        });
        const overallPrice = totalPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })
        const itemsAndPriceElement = createItemsAndPricesElement(orders, overallPrice);

        itemsAndPriceContainer.appendChild(document.createElement('br'));
        itemsAndPriceContainer.appendChild(itemsAndPriceElement);

        const dateContainerElement = createDateElement(orders);
        dateContainer.appendChild(document.createElement('br'));
        dateContainer.appendChild(dateContainerElement);

        // Enable the cancel order button
        if (orderCancellation) {
            orderCancellation.disabled = false;
        }

    }else{
        itemsAndPriceContainer.innerHTML = '';
        dateContainer.innerHTML = '';
        console.log("Wala nang laman yung orders!")
        cancelOrders(noOrderContainer, orderCancellation)
    }
}

function cancelOrders(noOrderContainer, cancelOrder){
        console.log('Cancelling orders...')

        if (cancelOrder) {
            cancelOrder.disabled = true;
        }
        const noOrderElement = document.createElement('div');
    
        noOrderElement.className = 'container-fluid w-100 p-2 text-bg-light rounded-1 d-flex mt-0 h-50 justify-content-center';
    
        noOrderElement.innerHTML = `
            <div class="h4 mt-1 mx-3 px-0 fw-bold text-center">
                <img src="clipboard_x.png" alt="" width=150 height=150>
                <div>NO PENDING ORDERS FOUND!</div>
            </div> 
        `;        
        
        noOrderContainer.appendChild(document.createElement('br'));
        noOrderContainer.appendChild(noOrderElement);

        alert("Successfully cancelling the orders!");

}

document.addEventListener('DOMContentLoaded', function () {
    
    const receiveCheckoutItemsURL = 'receiveCheckoutItems.php';
    // Get the container elements
    const container = document.getElementById('checkoutItemsContainer');
    const itemsAndPriceContainer = document.getElementById('itemsAndPriceContainer');
    const dateContainer = document.getElementById('dateContainer');
    const noOrderContainer = document.getElementById('noOrderContainer')
    const orderCancellation = document.getElementById('order--cancellation')

    const itemCancelled = document.getElementById('itemsCancelled');
    const dateCancelled = document.getElementById('dateCancelled');


    const cancelledItemsContainer = document.getElementById('cancelledItemsContainer'); 
    //console.log(cancelOrder);

    // Fetch data from PHP script
    fetch(receiveCheckoutItemsURL)
        .then(response => response.json())
        .then(data => {
            const orders = data.orders;
            const checkoutID = data.checkout_ids;
            const order_ids = [];
            const payment_ids = [];
            const product_ids = [];
            const user_ids = [];


            for (const order of orders) {
                // Assuming each order object has order_id and payment_id properties
                const order_id = order.order_id;
                const payment_id = order.payment_id;
                const product_id = order.product_id;
                const user_id = order.user_id;
            
                // Push the values to their respective arrays
                order_ids.push(order_id);
                payment_ids.push(payment_id);
                product_ids.push(product_id);
                user_ids.push(user_id);
            }

            console.log('Data received from PHP:', data);
            console.log("Orders: ", orders);
            console.log("Checkout ID for orders: ", checkoutID);
            console.log("Order ID for checkout: ", order_ids);
            console.log("Payment ID for orders: ", payment_ids);
            console.log("Product ID for orders: ", product_ids);
            console.log("User ID for orders: ", user_ids);

            console.log("Button: ", orderCancellation)

            // Render orders using the function
            renderOrders(orders, container, itemsAndPriceContainer, dateContainer, noOrderContainer, orderCancellation);

            // Check if there are orders before rendering items and price
                orderCancellation.addEventListener('click', () => {
                    // Assuming you have a PHP script to handle cancellation
                    const cancelOrderURL = 'cancelOrder.php'; // Replace with the actual URL
                
                    // Assuming you want to send the checkoutID, order_ids, payment_ids, product_ids, and user_ids to the server
                    const cancelData = {
                        checkout_id: checkoutID,
                        order_ids: order_ids,
                        payment_ids: payment_ids,
                        product_ids: product_ids,
                        user_ids: user_ids
                    };
                    
                    const cancelDataJSON = JSON.stringify(cancelData);

                    console.log("Sending data information to be cancelled: ", cancelDataJSON)
                
                    // Fetch to cancel_order.php with POST method
                    fetch(cancelOrderURL, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: cancelDataJSON,
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Handle the response from the server
                        console.log('Cancellation response:', data);
                
                        // Assuming the cancellation was successful, you may want to update the UI accordingly
                        if (data.success) {
                            console.log(data.msg)

                            /*setTimeout(() => {
                                window.location.reload();
                            },1000)*/
                            // Render orders using the function
                            //if()
                            renderOrders(data, container, itemsAndPriceContainer, dateContainer, noOrderContainer, orderCancellation);
                            const cancelledItemsURL = "cancelledItemsDisplay.php";

                            fetch(cancelledItemsURL)
                                .then(response => response.json())
                                .then(cancelledItemsData => {
                                    // Handle the response from cancelledItemsDisplay.php
                                    console.log('Cancelled Items Data:', cancelledItemsData);

                                    // Assuming you have a function to render cancelled items
                                    renderCancelledItems(cancelledItemsData, cancelledItemsContainer, itemCancelled, dateCancelled);
                                })
                                .catch(error => {
                                    console.error('Error fetching cancelled items:', error);
                                    // Handle the error
                                });

                        } else {
                            alert('Failed to cancel order. Please try again.');
                            // Optionally, you can provide more details about the failure to the user
                        }
                    })
                    .catch(error => {
                        console.error('Error cancelling order:', error);
                        alert('An error occurred while cancelling the order. Please try again.');
                        // Optionally, you can provide more details about the error to the user
                    });
                });
        })
        .catch(error => {
            const noOrderElement = document.createElement('div');

            noOrderElement.className = 'container-fluid w-100 p-2 text-bg-light rounded-1 d-flex mt-0 h-50 justify-content-center';

            noOrderElement.innerHTML = `
                <div class="h4 mt-1 mx-3 px-0 fw-bold text-center">
                    <img src="clipboard_x.png" alt="" width=150 height=150>
                    <div>NO PENDING ORDERS FOUND!</div>
                </div> 
            `; 
            orderCancellation.disabled="true"
            noOrderContainer.appendChild(noOrderElement);
            //console.error('Error fetching data from PHP:', error);
        });


        function renderCancelledItems(cancelledItems, cancelledItemsContainer, itemCancelled, dateCancelled){
            
            console.log("Cancelled Items: ", cancelledItems);
            console.log("Cancelled Items Container: ", cancelledItemsContainer);
            console.log("Items Cancelled Container: ", itemCancelled);
            console.log("Date Cancelled Element: ", dateCancelled);

            let overallPrice = 0;

            cancelledItems.forEach(cancelledItem => {
                overallPrice += parseFloat(cancelledItem.total_price)
                const cancelledItemElement = document.createElement('div');

                cancelledItemElement.className = "container-sm w-70 ms-5 p-2 text-bg-light border border-black border-2 rounded-1 d-flex mt-2 h-50";


                cancelledItemElement.innerHTML = `
                
                    <img src="../${cancelledItem.product_img}" alt="" width="160" height="175" class="rounded-2 border border-1 border-black my-3 mx-3">
                    <div class="h6 fw-bold p-3 mt-3 py-1 h-25 w-100 text-end">
                        ${cancelledItem.order_status}
                        <div class="h6 text-start mt-3 fw-bold">${cancelledItem.product_type}</div>
                        <div class="h6 mt-2 d-flex">Order Type: 
                            <span class="h6 px-1 fw-bold">${cancelledItem.order_type}</span>
                        </div>
                        <div class="h6 mt-4 py-1">
                            x <span class="h6">${cancelledItem.order_quantity}</span>
                        </div>
                        <div class="h6 mt-0 py-0 text-danger">
                            Php <span class="h6 text-danger">${parseFloat(cancelledItem.total_price).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span>
                        </div>
                    </div>
                
                `
                // Append each cancelledItemElement to the container
                 cancelledItemsContainer.appendChild(document.createElement('br'));
                 cancelledItemsContainer.appendChild(cancelledItemElement);
            })

            const itemCancelledElement = document.createElement('div')

            itemCancelledElement.className = 'container-sm w-70 ms-5 p-2 text-bg-light border border-2 border-black rounded-1 d-flex h-50';

            itemCancelledElement.innerHTML =  `

                <div class="h6 mt-2 w-50 mx-3 px-0">${cancelledItems.length}
                    <span class="h6">item/s</span>
                </div>
                <div class="container d-flex justify-content-end mt-2">
                    <div class="h6">Order Total: 
                        <span class="h6 text-danger">Php</span>
                    </div>
                    <div class="h6 text-danger px-1">${overallPrice.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</div>
                </div>          
            
            `
            itemCancelled.appendChild(document.createElement('br'))
            itemCancelled.appendChild(itemCancelledElement);


            const dateCancelledElement = document.createElement('div');

            dateCancelledElement.className = 'container-sm w-70 ms-5 p-2 d-flex mt-3 h-50 border-bottom border-3 justify-content-between';

            dateCancelledElement.innerHTML = `
                    <div class="h6 mt-2 w-50 mx-2 px-0 text-primary d-flex">
                        <div class="bi bi-truck fs-3"></div>
                        <div class="h6 px-2 mt-2">Order Cancelled</div>
                    </div>

                    <div class="py-1 mt-3">
                        ${cancelledItems[0].order_date}
                    </div> 
            `

            dateCancelled.appendChild(document.createElement('br'))
            dateCancelled.appendChild(dateCancelledElement);
            
        }
        // Loop through the ordersData and create HTML for each order
        /*orders.forEach(order => {
            totalPrice += parseFloat(order.total_price);
            const orderElement = createOrderElement(order);
            // Append the order element to the container
            
            container.appendChild(orderElement);
            //container.appendChild(document.createElement('br'))
        });*/


        
});
