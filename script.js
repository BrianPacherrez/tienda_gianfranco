document.addEventListener('DOMContentLoaded', () => {
    const offcanvasCategorias = document.getElementById('offcanvasCategorias');
    const mainContent = document.getElementById('main-content');

    offcanvasCategorias.addEventListener('show.bs.offcanvas', () => {
        mainContent.classList.add('shifted');
    });

    offcanvasCategorias.addEventListener('hidden.bs.offcanvas', () => {
        mainContent.classList.remove('shifted');
    });
});

function mostrarProductos(categoria) {
    const productList = document.getElementById('product-list');
    productList.innerHTML = `<h4>${categoria}</h4>`;

    // Aquí puedes agregar la lógica para obtener los productos de la categoría seleccionada
    // Por ahora, agregaré productos ficticios
    const productos = [
        { nombre: 'Producto 1', descripcion: 'Descripción del producto 1' },
        { nombre: 'Producto 2', descripcion: 'Descripción del producto 2' },
        { nombre: 'Producto 3', descripcion: 'Descripción del producto 3' }
    ];

    productos.forEach(producto => {
        const productItem = document.createElement('div');
        productItem.className = 'product-item';
        productItem.innerHTML = `<h5>${producto.nombre}</h5><p>${producto.descripcion}</p>`;
        productList.appendChild(productItem);
    });
}
