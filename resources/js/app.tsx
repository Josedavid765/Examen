import "./bootstrap";
import React from "react";
import { createRoot } from "react-dom/client";
import {
    BrowserRouter as Router,
    Routes,
    Route,
    Navigate,
    useNavigate,
} from "react-router-dom";
// Contextos y Páginas
import { DataProvider } from "./contexts/DataContext.tsx";
import AuthorPage from "./Pages/AuthorPage.tsx";
import AuthorFormPage from "./Pages/AuthorFormPage.tsx";
import AuthorPostsPage from "./Pages/AuthorPostsPage.tsx";
// ¡NUEVO IMPORT DEL FORMULARIO!
import PostFormPage from "./Pages/PostFormPage.tsx";
import PostPage from "./Pages/PostPage.tsx";
import { Button } from "./components/ui/button.tsx";

const App: React.FC = () => {
    const navigate = useNavigate();
    return (
        <div className="min-h-screen bg-slate-50">
            <div className="bg-gray-400/40 shadow flex justify-center align-middle gap-4 py-3">
                <Button onClick={() => navigate("/posts")} variant={"link"}>
                    Posts
                </Button>
                <Button onClick={() => navigate("/authors")} variant={"link"}>
                    Autores
                </Button>
            </div>
            <div className="container mx-auto py-8">
                <Routes>
                    <Route path="/" element={<Navigate to="/authors" />} />

                    <Route path="/authors" element={<AuthorPage />} />
                    <Route path="/authors/new" element={<AuthorFormPage />} />
                    <Route
                        path="/authors/edit/:id"
                        element={<AuthorFormPage />}
                    />

                    <Route
                        path="/authors/:id/posts"
                        element={<AuthorPostsPage />}
                    />

                    <Route path="/posts/new" element={<PostFormPage />} />
                    <Route path="/posts/edit/:id" element={<PostFormPage />} />
                    <Route path="/posts" element={<PostPage />} />

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
    );
};

const container = document.getElementById("app");
if (container) {
    const root = createRoot(container);
    root.render(
        <React.StrictMode>
            <DataProvider>
                <Router>
                    <App />
                </Router>
            </DataProvider>
        </React.StrictMode>,
    );
}
