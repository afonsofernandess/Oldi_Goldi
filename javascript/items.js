const deleteBTn = document.getElementById('delete_item');
console.log(deleteBTn);
if(deleteBTn){
deleteBTn.addEventListener('click',function(event){
    event.preventDefault();
 document.getElementById('Pop_Up_delete').style.display = "block";


});
}
const cancelBTn = document.getElementById('cancelBtn');
if(cancelBTn){
cancelBTn.addEventListener('click',function(event){
    event.preventDefault();
    document.getElementById('Pop_Up_delete').style.display = "none";
});

}

const orderBy = document.getElementById('orderBy');
if(orderBy){
orderBy.addEventListener('click', function() {
    const dropdownMenu = document.getElementById('dropdownMenu');
    const icon = document.getElementById('orderBy').querySelector('i');

    if (dropdownMenu.style.display === 'none') {
        dropdownMenu.style.display = 'block';
        icon.className = 'fa-solid fa-chevron-up';
    } else {
        dropdownMenu.style.display = 'none';
        icon.className = 'fa-solid fa-chevron-down';
    }
});

}

const filter = document.getElementById('Show_Filter');
console.log(filter);
if(filter){
filter.addEventListener('click', function() {
    console.log('filter');
    const Aside = document.getElementById('Filters');
    const ItemsSection = document.querySelector('section.items');
    const filtertext = document.getElementById('Show_Filter');
    if (Aside.style.display === 'none') {
        Aside.style.display = 'block';
        ItemsSection.style.gridTemplateColumns = '1fr 3fr';
        filtertext.innerHTML = 'Hide Filters <i class="fa-solid fa-sliders"></i>';
    } else {
        Aside.style.display = 'none';
        ItemsSection.style.gridTemplateColumns = '1fr';
        filtertext.innerHTML = 'Show Filters <i class="fa-solid fa-sliders"></i>';
    }
});
}

const summaries = document.querySelectorAll('summary');
if(summaries){
summaries.forEach(function(summary) {
    summary.addEventListener('click', function() {
        const icon = summary.querySelector('i');
        if (icon.className === 'fa-solid fa-chevron-down') {
            icon.className = 'fa-solid fa-chevron-up';
        } else {
            icon.className = 'fa-solid fa-chevron-down';
        }
    });
});
}
const sizeCheckboxes = document.querySelectorAll('section#sizeSection input[type="checkbox"]');
const brandCheckboxes = document.querySelectorAll('section#brandSection input[type="checkbox"]');
const conditionCheckboxes = document.querySelectorAll('section#ConditionSection input[type="checkbox"]');
const categoryCheckboxes = document.querySelectorAll('section#CategorySection input[type="checkbox"]');
const minPriceInput = document.querySelector('section#PriceSection input#Sprice');
const maxPriceInput = document.querySelector('section#PriceSection input#Finalprice');
const itemsContainer = document.querySelector('#Garticles');

const searchCheckbox = document.querySelector('#search_filter');


function updateItems() {
    console.log('updateItems');
    const selectedSizes = Array.from(sizeCheckboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.dataset.sizeId);

    const selectedBrands = Array.from(brandCheckboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.dataset.brandId);

    const selectedConditions = Array.from(conditionCheckboxes)
        .filter(checkbox => checkbox.checked)
        .map(checkbox => checkbox.dataset.conditionId);

    const selectedCategories = Array.from(categoryCheckboxes)
    .filter(checkbox => checkbox.checked)
    
    .map(checkbox => checkbox.dataset.categoryId);
    //localStorage.setItem('selectedCategories', JSON.stringify(selectedCategories)); //guarda numa local storage as cetegorias selecionadas
    //localStorage.setItem('selectedSizes', JSON.stringify(selectedSizes));
    //localStorage.setItem('selectedBrands', JSON.stringify(selectedBrands));
    //localStorage.setItem('selectedConditions', JSON.stringify(selectedConditions));

    const minPrice = minPriceInput.value;
    const maxPrice = maxPriceInput.value;
    let searchTerm = null;

    const searchTermElement = document.getElementById('search-term');
    
    if (searchTermElement && searchCheckbox.checked) {
    searchTerm = searchTermElement.textContent;
    }
    //localStorage.setItem('minPrice', minPrice);
    //localStorage.setItem('maxPrice', maxPrice);
    let url = '../api/api_filter_items.php';
    if (selectedSizes.length > 0) {
        url += '?size_ids=' + encodeURIComponent(JSON.stringify(selectedSizes));
    }
    if (selectedBrands.length > 0) {
        const separator = url.includes('?') ? '&' : '?';
        url += separator + 'brand_ids=' + encodeURIComponent(JSON.stringify(selectedBrands));
    }
    if (selectedConditions.length > 0) {
        const separator = url.includes('?') ? '&' : '?';
        url += separator + 'condition_ids=' + encodeURIComponent(JSON.stringify(selectedConditions));
    }
    if (selectedCategories.length > 0) {
        const separator = url.includes('?') ? '&' : '?';
        url += separator + 'category_ids=' + encodeURIComponent(JSON.stringify(selectedCategories));
    }
    if(minPrice){
        const separator = url.includes('?') ? '&' : '?';
        url += separator + 'min_price=' + encodeURIComponent(minPrice);
    }
    if(maxPrice){
        const separator = url.includes('?') ? '&' : '?';
        url += separator + 'max_price=' + encodeURIComponent(maxPrice);
    }
    
    if(searchTerm){
        const separator = url.includes('?') ? '&' : '?';
        url += separator + 'search=' + encodeURIComponent(searchTerm);
    }
    
    fetch(url)
        .then(response => response.text())
        .then(html => {
            itemsContainer.innerHTML = html;
        });
        console.log('finished');
}



