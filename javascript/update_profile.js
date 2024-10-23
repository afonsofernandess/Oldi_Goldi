
const FI = document.getElementById('fileInput');
if(FI){
    FI.addEventListener('change', function(event){
        const photo = event.target.files[0]; //slect the files uploaded
        const reader = new FileReader();
        reader.onload = function(event) {
            document.getElementById('profilePicture').src = event.target.result;
            document.getElementById('hidden_input').value = event.target.result;
            
        };

        if (photo) {
            reader.readAsDataURL(photo);
        } 
        
    });
}

const FI2 = document.getElementById('item_img');

if(FI2){

    FI2.addEventListener('change', function(event){
    for(let i = 0; i < event.target.files.length; i++){
        const photo = event.target.files[i]; 
        const reader = new FileReader();
        reader.onload = function(event) { 
            const img_wrapper = document.createElement('div');
            const Span = document.createElement('span');
            Span.className = 'delete_image';
            Span.id = 'delete_image_preview';
            const i = document.createElement('i');
            i.className = 'fa-solid fa-xmark';
            img_wrapper.id = 'img_wrapper';
            const img = document.createElement('img');
            img.src = event.target.result;
            img.width = 200;
            img.height = 200;
            document.getElementById('img_container').appendChild(img_wrapper);
            img_wrapper.appendChild(img);
            img_wrapper.appendChild(Span);
            Span.appendChild(i);
            
        };
    
        if (photo) {
            reader.readAsDataURL(photo);
        } 
    }
        
    });

    document.getElementById('img_container').addEventListener('click', function(event){
        if (event.target.className === 'fa-solid fa-xmark' || event.target.parentElement.className === 'delete_image') {
            console.log('clicked');
            const img = event.target.parentElement.previousElementSibling.src;
            console.log(img);
            event.target.parentElement.parentElement.remove();    
    
            document.getElementById('item_img').value = '';
        }
    });

}





const deleteImages = document.querySelectorAll('span#delete_image');
console.log(deleteImages);
if(deleteImages){

deleteImages.forEach(function(deleteImage){
    deleteImage.addEventListener('click', function(event){
        console.log(event.target);
        console.log('clicked');
        const imageId = event.target.parentElement.previousElementSibling.getAttribute('data-photo-id');
        console.log(imageId);
        const itemId = deleteImage.getAttribute('data-item-id');
        console.log(itemId);
        fetch('../api/api_delete_image.php?photo_id=' + encodeURIComponent(imageId) + '&item_id=' + encodeURIComponent(itemId))
        .then(response => response.text())
        .then(html => {
            if(html == "ok"){
                console.log(document.querySelector('div#photo_' + imageId));
            document.getElementById('img_container').removeChild(document.querySelector('div#photo_' + imageId));
            }
           
        });

       event.stopPropagation();

    });
});
}
