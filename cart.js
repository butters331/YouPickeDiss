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
    populateBasket();
}

function decrementBasket(prodID){
    for(let i = 0; i < basket.length; i++){
        if (basket[i][0] == prodID){
            basket[i][4] -= 1;
        }
    }
    populateBasket();
}

function updateQuantities(){
    for(let i = 0; i < basket.length; i++){
        if (document.getElementById('quantityOfID' + basket[i][0])!= null){
            currentQuantity = document.getElementById('quantityOfID' + basket[i][0]);
            basket[i][4] = parseInt(currentQuantity);
        }  
    }
    sessionStorage.setItem('basket', JSON.stringify(basket));
}

function populateBasket(){
    var basketList = document.getElementById('basketList');
    if (basketList != null){
        if (basket.length == 0){
            basketList.innerHTML = "basket empty";
        }
        else{
            while (basketList.firstChild){
                basketList.removeChild(basketList.firstChild)
            }
            basket.forEach(item => {
                basketList.innerHTML += '<li><div class="basketItem"> <div class="basketItemContents"><img class="productBasketImage" src="'+ item[3] + '"></div><div class="basketItemText">'+ item[1] +'</div><div class="basketItemPrice">£'+ item[2] +'</div> <div class="basketItemQuantityBtn">  <button type="button" class="btn btn-outline-secondary btn-xs" onclick="decrementBasket(' + item[0] + ')">-</button>   ' + item[4] + '    <button type="button" class="btn btn-outline-secondary btn-xs" onclick="incrementBasket(' + item[0] + ')">+</button></div><div class="basketItemRemoveBtn"><button type="button" class="btn btn-outline-danger btn-xs" onclick="removeFromBasket(' + item[0] + ')">Remove</button></div></div></li><li><hr class="dropdown-divider"></li>';
            });
        }
    }
 
}

