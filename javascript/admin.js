const buttonsDelete = document.getElementById('DeleteUSer');
if(buttonsDelete){
    buttonsDelete.addEventListener('click', function(event){
        console.log('click');
        event.preventDefault();
        console.log(        document.getElementById('deleteUserPopUp')    );
        document.getElementById('deleteUserPopUp').style.display = "block";
        
    });

    window.onclick = function(event) {
        if (event.target == document.getElementById('deleteUserPopUp')) {
        document.getElementById('deleteUserPopUp').style.display = "none";

        }
    }

    const cancelBtn = document.getElementById('cancelDeleteUser');
    if(cancelBtn){
        cancelBtn.addEventListener('click',function(event){
            event.preventDefault();
            document.getElementById('deleteUserPopUp').style.display = "none";
        });
    }

    const closeBtn = document.getElementById('closeDeleteUser');
    if(closeBtn){
        closeBtn.addEventListener('click',function(){
            document.getElementById('deleteUserPopUp').style.display = "none";
        });
    }
}




const buttonsAdd = document.querySelectorAll('button#AS');
if(buttonsAdd){
    buttonsAdd.forEach(function(button){
        button.addEventListener('click', function(event){
            event.preventDefault();
            const category = document.getElementById('new_category').value;
            const brand = document.getElementById('new_brand').value;
            const condition = document.getElementById('new_condition').value;
            const size = document.getElementById('new_size').value;
            if(category == "" || brand == "" || condition == "" || size == ""){
                
            
            fetch("../api/api_add_new_entities.php?" + "category=" + encodeURIComponent(category) + "&brand=" + encodeURIComponent(brand) + "&condition=" + encodeURIComponent(condition) + "&size=" + encodeURIComponent(size))
            .then(response => response.text())
            .then(data => {

                if(category != ""){
                    document.getElementById('CategoriesAdmin').innerHTML += data;
                    document.getElementById('new_category').value = "";
                }

                if(brand != ""){
                    document.getElementById('BrandsAdmin').innerHTML += data;
                    document.getElementById('new_brand').value = "";
                }
                if(condition != ""){
                    document.getElementById('ConditionsAdmin').innerHTML += data;
                    document.getElementById('new_condition').value = "";
                }
                if(size != ""){
                    document.getElementById('SizesAdmin').innerHTML += data;
                    document.getElementById('new_size').value = "";
                }
                
            });
        }
        });
    });
}

