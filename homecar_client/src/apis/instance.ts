import axios, { AxiosRequestConfig } from "axios";

const AUTHENTICATED_KEY = "access_token";

export const instance = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    "Content-Type": "application/json",
  },
});

export const instanceUpload = axios.create({
  baseURL: import.meta.env.VITE_API_URL,
  headers: {
    'content-type': 'multipart/form-data'
  },
});

export const getHeader = (): AxiosRequestConfig => {
  let token = localStorage.getItem(AUTHENTICATED_KEY);

  if (token == null) {
    localStorage.clear();
  }

  const headers: AxiosRequestConfig = {
    headers: {
      Authorization: `Bearer ${token}`,
    },
  };

  return headers;
};
