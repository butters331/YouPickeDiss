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
    basket.push([prodID, name, price, imgPath, quantity]);
    sessionStorage.setItem('basket', JSON.stringify(basket));
    populateBasket();
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
            basket.forEach(item => {
                basketList.innerHTML += '<li><div class="basketItem"> <div class="basketItemContents"><img class="productBasketImage" src="'+ item[3] + '"></div><div class="basketItemText">'+ item[1] +'</div><div class="basketItemPrice">£'+ item[2] +'</div> <div class="basketItemQuantityBtn">  <button type="button" class="btn btn-outline-secondary btn-xs" onclick="decrementBasket(' + item[0] + ')">-</button>   ' + item[4] + '    <button type="button" class="btn btn-outline-secondary btn-xs" onclick="incrementBasket(' + item[0] + ')">+</button></div><div class="basketItemRemoveBtn"><button type="button" class="btn btn-outline-danger btn-xs" onclick="removeFromBasket(' + item[0] + ')">Remove</button></div></div></li><li><hr class="dropdown-divider"></li>';
            });
            notifaction.innerHTML = '<i class="bi bi-bag-check-fill"></i><span class="position-absolute top-20 start-100 translate-middle badge rounded-pill bg-danger">'+ basket.length +'</span>';
        }
    }
 
}

