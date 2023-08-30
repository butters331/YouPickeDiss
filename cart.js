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
    //get stocks of items in basket
    let stocksArray = JSON.parse(document.getElementById('stockListsBasket').innerText);
    let arrayIndex = 0;

    for (let i = 0; i < stocksArray.length; i++){
        if (parseInt(stocksArray[i][0]) == prodID){
            arrayIndex = i;
        }
    }

    let size = 'M';
    for(let i = 0; i < basket.length; i++){
        if (basket[i][0] == prodID){
            size = basket[i][5];
        }
    }

    let stockLimit = 0;
    
    let allowIncrement = true;

    let incButton = document.getElementById(("basketIncrementer" + prodID + '' + size));

    switch(size){
        case 'XS':
            stockLimit = stocksArray[arrayIndex][1];
            break;
        case 'S':
            stockLimit = stocksArray[arrayIndex][2];
            break;
        case 'M':
            stockLimit = stocksArray[arrayIndex][3];
            break;
        case 'L':
            stockLimit = stocksArray[arrayIndex][4];
            break;
        case 'XL':
            stockLimit = stocksArray[arrayIndex][5];
            break;
        case 'XXL':
            stockLimit = stocksArray[arrayIndex][6];
            break;
        case 'XXXL':
            stockLimit = stocksArray[arrayIndex][7];
            break;
        default:
            stockLimit = 0;
            break;
    }
    
    //look through basket items, if reach limit, disable incrementation
    for(let i = 0; i < basket.length; i++){
        if (basket[i][4] >= stockLimit){
            allowIncrement = false;
            incButton.disabled = true;
        }
        else {
            allowIncrement = true
        }
        //if item in basket is one selected
        if (basket[i][0] == prodID && allowIncrement){
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
        //if correct item found
        if (basket[i][0] == prodID){
            //find increment button and re-enable
            let incButton = document.getElementById("basketIncrementer" + prodID + '' + basket[i][5]);
            incButton.disabled = false;
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

function reEnableIncrement(){
    let incrementButton = document.getElementById('incrementButton');
    incrementButton.disabled = false;
    let value = document.getElementById('productQuantity');
    let stockArray = JSON.parse(document.getElementById('stockLists').innerText);
    if (value != null){
        value.innerHTML = "  1  ";
    }
    switch(getSize()){
        case 'XS':
            if (stockArray[0] == 1){
                incrementButton.disabled = true;
            }
            break;
        case 'S':
            if (stockArray[1] == 1){
                incrementButton.disabled = true;
            }
            break;
        case 'M':
            if (stockArray[2] == 1){
                incrementButton.disabled = true;
            }
            break;
        case 'L':
            if (stockArray[3] == 1){
                incrementButton.disabled = true;
            }
            break;
        case 'XL':
            if (stockArray[4] == 1){
                incrementButton.disabled = true;
            }
            break;
        case 'XXL':
            if (stockArray[5] == 1){
                incrementButton.disabled = true;
            }
            break;
        case 'XXXL':
            if (stockArray[6] == 1){
                incrementButton.disabled = true;
            }
            break;
        default:
            break;
    }
}

function incrementPreBasket(){
    value = document.getElementById('productQuantity');
    let incrementButton = document.getElementById('incrementButton');
    let stockArray = JSON.parse(document.getElementById('stockLists').innerText);
    let size = getSize();
    let stockAmount = 0;
    switch(size){
        case 'XS':
            stockAmount = stockArray[0];
            break;
        case 'S':
            stockAmount = stockArray[1];
            break;
        case 'M':
                stockAmount = stockArray[2];
                break;
        case 'L':
            stockAmount = stockArray[3];
            break;
        case 'XL':
            stockAmount = stockArray[4];
            break;
        case 'XXL':
            stockAmount = stockArray[5];
            break;
        case 'XXL':
            stockAmount = stockArray[6];
            break;
        default:
            stockAmount = 0;
            break;
}
    if (value != null){
        value.innerHTML = "  " + (parseInt(value.innerHTML) + 1) + "  ";
        if (parseInt(value.innerHTML) == stockAmount){
            incrementButton.disabled = true;
        }
    }
}

function decrementPreBasket(){
    value = document.getElementById('productQuantity');
    if (incrementButton.disabled){
        incrementButton.disabled = false;
    }
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
    if (size != null){
        return size.value;
    }
    else {
        return 'M';
    }
    
}

function setCorrectSizeID(size, xs, s, m, l, xl, xxl, xxxl){
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
        case 'XXXL':
            return String(xxxl);
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
                basketList.innerHTML += '<li><div class="basketItem"> <div class="basketItemContents"><img class="productBasketImage" src="'+ item[3] + '"></div><div class="basketItemText">'+ item[5] +' - ' + item[1] +'</div><div class="basketItemPrice">£'+ item[2] +'</div> <div class="basketItemQuantityBtn">  <button type="button" class="btn btn-outline-secondary btn-xs" onclick="decrementBasket(' + item[0] + ')">-</button>   ' + item[4] + '    <button type="button" class="btn btn-outline-secondary btn-xs" id="basketIncrementer' + item[0] + '' + item[5] + '" onclick="incrementBasket(' + item[0] + ')">+</button></div><div class="basketItemRemoveBtn"><button type="button" class="btn btn-outline-danger btn-xs" onclick="removeFromBasket(' + item[0] + ')">Remove</button></div></div></li><li><hr class="dropdown-divider"></li>';
                //total = price * quantity
                basketTotal += (item[2] * item[4]);
                basketNotificationQuantity += item[4];
            });
            if (basketTotal > freeOver){
                ukShipping = 0.0;
            }
            basketList.innerHTML += '<li style="align-self: flex-end;"><div id="totalLeft"><p class="basketTotal">Sub-Total: £' + Number(basketTotal).toFixed(2) + '</p><p class="basketTotal">Shipping (UK estimate): £'+ ukShipping +'</p><p class="basketTotal">Total: £' + Number(basketTotal + ukShipping).toFixed(2) + '</p></div><div id="procedeToCheckoutDiv"><button id="procedeToCheckoutBtn" type="button" class="btn btn-outline-success"> Buy Diss </button></div></li>';
            notifaction.innerHTML = '<i class="bi bi-bag-check-fill"></i><span style="top:6px!important;" class="position-absolute translate-middle badge rounded-pill bg-danger">'+ basketNotificationQuantity +'</span>';
            //var stripe = Stripe("pk_test_51MYzE2IJdJ7IL9xJjIuTgaHyLiIwH1A0KyFQ4MApHMj9ViMh0GCnhJHljpwgcfegCxBEouENMXlX7jYbWj81Rnko00uOPMBgJt");
            var stripe = Stripe('pk_live_51MYzE2IJdJ7IL9xJdiZ9JDuxn62fkzYnCDN78aJhX89FgzW5HV16r89HM6K926latmIHnMkHMDPH5TyjoYm6qNTZ004piMo38c');
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

