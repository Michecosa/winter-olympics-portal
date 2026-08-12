const API_BASE_URL = (
  import.meta.env.VITE_API_URL || "http://127.0.0.1:8000"
).replace(/\/$/, "");

export const apiUrl = (path) => `${API_BASE_URL}/api${path}`;

export const storageUrl = (path) => `${API_BASE_URL}/storage/${path}`;
