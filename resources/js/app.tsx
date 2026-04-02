import "./bootstrap";
import React from "react";
import { createRoot } from "react-dom/client";
import {
    BrowserRouter as Router,
    Routes,
    Route,
    Navigate,
} from "react-router-dom";

// Contextos y Páginas
import { DataProvider } from "./contexts/DataContext.tsx";
import AuthorPage from "./Pages/AuthorPage.tsx";
import AuthorFormPage from "./Pages/AuthorFormPage.tsx"; // Asegúrate de crear este archivo

const App: React.FC = () => {
    return (
        <DataProvider>
            <Router>
                <div className="min-h-screen bg-slate-50">
                    {/* Aquí podrías meter un menú/header común si te da tiempo */}

                    <div className="container mx-auto py-8">
                        <Routes>
                            {/* Al entrar a la raíz, redirigimos a autores */}
                            <Route
                                path="/"
                                element={<Navigate to="/authors" />}
                            />

                            {/* Listado de autores */}
                            <Route path="/authors" element={<AuthorPage />} />

                            {/* Formulario de autores (Upsert) */}
                            <Route
                                path="/authors/new"
                                element={<AuthorFormPage />}
                            />
                            <Route
                                path="/authors/edit/:id"
                                element={<AuthorFormPage />}
                            />

                            {/* Ruta 404 simple */}
                            <Route
                                path="*"
                                element={
                                    <h1 className="text-center mt-10">
                                        Página no encontrada
                                    </h1>
                                }
                            />
                        </Routes>
                    </div>
                </div>
            </Router>
        </DataProvider>
    );
};

const container = document.getElementById("app");
if (container) {
    const root = createRoot(container);
    root.render(<App />);
}
