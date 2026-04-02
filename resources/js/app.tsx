import "./bootstrap";
import React from "react";
import { createRoot } from "react-dom/client";
import AuthorPage from "./Pages/AuthorPage.tsx";
import { DataProvider } from "./contexts/DataContext.tsx";

// Definimos un componente sencillo
const App: React.FC = () => {
    return (
        <DataProvider>
            <div style={{ padding: "20px" }}>
                <AuthorPage />
            </div>
        </DataProvider>
    );
};

// Buscamos el elemento 'app' en el HTML
const container = document.getElementById("app");

if (container) {
    const root = createRoot(container);
    root.render(<App />);
}
