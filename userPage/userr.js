let msg = document.querySelector('.message');
if (msg) { 
    setTimeout(() => {
        msg.style.display = 'none';
    }, 3000);
}

function search(){
    let searchBar = document.getElementById('search').value.toUpperCase();
    const cards = document.querySelectorAll('.card');
    let visibleCardCount = 0;

    for(let i = 0; i < cards.length; i++){
        let cardTitle = cards[i].querySelector('.cardName');
        if (cardTitle) {
            if (cardTitle.innerHTML.toUpperCase().indexOf(searchBar) >= 0) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }
    }
}