const remove_search = document.getElementById('remove-search-term');
if(remove_search){
remove_search.addEventListener('click', function(){

    document.getElementById('search-term-container').style.display = "none";

    document.getElementById('search_filter').checked = false;

    updateItems();
    

    const url = new URL(window.location.href);

    
    const params = new URLSearchParams(url.search); //gets the part after the ?

    params.delete('input'); //delets the part of input

    url.search = params.toString();

    window.history.replaceState({}, '', url.toString());
    

});

}



sizeCheckboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', updateItems);
});

brandCheckboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        updateItems();

        if (!checkbox.checked) {
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);
            params.delete('brand_id');
            url.search = params.toString();
            window.history.replaceState({}, '', url.toString());
        }
    });
});
if(conditionCheckboxes){
conditionCheckboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', updateItems);
});
}
if(categoryCheckboxes){
categoryCheckboxes.forEach(function(checkbox) {
    checkbox.addEventListener('change', function() {
        updateItems();

        if (!checkbox.checked) {
            const url = new URL(window.location.href);
            const params = new URLSearchParams(url.search);
            params.delete('category_id');
            url.search = params.toString();
            window.history.replaceState({}, '', url.toString());
        }
    });
});
}
if(minPriceInput)searchCheckbox.addEventListener('change',updateItems);

if(minPriceInput)minPriceInput.addEventListener('input', updateItems);

if(maxPriceInput)maxPriceInput.addEventListener('input', updateItems);


const OrderAcending = document.getElementById('Price_Ascend');

if(OrderAcending){
OrderAcending.addEventListener('click', function(event) {
    console.log('click');
    event.preventDefault();
    fetch("../api/api_order_items.php?order=1")
    .then(response => response.text())
    .then(html => {
        itemsContainer.innerHTML = html;
        document.getElementById('Price_Ascend').style.color = 'red';
        document.getElementById('Price_Descend').style.color = 'black';
        document.getElementById('Name').style.color = 'black';
        document.getElementById('dropdownMenu').style.display = 'none';
        document.getElementById('orderBy').querySelector('i').className = 'fa-solid fa-chevron-down';


        let resetOrderButton = document.getElementById('ResetOrder');
            if (resetOrderButton) {
                resetOrderButton.style.display = 'block';
            } else {
                resetOrderButton = document.createElement('button');
                resetOrderButton.id = 'ResetOrder';
                resetOrderButton.textContent = 'Reset Order';
                document.getElementById('Show_Filter').insertAdjacentElement('afterend', resetOrderButton);
            }
           

    });
    console.log('finished');
});

}

const OrderDescending = document.getElementById('Price_Descend');
if(OrderDescending){
OrderDescending.addEventListener('click', function(event) {
    event.preventDefault();
    fetch("../api/api_order_items.php?order=2")
    .then(response => response.text())
    .then(html => {
        itemsContainer.innerHTML = html;
        document.getElementById('Price_Descend').style.color = 'red';
        document.getElementById('Price_Ascend').style.color = 'black';
        document.getElementById('Name').style.color = 'black';
        document.getElementById('dropdownMenu').style.display = 'none';
        document.getElementById('orderBy').querySelector('i').className = 'fa-solid fa-chevron-down';


        let resetOrderButton = document.getElementById('ResetOrder');
        if (resetOrderButton) {
            resetOrderButton.style.display = 'block';
        } else {
            resetOrderButton = document.createElement('button');
            resetOrderButton.id = 'ResetOrder';
            resetOrderButton.textContent = 'Reset Order';
            document.getElementById('Show_Filter').insertAdjacentElement('afterend', resetOrderButton);
        }
    });
});
}

const Name = document.getElementById('Name');
if(Name){
Name.addEventListener('click', function(event) {
    event.preventDefault();
    fetch("../api/api_order_items.php?order=3")
    .then(response => response.text())
    .then(html => {
        itemsContainer.innerHTML = html;
        document.getElementById('Name').style.color = 'red';
        document.getElementById('Price_Descend').style.color = 'black';
        document.getElementById('Price_Ascend').style.color = 'black';
        document.getElementById('dropdownMenu').style.display = 'none';
        document.getElementById('orderBy').querySelector('i').className = 'fa-solid fa-chevron-down';


         let resetOrderButton = document.getElementById('ResetOrder');
            if (resetOrderButton) {
                resetOrderButton.style.display = 'block';
            } else {
                resetOrderButton = document.createElement('button');
                resetOrderButton.id = 'ResetOrder';
                resetOrderButton.textContent = 'Reset Order';
                document.getElementById('Show_Filter').insertAdjacentElement('afterend', resetOrderButton);
            }
    });
});
}

document.addEventListener('click', function(event) {
    if(event.target && event.target.id === 'ResetOrder') {
        event.preventDefault();
        fetch("../api/api_order_items.php?order=0")
        .then(response => response.text())
        .then(html => {
            itemsContainer.innerHTML = html;
            document.getElementById('Name').style.color = 'black';
            document.getElementById('Price_Descend').style.color = 'black';
            document.getElementById('Price_Ascend').style.color = 'black';
            document.getElementById('dropdownMenu').style.display = 'none';
            document.getElementById('ResetOrder').style.display = 'none';
        });
    }
});

