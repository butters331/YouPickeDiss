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

function addToBasket(prodID, name, price, imgPath, quantity, size, stripeID){
    let alreadyIn = false;
    for (let x = 0; x < basket.length; x++){
        if (basket != null && basket[x][0] == prodID && basket[x][5] == size){
            alreadyIn = true;
        }
    }
    if (!alreadyIn){
        basket.push([prodID, name, price, imgPath, quantity, size, stripeID]);
        sessionStorage.setItem('basket', JSON.stringify(basket));
        populateBasket();
        location.reload();
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
    location.reload();
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

function getSize(){
    let size = document.getElementById('sizeSelector');
    return size.value;
}

function populateBasket(){
    var basketList = document.getElementById('basketList');
    var notifaction = document.getElementById('basketButton')
    if (basketList != null){
        if (basket.length == 0){
            basketList.innerHTML = "basket empty";
            notifaction.innerHTML = '<i class="bi bi-bag-check-fill"></i>'
        }
        else{
            while (basketList.firstChild){
                basketList.innerHTML = "";
            }
            let basketTotal = 0;
            basket.forEach(item => {
                basketList.innerHTML += '<li><div class="basketItem"> <div class="basketItemContents"><img class="productBasketImage" src="'+ item[3] + '"></div><div class="basketItemText">'+ item[5] +' - ' + item[1] +'</div><div class="basketItemPrice">£'+ item[2] +'</div> <div class="basketItemQuantityBtn">  <button type="button" class="btn btn-outline-secondary btn-xs" onclick="decrementBasket(' + item[0] + ')">-</button>   ' + item[4] + '    <button type="button" class="btn btn-outline-secondary btn-xs" onclick="incrementBasket(' + item[0] + ')">+</button></div><div class="basketItemRemoveBtn"><button type="button" class="btn btn-outline-danger btn-xs" onclick="removeFromBasket(' + item[0] + ')">Remove</button></div></div></li><li><hr class="dropdown-divider"></li>';
                //total = price * quantity
                basketTotal += (item[2] * item[4]);
            });
            basketList.innerHTML += '<li style="align-self: flex-end;"><div id="totalLeft"><p class="basketTotal">Sub-Total: £' + Number(basketTotal).toFixed(2) + '</p><p class="basketTotal">Shipping: £4.99</p><p class="basketTotal">Total: £' + Number(basketTotal + 4.99).toFixed(2) + '</p></div><div id="procedeToCheckoutDiv"><button id="procedeToCheckoutBtn" type="button" class="btn btn-outline-success"> Buy Diss </button></div></li>';
            notifaction.innerHTML = '<i class="bi bi-bag-check-fill"></i><span style="top:6px!important;" class="position-absolute translate-middle badge rounded-pill bg-danger">'+ basket.length +'</span>';
            var stripe = Stripe('pk_test_51MYzE2IJdJ7IL9xJjIuTgaHyLiIwH1A0KyFQ4MApHMj9ViMh0GCnhJHljpwgcfegCxBEouENMXlX7jYbWj81Rnko00uOPMBgJt');
            const btn = document.getElementById("procedeToCheckoutBtn")
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                //get session id from page and add it to checkout session
                var sessionIdRetrieved = (document.getElementById("sessionIdDiv")).innerText.trim();
                stripe.redirectToCheckout({
                    sessionId: sessionIdRetrieved
                });
            });



            var basketJSON = JSON.stringify(basket);
            console.log(basketJSON);
            // var xhr = new XMLHttpRequest();
            // xhr.open("POST", "https://www.ypd4tp.co.uk/headerAndMenu.php", true);
            // xhr.setRequestHeader("Content-Type", "application/json");
            // xhr.send(basketJSON); 

            // $.ajax({
            //     method: "POST",
            //     url: "catch.php",
            //     data: { basket: basketJSON, age: "19" }
            // }).done(function( msg ) {
            //     alert(msg);
            // });

            $.ajax({
                type: "POST",
                url: "catch.php",
                data: {basket:JSON.stringify(basket)},
                beforeSend: function(xhr){xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")},
                success: function(res){
                    console.log(res);
                }
            });   
        }
    }
 
}

