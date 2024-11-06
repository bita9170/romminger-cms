import React, { useState } from "react";

const EditProfileForm = ({
  initialFirstName,
  initialLastName,
  initialUsername,
  initialEmail,
  initialPhone,
  onSave,
  onCancel,
}) => {
  const [firstName, setFirstName] = useState(initialFirstName || "");
  const [lastName, setLastName] = useState(initialLastName || "");
  const [username, setUsername] = useState(initialUsername || "");
  const [email, setEmail] = useState(initialEmail || "");
  const [phone, setPhone] = useState(initialPhone || "");
  const [password, setPassword] = useState("");
  const [confirmPassword, setConfirmPassword] = useState("");
  const [error, setError] = useState(null);

  const handleSubmit = (e) => {
    e.preventDefault();
    setError(null);

    if (password && password !== confirmPassword) {
      setError("Passwords do not match");
      return;
    }

    onSave({
      firstName,
      lastName,
      username,
      email,
      phone,
      password: password || undefined,
    });
  };

  return (
    <section className="profile-edit bg-white p-6 rounded shadow">
      <h3 className="text-xl font-semibold mb-4">Edit Profile</h3>
      <form className="grid gap-4" onSubmit={handleSubmit}>
        <label className="flex flex-col">
          First name
          <input
            type="text"
            placeholder="First Name"
            value={firstName}
            onChange={(e) => setFirstName(e.target.value)}
            className="border rounded p-2"
          />
        </label>
        <label className="flex flex-col">
          Last name
          <input
            type="text"
            placeholder="Last Name"
            value={lastName}
            onChange={(e) => setLastName(e.target.value)}
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
          Password
          <input
            type="password"
            placeholder="Password"
            value={password}
            onChange={(e) => setPassword(e.target.value)}
            className="border rounded p-2"
          />
        </label>
        <label className="flex flex-col">
          Confirm Password
          <input
            type="password"
            placeholder="Confirm Password"
            value={confirmPassword}
            onChange={(e) => setConfirmPassword(e.target.value)}
            className="border rounded p-2"
          />
        </label>
        {error && <p className="text-red-500">{error}</p>}
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
            onClick={onCancel}
          >
            Cancel
          </button>
        </div>
      </form>
    </section>
  );
};

export default EditProfileForm;
