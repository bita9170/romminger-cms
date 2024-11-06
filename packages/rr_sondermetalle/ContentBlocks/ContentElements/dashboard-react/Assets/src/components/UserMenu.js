import React, { useState, useEffect, memo } from "react";
import MenuItems from "./MenuItems";

const UserInfo = memo(() => (
  <div className="flex items-center mb-4">
    <img
      src="https://assets.api.uizard.io/api/cdn/stream/cb8e810a-bdec-4fda-976e-923586e478e5.png"
      alt="User Avatar"
      className="rounded-full w-12 h-12 mr-3"
    />
    <div>
      <p className="font-bold text-gray-900">John Doe</p>
      <p className="text-sm text-gray-600">john.doe@example.com</p>
    </div>
  </div>
));

const UserMenu = () => {
  const [isOpen, setIsOpen] = useState(false);

  const toggleMenu = () => setIsOpen(!isOpen);

  useEffect(async () => {
    await fetch("./api/user")
      .then((response) => response.json())
      .then((json) => console.log(json));

    await fetch("./api/material/all")
      .then((response) => response.json())
      .then((json) => console.log(json));
  });

  return (
    <div className="bg-gray-200 shadow-md p-4 rounded-lg md:h-screen md:w-64 md:sticky md:top-0 flex flex-col justify-between">
      <div>
        <UserInfo />
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
          <MenuItems isMobile={true} />
        </div>
      </div>

      {/* Logout button only for desktop */}
      <div className="hidden md:block">
        <button className="btn btn-secondary w-full">Logout</button>
      </div>
    </div>
  );
};

export default UserMenu;
