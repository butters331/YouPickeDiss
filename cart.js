//pull basket from local storage
var basket = sessionStorage.getItem('basket');

//if no basket yet, create an empty one
if (basket == null){
    basket = [];
}
else{
    basket = JSON.parse(basket);
}
populateBasket();

function addToBasket(prodID, name, price, imgPath, quantity){
    let alreadyIn = false;
    for (let x = 0; x < basket.length; x++){
        if (basket != null && basket[x][0] == prodID){
            alreadyIn = true;
        }
    }
    if (!alreadyIn){
        basket.push([prodID, name, price, imgPath, quantity]);
        sessionStorage.setItem('basket', JSON.stringify(basket));
        populateBasket();
    }
    
}

function removeFromBasket(prodID){
    for(let i = 0; i < basket.length; i++){
        if (basket[i][0] == prodID){
            basket.splice(i, 1);
            sessionStorage.setItem('basket', JSON.stringify(basket));
            populateBasket();
        }
    }
}

function incrementBasket(prodID){
    for(let i = 0; i < basket.length; i++){
        if (basket[i][0] == prodID){
            basket[i][4] += 1;
        }
    }
    sessionStorage.setItem('basket', JSON.stringify(basket));
    populateBasket();
}

function decrementBasket(prodID){
    for(let i = 0; i < basket.length; i++){
        if (basket[i][0] == prodID){
            if (basket[i][4] > 1){
                basket[i][4] -= 1;
            }
        }
    }
    sessionStorage.setItem('basket', JSON.stringify(basket));
    populateBasket();
}

function incrementPreBasket(){
    value = document.getElementById('productQuantity');
    if (value != null){
        value.innerHTML = "  " + (parseInt(value.innerHTML) + 1) + "  ";
    }
    
}

function decrementPreBasket(){
    value = document.getElementById('productQuantity');
    if (value != null && (parseInt(value.innerHTML) != 1)){
        value.innerHTML = "  " + (parseInt(value.innerHTML) - 1) + "  ";
    }
}

function getPreBasket(){
    value = document.getElementById('productQuantity');
    if (value != null){
        return (parseInt(document.getElementById('productQuantity').innerHTML));
    }
    else {
        return (null);
    }
    
}

function populateBasket(){
    var basketList = document.getElementById('basketList');
    var notifaction = document.getElementById('basketDropdown')
    if (basketList != null){
        if (basket.length == 0){
            basketList.innerHTML = "basket empty";
            notifaction.innerHTML = '<i class="bi bi-bag-check-fill"></i>'
        }
        else{
            while (basketList.firstChild){
                basketList.removeChild(basketList.firstChild)
            }
            let basketTotal = 0;
            basket.forEach(item => {
                basketList.innerHTML += '<li><div class="basketItem"> <div class="basketItemContents"><img class="productBasketImage" src="'+ item[3] + '"></div><div class="basketItemText">'+ item[1] +'</div><div class="basketItemPrice">£'+ item[2] +'</div> <div class="basketItemQuantityBtn">  <button type="button" class="btn btn-outline-secondary btn-xs" onclick="decrementBasket(' + item[0] + ')">-</button>   ' + item[4] + '    <button type="button" class="btn btn-outline-secondary btn-xs" onclick="incrementBasket(' + item[0] + ')">+</button></div><div class="basketItemRemoveBtn"><button type="button" class="btn btn-outline-danger btn-xs" onclick="removeFromBasket(' + item[0] + ')">Remove</button></div></div></li><li><hr class="dropdown-divider"></li>';
                //total = price * quantity
                basketTotal += (item[2] * item[4]);
            });
            basketList.innerHTML += '<li><div id="totalLeft"><p class="basketTotal">Sub-Total: £' + Number(basketTotal).toFixed(2) + '</p><p class="basketTotal">Shipping: £4.99</p><p class="basketTotal">Total: £' + Number(basketTotal + 4.99).toFixed(2) + '</p></div><div id="procedeToCheckoutDiv"><button id="procedeToCheckoutBtn" type="button" class="btn btn-outline-success"> Checkout </button></div></li>';
            notifaction.innerHTML = '<i class="bi bi-bag-check-fill"></i><span class="position-absolute top-20 start-100 translate-middle badge rounded-pill bg-danger">'+ basket.length +'</span>';
        }
    }
 
}

