function openModal() {
    let msg = document.querySelector('.modal');

    msg.style.display = 'block';

    setTimeout(() => {
        msg.style.display = 'none';
    }, 1500);
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