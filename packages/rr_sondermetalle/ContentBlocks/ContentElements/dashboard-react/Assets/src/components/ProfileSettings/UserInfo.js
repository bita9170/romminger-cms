import React from 'react';

const UserInfo = ({ firstName, lastName, username, email, phone, onEdit }) => {
  return (
    <section className="profile-overview bg-white p-6 rounded-lg shadow-lg mb-6">
      <h2 className="text-xl font-semibold text-primary-500 mb-4">My Profile</h2>
      <div className="flex items-center">
        <img
          src="https://assets.api.uizard.io/api/cdn/stream/cb8e810a-bdec-4fda-976e-923586e478e5.png"
          alt="User Avatar"
          className="rounded-full w-32 h-32"
        />
        <div className="ml-6">
          <p className="text-md font-bold text-primary-500 mb-1">
            Name: {firstName} {lastName}
          </p>
          <p className="text-md font-bold text-primary-500 mb-1">
            Username: {username}
          </p>
          <p className="text-md font-bold text-primary-500 mb-1">
            Email: <a href={`mailto:${email}`} className="text-primary-500">{email}</a>
          </p>
          <p className="text-md font-bold text-primary-500 mb-4">Phone: {phone}</p>
          <button
            className="bg-primary-500 text-white py-2 px-4 rounded w-full hover:bg-primary-600"
            onClick={onEdit}
          >
            Edit Profile
          </button>
        </div>
      </div>
    </section>
  );
};

export default UserInfo;
