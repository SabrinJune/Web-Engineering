// index.js
const foodItems = [
    { name: "Apple", currentPrice: 15, discount: 5, applyDiscount: true, image: "image/apple.jpg" },
    { name: "Banana", currentPrice: 8, discount: 0, applyDiscount: false, image: "image/banana.jpg" },
    { name: "Orange", currentPrice: 30, discount: 10, applyDiscount: true, image: "image/orange.jpg" },
    { name: "Watermelon", currentPrice: 50, discount: 0, applyDiscount: false, image: "image/watermelon.jpg" }
  ];
  
  function getDiscountedPrice(item) {
    if (item.applyDiscount) {
      return item.currentPrice - ((item.currentPrice * item.discount) / 100);
    }
    return item.currentPrice;
  }
  
  let cart = [];
  
  function handleAddToCart(food) {
    if (!IS_LOGGED_IN) {
      alert("You must login to add items to cart.");
      window.location.href = "login.php";
      return;
    }
  
    const existing = cart.find((item) => item.name === food.name);
    if (existing) {
      existing.quantity++;
    } else {
      cart.push({ ...food, quantity: 1 });
    }
    updateCartUI();
    openCart();
  }
  
  function updateCartUI() {
    const cartItemsContainer = document.getElementById("cartItems");
    const cartCount = document.getElementById("cartCount");
    const cartTotal = document.getElementById("cartTotal");
    cartItemsContainer.innerHTML = "";
  
    let totalCost = 0;
    cart.forEach((item) => {
      const discountedPrice = getDiscountedPrice(item);
      const itemTotal = discountedPrice * item.quantity;
      totalCost += itemTotal;
  
      const div = document.createElement("div");
      div.classList.add("cart-item");
      div.innerHTML = `
        <img src="${item.image}" alt="${item.name}" width="50" />
        <div class="cart-item-details">
          <p>${item.name}</p>
          <p>Qty: ${item.quantity}</p>
          <p>Unit Price: ৳${item.currentPrice}</p>
          <p>Line Total: ৳${itemTotal.toFixed(2)}</p>
        </div>
        <button class="remove-btn">Remove</button>
      `;
      div.querySelector(".remove-btn").addEventListener("click", () => {
        removeFromCart(item.name);
      });
      cartItemsContainer.appendChild(div);
    });
  
    const totalQuantity = cart.reduce((sum, item) => sum + item.quantity, 0);
    cartCount.innerText = totalQuantity;
    cartTotal.innerHTML = `<strong>Total: ৳${totalCost.toFixed(2)}</strong>`;
  
    // enable/disable checkout
    document.getElementById('checkoutBtn').disabled = (cart.length === 0);
  }
  
  function removeFromCart(itemName) {
    cart = cart.filter((item) => item.name !== itemName);
    updateCartUI();
  }
  
  function openCart() {
    document.getElementById("cartSidebar").style.right = "0";
  }
  
  function closeCart() {
    document.getElementById("cartSidebar").style.right = "-350px";
  }
  
  function toggleCart() {
    const sidebar = document.getElementById("cartSidebar");
    if (sidebar.style.right === "0px") {
      closeCart();
    } else {
      openCart();
    }
  }
  
  const createCard = () => {
    const container = document.getElementsByClassName("card-container")[0];
  
    foodItems.forEach((food) => {
      const card = document.createElement("div");
      card.classList.add("card");
  
      const button = document.createElement("button");
      button.innerText = "Add To Cart";
      button.addEventListener("click", () => handleAddToCart(food));
  
      card.innerHTML = `
        <img src="${food.image}" alt="card" />
        <div class="card-body">
          <div class="card-title">${food.name}</div>
          <div class="card-price">৳${food.currentPrice}</div>
        </div>
      `;
  
      card.querySelector(".card-body").appendChild(button);
      container.appendChild(card);
    });
  };
  
  createCard();
  
  function checkout() {
    if (!IS_LOGGED_IN) {
      alert("You must login to checkout.");
      window.location.href = "login.php";
      return;
    }
    if (cart.length === 0) {
      alert("Cart is empty");
      return;
    }
  
    const itemsPayload = cart.map(item => ({
      name: item.name,
      total: parseFloat((getDiscountedPrice(item) * item.quantity).toFixed(2))
    }));
  
    fetch('add_order.php', {
      method: 'POST',
      headers: {'Content-Type': 'application/json'},
      body: JSON.stringify({ items: itemsPayload })
    })
    .then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        alert('Order placed successfully!');
        cart = [];
        updateCartUI();
        closeCart();
        // optionally redirect to orders page
        window.location.href = 'orders.php';
      } else {
        alert('Order failed: ' + (data.error || 'Unknown error'));
      }
    })
    .catch(err => {
      alert('Network error: ' + err);
    });
  }
  