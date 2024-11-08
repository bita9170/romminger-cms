import React, { useState, useEffect } from "react";
import RightInfoPanel from "./RightInfoPanel";
import ShippingAddress from "./ShippingAddress";
import PaymentMethod from "./PaymentMethod";
import CartOverview from "./CartOverview";
import { fetchProfile } from "../ProfileSettings/ProfileApi";

const PaymentSetting = () => {
  const [userData, setUserData] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const loadUserData = async () => {
      try {
        const data = await fetchProfile();
        setUserData({
          fullName: `${data.first_name} ${data.last_name}`,
          address: {
            street: data.street || "Example Street",
            postcode: data.postcode || "12345",
            city: data.city || "Example City",
            country: data.country || "Example Country",
          },
          paymentMethod: data.paymentMethod || "Rechnung",
          additionalInfo: {
            shippingCost: "€1.30",
            totalPrice: "€38.99",
          },
        });
        setLoading(false);
      } catch (error) {
        console.error("Error loading user data:", error);
        setLoading(false);
      }
    };

    loadUserData();
  }, []);

  return (
    <div className="payment-setting flex flex-col md:flex-row gap-6 p-6 bg-gray-50 min-h-screen">
      <div className="main-content w-full md:w-3/4 space-y-6">
        <ShippingAddress />
        <PaymentMethod />
        <CartOverview />
      </div>

      <div className="md:block md:w-1/4">
        {!loading && userData && <RightInfoPanel userData={userData} />}
      </div>
    </div>
  );
};

export default PaymentSetting;
