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
import { DataProvider, useData } from "./contexts/DataContext.tsx";
import AuthorPage from "./Pages/AuthorPage.tsx";
import AuthorFormPage from "./Pages/AuthorFormPage.tsx";
import AuthorPostsPage from "./Pages/AuthorPostsPage.tsx";
import PostFormPage from "./Pages/PostFormPage.tsx";
import PostPage from "./Pages/PostPage.tsx";
import { Button } from "@/components/ui/button.tsx";
import { Switch } from "@/components/ui/switch.tsx";
import { Label } from "@/components/ui/label.tsx";

const App: React.FC = () => {
    const navigate = useNavigate();
    const { isDarkMode, setIsDarkMode } = useData();
    return (
        <div className="min-h-screen bg-slate-50 pt-12">
            <div className="fixed top-0 left-0 z-50 w-full grid grid-cols-3 bg-linear-to-r from-[#FF9A8B] to-[#1E1040] shadow gap-4 py-3 mb-10">
                <div></div>
                <div className="flex justify-center items-center gap-4">
                    <Button onClick={() => navigate("/posts")} variant={"link"}>
                        Posts
                    </Button>
                    <Button
                        onClick={() => navigate("/authors")}
                        variant={"link"}
                    >
                        Autores
                    </Button>
                </div>
                <div >
                    <div>
                        <Label className="flex items-center gap-3 cursor-pointer group">
                            <Switch
                            id="dark-mode"
                            checked={isDarkMode}
                            onCheckedChange={setIsDarkMode}
                            className=" border-gray-400/40 "/>
                            <span className="text-sm font-medium group-hover:text-slate-200">Toggle dark mode</span>
                        </Label>
                    </div>
                </div>
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
