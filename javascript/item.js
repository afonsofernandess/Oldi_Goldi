document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.product-thumbnails img').forEach(img => {
        img.addEventListener('click', function() {
            const mainImage = document.getElementById('mainImage');
            mainImage.src = this.src;
        });
    });

    const setupPopup = (triggerId, popupId, closeId) => {
        const trigger = document.getElementById(triggerId);
        const popup = document.getElementById(popupId);
        const close = document.getElementById(closeId);

        if(trigger)trigger.addEventListener('click', () => popup.style.display = 'block');
        if(close)close.addEventListener('click', () => popup.style.display = 'none');
    };

    setupPopup('MBTn', 'Message_PopUp', 'close');

    setupPopup('PAPBTn', 'newPriceI_PopUp', 'close2');

});
