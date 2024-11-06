import React, { useState, useEffect } from "react";
import UserInfo from "./UserInfo";
import EditProfileForm from "./EditProfileForm";
import { fetchProfile, updateProfile } from "./ProfileApi";

const ProfileSettings = () => {
  const [userData, setUserData] = useState({
    firstName: "",
    lastName: "",
    username: "",
    email: "",
    phone: "",
  });
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [isEditing, setIsEditing] = useState(false);
  const [success, setSuccess] = useState(false);

  useEffect(() => {
    setLoading(true);
    fetchProfile()
      .then((data) => {
        console.log("Profile Data from API:", data);
        setUserData({
          firstName: data.first_name || "",
          lastName: data.last_name || "",
          username: data.username || "",
          email: data.email || "",
          phone: data.phone || "",
        });
        setLoading(false);
      })
      .catch((error) => {
        setError(error.message);
        setLoading(false);
      });
  }, []);

  const handleSave = (updatedData) => {
    setError(null);
    setSuccess(false);

    updateProfile(updatedData)
      .then((response) => {
        setUserData(updatedData);
        setSuccess(true);
        setIsEditing(false);
      })
      .catch((error) => {
        setError(error.message);
      });
  };

  if (loading) return <div>Loading...</div>;
  if (error) return <div>Error: {error}</div>;

  return (
    <div className="profile-settings bg-gray-50 min-h-screen p-6">
      <UserInfo
        firstName={userData.firstName}
        lastName={userData.lastName}
        username={userData.username}
        email={userData.email}
        phone={userData.phone}
        onEdit={() => setIsEditing(true)}
      />

      {isEditing && (
        <EditProfileForm
          initialFirstName={userData.firstName}
          initialLastName={userData.lastName}
          initialUsername={userData.username}
          initialEmail={userData.email}
          initialPhone={userData.phone}
          onSave={handleSave}
          onCancel={() => setIsEditing(false)}
        />
      )}

      {success && (
        <p className="text-green-500 mt-4">Profile updated successfully!</p>
      )}
      {error && <p className="text-red-500 mt-4">{error}</p>}
    </div>
  );
};

export default ProfileSettings;
