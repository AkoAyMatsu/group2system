const toPay = document.querySelector('.toPay') //accesses the class toPay from the customer_order_status.html
const toShip = document.querySelector('.toShip')//accesses the class toShip from the customer_order_status.html
const toReceive = document.querySelector('.toReceive')//accesses the class toReceive from the customer_order_status.html
const completed = document.querySelector('.completed')//accesses the class completed from the customer_order_status.html
const cancelled = document.querySelector('.cancelled')//accesses the class cancelled from the customer_order_status.html


const toPayContainer = document.querySelector('.toPayContainer')


//create an event listeners for every class

//toPay class

toPay.addEventListener('click', () => {
    toPayContainer.appendChild = 
    `
        
        <tr class="border border-black border-2">
            <td colspan="5">
                <div class="container-sm w-70 ms-5 p-2 text-bg-light border border-2 border-black rounded-1 rounded-bottom-0 d-flex mt-5 h-50">
                    <img src="rounded-gallon.jpeg" alt="" width="160" height="175" class="rounded-2 border border-1 border-black my-3 mx-3">
                    <div class="h6 fw-bold p-3 mt-3 py-1 h-25 w-100 text-end">
                        Pending
                        <div class="h6 text-start mt-3 fw-bold">18L Rounded Gallon Water</div>
                        <div class="h6 mt-2 d-flex">Order Type: 
                            <span class="h6 px-1 fw-bold">Refill</span> <!--FORM PRICE-->
                        </div>
                        <div class="h6 mt-4 py-1">
                            x <span class="h6">10</span>
                        </div>
                        <div class="h6 mt-0 py-0 text-danger">
                            Php <span class="h6 text-danger">300.00</span>
                        </div>
                    </div>
                </div>

                <div class="container-sm w-70 ms-5 p-2 text-bg-light border border-2 border-black rounded-0 rounded-bottom-1 d-flex mt-0 h-50">
                    <div class="h6 mt-2 w-50 mx-3 px-0">1
                        <span class="h6">item/s</span>
                    </div>
                    <div class="container d-flex justify-content-end mt-2">
                        <div class="h6">Order Total: 
                            <span class="h6 text-danger">Php</span>
                        </div>
                        <div class="h6 text-danger px-1">300.00</div>
                    </div> 
                </div>

                <div class="container-sm w-70 ms-5 p-2 d-flex mt-3 h-50 border-bottom border-3">
                    <div class="h6 mt-2 w-50 mx-3 px-0 text-primary">Waiting for order confirmation
                    </div>
                    <div class="container d-flex justify-content-end mt-2">
                        05/20/2023
                    </div> 
                </div>


                <div class="container-sm w-70 ms-5 p-2 d-flex mt-3 h-50">
                    <button class="btn btn-danger text-light text-start">Cancel Order</button>
                </div>

                
                
            </td>
        </tr>
    `
})

toShip.addEventListener('click', () => {
    
})

toReceive.addEventListener('click', () => {
    
})

completed.addEventListener('click', () => {
    
})

cancelled.addEventListener('click', () => {
    
})