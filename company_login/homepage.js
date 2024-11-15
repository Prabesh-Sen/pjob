const logregBox = document.querySelector('.log-box');
const loginLink = document.querySelector('.login-link');
const registerLink = document.querySelector('.register-link');
const btnPopup = document.querySelector('.btnLogin-popup');
const iconClose = document.querySelector('.icon-close');

registerLink.addEventListener('click',()=>{
    logregBox.classList.add('active');
});
loginLink.addEventListener('click',()=>{
    logregBox.classList.remove('active');
});
btnPopup.addEventListener('click',()=>{
    logregBox.classList.add('active-popup');
});
iconClose.addEventListener('click',()=>{
    logregBox.classList.remove('active-popup');
});

