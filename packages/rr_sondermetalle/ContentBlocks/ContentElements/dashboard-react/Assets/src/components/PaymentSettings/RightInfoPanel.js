import React, { useEffect, useState } from "react";

const RightInfoPanel = () => {
  const [userData, setUserData] = useState(null);
  const [loading, setLoading] = useState(true);

  useEffect(() => {
    const fetchUserData = async () => {
      try {
        const response = await fetch("/api/user");
        if (!response.ok) throw new Error("Failed to fetch user data");
        const data = await response.json();

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
        console.error("Error fetching user data:", error);
        setLoading(false);
      }
    };

    fetchUserData();
  }, []);

  const exampleData = {
    fullName: "John Doe",
    address: {
      street: "Berliner Straße, 10",
      postcode: "70123",
      city: "Berlin",
      country: "Germany",
    },
    paymentMethod: "Rechnung",
    additionalInfo: {
      shippingCost: "€1.30",
      totalPrice: "€38.99",
    },
  };

  const displayData = userData || exampleData;

  return (
    <aside className="bg-gray-100 p-4 rounded-lg shadow-md md:w-64">
      <div className="mb-6">
        <h3 className="text-lg font-semibold">My Current Address</h3>
        <p>{displayData.fullName}</p>
        <p>{displayData.address.street}</p>
        <p>
          {displayData.address.postcode}, {displayData.address.city}
        </p>
        <p>{displayData.address.country}</p>
      </div>

      <div className="mb-6">
        <h3 className="text-lg font-semibold">Aktuelle Zahlungsart</h3>
        <p>{displayData.paymentMethod}</p>
        <p className="text-sm text-gray-600">
          Bei Auswahl der Zahlungsart Rechnung erhalten Sie Ihre Bestellung...
        </p>
      </div>

      <div>
        <h3 className="text-lg font-semibold">Additional Info</h3>
        <p>Gutscheine</p>
        <p>Rabatte</p>
        <p>Versandkosten: {displayData.additionalInfo.shippingCost}</p>
        <p>Gesamtpreis: {displayData.additionalInfo.totalPrice}</p>
      </div>
    </aside>
  );
};

export default RightInfoPanel;
