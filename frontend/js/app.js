/**
 * DULCE IMPRESIÓN - JavaScript de Apoyo Visual
 * Código simplificado y didáctico para interacción con el catálogo
 */

document.addEventListener('DOMContentLoaded', () => {
    // 1. Buscador en tiempo real para el catálogo
    const searchInput = document.getElementById('globalSearchInput');
    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            const texto = e.target.value.toLowerCase().trim();
            const tarjetas = document.querySelectorAll('.product-card');

            tarjetas.forEach(card => {
                const nombre = card.getAttribute('data-name') || '';
                if (nombre.includes(texto)) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }
});

/**
 * Filtro de categorías por clic en el sidebar
 */
function filtrarCategoria(categoria, elemento) {
    // Actualizar clase activa en el menú
    document.querySelectorAll('.category-link-item').forEach(el => el.classList.remove('active'));
    if (elemento) {
        elemento.classList.add('active');
    }

    const tarjetas = document.querySelectorAll('.product-card');
    tarjetas.forEach(card => {
        const catCard = card.getAttribute('data-category') || '';
        if (categoria === 'all' || catCard.includes(categoria)) {
            card.style.display = '';
        } else {
            card.style.display = 'none';
        }
    });
}
