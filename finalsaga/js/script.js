// Optional: Sidebar dropdown toggle for classes
document.addEventListener('DOMContentLoaded', function(){
    let yearButtons = document.querySelectorAll('.year-btn');
    yearButtons.forEach(btn => {
        btn.addEventListener('click', function(){
            let classList = this.nextElementSibling;
            if(classList.style.display === 'block'){
                classList.style.display = 'none';
            } else {
                classList.style.display = 'block';
            }
        });
    });
});
