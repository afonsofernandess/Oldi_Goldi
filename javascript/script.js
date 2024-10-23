

document.body.addEventListener('click', function(event) {
    if (event.target.matches('#heart i')) {
        const heart = event.target;
        const itemID = heart.dataset.itemId;
        fetch('../api/api_add_to_whishlist.php?item_id=' + encodeURIComponent(itemID))
        .then(response => response.text())
        .then(text => {
            heart.className = text;
        });
    }
});

const addItem = document.getElementById('itemWhishlist');
console.log(addItem);
if(addItem){
addItem.addEventListener('click', function(event) {
    event.preventDefault();

        const itemID = addItem.getAttribute('data-item-id');
        fetch('../api/api_add_to_whishlist.php?item_id=' + encodeURIComponent(itemID))
        .then(response => response.text())
        .then(text => {
            document.getElementById('heartItem').className = text;
        });
    


});

}