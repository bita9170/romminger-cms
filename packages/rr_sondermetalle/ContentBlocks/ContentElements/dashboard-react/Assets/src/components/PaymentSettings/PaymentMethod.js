import React, { useState, useEffect } from "react";

const PaymentMethod = () => {
  const [payment, setPayment] = useState("");
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchPaymentMethod = async () => {
      try {
        const response = await fetch("/api/user");
        if (!response.ok)
          throw new Error("Failed to fetch payment method data");
        const data = await response.json();

        setPayment(data.paymentMethod);
        setLoading(false);
      } catch (error) {
        setError(error.message);
        setLoading(false);
      }
    };

    fetchPaymentMethod();
  }, []);

  const handlePaymentChange = (e) => {
    setPayment(e.target.value);
  };

  if (loading) return <div>Loading...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <section className="payment-method bg-white p-6 rounded shadow">
      <h2 className="text-xl font-semibold mb-4">Payment Method</h2>
      <div className="space-y-2">
        <label className="flex items-center">
          <input
            type="radio"
            name="payment"
            value="invoice"
            className="mr-2"
            checked={payment === "invoice"}
            onChange={handlePaymentChange}
          />
          Invoice (Prepayment)
        </label>
        <label className="flex items-center">
          <input
            type="radio"
            name="payment"
            value="credit-card"
            className="mr-2"
            checked={payment === "credit-card"}
            onChange={handlePaymentChange}
          />
          Credit Card
        </label>
        <label className="flex items-center">
          <input
            type="radio"
            name="payment"
            value="paypal"
            className="mr-2"
            checked={payment === "paypal"}
            onChange={handlePaymentChange}
          />
          PayPal
        </label>
      </div>
    </section>
  );
};

export default PaymentMethod;
