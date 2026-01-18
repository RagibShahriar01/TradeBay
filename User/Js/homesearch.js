document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("searchForm");
    const input = document.getElementById("searchInput");
    const grid = document.getElementById("productGrid");

    let t = null;

    function escapeHtml(s) {
        return String(s ?? "")
            .replaceAll("&", "&amp;")
            .replaceAll("<", "&lt;")
            .replaceAll(">", "&gt;")
            .replaceAll('"', "&quot;")
            .replaceAll("'", "&#039;");
    }

    function render(products) {
        grid.innerHTML = "";

        if (!products || products.length === 0) {
            grid.innerHTML = `<p class="no-products">No products found.</p>`;
            return;
        }

        products.forEach(p => {
            const a = document.createElement("a");
            a.className = "product-card";
            a.href = `product.php?id=${p.id}`;

            a.innerHTML = `
        <div class="product-img-wrap">
          <img src="../${escapeHtml(p.image_path)}" alt="">
        </div>
        <div class="product-meta">
          <p class="product-name">${escapeHtml(p.product_name)}</p>
          <p class="product-price">${Number(p.price).toFixed(2)} Taka</p>
        </div>
      `;

            grid.appendChild(a);
        });
    }

    async function loadSearch(q) {
        try {
            const res = await fetch(`../php/searchproducts.php?q=${encodeURIComponent(q)}`);
            const data = await res.json();
            render(data);
        } catch (err) {
            // optional: show error message
            console.log(err);
        }
    }

    // prevent page reload on submit
    if (form) {
        form.addEventListener("submit", (e) => {
            e.preventDefault();
            loadSearch(input.value.trim());
        });
    }

    // live dynamic search
    if (input) {
        input.addEventListener("input", () => {
            clearTimeout(t);
            t = setTimeout(() => {
                loadSearch(input.value.trim());
            }, 250); // debounce
        });
    }
});
