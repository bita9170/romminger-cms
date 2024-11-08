import React from "react";

const CartOverview = () => {
  const cart = [
    {
      quantity: 1,
      name: "TLGREEN Klavierbank, Höhenverstellbarer, X-förmiger Keyboard Hocker, Klappbare",
      price: "38.99",
      deliveryTime: "6-8 Werktagen",
      seller: "AUCOOR GmbH",
      paymentPauseDays: 100,
      subtotal: "1.36",
      totalPrice: "38.99",
    },
  ];

  return (
    <section className="cart-overview bg-white p-6 rounded shadow">
      <h2 className="text-xl font-semibold mb-4">Warenkorb</h2>
      {cart.map((item, index) => (
        <div key={index} className="mb-4">
          <p className="mb-2">
            {item.quantity}x {item.name} (Price: €{item.price})
          </p>
          <p className="text-gray-700">
            lieferbar - in {item.deliveryTime} bei dir
          </p>
          <p className="text-gray-700">Verkäufer: {item.seller}</p>
          <p className="text-gray-700">
            {item.paymentPauseDays} Tage Zahlpause
          </p>
          <p className="font-semibold mt-2">Zwischensumme: €{item.subtotal}</p>{" "}
          <p className="font-semibold">Gesamtpreis: €{item.totalPrice}</p>{" "}
        </div>
      ))}
      <div className="mt-4">
        <button
          onClick={() => alert("This is a placeholder for order placement.")}
          className="bg-green-500 hover:bg-green-400 text-white py-2 px-4 rounded w-full shadow-md"
        >
          Jetzt zum genannten Preis bestellen
        </button>
      </div>
    </section>
  );
};

export default CartOverview;
