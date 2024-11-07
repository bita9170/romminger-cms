import React, { useState, useEffect } from "react";
import { fetchOrders } from "./OrderApi";

const OrderHistory = () => {
  const [orders, setOrders] = useState([]);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    setLoading(true);
    fetchOrders()
      .then((data) => {
        setOrders(data);
        setLoading(false);
      })
      .catch((error) => {
        setError(error.message);
        setLoading(false);
      });
  }, []);

  if (loading) return <div>Loading...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <div className="order-history bg-gray-50 min-h-screen p-6">
      <h2 className="text-2xl font-semibold mb-6">Order History</h2>

      <div className="space-y-4">
        {orders.map((order, index) => (
          <div
            key={index} // Using index as a temporary key
            className="bg-white p-6 rounded shadow flex justify-between items-center"
          >
            <div>
              <p className="text-lg font-semibold">Order #{index + 1}</p>{" "}
              <p>Status: {order.status || "Completed"}</p>
              <p>Date: {order.date || "2024-01-01"}</p>
            </div>
            <div className="flex space-x-2">
              <button className="bg-primary-500 text-white py-2 px-4 rounded hover:bg-primary-400">
                View Details
              </button>
              <button className="bg-gray-300 text-black py-2 px-4 rounded hover:bg-gray-200">
                Reorder
              </button>
            </div>
          </div>
        ))}
      </div>
    </div>
  );
};

export default OrderHistory;
