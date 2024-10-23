const log_button = document.getElementById('log_button');
if(log_button){
log_button.addEventListener('click', function(event){
    event.preventDefault();
    const merrs = document.getElementById('message_error_login');
    const form = document.getElementById('login_action');

    const formData = new FormData(form);

    fetch('../api/api_check_login.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        if(data == "true"){
            form.submit();
        }
        else if (data == "erro1"){
            merrs.innerHTML = "Username doesnt exists!";
        }
        else if(data == "erro2"){
            merrs.innerHTML = "Password does not match to the username!";
        }
        
    })



});

}


const reg_button = document.getElementById('reg_button');
if(reg_button){
reg_button.addEventListener('click',function(event){
    event.preventDefault();
    const merrs = document.getElementById('message_error_register');
    const form = document.getElementById('register_action');

    const formData = new FormData(form);

    fetch('../api/api_check_register.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log(data);
        if(data == "true"){
            form.submit();
        }
        else if (data == "erro1"){
            merrs.innerHTML = "Username already exists!";
        }
        else if(data == "erro2"){
            merrs.innerHTML = "Email already exists!";
        }
        else{
            merrs.innerHTML = "Passwords do not match!";
        }
    })


});

}