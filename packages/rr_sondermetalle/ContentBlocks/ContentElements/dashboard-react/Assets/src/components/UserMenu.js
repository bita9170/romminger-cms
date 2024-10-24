import React, { useState, memo } from "react";
import { Nav } from "react-bootstrap";

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

const MenuItems = ({ isMobile }) => (
  <Nav className="flex flex-col">
    <Nav.Link href="/profile" className="text-primary-800 hover:underline">
      Profile Settings
    </Nav.Link>
    <Nav.Link href="/orders" className="text-primary-800 hover:underline">
      Order History
    </Nav.Link>
    <Nav.Link href="/payments" className="text-primary-800 hover:underline">
      Payment Settings
    </Nav.Link>
    {isMobile && (
      <Nav.Link href="/logout" className="text-primary-800 hover:underline">
        Logout
      </Nav.Link>
    )}
  </Nav>
);

const UserMenu = () => {
  const [isOpen, setIsOpen] = useState(false);

  const toggleMenu = () => setIsOpen(!isOpen);

  return (
    <div className="bg-gray-200 shadow-md p-4 rounded-lg md:h-screen md:w-64 md:sticky md:top-0 flex flex-col justify-between">
      <div>
        <UserInfo />
        {/* Toggle button for mobile */}
        <div
          className="cursor-pointer flex items-center justify-start md:hidden"
          onClick={toggleMenu}
        >
          <p className="font-bold text-gray-900">User Menu</p>
          <svg
            className={`w-6 h-6 ml-2 transition-transform duration-300 ${
              isOpen ? "rotate-180" : "rotate-0"
            }`}
            viewBox="0 0 24 24"
          >
            <path d="M0 0h24v24H0z" fill="none"></path>
            <path d="M16.59 8.59L12 13.17 7.41 8.59 6 10l6 6 6-6z"></path>
          </svg>
        </div>

        {/* Collapsible menu */}
        <div className={`mt-2 md:mt-0 ${isOpen ? "block" : "hidden"} md:block`}>
          <MenuItems isMobile={true} />
        </div>
      </div>
      
      {/* Logout button for desktop */}
      <div className="hidden md:block">
        <button className="btn btn-secondary w-full">Logout</button>
      </div>
    </div>
  );
};

export default UserMenu;
