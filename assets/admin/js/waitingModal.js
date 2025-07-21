function showWaitingModal(message = 'Please wait...', spinnerSize = '50px') {
    let modal = document.createElement('div');
    modal.id = 'waitingModal';
    modal.style.position = 'fixed';
    modal.style.top = '0';
    modal.style.left = '0';
    modal.style.width = '100%';
    modal.style.height = '100%';
    modal.style.backgroundColor = 'rgba(0, 0, 0, 0.5)';
    modal.style.display = 'flex';
    modal.style.justifyContent = 'center';
    modal.style.alignItems = 'center';
    modal.style.zIndex = '1000';
    
    let content = document.createElement('div');
    content.style.background = '#fff';
    content.style.padding = '20px';
    content.style.borderRadius = '10px';
    content.style.boxShadow = '0 0 10px rgba(0,0,0,0.2)';
    content.style.textAlign = 'center';
    
    let spinner = document.createElement('div');
    spinner.style.width = spinnerSize;
    spinner.style.height = spinnerSize;
    spinner.style.border = '5px solid #ccc';
    spinner.style.borderTop = '5px solid #3498db';
    spinner.style.borderRadius = '50%';
    spinner.style.animation = 'spin 1s linear infinite';
    spinner.style.margin = '0 auto 10px';
    
    let messageElem = document.createElement('p');
    messageElem.id = "waiting_modal_message";
    messageElem.innerText = message;
    
    // let reloadText = document.createElement('p');
    // reloadText.innerText = 'If stuck, consider reloading the page.';
    // reloadText.style.marginTop = '10px';
    // reloadText.style.color = 'gray';
    // reloadText.style.fontSize = '12px';
    // reloadText.style.textDecoration = "underline";

    // reloadText.addEventListener('click', function() {
    // location.reload(); 
    // });
    
    let style = document.createElement('style');
    style.innerHTML = `@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }`;
    
    content.appendChild(spinner);
    content.appendChild(messageElem);
    //content.appendChild(reloadText);
    modal.appendChild(content);
    document.body.appendChild(style);
    document.body.appendChild(modal);
}

function hideWaitingModal() {
    let modal = document.getElementById('waitingModal');
    if (modal) {
        modal.remove();
    }
}

function changeWaitingModal(message){
    document.getElementById('waiting_modal_message').innerHTML = message;
}
