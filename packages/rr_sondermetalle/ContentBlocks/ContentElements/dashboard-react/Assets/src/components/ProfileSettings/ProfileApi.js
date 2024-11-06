export const fetchProfile = async () => {
  try {
    const response = await fetch("/api/user");
    if (!response.ok) {
      throw new Error("Failed to fetch profile data");
    }
    const data = await response.json();
    console.log("Fetched Profile Data:", data);
    return data;
  } catch (error) {
    throw error;
  }
};

export const updateProfile = async (data) => {
  try {
    const response = await fetch("/api/user", {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(data),
    });
    if (!response.ok) {
      throw new Error("Failed to save profile data");
    }
    return await response.json();
  } catch (error) {
    throw error;
  }
};
