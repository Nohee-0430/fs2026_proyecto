function filtrarCategoria(categoria, elemento) {
    var items = document.querySelectorAll('.category-link-item');
    for (var i = 0; i < items.length; i++) {
        items[i].classList.remove('active');
    }
    if (elemento) {
        elemento.classList.add('active');
    }

    var productos = document.querySelectorAll('.product-card');
    var visibles = 0;
    for (var j = 0; j < productos.length; j++) {
        var card = productos[j];
        var cat = card.getAttribute('data-category') || '';
        if (categoria === 'all' || cat === categoria) {
            card.style.display = '';
            visibles++;
        } else {
            card.style.display = 'none';
        }
    }

    var countText = document.getElementById('catalogCountText');
    if (countText) {
        countText.textContent = 'Mostrando ' + visibles + ' productos';
    }
}

document.addEventListener('DOMContentLoaded', function() {
    var searchInput = document.getElementById('globalSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', function() {
            var filtro = searchInput.value.toLowerCase().trim();
            var productos = document.querySelectorAll('.product-card');
            var visibles = 0;

            for (var i = 0; i < productos.length; i++) {
                var card = productos[i];
                var nombre = (card.getAttribute('data-name') || '').toLowerCase();
                if (filtro === '' || nombre.indexOf(filtro) !== -1) {
                    card.style.display = '';
                    visibles++;
                } else {
                    card.style.display = 'none';
                }
            }

            var countText = document.getElementById('catalogCountText');
            if (countText) {
                countText.textContent = 'Mostrando ' + visibles + ' productos';
            }
        });
    }
});
