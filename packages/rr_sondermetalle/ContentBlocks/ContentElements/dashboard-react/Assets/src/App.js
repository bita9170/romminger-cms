import React from "react";
import {
  BrowserRouter as Router,
  Route,
  Routes,
  Navigate,
} from "react-router-dom";
import UserMenu from "./components/LeftNavigation/UserMenu";
import ProfileSettings from "./components/ProfileSettings/ProfileSettings";
import OrderHistory from "./components/OrderHistory";
import PaymentSettings from "./components/PaymentSettings";

function WelcomeDashboard() {
  return (
    <div className="welcome-message mt-6 p-6 bg-white rounded-lg shadow-md">
      <h2 className="text-2xl font-semibold text-gray-800">
        Welcome to Your Dashboard!
      </h2>
      <p className="text-gray-600 mt-2">
        Here you can manage your profile, view your order history, and update
        your payment settings.
      </p>
      <div className="info-cards mt-4 grid grid-cols-1 md:grid-cols-2 gap-4">
        <div className="card p-4 bg-gray-100 rounded-lg shadow-sm">
          <h3 className="font-bold text-gray-800">Account Status</h3>
          <p className="text-gray-600">Active</p>
        </div>
        <div className="card p-4 bg-gray-100 rounded-lg shadow-sm">
          <h3 className="font-bold text-gray-800">Recent Orders</h3>
          <p className="text-gray-600">You have 5 recent orders</p>
        </div>
        <div className="card p-4 bg-gray-100 rounded-lg shadow-sm">
          <h3 className="font-bold text-gray-800">Last Login</h3>
          <p className="text-gray-600">2 days ago</p>
        </div>
      </div>
    </div>
  );
}

function App() {
  return (
    <Router>
      <div className="flex flex-col md:flex-row">
        <UserMenu />
        <div className="flex-grow p-4 ml-64">
          <Routes>
            <Route path="/dashboard" element={<WelcomeDashboard />} />
            <Route path="/profile" element={<ProfileSettings />} />
            <Route path="/orders" element={<OrderHistory />} />
            <Route path="/payments" element={<PaymentSettings />} />
            <Route path="*" element={<Navigate to="/dashboard" />} />
          </Routes>
        </div>
      </div>
    </Router>
  );
}

export default App;
