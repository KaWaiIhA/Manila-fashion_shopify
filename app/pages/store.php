<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store - FPASSION MANILA</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
     <link rel="stylesheet" href="../css/store.css">
    <style>
 

    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <a href="#" class="logo">FPASSION MANILA</a>
            <nav>
                    <ul><li><a href="../index.html">Home</a></li>
                    <li><a href="store.php" class="active">Store</a></li>
                    <li><a href="about.php">About</a></li></ul>
        </nav>
            <div class="header-actions">
                
                <a href="help.php" class="header-link">Help</a>
                <a href="#" class="header-link">Sign in</a>
                <button class="cart-btn cart-toggle">Cart <span class="cart-count">0</span></button>
            </div>
        </div>
    </header>
    <section class="page-header"><h1>Our Store</h1><p>Discover premium Filipino fashion</p></section>
    <section class="filter-section">
        <div class="filter-container">
            <div class="filter-left">
                <button class="filter-btn active" data-category="all">All</button>
                <button class="filter-btn" data-category="men">Men</button>
                <button class="filter-btn" data-category="women">Women</button>
                <button class="filter-btn" data-category="accessories">Accessories</button>
                <button class="filter-btn" data-category="sale">Sale</button>
            </div>
            <select class="sort-select" id="sort-select">
                <option value="featured">Featured</option>
                <option value="price-asc">Price: Low to High</option>
                <option value="price-desc">Price: High to Low</option>
                <option value="name">Name: A-Z</option>
            </select>
        </div>
    </section>
    <div class="container">
        <p class="products-count"><span id="product-count">0</span> products</p>
        <div class="product-grid" id="product-grid"></div>
    </div>
    <div class="cart-overlay"></div>
    <div class="cart-drawer">
        <div class="cart-header"><h2>Your Cart (<span class="cart-count">0</span>)</h2><button class="close-cart">×</button></div>
        <div class="cart-items" id="cart-items"><p class="cart-empty">Your cart is empty</p></div>
        <div class="cart-footer">
            <div class="cart-subtotal"><span>Subtotal:</span><span class="cart-total">₱0.00</span></div>
            <button class="btn btn-primary">Proceed to Checkout</button>
            <p class="shipping-notice">Free shipping on orders over ₱1,500</p>
        </div>
    </div>
    <div class="product-modal" id="product-modal">
        <button class="close-modal">×</button>
        <div class="modal-content">
            <div>
                <img src="" alt="" class="modal-main-image" id="modal-main-image">
                <div class="modal-thumbnails" id="modal-thumbnails"></div>
            </div>
            <div>
                <h2 class="modal-title" id="modal-title"></h2>
                <div class="product-price" id="modal-price"></div>
                <p class="modal-description" id="modal-description"></p>
                <div class="size-selector"><label>Select Size</label><div class="size-buttons" id="size-buttons"></div></div>
                <div class="quantity-selector">
                    <label>Quantity</label>
                    <div class="qty-input">
                        <button class="qty-btn" onclick="decreaseQty()">−</button>
                        <input type="number" class="qty-number" value="1" min="1" id="modal-qty">
                        <button class="qty-btn" onclick="increaseQty()">+</button>
                    </div>
                </div>
                <button class="btn btn-primary" onclick="addToCartFromModal()">Add to Cart</button>
            </div>
        </div>
    </div>
    <div class="toast" id="toast"><span>✓</span><span id="toast-message">Added to cart!</span></div>
    <script>
        const products = [
            {id: 1, title: "Classic White Shirt", category: "men", price: 1250, comparePrice: 1500, image: "https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=400", images: ["https://images.unsplash.com/photo-1620799140408-edc6dcb6d633?w=800"], badge: "sale", description: "Premium cotton shirt with modern fit."},
            {id: 2, title: "Denim Jacket", category: "men", price: 2850, image: "https://images.unsplash.com/photo-1601333144130-8cbb312386b6?w=400", images: ["https://images.unsplash.com/photo-1601333144130-8cbb312386b6?w=800"], badge: "new", description: "Timeless denim jacket."},
            {id: 3, title: "Summer Dress", category: "women", price: 1890, image: "https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=400", images: ["https://images.unsplash.com/photo-1595777457583-95e059d581b8?w=800"], description: "Lightweight dress."},
            {id: 4, title: "Casual Sneakers", category: "accessories", price: 3200, comparePrice: 3800, image: "https://images.unsplash.com/photo-1549298916-b41d501d3772?w=400", images: ["https://images.unsplash.com/photo-1549298916-b41d501d3772?w=800"], badge: "sale", description: "Comfortable sneakers."},
            {id: 5, title: "Leather Bag", category: "accessories", price: 4500, image: "https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=400", images: ["https://images.unsplash.com/photo-1548036328-c9fa89d128fa?w=800"], description: "Handcrafted leather bag."},
            {id: 6, title: "Polo Shirt", category: "men", price: 980, image: "https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=400", images: ["https://images.unsplash.com/photo-1586790170083-2f9ceadc732d?w=800"], badge: "new", description: "Classic polo."},
            {id: 7, title: "Floral Blouse", category: "women", price: 1450, image: "https://images.unsplash.com/photo-1564257577-4bcf9b8efc0a?w=400", images: ["https://images.unsplash.com/photo-1564257577-4bcf9b8efc0a?w=800"], description: "Elegant blouse."},
            {id: 8, title: "Sports Watch", category: "accessories", price: 5200, image: "https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400", images: ["https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=800"], badge: "new", description: "Premium watch."}
        ];
        let cart = [], filter = "all", sort = "featured", selected = null;
        
        function render() {
            let f = filter === "all" ? products : filter === "sale" ? products.filter(p => p.badge === "sale") : products.filter(p => p.category === filter);
            if (sort === "price-asc") f.sort((a, b) => a.price - b.price);
            else if (sort === "price-desc") f.sort((a, b) => b.price - a.price);
            else if (sort === "name") f.sort((a, b) => a.title.localeCompare(b.title));
            document.getElementById("product-count").textContent = f.length;
            document.getElementById("product-grid").innerHTML = f.map((p, i) => `
                <div class="product-card" style="animation-delay: ${i * 0.1}s" onclick="openModal(${p.id})">
                    <div class="product-image-container">
                        <img src="${p.image}" alt="${p.title}" class="product-image">
                        ${p.badge ? `<span class="badge badge-${p.badge}">${p.badge}</span>` : ""}
                    </div>
                    <div class="product-info">
                        <p class="product-category">${p.category}</p>
                        <h3 class="product-title">${p.title}</h3>
                        <div class="product-price">
                            <span class="${p.comparePrice ? 'price-sale' : 'price'}">₱${p.price.toLocaleString()}</span>
                            ${p.comparePrice ? `<span class="price-compare">₱${p.comparePrice.toLocaleString()}</span>` : ""}
                        </div>
                        <button class="quick-add-btn" onclick="event.stopPropagation(); quickAdd(${p.id})">Quick Add</button>
                    </div>
                </div>
            `).join("");
        }
        
        function openModal(id) {
            selected = products.find(p => p.id === id);
            document.getElementById("modal-title").textContent = selected.title;
            document.getElementById("modal-description").textContent = selected.description;
            document.getElementById("modal-main-image").src = selected.images[0];
            document.getElementById("modal-price").innerHTML = selected.comparePrice ? 
                `<span class="price-sale">₱${selected.price.toLocaleString()}</span><span class="price-compare">₱${selected.comparePrice.toLocaleString()}</span>` : 
                `<span class="price">₱${selected.price.toLocaleString()}</span>`;
            document.getElementById("modal-thumbnails").innerHTML = selected.images.map((img, i) => 
                `<img src="${img}" class="thumbnail ${i === 0 ? 'active' : ''}" onclick="changeImg('${img}', this)">`).join("");
            document.getElementById("size-buttons").innerHTML = ["S", "M", "L", "XL"].map((s, i) => 
                `<button class="size-btn ${i === 0 ? 'active' : ''}" onclick="selectSize(this)">${s}</button>`).join("");
            document.getElementById("modal-qty").value = 1;
            document.getElementById("product-modal").classList.add("active");
            document.querySelector(".cart-overlay").classList.add("active");
        }
        
        function changeImg(src, el) {
            document.getElementById("modal-main-image").src = src;
            document.querySelectorAll(".thumbnail").forEach(t => t.classList.remove("active"));
            el.classList.add("active");
        }
        
        function selectSize(el) {
            document.querySelectorAll(".size-btn").forEach(b => b.classList.remove("active"));
            el.classList.add("active");
        }
        
        function decreaseQty() {
            const inp = document.getElementById("modal-qty");
            if (inp.value > 1) inp.value--;
        }
        
        function increaseQty() {
            document.getElementById("modal-qty").value++;
        }
        
        function quickAdd(id) {
            addCart(id, "M", 1);
        }
        
        function addToCartFromModal() {
            const size = document.querySelector(".size-btn.active").textContent;
            const qty = parseInt(document.getElementById("modal-qty").value);
            addCart(selected.id, size, qty);
            document.getElementById("product-modal").classList.remove("active");
            document.querySelector(".cart-overlay").classList.remove("active");
        }
        
        function addCart(id, size, qty) {
            const p = products.find(p => p.id === id);
            const ex = cart.find(i => i.id === id && i.size === size);
            if (ex) ex.quantity += qty;
            else cart.push({...p, size, quantity: qty});
            updateCart();
            showToast(`${p.title} added!`);
        }
        
        function updateCart() {
            const total = cart.reduce((s, i) => s + i.price * i.quantity, 0);
            const count = cart.reduce((s, i) => s + i.quantity, 0);
            document.querySelectorAll(".cart-count").forEach(el => {
                el.textContent = count;
                el.classList.add("bump");
                setTimeout(() => el.classList.remove("bump"), 300);
            });
            document.querySelector(".cart-total").textContent = `₱${total.toLocaleString()}`;
            document.getElementById("cart-items").innerHTML = cart.length ? cart.map(i => `
                <div class="cart-item">
                    <img src="${i.image}" class="cart-item-image">
                    <div class="cart-item-info">
                        <div class="cart-item-title">${i.title}</div>
                        <div class="cart-item-variant">Size: ${i.size}</div>
                        <div class="cart-item-price">₱${i.price.toLocaleString()}</div>
                    </div>
                    <div class="cart-item-actions">
                        <button class="qty-btn" onclick="changeQty(${i.id}, '${i.size}', -1)">−</button>
                        <span>${i.quantity}</span>
                        <button class="qty-btn" onclick="changeQty(${i.id}, '${i.size}', 1)">+</button>
                        <button class="remove-item" onclick="removeItem(${i.id}, '${i.size}')">×</button>
                    </div>
                </div>
            `).join("") : '<p class="cart-empty">Your cart is empty</p>';
        }
        
        function changeQty(id, size, delta) {
            const item = cart.find(i => i.id === id && i.size === size);
            if (item) {
                item.quantity += delta;
                if (item.quantity <= 0) removeItem(id, size);
                else updateCart();
            }
        }
        
        function removeItem(id, size) {
            cart = cart.filter(i => !(i.id === id && i.size === size));
            updateCart();
        }
        
        function showToast(msg) {
            const toast = document.getElementById("toast");
            document.getElementById("toast-message").textContent = msg;
            toast.classList.add("show");
            setTimeout(() => toast.classList.remove("show"), 3000);
        }
        
        document.querySelectorAll(".filter-btn").forEach(btn => {
            btn.addEventListener("click", () => {
                document.querySelectorAll(".filter-btn").forEach(b => b.classList.remove("active"));
                btn.classList.add("active");
                filter = btn.dataset.category;
                render();
            });
        });
        
        document.getElementById("sort-select").addEventListener("change", (e) => {
            sort = e.target.value;
            render();
        });
        
        document.querySelectorAll(".cart-toggle, .close-cart, .cart-overlay").forEach(el => {
            el.addEventListener("click", () => {
                document.querySelector(".cart-drawer").classList.toggle("active");
                document.querySelector(".cart-overlay").classList.toggle("active");
            });
        });
        
        document.querySelector(".close-modal").addEventListener("click", () => {
            document.getElementById("product-modal").classList.remove("active");
            document.querySelector(".cart-overlay").classList.remove("active");
        });
        
        render();
    </script>
</body>

</html>
