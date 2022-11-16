//pull basket from local storage
var basket = localStorage.getItem('basket');

//if no basket yet, create an empty one
if (basket == null){
    basket = [[],[]];
}
else{
    basket = JSON.parse(basket);
}

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
    var basketList = document.getElementById('basketList');
    basketList.innerHTML = '';
    basket.forEach(item => {
        basketList.innerHTML += '<li>'+ item[1] + '</li><li><hr class="dropdown-divider"></li>';
    });
}