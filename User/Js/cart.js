document.addEventListener("DOMContentLoaded", () => {
    const btn = document.getElementById("addToCartBtn");
    const msg = document.getElementById("cartMsg");

    if (!btn) return;

    btn.addEventListener("click", async () => {
        try {
            const listingId = btn.dataset.id;

            const res = await fetch("../php/cartadds.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ listing_id: listingId })
            });

            const data = await res.json();

            if (!data.ok) {
                msg.style.color = "red";
                msg.textContent = data.message || "Failed to add to cart";
                return;
            }

            msg.style.color = "green";
            msg.textContent = data.message || "Added to cart!";
        } catch (e) {
            msg.style.color = "red";
            msg.textContent = "Error adding to cart";
        }
    });
});
