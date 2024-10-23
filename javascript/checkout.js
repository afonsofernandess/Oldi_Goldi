
const CABtn = document.getElementById('CABtn');
if(CABtn){
    CABtn.addEventListener('click',function(event){
        event.preventDefault();
        document.getElementById('Adress_PopUp').style.display = 'block';
    });

    window.onclick = function(event) {
        if (event.target == document.getElementById('Adress_PopUp')) {
            document.getElementById('Adress_PopUp').style.display = 'none'; 
        }
    }
}

const closeX = document.getElementById('close');
if(closeX){
closeX.addEventListener('click',function(){
    document.getElementById('Adress_PopUp').style.display = 'none'; 
    });
    
}

const radio = document.getElementById('credit')
console.log(radio);
if(radio){
    radio.addEventListener('change', function(){
        if (radio.checked) {
            console.log('radio checked');
            document.getElementById('creditCardInfo').style.display = 'block';
        } else {
            console.log('radio not checked');
            document.getElementById('creditCardInfo').style.display = 'none';
        }
    });
}

const addCardBtn = document.getElementById('addCardsBtn');
if(addCardBtn){

    addCardBtn.addEventListener('click',function(event){
        event.preventDefault();
        document.getElementById('Card_PopUp').style.display = 'block';
    })
    window.onclick = function(event) {
        if (event.target == document.getElementById('Card_PopUp')) {
            document.getElementById('Card_PopUp').style.display = 'none'; 
        }
    }

}

const closeY = document.getElementById('closeCard');
if(closeY){
closeY.addEventListener('click',function(){
    document.getElementById('Card_PopUp').style.display = 'none'; 
    });
    
}

const cardNumber = document.getElementById("cardNumber");
if(cardNumber){
cardNumber.addEventListener('keypress', function (e) {
    if (e.key < '0' || e.key > '9') {
        e.preventDefault();
    }
});
}
const confirmBtn = document.getElementById('PopUp_Card');
if(confirmBtn){
    confirmBtn.addEventListener('click',function(event){
        
        const cardName = document.getElementById("cardName");
        const cardNumber = document.getElementById("cardNumber");
        const cardExpiry = document.getElementById("cardExpiry");
        const cardCVV = document.getElementById("cardCVV");
    
        if (!cardName.value || !cardNumber.value || !cardExpiry.value || !cardCVV.value) {
            event.preventDefault();
    
            document.getElementById('Errormesage').innerHTML = "Please fill out all fields";
            return;
        }

        if(cardNumber.value.length != 16){
            event.preventDefault();
            document.getElementById('Errormesage').innerHTML = "Card number must be 16 digits";
            return;
        }
        if(cardCVV.value.length < 3){
            event.preventDefault();
            document.getElementById('Errormesage').innerHTML = "CVV must be at least 3 digits";
            return;
        }
        const currentDate = new Date();
        const inputDate = new Date(cardExpiry.value);
        if (inputDate < currentDate) {
            event.preventDefault();
            document.getElementById('Errormesage').innerHTML = "Expiry date must be in the future";
            return;
        }
        
        if (!cardNumber.value.startsWith('5') && !cardNumber.value.startsWith('2') && !cardNumber.value.startsWith('4') && !cardNumber.value.startsWith('3') && !cardNumber.value.startsWith('6')) {
            event.preventDefault();
            document.getElementById('Errormesage').innerHTML = "Card number must start with 5, 2, 4, 3, or 6 - Not a Valid Card Number";
            return;
        }
        
        event.preventDefault();
         
        fetch("../api/api_add_delete_new_card.php?cardNumber="+ encodeURIComponent(document.getElementById('cardNumber').value)+"&expDate="+encodeURIComponent(document.getElementById('cardExpiry').value)+"&cvv="+encodeURIComponent(document.getElementById('cardCVV').value) +"&cardName="+ encodeURIComponent(document.getElementById('cardName').value))
        .then(response => response.text())
        .then(date => {
            console.log(document.getElementById('cards'));
            console.log(document.getElementById('noCards'));
            document.getElementById('cards').innerHTML += date;
            if(document.getElementById('noCards')){
            document.getElementById('noCards').remove();
            }
            document.getElementById('Card_PopUp').style.display = "none";
            document.getElementById("cardName").value = "";
            document.getElementById("cardNumber").value = "";
            document.getElementById("cardExpiry").value = "";
            document.getElementById("cardCVV").value = "";
            const deleteCard = document.querySelectorAll('span.delete_card');
            console.log(deleteCard);            
            if(deleteCard){
    deleteCard.forEach(function(deleteCard){
        console.log(deleteCard);
        deleteCard.addEventListener('click', function(){
            const cardId = deleteCard.getAttribute('data-card-id');
            console.log(cardId);
            fetch('../api/api_add_delete_new_card.php?card_id=' + encodeURIComponent(cardId))
            .then(response => response.text())
            .then(html => {
                if(html == "Carddeleted"){
                  
                    let cardElement = document.querySelector('#input_' + cardId);
                    console.log(cardElement.parentElement);
                    document.getElementById('cards').removeChild(cardElement.parentElement);
                }
            });
        });
    });
}
        }

        )
    });
}

const deleteCard = document.querySelectorAll('span.delete_card');
if(deleteCard){
    deleteCard.forEach(function(deleteCard){
        deleteCard.addEventListener('click', function(){
            const cardId = deleteCard.getAttribute('data-card-id').trim();
            console.log(cardId);
            fetch('../api/api_add_delete_new_card.php?card_id=' + encodeURIComponent(cardId))
            .then(response => response.text())
            .then(html => {
                if(html == "Carddeleted"){
                  
                    let cardElement = document.querySelector('#input_' + cardId);
                    console.log(cardElement);
                    console.log(document.getElementById('cards').childNodes);
                    document.getElementById('cards').removeChild(cardElement.parentElement);
                }
            });
        });
    });
}

