const foodItems = [
 {
    name: "Apple",
    currentPrice: 15,
    discount: 5,
    applyDiscount: true,
    image: "image/apple.jpg",
  },
  {
    name: "Banana",
    currentPrice: 8,
    discount: 0,
    applyDiscount: false,
    image: "image/banana.jpg",
  },
  {
    name: "Orange",
    currentPrice: 30,
    discount: 10,
    applyDiscount: true,
    image: "image/orange.jpg",
  },
  {
    name: "Watermelon",
    currentPrice: 50,
    discount: 0,
    applyDiscount: false,
    image: "image/watermelon.jpg",
  },
];
function getDiscountedPrice(item) {
  if (item.applyDiscount) {
    return item.currentPrice - ((item.currentPrice * item.discount)/100);
  }
  return item.currentPrice;
}
let cart = [];

function handleAddToCart(food) {
  console.log(`${food.name} added to cart`);

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
        <p>Price: ${item.currentPrice * item.quantity}</p>
        <p>Discount Price: ${itemTotal}</p>
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

  // 🧮 Update total cost in sidebar
  cartTotal.innerHTML = `<strong>Total: ৳${totalCost}</strong>`;
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
      <img src=${food.image} alt="card" />
      <div class="card-body">
        <div class="card-title">${food.name}</div>
        <div class="card-price">${food.currentPrice}</div>
      </div>
    `;

    card.querySelector(".card-body").appendChild(button);
    container.appendChild(card);
  });
};

createCard();