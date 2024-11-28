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

    const updateTotalPrice = (element, newQuantity) => {
      const quantity = parseInt(quantityInput.value) || 0;
      const totalPrice = quantity * basePrice;
      totalPriceElement.textContent = formatPrice(totalPrice);

      const cartItemsContainer = document.querySelector(".cart-items-checkout");
      if (cartItemsContainer) {
        const productElement = element.closest(".grid");

        if (productElement) {
          const productUid = productElement.dataset.baseUid;
          const productName = productElement.dataset.baseName;
          const productImage = productElement.dataset.baseImage;

          const price = parseFloat(
            productElement.querySelector(".total-price").dataset.basePrice
          );

          if (quantity > 0) {
            addToCart(
              productImage,
              productName,
              productUid,
              newQuantity,
              price
            );
          }
        }
      }
    };

    decreaseBtn.addEventListener("click", (event) => {
      let currentValue = parseInt(quantityInput.value) || 0;
      if (currentValue > 0) {
        quantityInput.value = currentValue - 1;
        element = event.target;
        updateTotalPrice(element, -1);
      }
    });

    increaseBtn.addEventListener("click", (event) => {
      let currentValue = parseInt(quantityInput.value) || 0;
      quantityInput.value = currentValue + 1;
      element = event.target;
      updateTotalPrice(element, 1);
    });

    quantityInput.addEventListener("change", (event) => {
      element = event.target;
      const productQuanitity =
        parseInt(quantityInput.value) - parseInt(element.dataset.baseQuantity);
      updateTotalPrice(element, productQuanitity);
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
  const cartItemsContainer = document.querySelector(".cart-items-checkout");
  if (cartItemsContainer) {
    renderCheckout(cart, cartItemsContainer);
  }
  const cartSummary = document.querySelector(".cart-summary");
  if (cartSummary) {
    updateCartSummary(cart);
  }
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

  const cartItemsContainer = document.querySelector(".cart-items-checkout");
  if (cartItemsContainer) {
    renderCheckout(cart, cartItemsContainer);
  }

  const cartSummary = document.querySelector(".cart-summary");
  if (cartSummary) {
    updateCartSummary(cart);
  }
}

function getCart() {
  let cart = getCookie("cart");
  return cart ? JSON.parse(cart) : [];
}

function clearCart() {
  setCookie("cart", "", -1);
  renderCartPopover([]);
  updateCart([]);

  const cartItemsContainer = document.querySelector(".cart-items-checkout");
  if (cartItemsContainer) {
    renderCheckout([], cartItemsContainer);
  }

  const cartSummary = document.querySelector(".cart-summary");
  if (cartSummary) {
    updateCartSummary([]);
  }
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
  const numberCart = document.querySelectorAll(".cart-number");
  const popoverCart = document.getElementById("popover-cart");

  if (cart.length > 0) {
    numberCart.forEach((el) => {
      el.innerHTML = cart.length;
      el.classList.remove("d-none");
    });
    popoverCart.classList.remove("d-none");
  } else {
    numberCart.forEach((el) => {
      el.classList.add("d-none");
    });
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
  const cartItemsContainer = document.querySelectorAll(".cart-items");
  cartItemsContainer.forEach((container) => {
    container.innerHTML = "";
  });

  cart.forEach((item) => {
    const itemElement = document.createElement("div");
    const itemElement2 = document.createElement("div");

    itemElement.classList.add(
      "py-2",
      "border-b",
      "border-gray-200",
      "relative"
    );

    itemElement2.classList.add(
      "py-2",
      "border-b",
      "border-gray-200",
      "relative"
    );

    itemElement.innerHTML = `    
      <div class="flex flex-row items-center gap-2 py-2 group">
          <div class="w-full md:max-w-[62px]" style="max-width:62px">
            <img
              src="${window.location.origin}/${item.product_image}"
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
                <button class="remove-item mr-2" type="button" data-uid="${
                  item.product_uid
                }">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-red-700 hover:!fill-gray-400" viewBox="0 0 20 20" width="20px" height="20px"  aria-hidden="true" data-slot="icon" class="nl"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd"></path></svg>
               </ button>
              </div>
            </div>
          </div>
        </div>
      `;

    itemElement2.innerHTML = `    
      <div class="flex flex-row items-center gap-2 py-2 group">
          <div class="w-full md:max-w-[62px]" style="max-width:62px">
            <img
              src="${window.location.origin}/${item.product_image}"
              alt="${item.product_name}"
              class="mx-auto rounded-xl object-cover h-[60px] w-[60px]"
              style="width:60px;height:60px"
            />
          </div>
          <div class="grid grid-cols-4 w-full">
            <div class="col-span-4">
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
           
          </div>
        </div>
        
      `;

    cartItemsContainer.forEach((container, index) => {
      if (index == 0) {
        container.appendChild(itemElement);
      } else {
        container.appendChild(itemElement2);
      }
    });
  });

  document.querySelectorAll(".remove-item").forEach((button) => {
    button.addEventListener("click", function () {
      const productUid = this.getAttribute("data-uid");
      removeFromCart(productUid);
    });
  });
};

const renderCheckout = (cart, cartItemsContainer) => {
  cartItemsContainer.innerHTML = "";

  cart.forEach((item) => {
    const itemElement = document.createElement("div");
    itemElement.classList.add(
      "cart-item",
      "border-b",
      "border-gray-200",
      "pb-4"
    );

    itemElement.innerHTML = `    
      <div
          class="flex flex-col min-[500px]:flex-row min-[500px]:items-center gap-2 group"
        >
          <div
            class="w-full md:max-w-[86px] flex items-center gap-2 flex-col-reverse md:flex-row"
          >
            
            <img
              src="${window.location.origin}/${item.product_image}"
              alt="${item.product_name}"
              class="mx-auto rounded-xl object-cover h-[80px] w-[80px]"
              loading="lazy"
            />
          </div>
          <div
            class="grid grid-cols-1 md:grid-cols-4 w-full"
            data-base-uid="${item.product_uid}"
            data-base-name="${item.product_name}"
            data-base-image="${item.product_image}"
          >
            <div class="md:col-span-2">
              <div
                class="flex flex-col max-[500px]:items-center"
              >
                <h6
                  class="font-semibold text-base leading-7 text-black"
                >
                  ${item.product_name}
                </h6>

                <h6
                  class="font-medium text-base leading-7 text-gray-600 transition-all duration-300 group-hover:text-indigo-600"
                >
                  ${formatPrice(item.price)}
                </h6>
              </div>
            </div>
            <div
              class="flex items-center justify-center h-full max-md:mt-3 gap-4"
            >
              <div class="flex items-center h-full quantity-control">
              <button class="remove-item mr-2" type="button" data-uid="${
                item.product_uid
              }">
                <svg xmlns="http://www.w3.org/2000/svg" class="fill-red-700 hover:!fill-gray-400" viewBox="0 0 20 20" width="20px" height="20px"  aria-hidden="true" data-slot="icon" class="nl"><path fill-rule="evenodd" d="M8.75 1A2.75 2.75 0 0 0 6 3.75v.443c-.795.077-1.584.176-2.365.298a.75.75 0 1 0 .23 1.482l.149-.022.841 10.518A2.75 2.75 0 0 0 7.596 19h4.807a2.75 2.75 0 0 0 2.742-2.53l.841-10.52.149.023a.75.75 0 0 0 .23-1.482A41.03 41.03 0 0 0 14 4.193V3.75A2.75 2.75 0 0 0 11.25 1h-2.5ZM10 4c.84 0 1.673.025 2.5.075V3.75c0-.69-.56-1.25-1.25-1.25h-2.5c-.69 0-1.25.56-1.25 1.25v.325C8.327 4.025 9.16 4 10 4ZM8.58 7.72a.75.75 0 0 0-1.5.06l.3 7.5a.75.75 0 1 0 1.5-.06l-.3-7.5Zm4.34.06a.75.75 0 1 0-1.5-.06l-.3 7.5a.75.75 0 1 0 1.5.06l.3-7.5Z" clip-rule="evenodd"></path></svg>
               </ button>
              <button
                  class="decreaseBtn group rounded-l-xl px-2 py-[10px] border border-gray-200 flex items-center justify-center shadow-sm shadow-transparent transition-all duration-500 hover:bg-gray-50 hover:border-gray-300 hover:shadow-gray-300 focus-within:outline-gray-300"
                >
                  <svg
                    class="stroke-gray-900 transition-all duration-500 group-hover:stroke-black"
                    xmlns="http://www.w3.org/2000/svg"
                    width="22"
                    height="22"
                    viewBox="0 0 22 22"
                    fill="none"
                  >
                    <path
                      d="M16.5 11H5.5"
                      stroke=""
                      stroke-width="1.6"
                      stroke-linecap="round"
                    />
                    <path
                      d="M16.5 11H5.5"
                      stroke=""
                      stroke-opacity="0.2"
                      stroke-width="1.6"
                      stroke-linecap="round"
                    />
                    <path
                      d="M16.5 11H5.5"
                      stroke=""
                      stroke-opacity="0.2"
                      stroke-width="1.6"
                      stroke-linecap="round"
                    />
                  </svg>
                </button>
                <input
                  type="text"
                  class="quantityInput border-y border-gray-200 outline-none text-gray-900 font-semibold text-lg w-full max-w-[60px] min-w-[50px] placeholder:text-gray-900 py-[7px] text-center bg-transparent"
                  placeholder="1"
                  value="${item.quantity}"
                  data-base-quantity="${item.quantity}"
                />
                <button
                  class="increaseBtn group rounded-r-xl px-2 py-[10px] border border-gray-200 flex items-center justify-center shadow-sm shadow-transparent transition-all duration-500 hover:bg-gray-50 hover:border-gray-300 hover:shadow-gray-300 focus-within:outline-gray-300"
                >
                  <svg
                    class="stroke-gray-900 transition-all duration-500 group-hover:stroke-black"
                    xmlns="http://www.w3.org/2000/svg"
                    width="22"
                    height="22"
                    viewBox="0 0 22 22"
                    fill="none"
                  >
                    <path
                      d="M11 5.5V16.5M16.5 11H5.5"
                      stroke=""
                      stroke-width="1.6"
                      stroke-linecap="round"
                    />
                    <path
                      d="M11 5.5V16.5M16.5 11H5.5"
                      stroke=""
                      stroke-opacity="0.2"
                      stroke-width="1.6"
                      stroke-linecap="round"
                    />
                    <path
                      d="M11 5.5V16.5M16.5 11H5.5"
                      stroke=""
                      stroke-opacity="0.2"
                      stroke-width="1.6"
                      stroke-linecap="round"
                    />
                  </svg>
                </button>                
              </div>              
            </div>
            <div
              class="flex items-center max-[500px]:justify-center md:justify-end max-md:mt-3 h-full"
            >
              <p
                class="font-bold text-lg leading-8 text-gray-600 text-center transition-all duration-300 group-hover:text-indigo-600 total-price"
                data-base-price="${item.price}"
              >
                 ${formatPrice(item.total_price)}
              </p>
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

  document.querySelectorAll(".quantity-control").forEach((control) => {
    const decreaseBtn = control.querySelector(".decreaseBtn");
    const increaseBtn = control.querySelector(".increaseBtn");
    const quantityInput = control.querySelector(".quantityInput");
    const totalPriceElement = control
      .closest(".grid")
      .querySelector(".total-price");
    const basePrice = parseFloat(totalPriceElement.dataset.basePrice);

    const updateTotalPrice = (element, newQuantity) => {
      const quantity = parseInt(quantityInput.value) || 0;
      const totalPrice = quantity * basePrice;
      totalPriceElement.textContent = formatPrice(totalPrice);

      const cartItemsContainer = document.querySelector(".cart-items-checkout");
      if (cartItemsContainer) {
        const productElement = element.closest(".grid");

        if (productElement) {
          const productUid = productElement.dataset.baseUid;
          const productName = productElement.dataset.baseName;
          const productImage = productElement.dataset.baseImage;

          const price = parseFloat(
            productElement.querySelector(".total-price").dataset.basePrice
          );

          if (quantity > 0) {
            addToCart(
              productImage,
              productName,
              productUid,
              newQuantity,
              price
            );
          }
        }
      }
    };

    decreaseBtn.addEventListener("click", (event) => {
      let currentValue = parseInt(quantityInput.value) || 0;
      if (currentValue > 0) {
        quantityInput.value = currentValue - 1;
        element = event.target;
        updateTotalPrice(element, -1);
      }
    });

    increaseBtn.addEventListener("click", (event) => {
      let currentValue = parseInt(quantityInput.value) || 0;
      quantityInput.value = currentValue + 1;
      element = event.target;
      updateTotalPrice(element, 1);
    });

    quantityInput.addEventListener("change", (event) => {
      element = event.target;
      const productQuanitity =
        parseInt(quantityInput.value) - parseInt(element.dataset.baseQuantity);
      updateTotalPrice(element, productQuanitity);
    });
  });
};

function removeFromCart(productUid) {
  let cart = getCart();
  cart = cart.filter((item) => item.product_uid !== productUid);
  setCookie("cart", JSON.stringify(cart), 7);
  updateCart(cart);
  renderCartPopover(cart);

  const cartItemsContainer = document.querySelector(".cart-items-checkout");
  if (cartItemsContainer) {
    renderCheckout(cart, cartItemsContainer);
  }

  const cartSummary = document.querySelector(".cart-summary");
  if (cartSummary) {
    updateCartSummary(cart);
  }
}

function updateCartSummary(cart) {
  const totalWithoutVatElement = document.querySelector(".total-without-vat");
  const vatElement = document.querySelector(".price-vat");
  const shippingCostElement = document.querySelector(".shipping-cost");
  const totalElement = document.querySelector(".total");

  let totalWithoutVat = 0;
  let vatRate = 0.19;
  let shippingCost = 0;

  cart.forEach((item) => {
    totalWithoutVat += item.price * item.quantity;
  });

  const vat = totalWithoutVat * vatRate;
  const total = totalWithoutVat + vat + shippingCost;

  if (totalWithoutVatElement) {
    totalWithoutVatElement.textContent = formatPrice(totalWithoutVat);
  }
  if (vatElement) {
    vatElement.textContent = formatPrice(vat);
  }
  if (shippingCostElement) {
    shippingCostElement.textContent = formatPrice(shippingCost);
  }
  if (totalElement) {
    totalElement.textContent = formatPrice(total);
  }
}
