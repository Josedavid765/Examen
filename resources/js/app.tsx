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
import AuthorFormPage from "./Pages/AuthorFormPage.tsx";
import AuthorPostsPage from "./Pages/AuthorPostsPage.tsx";
// ¡NUEVO IMPORT DEL FORMULARIO!
import PostFormPage from "./Pages/PostFormPage.tsx";

const App: React.FC = () => {
    return (
        <DataProvider>
            <Router>
                <div className="min-h-screen bg-slate-50">
                    <div className="container mx-auto py-8">
                        <Routes>
                            <Route
                                path="/"
                                element={<Navigate to="/authors" />}
                            />

                            <Route path="/authors" element={<AuthorPage />} />
                            <Route
                                path="/authors/new"
                                element={<AuthorFormPage />}
                            />
                            <Route
                                path="/authors/edit/:id"
                                element={<AuthorFormPage />}
                            />

                            <Route
                                path="/authors/:id/posts"
                                element={<AuthorPostsPage />}
                            />

                            <Route
                                path="/posts/new"
                                element={<PostFormPage />}
                            />
                            <Route
                                path="/posts/edit/:id"
                                element={<PostFormPage />}
                            />

                            <Route
                                path="*"
                                element={
                                    <h1 className="text-center mt-10 text-xl font-bold">
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
