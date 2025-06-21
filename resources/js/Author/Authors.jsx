import React, { useState, useEffect } from "react";
import axios from "axios";

const Authors = () => {
    const [authors, setAuthors] = useState[[]];

    useEffect(() => {
        axios
            .get("/authors")
            .then((response) => {
                setAuthors(response.data);
            })
            .catch((error) => {
                console.log("finding error => ", error);
            });
    }, []);
    console.log(authors);
    return (
        <div>
            <h1>Authors</h1>
        </div>
    );
};

export default Authors;
