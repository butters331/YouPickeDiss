//pull basket from local storage
var basket = localStorage.getItem('basket');

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
    localStorage.setItem('basket', JSON.stringify(basket));
    populateBasket();
}

function removeFromBasket(prodID){
    for(let i = 0; i < basket.length; i++){
        if (basket[i][0] == prodID){
            basket.splice(i, 1);
            localStorage.setItem('basket', JSON.stringify(basket));
            populateBasket();
        }
    }
}

function populateBasket(){
    localStorage.clear();
    var basketList = document.getElementById('basketList');
    if (basket.length == 0){
        basketList.innerHTML = "basket empty";
    }
    else{
        basketList.innerHTML = '';
        basket.forEach(item => {
            basketList.innerHTML += '<li><div class="basketItem"> <div class="basketItemContents"><img class="productBasketImage" src="'+ item[3] + '"></div><div class="basketItemText">'+ item[1] +'</div><div class="basketItemPrice">£'+ item[2] +'</div> <div class="basketItemRemoveBtn"><button type="button" class="btn btn-outline-danger btn-sm">Remove</button></div></div></li><li><hr class="dropdown-divider"></li>';
    });
    }
    
}

