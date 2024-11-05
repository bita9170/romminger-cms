import React, { useState, useEffect } from "react";

const OrderHistory = () => {
  const [orders, setOrders] = useState([]);

  useEffect(() => {
    // example data
    const mockOrders = [
      { id: 12345, status: "Shipped", date: "2023-08-30" },
      { id: 12346, status: "Delivered", date: "2023-08-30" },
      { id: 12347, status: "Processing", date: "2023-08-10" },
    ];
    setOrders(mockOrders);
// Api call
  }, []);

  return (
    <div className="order-history bg-gray-50 min-h-screen p-6">
      <h2 className="text-2xl font-semibold mb-6">Order History</h2>

      <div className="space-y-4">
        {orders.map((order) => (
          <div
            key={order.id}
            className="bg-white p-6 rounded shadow flex justify-between items-center"
          >
            <div>
              <p className="text-lg font-semibold">Order #{order.id}</p>
              <p>Status: {order.status}</p>
              <p>Date: {order.date}</p>
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
