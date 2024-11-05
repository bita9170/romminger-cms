import React from "react";
import RightInfoPanel from "./RightInfoPanel";

const PaymentSetting = () => {
  return (
    <div className="payment-setting flex flex-col md:flex-row gap-6 p-6 bg-gray-50 min-h-screen">
      <div className="main-content w-full md:w-3/4 space-y-6">
        <section className="shipping-address bg-white p-6 rounded shadow">
          <h2 className="text-xl font-semibold mb-4">Shipping Address</h2>
          <form className="grid gap-4">
            <label className="flex flex-col">
              Full Name
              <input
                type="text"
                placeholder="Full Name"
                className="border rounded p-2"
              />
            </label>
            <label className="flex flex-col">
              Street/Home Nr
              <input
                type="text"
                placeholder="Street, Home Nr"
                className="border rounded p-2"
              />
            </label>
            <label className="flex flex-col">
              Postcode, City
              <input
                type="text"
                placeholder="Postcode, City"
                className="border rounded p-2"
              />
            </label>
            <label className="flex flex-col">
              Country
              <input
                type="text"
                placeholder="Country"
                className="border rounded p-2"
              />
            </label>
          </form>
        </section>

        <section className="payment-method bg-white p-6 rounded shadow">
          <h2 className="text-xl font-semibold mb-4">Payment Method</h2>
          <div className="space-y-2">
            <label className="flex items-center">
              <input
                type="radio"
                name="payment"
                value="invoice"
                className="mr-2"
              />
              Invoice (Prepayment)
            </label>
            <label className="flex items-center">
              <input
                type="radio"
                name="payment"
                value="credit-card"
                className="mr-2"
              />
              Credit Card
            </label>
            <label className="flex items-center">
              <input
                type="radio"
                name="payment"
                value="paypal"
                className="mr-2"
              />
              PayPal
            </label>
          </div>
        </section>

        <section className="cart-overview bg-white p-6 rounded shadow">
          <h2 className="text-xl font-semibold mb-4">Warenkorb</h2>
          <p className="mb-2">
            1x TILGREEN Keyboard Stand, Foldable (Price: €38.99)
          </p>
          <p className="mb-2">Delivery: 6-8 days</p>
          <p className="mb-2">Seller: AUCOOR GmbH</p>
          <p className="font-semibold mb-4">Total Price: €38.99</p>
          <button className="bg-green-500 text-white py-2 px-4 rounded">
            Jetzt zum genannten Preis bestellen
          </button>
        </section>
      </div>

      <div className="md:block md:w-1/4">
        <RightInfoPanel />
      </div>
    </div>
  );
};

export default PaymentSetting;
