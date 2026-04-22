import { Button } from "@/components/ui/button";
import { Switch } from "@/components/ui/switch";
import { Label } from "@/components/ui/label";
import { CiLight } from "react-icons/ci";
import { CiDark } from "react-icons/ci";
import { useNavigate } from "react-router-dom";
import { useData } from "@/contexts/DataContext";

const Navbar: React.FC = () => {
    const navigate = useNavigate();
    const { isDarkMode, setIsDarkMode, authorLogged, logout } = useData();

    return (
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
                        <CiLight
                            className={`text-2xl text-white ${isDarkMode ? "visible" : "invisible"}`}
                        />

                        <Switch
                            id="dark-mode"
                            checked={isDarkMode}
                            onCheckedChange={() => setIsDarkMode(!isDarkMode)}
                            className={
                                isDarkMode ? "bg-gray-400/40" : "bg-white"
                            }
                        />

                        <CiDark
                            className={`text-2xl text-black ${!isDarkMode ? "visible" : "invisible"}`}
                        />
                    </Label>
                    <div className="absolute top-3 right-4 flex gap-2 items-center">
                        {authorLogged !== null ? (
                            <>
                                <span
                                    className="text-white font-bold cursor-pointer hover:underline"
                                    onClick={() => navigate("/profile")}
                                >
                                    {authorLogged.fullName}
                                </span>
                                <Button
                                    variant="link"
                                    className="text-white underline hover:text-gray-200"
                                    onClick={() => {
                                        logout();
                                        navigate("/authors");
                                    }}
                                >
                                    Cerrar sesión
                                </Button>
                            </>
                        ) : (
                            <>
                                <Button
                                    variant="link"
                                    className="text-black dark:text-gray-200 hover:underline"
                                    onClick={() => navigate("/login")}
                                >
                                    Iniciar sesión
                                </Button>
                                <Button
                                    variant="link"
                                    className="text-black dark:text-gray-200 hover:underline"
                                    onClick={() => navigate("/authors/new")}
                                >
                                    Registrarse
                                </Button>
                            </>
                        )}
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Navbar;
