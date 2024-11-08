import React, { useState, useEffect } from "react";

const ShippingAddress = () => {
  const [address, setAddress] = useState({
    fullName: "",
    street: "",
    postcode: "",
    country: "",
  });
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);

  useEffect(() => {
    const fetchAddress = async () => {
      try {
        const response = await fetch("/api/user");
        if (!response.ok) throw new Error("Failed to fetch address data");
        const data = await response.json();

        console.log("User data:", data);

        setAddress({
          fullName: data.fullName || data.name || "",
          street: data.address?.street || "",
          postcode: data.address?.postcode || "",
          country: data.address?.country || "",
        });

        setLoading(false);
      } catch (error) {
        setError(error.message);
        setLoading(false);
      }
    };

    fetchAddress();
  }, []);

  const handleChange = (e) => {
    const { name, value } = e.target;
    setAddress((prev) => ({ ...prev, [name]: value }));
  };

  if (loading) return <div>Loading...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <section className="shipping-address bg-white p-6 rounded shadow">
      <h2 className="text-xl font-semibold mb-4">Shipping Address</h2>
      <form className="grid gap-4">
        <label className="flex flex-col">
          Full Name
          <input
            type="text"
            name="fullName"
            placeholder="Full Name"
            className="border rounded p-2"
            value={address.fullName}
            onChange={handleChange}
          />
        </label>
        <label className="flex flex-col">
          Street/Home Nr
          <input
            type="text"
            name="street"
            placeholder="Street, Home Nr"
            className="border rounded p-2"
            value={address.street}
            onChange={handleChange}
          />
        </label>
        <label className="flex flex-col">
          Postcode, City
          <input
            type="text"
            name="postcode"
            placeholder="Postcode, City"
            className="border rounded p-2"
            value={address.postcode}
            onChange={handleChange}
          />
        </label>
        <label className="flex flex-col">
          Country
          <input
            type="text"
            name="country"
            placeholder="Country"
            className="border rounded p-2"
            value={address.country}
            onChange={handleChange}
          />
        </label>
      </form>
    </section>
  );
};

export default ShippingAddress;
