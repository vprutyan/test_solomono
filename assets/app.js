document.addEventListener('DOMContentLoaded', function () {
    const productListDiv = document.getElementById('product-list');
    const categoryList = document.getElementById('category-list');
    const sortSelect = document.getElementById('sort-select');
    let currentCategory = initialCategory;
    let currentSort = initialSort;

    // Load template once at startup
    let productCardTemplate = '';

    function loadTemplate(url) {
        return fetch(url)
            .then(response => response.text());
    }

    // Render products using the loaded template
    function renderProducts(products) {
        const productListDiv = document.getElementById('product-list');
        productListDiv.innerHTML = '';
        if (products.length === 0) {
            productListDiv.innerHTML = '<div class="col-12"><p>No products found.</p></div>';
            return;
        }
        products.forEach(product => {
            let html = productCardTemplate;
            // Simple string replacement for template variables
            Object.keys(product).forEach(key => {
                const re = new RegExp(`{{${key}}}`, 'g');
                html = html.replace(re, product[key]);
            });
            // Format price to two decimals
            html = html.replace('{{price}}', parseFloat(product.price).toFixed(2));
            // Insert into grid
            const col = document.createElement('div');
            col.className = 'col-md-6 col-lg-4 mb-3';
            col.innerHTML = html;
            productListDiv.appendChild(col);
        });
    }

    // Load template before first render
    loadTemplate('assets/templates/product_card.html').then(tpl => {
        productCardTemplate = tpl;
        renderProducts(initialProducts);
    });

    // Load products via AJAX
    function loadProducts(categoryId, sortOrder, pushState = true) {
        const params = new URLSearchParams();
        if (categoryId) params.set('category', categoryId);
        if (sortOrder) params.set('sort', sortOrder);

        fetch('ajax.php?' + params.toString())
            .then(r => r.json())
            .then(products => {
                renderProducts(products);
                if (pushState) {
                    const url = '?' + params.toString();
                    history.pushState({category: categoryId, sort: sortOrder}, '', url);
                }
            });
    }

    // Category click handler
    categoryList.addEventListener('click', function (e) {
        const li = e.target.closest('.category-item');
        if (li) {
            // Remove active class
            categoryList.querySelectorAll('.category-item').forEach(el => el.classList.remove('active'));
            li.classList.add('active');
            currentCategory = li.dataset.category;
            loadProducts(currentCategory, currentSort);
        }
    });

    // Sort select handler
    sortSelect.addEventListener('change', function () {
        currentSort = sortSelect.value;
        loadProducts(currentCategory, currentSort);
    });

    // Buy button handler (event delegation)
    productListDiv.addEventListener('click', function (e) {
        if (e.target.classList.contains('buy-btn')) {
            const productId = e.target.dataset.productId;
            fetch('ajax.php?product_id=' + productId)
                .then(r => r.json())
                .then(product => {
                    showBuyModal(product);
                });
        }
    });

    // Popstate handler (browser navigation)
    window.addEventListener('popstate', function (event) {
        const state = event.state || {};
        currentCategory = state.category || null;
        currentSort = state.sort || 'cheapest';
        // Set sort select and category active
        sortSelect.value = currentSort;
        categoryList.querySelectorAll('.category-item').forEach(el => {
            el.classList.toggle('active', el.dataset.category == currentCategory);
        });
        loadProducts(currentCategory, currentSort, false);
    });

    // Modal logic
    function showBuyModal(product) {
        const modalBody = document.getElementById('buy-modal-body');
        modalBody.innerHTML = `
            <h5>${product.name}</h5>
            <p><strong>Price:</strong> $${parseFloat(product.price).toFixed(2)}</p>
            <p><strong>Date:</strong> ${product.date}</p>
            <p><strong>Category ID:</strong> ${product.category_id}</p>
        `;
        const buyModal = new bootstrap.Modal(document.getElementById('buyModal'));
        buyModal.show();
    }
});