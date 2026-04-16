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
import { Button } from "@/components/ui/button";
import { Switch } from "@/components/ui/switch";
import { Label } from "@/components/ui/label";
import { CiLight } from "react-icons/ci";
import { CiDark } from "react-icons/ci";

const App: React.FC = () => {
    const navigate = useNavigate();
    const { isDarkMode, setIsDarkMode, authorLogged } = useData();
    return (
        <div className="min-h-screen bg-slate-50 pt-12 dark:bg-slate-800 dark:text-white transition-colors duration-300">
            <div
                className={
                    isDarkMode
                        ? "fixed top-0 left-0 z-50 w-full grid grid-cols-3 bg-linear-to-r from-[#FF9A8B] to-[#1E1040] shadow gap-4 py-3 mb-10 transition-colors"
                        : "fixed top-0 left-0 z-50 w-full grid grid-cols-3 bg-linear-to-r from-[#5B0FBE] to-[#00d4ff] shadow gap-4 py-3 mb-10 transition-colors"
                }
            >
                <div></div>
                <div className="flex justify-center items-center gap-4">
                    <Button
                        className="text-white"
                        onClick={() => navigate("/posts")}
                        variant={"link"}
                    >
                        Posts
                    </Button>
                    <Button
                        className="text-white"
                        onClick={() => navigate("/authors")}
                        variant={"link"}
                    >
                        Autores
                    </Button>
                </div>
                <div className="flex">
                    <div>
                        <Label className="flex items-center gap-3 cursor-pointer group">
                            {isDarkMode &&
                                <CiLight className="text-2xl" />
                            }
                            <Switch
                                id="dark-mode"
                                checked={isDarkMode}
                                onCheckedChange={() =>
                                    setIsDarkMode(!isDarkMode)
                                }
                                className= {isDarkMode ? "bg-gray-400/40" : "bg-white"}
                            />
                            {!isDarkMode &&
                                <CiDark className="text-2xl" />
                            }
                        </Label>
                        <div className="absolute top-3 right-4 flex gap-2">
                            {authorLogged !== null ? (
                                <Button
                                    variant="link"
                                    className="text-white font-bold"
                                >
                                    {authorLogged.fullName}
                                </Button>
                            ) : (
                                <>
                                    <Button
                                        variant="link"
                                        className="text-black dark:text-gray-200 hover:underline"
                                    >
                                        Iniciar sesión
                                    </Button>
                                    <Button
                                        variant="link"
                                        className="text-black dark:text-gray-200 hover:text-underline"
                                    >
                                        Registrarse
                                    </Button>
                                </>
                            )}
                        </div>
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
