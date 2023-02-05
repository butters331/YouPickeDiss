function replaceSearchButton(){
    let searchButton = document.getElementById("initialSearchButton");
    searchButton.innerHTML = '<div class="searchBar" style="padding-left:5px;padding-right:5px;"><form action="results.php" class="d-flex"><input class="form-control me-2 w-50" type="search" placeholder="Search" name="query" aria-label="Search" required><br><button class="btn btn-outline-success" type="submit">Search</button></form></div>'
}
