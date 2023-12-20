const priceLabelRounded = document.querySelector('.priceLabel_roundedgallonwater'); //price label for rounded gallons
const priceLabelSlim = document.querySelector('.priceLabel_slimgallonwater'); //price label for slim gallons

const selectOrderRounded = document.querySelector('.selectOrder_roundedgallonwater'); //select order for rounded gallons
const selectOrderSlim = document.querySelector('.selectOrder_slimgallonwater'); //select order for slim gallons

const addCartRounded = document.querySelector('.addCart_roundedgallonwater'); //add to cart sa main section ng rounded gallons
const addCartSlim = document.querySelector('.addCart_slimgallonwater'); // add to cart sa main section ng slim gallons

const orderNowRounded = document.querySelector('.orderNow_roundedgallonwater')// order now button ng main section para sa rounded gallons
const orderNowSlim = document.querySelector('.orderNow_slimgallonwater');//order now button ng main section para sa slim gallons


//FOR MODAL PART
const typeRoundedLabel = document.querySelector('.type_roundedgallonwater'); //label ng order type sa modal for rounded
const typeSlimLabel = document.querySelector('.type_slimgallonwater'); //label ng order type sa modal for slim

const addRounded = document.querySelector('.add_roundedgallonwater'); //addition quantity button rounded
const addSlim = document.querySelector('.add_slimgallonwater'); //addition quantity button ng slim gallons

const subRounded = document.querySelector('.sub_roundedgallonwater');//subtraction para sa rounded gallons
const subSlim = document.querySelector('.sub_slimgallonwater');//subtraction para sa slim gallons

const quantityRounded = document.querySelector('.quant_roundedgallonwater');//quantity ng rounded gallon water
const quantitySlim = document.querySelector('.quant_slimgallonwater'); //quantity ng slim gallon water

const totalPriceRounded = document.querySelector('.totalprice_roundedgallonwater'); //label ng price para doon sa computation ng rounded gallons
const totalPriceSlim = document.querySelector('.totalprice_slimgallonwater'); //label ng price para doon sa computation ng slim gallonw water

const cart_round = document.querySelector('.addtocart_roundedgallonwater'); //cart button ng rounded sa modal
const cart_slim = document.querySelector('.addtocart_slimgallonwater'); //cart button ng slim sa modal

const order_round = document.querySelector('.noworder_roundedgallonwater'); //order button ng rounded sa modal
const order_slim = document.querySelector('.noworder_slimgallonwater'); //order ng button ng slim sa modal

const closeRounded = document.querySelector('.close_roundedgallonwater'); //close button for slim sa modal
const closeSlim = document.querySelector('.close_slimgallonwater'); //close button for rounded sa modal

//second modal classes
const closeCartRound = document.querySelector('.cc_roundedgallonwater')
const cartItemsRound = document.querySelector('.cartItems_roundedgallonwater')
const noCartRound = document.querySelector('.nc_roundedgallonwater')
const confirmCartRound = document.querySelector(".confcart_roundedgallonwater")

const closeCartSlim = document.querySelector('.cc_slimgallonwater')
const cartItemsSlim = document.querySelector('.cartItems_slimgallonwater')
const noCartSlim = document.querySelector('.nc_slimgallonwater')
const confirmCartSlim = document.querySelector(".confcart_slimgallonwater")

const closeOrderRound = document.querySelector('.co_roundedgallonwater')
const orderItemsRound = document.querySelector('.orderItems_roundedgallonwater')
const noOrderRound = document.querySelector('.no_roundedgallonwater')
const confirmOrderRound = document.querySelector(".conforder_roundedgallonwater")

const closeOrderSlim = document.querySelector('.co_slimgallonwater')
const orderItemsSlim = document.querySelector('.orderItems_slimgallonwater')
const noOrderSlim = document.querySelector('.no_slimgallonwater')
const confirmOrderSlim = document.querySelector(".conforder_slimgallonwater")
//end

//third modal classes
const successCartRound = document.querySelector('.sc_roundedgallonwater')
const successOrderRound = document.querySelector('.so_roundedgallonwater')

const successCartSlim = document.querySelector('.sc_slimgallonwater')
const successOrderSlim = document.querySelector('.so_slimgallonwater')

const closeSuccessCartRound = document.querySelector('.csc_roundedgallonwater')//close successfully addition to cart
//const closeSuccessOrderRound = document.querySelector(".cso_roundedgallonwater");

