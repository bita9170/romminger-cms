import React from "react";
import { NavLink } from "react-router-dom";

const MenuItems = ({ isMobile }) => (
  <ul className="flex flex-col">
    <NavLink to="/profile" className="text-primary-800 hover:underline">
      Profile Settings
    </NavLink>
    <NavLink to="/orders" className="text-primary-800 hover:underline">
      Order History
    </NavLink>
    <NavLink to="/payments" className="text-primary-800 hover:underline">
      Payment Settings
    </NavLink>

    {isMobile && (
      <NavLink
        to="/logout"
        className="text-primary-800 hover:underline md:hidden"
      >
        Logout
      </NavLink>
    )}
  </ul>
);

export default MenuItems;
