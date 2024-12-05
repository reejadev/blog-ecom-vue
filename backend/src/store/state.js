export const state = {
  user: {
    data: null,
    token: sessionStorage.getItem("Token"),
  },
  products: [],
  loading: true,
  error: null,
};