const closeSuccessCartSlim = document.querySelector('.csc_slimgallonwater')//close successfully addition to cart
//const closeSuccessOrderSlim = document.querySelector(".cso_slimgallonwater");


const productRoundClass = document.querySelector(".class_roundedgallonwater");
const productSlimClass = document.querySelector(".class_slimgallonwater");


//end for modal part

const buyPrice = 280.00; //buy prices
const refillPrice = buyPrice - 250.00; //refill price
const borrowPrice = buyPrice - 80.00; //borrow price


let quantity = 0;
let totalPrice = 0;

let orderQuantity = 0;
let priceTotal = 0;
let order_type = "";
let order_date = "";
let productId = "";
let order_status = "";

const defaultOrderType = "Buy"

const date = new Date();

//disable first bago magappear yung first modal
function disable(cartElement, minElement, orderElement){
    quantity = 0
    totalPrice = 0
    cartElement.disabled = true;
    minElement.disabled = true;
    orderElement.disabled = true;
}

//function to compute the price based on the type of order
function computePrice(price, quantity){
    totalPrice = price * quantity;
    totalPrice = totalPrice.toFixed(2);

    return totalPrice;
}
//update quantity
function updateQuantity(change, subElement, cartElement, quantityElement, orderElement, selectOrderElement, totalPriceElement) {
    quantity += change;
    
    subElement.disabled = quantity <= 1;
    cartElement.disabled = orderElement.disabled = quantity <= 0;
    
    quantityElement.innerText = quantity;

    forOrderType(selectOrderElement, totalPriceElement);
}
//selection of items
function forOrderType(selectOrderElement, totalPriceElement){
    if (selectOrderElement.value === "Buy"){ //if type of order is buy
        totalPrice = computePrice(buyPrice, quantity)
        totalPriceElement.innerText = totalPrice;

    }else if(selectOrderElement.value === "Refill"){ //if refill
        totalPrice = computePrice(refillPrice, quantity)
        totalPriceElement.innerText = totalPrice;

    }else if(selectOrderElement.value === "Borrow"){ //if refill
        totalPrice = computePrice(borrowPrice, quantity)
        totalPriceElement.innerText = totalPrice;
    }
}
//function to update the quantity
function updateLabelQuantity(element, text) {
    element.innerText = text;
}
//reset all values

function resetAllValues(){
    totalPriceSlim.innerText = '0.00'
    totalPriceRounded.innerText = '0.00'

    quantitySlim.innerText = '0'
    quantityRounded.innerText = '0'

    subSlim.disabled = true;
    cart_slim.disabled = true;
    order_slim.disabled = true;

    subRounded.disabled = true;
    cart_round.disabled = true;
    order_round.disabled = true;

    quantity = 0;
    totalPrice = 0;
    orderQuantity = 0;
    priceTotal = 0;
    order_type = "";
    order_date = "";
    productId = "";
    order_status = "";
}
//handle order change
function handleOrderChange(selectElement, priceLabel) {
    const selectedValue = selectElement.value;

    switch (selectedValue) {
        case 'Buy':
            priceLabel.innerText = buyPrice.toFixed(2);
            break;
        case 'Refill':
            priceLabel.innerText = refillPrice.toFixed(2);
            break;
        case 'Borrow':
            priceLabel.innerText = borrowPrice.toFixed(2);
            break;
        default:
            // Handle other cases or provide a default value
            break;
    }
}
//handle add to cart click
function handleCartandOrderClick(selectElement, typeLabel, defaultOrderType, cartElement, minElement, orderElement) {
    if (!selectElement.selectedIndex) {
        typeLabel.innerText = "(" + defaultOrderType + ")";
    } else {
        typeLabel.innerText = "(" + selectElement.value + ")";
    }
    disable(cartElement, minElement, orderElement);
}

//rounded gallon section
// Usage for selectOrderRounded
selectOrderRounded.addEventListener('change', () => {
    handleOrderChange(selectOrderRounded, priceLabelRounded);
});

// Usage for addCartRounded
addCartRounded.addEventListener('click', () => {
    handleCartandOrderClick(selectOrderRounded, typeRoundedLabel, defaultOrderType, cart_round, subRounded, order_round);
});
//usage for orderNowRounded
orderNowRounded.addEventListener('click', () => {
    handleCartandOrderClick(selectOrderRounded, typeRoundedLabel, defaultOrderType, cart_round, subRounded, order_round);
})
//usage for addition ng quantity ng rounded gallons
addRounded.addEventListener('click', () => {
    updateQuantity(1, subRounded, cart_round, quantityRounded, order_round, selectOrderRounded, totalPriceRounded);
});
//usage for subtraction
subRounded.addEventListener('click', () => {
    updateQuantity(-1, subRounded, cart_round, quantityRounded, order_round, selectOrderRounded, totalPriceRounded);
});

