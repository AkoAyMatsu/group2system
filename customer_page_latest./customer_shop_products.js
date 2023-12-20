
const addSlim = document.querySelector('.add--slim') //add button ng slim
const minSlim = document.querySelector('.min--slim') //minus button ng slim
const quantitySlim = document.querySelector('.quantity--slim') //quantity ng slim
const slimPrice = document.querySelector('.slim--total') //total ng slim
const slimClose = document.querySelector('.slim--close--button') //close button ng slim modal
const slimOrderSelect = document.querySelector('.slim--order--select') //select order type
const slimPriceLabel = document.querySelector('.slimPrice') //price label ng slim
const slimOrderType = document.querySelector('.slim--order--type') //para malagyan ng order-type yung modal title
const slimAddToCart = document.querySelector('.slimAddToCart') //add to cart ng main section ng slim
const slimCartButton = document.querySelector('.slim--cart--button') //add to cart ng slim modal
const slimOrderNow = document.querySelector('.order--now--slim')
const slimBuy = document.querySelector('.slim--buy')

const addRound = document.querySelector('.add--rd')//add button ng round
const minRound = document.querySelector('.min--rd')//minus button ng round
const quantityRound = document.querySelector('.quantity--round')//quantity ng round
const roundPrice = document.querySelector('.round--total')//total ng round
const roundClose = document.querySelector('.round--close--button')//close button ng round modal
const roundOrderSelect = document.querySelector('.round--order--select')//select order type
const roundPriceLabel = document.querySelector('.roundPrice')//price label ng round
const roundOrderType = document.querySelector('.round--order--type')//para malagyan ng order type yung modal title
const roundAddToCart = document.querySelector('.roundAddToCart')//add to cart ng main section ng round
const roundCartButton = document.querySelector('.round--cart--button') //add to cart ng round modal
const roundOrderNow = document.querySelector('.order--now--round')
const roundBuy = document.querySelector('.round--buy')


const checkout = document.querySelector('.checkout')
const goToCart = document.querySelector('.goToCart')

const cartItems = document.querySelector('.cart--items')
const orderItems = document.querySelector('.order--items')

const confirmedCart = document.querySelector('.confirmedToCart')
const confirmedOrder = document.querySelector('.confirmedOrder')

const successCart = document.querySelector('.success--cart')
const successOrder = document.querySelector('.success--order')


const rdSlimPrice = 280; //Price sa bibili
const rdSlimPriceRefill = 30; //Price sa magrerefill
const rdSlimPriceBorrow = 50; //Price sa hihiram

checkout.addEventListener('click', () => {
    const pageUrl = 'customer_order_checkout.html'
    window.location.href = pageUrl
})
goToCart.addEventListener('click', () => {
    const pageUrl = 'customer_cart.html'
    window.location.href = pageUrl
})


//FOR SLIM GALLON WATER
//Function to compute the total price and the quantity 
function computeSlimPrice(price){
    let quantity = 0
    let totalPrice = 0

    slimCartButton.disabled = true;
    minSlim.disabled = true;
    slimOrderNow.disabled = true;
    //For Slim Gallon Containers
    addSlim.addEventListener('click', () => {
        quantity += 1;
        if (quantity > 0){
            slimCartButton.disabled = false;
            minSlim.disabled = false;
            slimOrderNow.disabled = false;
        }
        quantitySlim.innerText = quantity;

        totalPrice = price * quantity;
        totalPrice = totalPrice.toFixed(2);

        slimPrice.innerText = totalPrice;
    })

    minSlim.addEventListener('click', () => {
        if (quantity <= 1) {
            minSlim.disabled = true;
            slimCartButton.disabled = true;
            slimOrderNow.disabled = true;
            quantity = 0;
        } else {
            quantity -= 1;
        }
    
        quantitySlim.innerText = quantity;
    
        totalPrice = price * quantity;
        totalPrice = totalPrice.toFixed(2);
    
        slimPrice.innerText = totalPrice;
    })

    slimCartButton.addEventListener('click', ()=> {
        cartItems.innerText = quantity;
    })
    slimOrderNow.addEventListener('click', ()=> {
        orderItems.innerText = quantity;
    })

    confirmedCart.addEventListener('click', () => {
        successCart.innerText = cartItems.innerText //displays the total items successfully added to cart from the confirmation of cart addition
    })
    confirmedOrder.addEventListener('click', () => {
        successOrder.innerText = orderItems.innerText //displays the total items successfully ordered from the confirmation of order now
    })

    slimClose.addEventListener('click', () => {
        slimPrice.innerText = '0.00'
        quantitySlim.innerText = '0'
        quantity = 0
        totalPrice = 0
        //slimOrderType.innerText = ''
        minSlim.disabled = true;
        slimCartButton.disabled = true;
        slimOrderNow.disabled = true;
    })
}
//
function addSlimCart(val){
    slimAddToCart.addEventListener('click', () => {
        slimOrderType.innerText = "(" +`${val}` + ")"
    })
    slimBuy.addEventListener('click', () => {
        slimOrderType.innerText = "(" +`${val}` + ")"
    })
}
//If nothing was selected from a pool of options, 'buy' option will be performed or executed
if (!slimOrderSelect.selectedIndex){
    slimAddToCart.addEventListener('click', () => {
        slimOrderType.innerText = "(Buy)"
    })
    slimBuy.addEventListener('click', ()=> {
        slimOrderType.innerText = "(Buy)"
    })
    computeSlimPrice(rdSlimPrice)
}   
//FOR SELECTION OF ORDERS
slimOrderSelect.addEventListener('change', () => {
    // Perform actions based on the selected option's value
    if (slimOrderSelect.value === 'Buy') {
        // Do something for Option 1
        console.log('Buy')
        slimPriceLabel.innerText = rdSlimPrice.toFixed(2)
        const val = slimOrderSelect.value
        addSlimCart(val)
        computeSlimPrice(rdSlimPrice)
        
    } else if (slimOrderSelect.value === 'Refill') {
        // Do something for Option 2
        console.log('Refill')
        slimPriceLabel.innerText = rdSlimPriceRefill.toFixed(2)
        const val = slimOrderSelect.value
        addSlimCart(val)
        computeSlimPrice(rdSlimPriceRefill)

    } else if (slimOrderSelect.value === 'Borrow') {
        // Do something for Option 3
        console.log('Borrow')
        slimPriceLabel.innerText = rdSlimPriceBorrow.toFixed(2)
        const val = slimOrderSelect.value
        addSlimCart(val)
        computeSlimPrice(rdSlimPriceBorrow)
    }
})

