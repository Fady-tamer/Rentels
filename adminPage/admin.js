var header = document.querySelector('#header');
var content = document.querySelector('#content');
var CardForm = document.querySelector('#CardForm');
var footer = document.querySelector('#footer');

function displayAddCard(){
    header.style.display = "none";
    content.style.display = "none";
    CardForm.style.display = "flex";
    footer.style.display = "none";
}
function cancelAddCard(){
    header.style.display = "flex";
    content.style.display = "flex";
    CardForm.style.display = "none";
    footer.style.display = "flex";
}