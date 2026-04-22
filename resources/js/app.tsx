import "./bootstrap";
import React from "react";
import { createRoot } from "react-dom/client";
import {
    BrowserRouter as Router,
    Routes,
    Route,
    Navigate,
} from "react-router-dom";
import { DataProvider } from "./contexts/DataContext.tsx";
import AuthorPage from "./Pages/AuthorPage.tsx";
import AuthorFormPage from "./Pages/AuthorFormPage.tsx";
import AuthorPostsPage from "./Pages/AuthorPostsPage.tsx";
import PostFormPage from "./Pages/PostFormPage.tsx";
import PostPage from "./Pages/PostPage.tsx";
import PostDetailPage from "./Pages/PostDetailPage.tsx";
import LoginPage from "./Pages/LoginPage.tsx";
import LoggedAuthorPage from "./Pages/LoggedAuthorPage.tsx";
import Navbar from "./components/Navbar.tsx";
import { ToastProvider } from "./components/ui/toast.tsx";

const App: React.FC = () => {
    return (
        <div className="min-h-screen bg-slate-50 pt-12 dark:bg-slate-800 dark:text-slate-300 transition-colors">
            <Navbar />
            <div>
                <div className="container mx-auto py-8">
                    <Routes>
                        <Route path="/" element={<Navigate to="/authors" />} />

                        <Route path="/login" element={<LoginPage />} />

                        <Route path="/authors" element={<AuthorPage />} />
                        <Route
                            path="/authors/new"
                            element={<AuthorFormPage />}
                        />
                        <Route
                            path="/authors/edit/:id"
                            element={<AuthorFormPage />}
                        />

                        <Route path="/profile" element={<LoggedAuthorPage />} />

                        <Route
                            path="/authors/:id/posts"
                            element={<AuthorPostsPage />}
                        />

                        <Route path="/posts/new" element={<PostFormPage />} />
                        <Route
                            path="/posts/edit/:id"
                            element={<PostFormPage />}
                        />
                        <Route path="/posts/:id" element={<PostDetailPage />} />
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
        </div>
    );
};

const container = document.getElementById("app");
if (container) {
    const root = createRoot(container);
    root.render(
        <React.StrictMode>
            <DataProvider>
                <ToastProvider position="bottom-right">
                    <Router>
                        <App />
                    </Router>
                </ToastProvider>
            </DataProvider>
        </React.StrictMode>,
    );
}