//-------------------------------------------------END OF SLIM ORDER SECTION-----------------------------//

//FOR ROUND SECTION
function addRoundCart(val){
    roundAddToCart.addEventListener('click', () => {
        roundOrderType.innerText = "(" +`${val}` + ")"
    })
    roundBuy.addEventListener('click', () => {
        roundOrderType.innerText = "(" +`${val}` + ")"
    })
}
//If nothing was selected from a pool of options, 'buy' option will be performed or executed
if (!roundOrderSelect.selectedIndex){
    roundAddToCart.addEventListener('click', () => {
        roundOrderType.innerText = "(Buy)"
    })
    roundBuy.addEventListener('click', () => {
        roundOrderType.innerText = "(Buy)"
    })
    computeRoundPrice(rdSlimPrice)
} 
//FOR COMPUTING ROUND GALLON PRICE
function computeRoundPrice(price){
    let quantity = 0
    let totalPrice = 0

    roundCartButton.disabled = true;
    minRound.disabled = true;
    roundOrderNow.disabled = true;
    //For Slim Gallon Containers
    addRound.addEventListener('click', () => {
        quantity += 1;
        if (quantity > 0){
            roundCartButton.disabled = false;
            minRound.disabled = false;
            roundOrderNow.disabled = false;
        }
        quantityRound.innerText = quantity;

        totalPrice = price * quantity;
        totalPrice = totalPrice.toFixed(2);

        roundPrice.innerText = totalPrice;
    })

    //Button for decrement in the quantity of round
    minRound.addEventListener('click', () => {
        if (quantity <= 1) {
            minRound.disabled = true;
            roundCartButton.disabled = true;
            roundOrderNow.disabled = true;
            quantity = 0;
        } else {
            quantity -= 1;
        }
    
        quantityRound.innerText = quantity;
    
        totalPrice = price * quantity;
        totalPrice = totalPrice.toFixed(2);
    
        roundPrice.innerText = totalPrice;
    })

    roundCartButton.addEventListener('click', ()=> {
        cartItems.innerText = quantity;
    })
    roundOrderNow.addEventListener('click', ()=> {
        orderItems.innerText = quantity;
    })

    confirmedCart.addEventListener('click', () => {
        successCart.innerText = cartItems.innerText //displays the total items successfully added to cart from the confirmation of cart addition
    })
    confirmedOrder.addEventListener('click', () => {
        successOrder.innerText = orderItems.innerText //displays the total items successfully ordered from the confirmation of order now
    })

    roundClose.addEventListener('click', () => {
        roundPrice.innerText = '0.00'
        quantityRound.innerText = '0'
        quantity = 0
        totalPrice = 0
        //roundOrderType.innerText = ''
        minRound.disabled = true;
        roundCartButton.disabled = true;
        roundOrderNow.disabled = true;
    })
}
//FOR SELECTION OF ROUND GALLON ORDERS
roundOrderSelect.addEventListener('change', () => {
    // Perform actions based on the selected option's value
    if (roundOrderSelect.value === 'Buy') {
        // Do something for Option 1
        console.log('Buy')
        roundPriceLabel.innerText = rdSlimPrice.toFixed(2)
        const val = roundOrderSelect.value
        addRoundCart(val)
        computeRoundPrice(rdSlimPrice)
        
    } else if (roundOrderSelect.value === 'Refill') {
        // Do something for Option 2
        console.log('Refill')
        roundPriceLabel.innerText = rdSlimPriceRefill.toFixed(2)
        const val = roundOrderSelect.value
        addRoundCart(val)
        computeRoundPrice(rdSlimPriceRefill)

    } else if (roundOrderSelect.value === 'Borrow') {
        // Do something for Option 3
        console.log('Borrow')
        roundPriceLabel.innerText = rdSlimPriceBorrow.toFixed(2)
        const val = roundOrderSelect.value
        addRoundCart(val)
        computeRoundPrice(rdSlimPriceBorrow)
    }
})






