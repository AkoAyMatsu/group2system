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
const closeSuccessOrderRound = document.querySelector(".cso_roundedgallonwater");

const closeSuccessCartSlim = document.querySelector('.csc_slimgallonwater')//close successfully addition to cart
const closeSuccessOrderSlim = document.querySelector(".cso_slimgallonwater");


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
    processOrder(order_status, successCartRound, cartItemsRound, selectOrderRounded, productRoundClass);
});

confirmOrderRound.addEventListener('click', () => {
    order_status = 'In Progress'
    processOrder(order_status, successOrderRound, orderItemsRound, selectOrderRounded, productRoundClass);
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
    processOrder(order_status, successCartSlim, cartItemsSlim, selectOrderSlim, productSlimClass);
});

confirmOrderSlim.addEventListener('click', () => {
    order_status = 'In Progress'
    processOrder(order_status, successOrderSlim, orderItemsSlim, selectOrderSlim, productSlimClass);
});



function processOrder(orderStatus, success, items, selectOrderClass, productClass) {
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
        order_status: order_status,
    };

    const url = "submit_order.php";

    console.log('Sending data: ', orderInfo);

    fetchRequest(orderInfo, url);
    resetAllValues();
}
//for main section - SLIM GALLONS
//selectio order for slim gallons

function fetchRequest(orderInfo, url){
    console.log('Sending request with data:', orderInfo);
    console.log(url);
    fetch(url, { //to submit_order.php
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
        // Check if response has data
        if (response.headers.get('content-length') === '0') {
            throw new Error('Empty response from server.');
        }
        return response.json();
    })
    .then(function(responseData) {
      if (!(responseData.data && responseData.data.success)) {
        throw new Error('Bad response from server.');
      }
    })
    .catch(function(error) {
        console.error('Error during JSON parsing:', error);
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
    { element: closeSuccessOrderSlim, event: 'click' },
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
    { element: closeSuccessOrderRound, event: 'click' },
    // Add more elements as needed
];

// Add reset event listeners for Slim
addResetEventListeners(slimElements);

// Add reset event listeners for Rounded
addResetEventListeners(roundedElements);




