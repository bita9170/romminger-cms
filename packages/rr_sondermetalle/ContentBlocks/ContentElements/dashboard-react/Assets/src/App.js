import React from "react";
import { BrowserRouter as Router, Route, Routes } from "react-router-dom";
import UserMenu from "./components/UserMenu";
import ProfileSettings from "./components/ProfileSettings";
import OrderHistory from "./components/OrderHistory";
import PaymentSettings from "./components/PaymentSettings";

function App() {
  return (
    <Router>
      <div className="flex flex-col md:flex-row">
        <UserMenu />
        <div className="flex-grow p-4 ml-64">
          <Routes>
            <Route path="/profile" element={<ProfileSettings />} />
            <Route path="/orders" element={<OrderHistory />} />
            <Route path="/payments" element={<PaymentSettings />} />
          </Routes>
        </div>
      </div>
    </Router>
  );
}

export default App;