cart_round.addEventListener('click', () => {
    updateLabelQuantity(cartItemsRound, quantity);
});

order_round.addEventListener('click', () => {
    updateLabelQuantity(orderItemsRound, quantity);
});

confirmCartRound.addEventListener('click', () => {
    order_status = 'In Cart'
    processOrderForCart(order_status, successCartRound, cartItemsRound, selectOrderRounded, productRoundClass);
});

confirmOrderRound.addEventListener('click', () => {
    order_status = 'In Progress'
    processOrderForCheckout(order_status, successOrderRound, orderItemsRound, selectOrderRounded, productRoundClass);
});


//slim gallon section
// Usage for selectOrderSlim
selectOrderSlim.addEventListener('change', () => {
    handleOrderChange(selectOrderSlim, priceLabelSlim);
});
// Usage for addCartSlim
addCartSlim.addEventListener('click', () => {
    handleCartandOrderClick(selectOrderSlim, typeSlimLabel, defaultOrderType, cart_slim, subSlim, order_slim);
});
orderNowSlim.addEventListener('click', () => {
    handleCartandOrderClick(selectOrderSlim, typeSlimLabel, defaultOrderType, cart_slim, subSlim, order_slim);
})
//Quantity of the order
addSlim.addEventListener('click', () => {
    updateQuantity(1, subSlim, cart_slim, quantitySlim, order_slim, selectOrderSlim, totalPriceSlim);
});

subSlim.addEventListener('click', () => {
    updateQuantity(-1, subSlim, cart_slim, quantitySlim, order_slim, selectOrderSlim, totalPriceSlim);
});
//end of the quantity
//buttons for transferring to the second modal and displaying the quantity ordered or going to the cart
cart_slim.addEventListener('click', () => {
    updateLabelQuantity(cartItemsSlim, quantity);
});
order_slim.addEventListener('click', () => {
    updateLabelQuantity(orderItemsSlim, quantity);
    //confirmation of order now
});

confirmCartSlim.addEventListener('click', () => {
    order_status = 'In Cart'
    processOrderForCart(order_status, successCartSlim, cartItemsSlim, selectOrderSlim, productSlimClass);
});

confirmOrderSlim.addEventListener('click', () => {
    order_status = 'In Progress'
    processOrderForCheckout(order_status, successOrderSlim, orderItemsSlim, selectOrderSlim, productSlimClass);
});

function processOrderForCheckout(orderStatus, success, items, selectOrderClass, productClass) {
    success.innerText = items.innerText; //display the quantity ordered
    orderQuantity = items.innerText; //extract the quantity ordered


    priceTotal = totalPrice;
    order_type = selectOrderClass.value;
    order_date = date.toLocaleDateString("en-US");
    productId = productClass.innerText;
    order_status = orderStatus;

    let orderInfo = {
        order_quantity: orderQuantity,
        total_price: priceTotal,
        order_type: order_type,
        order_date: order_date,
        product_id: productId,
        order_status: order_status
    };

    const url = "submit_order.php";

    console.log('Sending data: ', orderInfo);

    fetchRequestForCheckout(orderInfo, url);
    resetAllValues();
}
//for main section - SLIM GALLONS
//selectio order for slim gallons

