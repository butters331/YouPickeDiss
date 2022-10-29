
function itemClicked(itemID) {
    localStorage.setItem("productID", itemID);
    document.write("ID Stored: " + itemID);
}

function recieveItem() {
    return localStorage.getItem("productID");
}