import React from "react";
import ReactDOM from "react-dom/client";
import App from "./App.jsx";
import "./index.css";
import { store } from "./Redux/store.js";
import { Provider } from "react-redux";
import DataProvider from "./Provider/DataProvider.jsx";

ReactDOM.createRoot(document.getElementById("root")).render(
  <React.StrictMode>
   
      <DataProvider>
        <App />
      </DataProvider>
  
  </React.StrictMode>
);