function fetchRequestForCheckout(orderInfo, url) {
    console.log('Sending request with data:', orderInfo);
    console.log(url);
    
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(orderInfo)
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Bad status code from server.');
        }
        //console.log(response.json());
        return response.json(); // Always parse the JSON response
    })
    .then(function(responseData) {
        if (!responseData.success) {
            throw new Error('Bad response from server.');
        }
        // Handle successful response here
        console.log('Response from server:', responseData);

        const orderData = responseData.order_data; //order data as JSON form
        const totalQuantity = orderData.order_quantity; //order quantity
        const totalPrice = orderData.total_price; //total price ng order
        const orderType = orderData.order_type; //order type
        const orderId = orderData.order_id; //order id

        const productId = orderData.product_id; //product id
        const userId = orderData.user_id; //user id
        const orderDate = orderData.order_date; //order date

        const changeOrderStatus = "Pending";
        // Initialize an object to store the count of each order_id
        const orderIdCountMap = {};


        const checkoutPrefix = "101";
        const paymentPrefix = "205";
        const generatedCheckoutId = getGeneratedCheckoutAndPaymentId(checkoutPrefix) 
        const generatedPaymentId = getGeneratedCheckoutAndPaymentId(paymentPrefix)


        console.log("Payment ID: ", generatedPaymentId);
        console.log("Checkout ID: ", generatedCheckoutId);

        // Iterate through each item in orderData
        for (const order_id in orderData) {
            if (orderData.hasOwnProperty('order_id')) {
                // Increment the count for each order_id
                orderIdCountMap[order_id] = (orderIdCountMap[order_id] || 0) + 1;
            }
        }

        const totalItems = orderIdCountMap.order_id; //total items

        //console.log(orderCountMap.order_id);

        console.log("Type of Data: ", typeof(orderData));


        console.log('Order data: ', orderData);
        console.log("Order Quantity: ", totalQuantity);
        console.log("Total Price: ", totalPrice)
        console.log("Order Type: ", orderType)
        console.log("Total Items: ", totalItems)

        const overallItemPrices = document.querySelectorAll('.checkout--overall--price');
        const selectedItems = document.querySelector('.checkout--overall--items');

        const place_order = document.getElementById('placeOrderButton')

        const selectDelivery = document.querySelector('.delivery--select') //get the select class

        const closeCheckout = document.querySelectorAll('.close--checkout'); //get all the close--checkout classes

        const codOption = selectDelivery.options[0].textContent; //get the type of payment or delivery

        // Check if any option is selected
        if (selectDelivery.selectedIndex !== -1) {
            // Get the text content of the selected option
            const selectedOptionText = selectDelivery.options[selectDelivery.selectedIndex].textContent;
            
            // Log the text content of the selected option to the console
            console.log("Payment Method: ",selectedOptionText);
        } else {
            console.log('No option selected');
        }
        // Get the container element by its class name
        const container = document.querySelector('.updateContainer');

        // Clear existing content
        container.innerHTML = '';

        // Loop through the updated data and update the content of the container
        const itemContainer = document.createElement('div');
        itemContainer.className = 'container-sm ms-0 p-2 text-bg-light border border-3 border-gray rounded-2 d-flex';

        itemContainer.innerHTML = `
            <img src="../${orderData.product_img}" alt="" width="140" height="154" class="rounded-2 border border-2 border-gray my-2 mx-2 checkout--order--imgs">
            <div class="h6 fw-bold p-3 mt-3 py-1">
                <span class="h6 checkout--product--name">${orderData.product_type}</span>
                <span class="h6 fw-bold">${orderData.order_status}</span>
                <span class="h6">${orderData.order_id}</span>
                <div class="h6 mt-3">Order Type: 
                    <span class="h6 fw-bold checkout--order--type">${orderType}</span>
                </div>
                <div class="h6 mt-3 d-flex">Php 
                    <span class="h6 px-1 fw-bold checkout--unit--price">${getUnitPrice(orderData)}</span>
                </div>
                <div class="h6 mt-3 py-0">x 
                    <span class="h6 checkout--items--quantity">${totalQuantity}</span>
                </div>
            </div>
        `;

        // Append the item container to the main container
        container.appendChild(itemContainer);

        // Add a line break after each item except the last one
        // Add a line break after each item
        container.appendChild(document.createElement('br'));

        // Update Total Items Ordered
        selectedItems.textContent = `(${totalItems} items)`;

        // Update Total Price
        overallItemPrices.forEach(element => {
            element.textContent = parseFloat(totalPrice).toFixed(2); // Assuming priceToCheckout is a number
        });

        closeCheckout.forEach(element => {
            element.addEventListener('click', function () {
                // Get the checkout_id associated with this checkout
                const removeCheckoutId = {
                    order_id: orderId,
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
                        console.log(`Order with ID ${data.orderId} deleted successfully`); //${checkoutIdJSON}
                        setTimeout(() => {
                            window.location.reload();
                        }, 1000)
                        // Optionally, you can perform additional actions
                    } else {
                        console.error(`Error deleting order with ID ${data.orderId} : `, data.message);
                    }
                })
                .catch(error => {
                    console.error('Network error:', error);
                });
            });
        });
        
        // Function to calculate unit price based on order type
        function getUnitPrice(orderData) {
            switch(orderData.order_type) {
                case 'Buy':
                    return orderData.product_buy_price;
                case 'Refill':
                    return orderData.product_refill_price;
                case 'Borrow':
                    return orderData.product_borrow_price;
                default:
                    return 0;
            }
        }
        //generate checkout and payment id
        function getGeneratedCheckoutAndPaymentId(prefix){
            const length = 8 - prefix.length;
        
            let randomId = prefix;
        
            for (let i = 0; i < length; i++) {
                randomId += Math.floor(Math.random() * 10);
            }
        
            return randomId;
        }

        place_order.addEventListener('click', () => {
            const order_information = {
                order_quantity: totalQuantity,
                overall_price: totalPrice,
                order_type: orderType,
                overall_items: totalItems,
                order_date: orderDate,
                product_id: productId,
                order_id: orderId,
                order_status: changeOrderStatus,
                payment_id: generatedPaymentId,
                checkout_id: generatedCheckoutId,
                user_id: userId,
                payment_method: codOption,
                dates: {
                    checkout_date: orderDate,
                    payment_date: orderDate,
                    order_date: orderDate,
                }
            };

            console.log(JSON.stringify(order_information))
        
            // Convert the order_information object to JSON
            const orderInformationJSON = JSON.stringify(order_information);

            const inserDataFromShopURL = "insertDataFromShop.php";
        
            // Make a fetch request
            fetch(inserDataFromShopURL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: orderInformationJSON,
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                // Handle the response data here
            })
            .catch(error => {
                console.error('Error:', error);
            });
        });
        

    })
    .catch(function(error) {
        console.error('Error during request:', error);
    });
}

