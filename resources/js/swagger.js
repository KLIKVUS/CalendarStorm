import SwaggerUI from "swagger-ui";
import "swagger-ui/dist/swagger-ui.css";

SwaggerUI({
    dom_id: "#swagger-api",
    url: "/api-docs/v1.json",
    persistAuthorization: true,
    docExpansion: "none",

    requestInterceptor: (req) => {
        const authorized = JSON.parse(localStorage.getItem("authorized"));

        if (authorized?.AccessToken)
            req.headers.Authorization = "Bearer " + authorized.AccessToken.value;

        return req;
    },
});
