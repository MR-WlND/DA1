let psw = document.querySelector('#password');
let checkbox = document.querySelector('#hide');

checkbox.addEventListener('click', () => {
    checkbox.classList.toggle('show');

    psw.type === 'password' ? (psw.type = 'text') : (psw.type = 'password');
});