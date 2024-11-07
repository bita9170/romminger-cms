export const fetchOrders = async () => {
  try {
    const response = await fetch("/api/material/all");
    if (!response.ok) {
      console.error("API response status:", response.status);
      throw new Error("Failed to fetch orders data");
    }
    const data = await response.json();
    console.log("Fetched Orders Data:", data);
    return data;
  } catch (error) {
    console.error("Fetch Orders Error:", error);
    throw error;
  }
};
