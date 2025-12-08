function interested() {
    alert('Thank you for your interest! We will contact you soon.');
};

function openModal() {
    document.getElementById('customAlert').style.display = 'block';
}

window.onclick = function(event) {
    const modal = document.getElementById('customAlert');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
}

function search(){
    let searchBar = document.getElementById('search').value.toUpperCase();
    const cards = document.querySelectorAll('.card');
    let visibleCardCount = 0;

    for(let i = 0; i<cards.length;i++){
        let cardTitle = cards[i].querySelector('.cardName');
        let cardIsVisible = false;
        
        if (cardTitle) {
            if (cardTitle.innerHTML.toUpperCase().indexOf(searchBar) >= 0) {
                cards[i].style.display = "";
                cardIsVisible = true;
            } else {
                cards[i].style.display = "none";
            }
        }
        
        if (cardIsVisible) {
            visibleCardCount++;
        }
    }
}