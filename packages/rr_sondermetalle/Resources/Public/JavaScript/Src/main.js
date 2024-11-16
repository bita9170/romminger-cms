const header = document.querySelector("header");

window.addEventListener("scroll", function () {
  if (window.scrollY >= header.offsetHeight) {
    header.classList.add("fixed");
  } else {
    header.classList.remove("fixed");
  }
});

document.addEventListener("DOMContentLoaded", function () {
  const togglers = document.querySelectorAll(".caret-icon");
  togglers.forEach(function (toggle) {
    toggle.addEventListener("click", function (event) {
      event.stopPropagation();
      const nestedList = this.parentElement.querySelector(".nested");
      if (nestedList) {
        nestedList.classList.toggle("d-block");
        this.classList.toggle("caret-down");
      }
    });
  });

  const cart = getCart();
  updateCart(cart);

  document.querySelectorAll(".quantity-control").forEach((control) => {
    const decreaseBtn = control.querySelector(".decreaseBtn");
    const increaseBtn = control.querySelector(".increaseBtn");
    const quantityInput = control.querySelector(".quantityInput");
    const totalPriceElement = control
      .closest(".grid")
      .querySelector(".total-price");
    const basePrice = parseFloat(totalPriceElement.dataset.basePrice);

    const updateTotalPrice = () => {
      const quantity = parseInt(quantityInput.value) || 0;
      const totalPrice = quantity * basePrice;
      totalPriceElement.textContent = formatPrice(totalPrice);
    };

    decreaseBtn.addEventListener("click", () => {
      let currentValue = parseInt(quantityInput.value) || 0;
      if (currentValue > 0) {
        quantityInput.value = currentValue - 1;
        updateTotalPrice();
      }
    });

    increaseBtn.addEventListener("click", () => {
      let currentValue = parseInt(quantityInput.value) || 0;
      quantityInput.value = currentValue + 1;
      updateTotalPrice();
    });

    quantityInput.addEventListener("change", () => {
      updateTotalPrice();
    });
  });

  document.querySelectorAll(".cart-button").forEach((addToCartBtn, index) => {
    addToCartBtn.addEventListener("click", function () {
      const productElement = addToCartBtn.closest(".grid");
      const productUid = productElement.dataset.baseUid;
      const productName = productElement.dataset.baseName;
      const productImage = productElement.dataset.baseImage;

      const quantity =
        parseInt(productElement.querySelector(".quantityInput").value) || 0;
      const price = parseFloat(
        productElement.querySelector(".total-price").dataset.basePrice
      );

      if (quantity > 0) {
        addToCart(productImage, productName, productUid, quantity, price);
      }
    });
  });

  renderCartPopover(cart);
});

function addToCart(product_image, product_name, product_uid, quantity, price) {
  let cart = getCart();
  let total_price = price * quantity;

  const existingProductIndex = cart.findIndex(
    (item) => item.product_uid === product_uid
  );
  if (existingProductIndex !== -1) {
    cart[existingProductIndex].quantity += quantity;
    cart[existingProductIndex].total_price += total_price;
  } else {
    cart.push({
      product_image,
      product_name,
      product_uid,
      quantity,
      price,
      total_price,
    });
  }

  setCookie("cart", JSON.stringify(cart), 7);
  updateCart(cart);
  renderCartPopover(cart);
}

function getCart() {
  let cart = getCookie("cart");
  return cart ? JSON.parse(cart) : [];
}

function clearCart() {
  setCookie("cart", "", -1);
  renderCartPopover([]);
  updateCart([]);
}

function setCookie(name, value, days) {
  let expires = "";
  if (days) {
    let date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000);
    expires = "; expires=" + date.toUTCString();
  }
  document.cookie =
    name + "=" + (encodeURIComponent(value) || "") + expires + "; path=/";
}

function getCookie(name) {
  let cookieArr = document.cookie.split(";");
  for (let i = 0; i < cookieArr.length; i++) {
    let cookiePair = cookieArr[i].split("=");
    if (name === cookiePair[0].trim()) {
      return decodeURIComponent(cookiePair[1]);
    }
  }
  return null;
}

function updateCart(cart) {
  const numberCart = document.querySelector(".cart-number");
  const popoverCart = document.getElementById("popover-cart");

  if (cart.length > 0) {
    numberCart.innerHTML = cart.length;
    numberCart.classList.remove("d-none");
    popoverCart.classList.remove("d-none");
  } else {
    numberCart.classList.add("d-none");
    popoverCart.classList.add("d-none");
  }
}

const formatPrice = (price) => {
  return new Intl.NumberFormat("de-DE", {
    style: "currency",
    currency: "EUR",
  }).format(price);
};

const renderCartPopover = (cart) => {
  const cartItemsContainer = document.querySelector(".cart-items");
  cartItemsContainer.innerHTML = "";

  cart.forEach((item) => {
    const itemElement = document.createElement("div");
    itemElement.classList.add(
      "py-2",
      "border-b",
      "border-gray-200",
      "relative"
    );

    itemElement.innerHTML = `    
      <div class="flex flex-row items-center gap-2 py-2 group">
          <div class="w-full md:max-w-[62px]" style="max-width:62px">
            <img
              src="${item.product_image}"
              alt="${item.product_name}"
              class="mx-auto rounded-xl object-cover h-[60px] w-[60px]"
              style="width:60px;height:60px"
            />
          </div>
          <div class="grid grid-cols-4 w-full">
            <div class="col-span-2">
              <div class="flex flex-col">
                <div class="font-semibold text-sm text-black">${
                  item.product_name
                }</div>
                <div class="font-medium text-sm text-gray-600">${
                  item.quantity
                } x ${formatPrice(item.price)}</div>
                <div class="font-bold text-sm text-gray-600 total-price">${formatPrice(
                  item.total_price
                )}</div>
              </div>
            </div>
            <div class="col-span-2">
              <div class="flex items-center justify-end h-full">
               <button
                  class="text-primary-500 hover:text-red-800 text-3xl text-center remove-item"
                  data-uid="${item.product_uid}"
                >
                  &times;
                </button>
              </div>
            </div>
          </div>
        </div>
        
      `;
    cartItemsContainer.appendChild(itemElement);
  });

  document.querySelectorAll(".remove-item").forEach((button) => {
    button.addEventListener("click", function () {
      const productUid = this.getAttribute("data-uid");
      removeFromCart(productUid);
    });
  });
};

function removeFromCart(productUid) {
  let cart = getCart();
  cart = cart.filter((item) => item.product_uid !== productUid);
  setCookie("cart", JSON.stringify(cart), 7);
  updateCart(cart);
  renderCartPopover(cart);
}
