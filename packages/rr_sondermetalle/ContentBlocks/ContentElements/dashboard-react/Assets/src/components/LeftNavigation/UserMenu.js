import React, { useState, useEffect, memo } from "react";
import { Link } from "react-router-dom";

const UserInfo = memo(({ name, email, avatar }) => (
  <div className="flex items-center mb-4">
    <img
      src={
        avatar ||
        "https://assets.api.uizard.io/api/cdn/stream/cb8e810a-bdec-4fda-976e-923586e478e5.png"
      }
      alt="User Avatar"
      className="rounded-full w-12 h-12 mr-3"
    />
    <div>
      <p className="font-bold text-gray-900">{name}</p>
      <p className="text-sm text-gray-600">{email}</p>{" "}
    </div>
  </div>
));

const UserMenu = () => {
  const [isOpen, setIsOpen] = useState(false);
  const [userData, setUserData] = useState({ name: "", email: "", avatar: "" });

  const toggleMenu = () => setIsOpen(!isOpen);

  useEffect(() => {
    const fetchUserData = async () => {
      try {
        const response = await fetch("./api/user");
        const data = await response.json();
        console.log("User Data from API:", data);

        setUserData({
          name: `${data.first_name} ${data.last_name}`,
          email: data.email,
          avatar: data.avatar,
        });
      } catch (error) {
        console.error("Error fetching user data:", error);
      }
    };

    fetchUserData();
  }, []);

  return (
    <div className="bg-gray-200 shadow-md p-4 rounded-lg md:h-screen md:w-64 md:sticky md:top-0 flex flex-col justify-between">
      <div>
        <UserInfo
          name={userData.name}
          email={userData.email}
          avatar={userData.avatar}
        />

        <div className="flex justify-between items-center mt-4">
          <p className="font-bold text-gray-900">User Menu</p>
          <div className="md:hidden">
            <button
              onClick={toggleMenu}
              className="text-gray-900 focus:outline-none"
            >
              <svg
                className={`w-6 h-6 transition-transform duration-300 ${
                  isOpen ? "rotate-180" : "rotate-0"
                }`}
                viewBox="0 0 24 24"
              >
                <path d="M0 0h24v24H0z" fill="none"></path>
                <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
              </svg>
            </button>
          </div>
        </div>

        <div className={`mt-2 md:mt-0 ${isOpen ? "block" : "hidden"} md:block`}>
          <ul className="space-y-2">
            <li>
              <Link
                to="/dashboard"
                className="text-gray-900 hover:text-primary-500"
              >
                Dashboard
              </Link>
            </li>
            <li>
              <Link
                to="/profile"
                className="text-gray-900 hover:text-primary-500"
              >
                Profile Settings
              </Link>
            </li>
            <li>
              <Link
                to="/orders"
                className="text-gray-900 hover:text-primary-500"
              >
                Order History
              </Link>
            </li>
            <li>
              <Link
                to="/payments"
                className="text-gray-900 hover:text-primary-500"
              >
                Payment Settings
              </Link>
            </li>
          </ul>
        </div>
      </div>

      {/* Logout button only for desktop */}
      <div className="hidden md:block mt-4">
        <button className="btn btn-secondary w-full">Logout</button>
      </div>
    </div>
  );
};

export default UserMenu;
