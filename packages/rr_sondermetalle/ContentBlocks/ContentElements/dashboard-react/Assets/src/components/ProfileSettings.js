import React, { useState } from "react";

const ProfileSettings = () => {
  const [fullName, setFullName] = useState("");
  const [username, setUsername] = useState("");
  const [email, setEmail] = useState("");
  const [phone, setPhone] = useState("");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");

  return (
    <div className="profile-settings bg-gray-50 min-h-screen p-6">
      <section className="profile-overview bg-white p-6 rounded-lg shadow-lg mb-6">
        <h2 className="text-xl font-semibold text-primary-500 mb-4">
          My Profile
        </h2>
        <div className="flex items-center">
          <img
            src="https://assets.api.uizard.io/api/cdn/stream/cb8e810a-bdec-4fda-976e-923586e478e5.png"
            alt="User Avatar"
            className="rounded-full w-32 h-32"
          />
          <div className="ml-6">
            {" "}
            <p className="text-md font-bold text-primary-500 mb-1">
              Name: Jane Doe
            </p>
            <p className="text-md font-bold text-primary-500 mb-1">
              Email:{" "}
              <a
                href="mailto:jane.doe@example.com"
                className="text-primary-500"
              >
                jane.doe@example.com
              </a>
            </p>
            <p className="text-md font-bold text-primary-500 mb-4">
              Phone: (123) 456-7890
            </p>
            <button className="bg-primary-500 text-white py-2 px-4 rounded w-full hover:bg-primary-600">
              Edit Profile
            </button>
          </div>
        </div>
      </section>

      <section className="profile-edit bg-white p-6 rounded shadow">
        <h3 className="text-xl font-semibold mb-4">Edit Profile</h3>
        <form className="grid gap-4">
          <label className="flex flex-col">
            Full name
            <input
              type="text"
              placeholder="Full Name"
              value={fullName}
              onChange={(e) => setFullName(e.target.value)}
              className="border rounded p-2"
            />
          </label>
          <label className="flex flex-col">
            Username
            <input
              type="text"
              placeholder="Username"
              value={username}
              onChange={(e) => setUsername(e.target.value)}
              className="border rounded p-2"
            />
          </label>
          <label className="flex flex-col">
            Email
            <input
              type="email"
              placeholder="Company Email"
              value={email}
              onChange={(e) => setEmail(e.target.value)}
              className="border rounded p-2"
            />
          </label>
          <label className="flex flex-col">
            Phone number
            <input
              type="text"
              placeholder="123 456-7890"
              value={phone}
              onChange={(e) => setPhone(e.target.value)}
              className="border rounded p-2"
            />
          </label>
          <label className="flex flex-col">
            Create your password
            <input
              type="password"
              placeholder="Password"
              value={password}
              onChange={(e) => setPassword(e.target.value)}
              className="border rounded p-2"
            />
          </label>
          <label className="flex flex-col">
            Confirm password
            <input
              type="password"
              placeholder="Confirm Password"
              value={confirmPassword}
              onChange={(e) => setConfirmPassword(e.target.value)}
              className="border rounded p-2"
            />
          </label>
          <div className="flex space-x-2 mt-4">
            <button
              type="submit"
              className="bg-primary-500 text-white py-2 px-4 rounded hover:bg-primary-400"
            >
              Save Changes
            </button>
            <button
              type="button"
              className="bg-gray-300 text-gray-700 py-2 px-4 rounded hover:bg-gray-400"
            >
              Cancel
            </button>
          </div>
        </form>
      </section>
    </div>
  );
};

export default ProfileSettings;
