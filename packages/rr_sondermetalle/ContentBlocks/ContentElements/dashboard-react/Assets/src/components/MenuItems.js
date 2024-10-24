import React from "react";
import { NavLink } from "react-router-dom";

const MenuItems = ({ isMobile }) => (
  <ul className="flex flex-col">
    <NavLink
      to="/profile"
      className="text-primary-800 hover:underline"
      activeClassName="font-bold"
    >
      Profile Settings
    </NavLink>
    <NavLink
      to="/orders"
      className="text-primary-800 hover:underline"
      activeClassName="font-bold"
    >
      Order History
    </NavLink>
    <NavLink
      to="/payments"
      className="text-primary-800 hover:underline"
      activeClassName="font-bold"
    >
      Payment Settings
    </NavLink>

    {isMobile && (
      <NavLink
        to="/logout"
        className="text-primary-800 hover:underline md:hidden"
        activeClassName="font-bold"
      >
        Logout
      </NavLink>
    )}
  </ul>
);

export default MenuItems;
