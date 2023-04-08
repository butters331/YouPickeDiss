//pull basket from local storage
var basket = sessionStorage.getItem('basket');
var ukShipping = 5.99;
var freeOver = 200.00;

//if no basket yet, create an empty one
if (basket == null){
    basket = [];
}
else{
    basket = JSON.parse(basket);
}
populateBasket();

function setHidden(){
    localStorage.setItem("hidden", "true");
}

function toggleHidden(){
    if (localStorage.getItem("hidden") === "true"){
        localStorage.setItem("hidden", "false");
    }
    else {
        localStorage.setItem("hidden", "true");
    }
}

function addToBasket(prodID, name, price, imgPath, quantity, size, stripeID){
    fbq('track', 'AddToCart');
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
    localStorage.setItem("hidden", "false");
    location.reload();
}

function clearBasket(){
    for (let i = basket.length - 1; i >= 0 ; i--){
        removeFromBasket(basket[i][0]);
    }
}

function incrementBasket(prodID){
    for(let i = 0; i < basket.length; i++){
        if (basket[i][0] == prodID){
            basket[i][4] += 1;
        }
    }
    sessionStorage.setItem('basket', JSON.stringify(basket));
    localStorage.setItem("hidden", "false");
    populateBasket();
    location.reload();
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
    localStorage.setItem("hidden", "false");
    populateBasket();
    location.reload();
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

function setCorrectSizeID(size, xs, s, m, l, xl, xxl){
    switch(size){
        case 'XS':
            return String(xs);
            break;

        case 'S':
            return String(s);
            break;
        
        case 'M':
            return String(m);
            break;
        
        case 'L':
            return String(l);
            break;
        
        case 'XL':
            return String(xl);
            break;

        case 'XXL':
            return String(xxl);
            break;

        default:
            return String(m);
            break;
    }
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
            let basketNotificationQuantity = 0;
            basket.forEach(item => {
                basketList.innerHTML += '<li><div class="basketItem"> <div class="basketItemContents"><img class="productBasketImage" src="'+ item[3] + '"></div><div class="basketItemText">'+ item[5] +' - ' + item[1] +'</div><div class="basketItemPrice">£'+ item[2] +'</div> <div class="basketItemQuantityBtn">  <button type="button" class="btn btn-outline-secondary btn-xs" onclick="decrementBasket(' + item[0] + ')">-</button>   ' + item[4] + '    <button type="button" class="btn btn-outline-secondary btn-xs" onclick="incrementBasket(' + item[0] + ')">+</button></div><div class="basketItemRemoveBtn"><button type="button" class="btn btn-outline-danger btn-xs" onclick="removeFromBasket(' + item[0] + ')">Remove</button></div></div></li><li><hr class="dropdown-divider"></li>';
                //total = price * quantity
                basketTotal += (item[2] * item[4]);
                basketNotificationQuantity += item[4];
            });
            if (basketTotal > freeOver){
                ukShipping = 0.0;
            }
            basketList.innerHTML += '<li style="align-self: flex-end;"><div id="totalLeft"><p class="basketTotal">Sub-Total: £' + Number(basketTotal).toFixed(2) + '</p><p class="basketTotal">Shipping (UK estimate): £'+ ukShipping +'</p><p class="basketTotal">Total: £' + Number(basketTotal + ukShipping).toFixed(2) + '</p></div><div id="procedeToCheckoutDiv"><button id="procedeToCheckoutBtn" type="button" class="btn btn-outline-success"> Buy Diss </button></div></li>';
            notifaction.innerHTML = '<i class="bi bi-bag-check-fill"></i><span style="top:6px!important;" class="position-absolute translate-middle badge rounded-pill bg-danger">'+ basketNotificationQuantity +'</span>';
            var stripe = Stripe('pk_live_51MYzE2IJdJ7IL9xJoMYTXhga0vugaKk4CjjRFzC48CFTOS7yBmLyqrAhMXmM30KZeHWrbqzuJpBRJo2GVV5xtpIs00yIAwzH7s');
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
            // console.log(basketJSON);
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

