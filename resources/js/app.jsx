import React from "react";
import { createRoot } from "react-dom/client";
import Login from "./Login";
import Authors from "./Author/Authors";

const path = window.location.pathname;

const root = createRoot(document.getElementById("app"));

if (path === "/") {
    root.render(<Login />);
}
if (path === "/authors") {
    root.render(<Authors />);
}
