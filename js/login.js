const form = document.querySelector('.container > form'),
continueBtn = form.querySelector('form button'),
errorText = form.querySelector('.errorText');

form.addEventListener('submit', e => {
    e.preventDefault()
});

continueBtn.addEventListener('click', () => {
    // lets start AJAX 
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'php/login.php', true);
    xhr.addEventListener('load', () => {
        if(xhr.readyState === 4 && xhr.status === 200) {
            let data = xhr.response;
            if(data == 'success') {
                location.href = ''
            }
        }
    })
})