function processOrderForCart(orderStatus, success, items, selectOrderClass, productClass) {
    success.innerText = items.innerText; //display the quantity ordered
    orderQuantity = items.innerText; //extract the quantity ordered


    priceTotal = totalPrice;
    order_type = selectOrderClass.value;
    order_date = date.toLocaleDateString("en-US");
    productId = productClass.innerText;
    order_status = orderStatus;

    let orderInfo = {
        order_quantity: orderQuantity,
        total_price: priceTotal,
        order_type: order_type,
        order_date: order_date,
        product_id: productId,
        order_status: order_status
    };

    const url = "submit_order.php";

    console.log('Sending data: ', orderInfo);

    fetchRequestForCart(orderInfo, url);
    resetAllValues();
}
//for main section - SLIM GALLONS
//selectio order for slim gallons

function fetchRequestForCart(orderInfo, url) {
    console.log('Sending request with data:', orderInfo);
    console.log(url);
    
    fetch(url, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify(orderInfo)
    })
    .then(function(response) {
        if (!response.ok) {
            throw new Error('Bad status code from server.');
        }
        //console.log(response.json());
        return response.json(); // Always parse the JSON response
    })
    .then(function(responseData) {
        if (!responseData.success) {
            throw new Error('Bad response from server.');
        }
        // Handle successful response here
        console.log('Response from server:', responseData);
        console.log('Order data: ', responseData.order_data);
    })
    .catch(function(error) {
        console.error('Error during request:', error);
    });
}



function addResetEventListeners(elements) {
    elements.forEach(({ element, event }) => {
        element.addEventListener('click', resetAllValues);
    });
}

// Define your elements and events for Slim
const slimElements = [
    { element: closeSlim, event: 'click' },
    { element: closeCartSlim, event: 'click' },
    { element: noCartSlim, event: 'click' },
    { element: closeSuccessCartSlim, event: 'click' },
    { element: closeOrderSlim, event: 'click' },
    { element: noOrderSlim, event: 'click' },
    //{ element: closeSuccessOrderSlim, event: 'click' },
    // Add more elements as needed
];

// Define your elements and events for Rounded
const roundedElements = [
    { element: closeRounded, event: 'click' },
    { element: closeCartRound, event: 'click' },
    { element: noCartRound, event: 'click' },
    { element: closeSuccessCartRound, event: 'click' },
    { element: closeOrderRound, event: 'click' },
    { element: noOrderRound, event: 'click' },
    //{ element: closeSuccessOrderRound, event: 'click' },
    // Add more elements as needed
];

// Add reset event listeners for Slim
addResetEventListeners(slimElements);

// Add reset event listeners for Rounded
addResetEventListeners(roundedElements);




