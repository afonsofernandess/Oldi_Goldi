const sendMessage = document.getElementById('sendMessage');
console.log(sendMessage);
if(sendMessage){
    sendMessage.addEventListener('click',function(event) {
    event.preventDefault();
    console.log('clicked');
    const message = document.getElementById('message_box').value;
    const chat_id = document.getElementById('hidden_chat_id').value;
    if(message != ''){
        fetch('../api/api_send_message.php?message=' + encodeURIComponent(message) + '&chat_id=' + encodeURIComponent(chat_id))
        .then(response => response.text())
        .then(data => {
            console.log(data);
            document.getElementById('Message_list').innerHTML += data;
            document.getElementById('message_box').value = '';
            scrollToBottom();
        });


    }
    });

}

const popUPBtn = document.getElementById('PNPBtn');
console.log(popUPBtn);
if(popUPBtn){
    popUPBtn.addEventListener('click', function(event){
        event.preventDefault();
        document.getElementById('newPrice_PopUp').style.display = 'block';
    })

    window.onclick = function(event) {
        if (event.target == document.getElementById('newPrice_PopUp')) {
            document.getElementById('newPrice_PopUp').style.display = 'none'; 
        }
}

const closeX = document.getElementById('close');
if(closeX){
closeX.addEventListener('click',function(){
    document.getElementById('newPrice_PopUp').style.display = 'none'; 
    });
    
}

}   
document.addEventListener('click', function(event) {
    if (event.target && event.target.id === 'Reject_Btn') {
        const messageId = event.target.getAttribute('data-message-id');
        fetch('../api/api_reject_accept_proposal.php?message_id=' + encodeURIComponent(messageId) + '&action=reject')
        .then(response => response.text())
        .then(data => {
            console.log(data);
            document.getElementById('Message_list').innerHTML = data;
        });
    }
});

const MpopUPBtn = document.getElementById('MBTn');

if(MpopUPBtn){
    MpopUPBtn.addEventListener('click', function(event){
        event.preventDefault();
        document.getElementById('Message_PopUp').style.display = 'block';
    })

    window.onclick = function(event) {
        if (event.target == document.getElementById('Message_PopUp')) {
            document.getElementById('Message_PopUp').style.display = 'none'; 
        }
}

const closeX = document.getElementById('close');
if(closeX){
closeX.addEventListener('click',function(){
    document.getElementById('Message_PopUp').style.display = 'none'; 
    });
    
}
}


const PIpopUPBtn = document.getElementById('PAPBTn');

if(PIpopUPBtn){
    PIpopUPBtn.addEventListener('click', function(event){
        event.preventDefault();
        document.getElementById('newPriceI_PopUp').style.display = 'block';
    })

    window.onclick = function(event) {
        if (event.target == document.getElementById('newPriceI_PopUp')) {
            document.getElementById('newPriceI_PopUp').style.display = 'none'; 
        }
}

const closeX = document.getElementById('close2');
if(closeX){
closeX.addEventListener('click',function(){
    document.getElementById('newPriceI_PopUp').style.display = 'none'; 
    });
    
}
}

function scrollToBottom() {
    const messageList = document.getElementById('Message_list');
    messageList.scrollTop = messageList.scrollHeight;
}

document.addEventListener('DOMContentLoaded', function() {
    scrollToBottom();
});

function retrieveNewMessages(chat_id) {
    

    fetch('../api/api_retrieveNewMessages.php?chat_id=' + encodeURIComponent(chat_id))
        .then(response => response.text())
        .then(newMessages => {
            document.getElementById('Message_list').innerHTML = newMessages;
            scrollToBottom();
        });
}

function retrieveCurrentPrice(chat_id) {

    fetch('../api/api_retrievePrice.php?chat_id=' + encodeURIComponent(chat_id))
        .then(response => response.text())
        .then(newMessages => {
            document.getElementById('item_price').innerHTML = newMessages;
        });
}


if (window.location.href.indexOf('messages.php') > -1) {
    setInterval(function() {
        const chat_id = document.getElementById('message_id').value;

        retrieveNewMessages(chat_id);
        retrieveCurrentPrice(chat_id);
    }, 5000);
}