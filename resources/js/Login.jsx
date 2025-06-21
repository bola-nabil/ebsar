import React, { useState } from "react";

export default function Login() {
    const [name, setName] = useState("");
    const [password, setPassword] = useState("");
    const [error, setError] = useState("");
    const csrf = document.querySelector('meta[name="csrf-token"]').content;

    const handleSubmit = async (e) => {
        e.preventDefault();

        const res = await fetch("/", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": csrf,
            },
            body: JSON.stringify({ name, password }),
        });

        let data;
        try {
            data = await res.json();
        } catch (e) {
            console.error("Invalid JSON:", e);
            setError("Unexpected error. Please check the server logs.");
            return;
        }

        if (res.ok) {
            window.location.href = data.redirect;
        } else {
            setError(data.message || "Login Failed");
        }
    };

    console.log("errors => ", error);
    return (
        <div className="login">
            <div className="background"></div>
            <div className="overlay"></div>
            <div className="form-wrapper">
                <div className="form-header">
                    <img src="./photos/app_logo.png" alt="Logo" />
                </div>
                <form onSubmit={handleSubmit}>
                    <label htmlFor="username">Username</label>
                    <input
                        type="text"
                        id="username"
                        name="name"
                        value={name}
                        onChange={(e) => setName(e.target.value)}
                    />
                    <label htmlFor="password">Password</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        value={password}
                        onChange={(e) => setPassword(e.target.value)}
                    />
                    <button type="submit">Login</button>
                    {error && <p style={{ color: "red" }}>{error}</p>}
                </form>
            </div>
        </div>
    );
}
