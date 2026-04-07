import {
    createContext,
    useContext,
    useState,
    useEffect,
    ReactNode,
} from "react";
import { apiService } from "../services/apiService";
import { Author } from "../models/Author";
import { Post } from "../models/Post";

interface DataContextType {
    authors: Author[];
    posts: Post[];
    loading: boolean;
    page: number;
    setPage: (page: number) => void;
    totalPages: number;
    fullname: string;
    setFullname: (fullname: string) => void;
    perPage: number;
    setPerPage: (perPage: number) => void;
    refreshData: () => Promise<void>;
}

const DataContext = createContext<DataContextType | undefined>(undefined);

export const DataProvider = ({ children }: { children: ReactNode }) => {
    const [authors, setAuthors] = useState<Author[]>([]);
    const [posts, setPosts] = useState<Post[]>([]);
    const [loading, setLoading] = useState(true);
    const [fullname, setFullname] = useState("");
    const [page, setPage] = useState(1);
    const [totalPages, setTotalPages] = useState(1);
    const [perPage, setPerPage] = useState(3);

    const loadInitialData = async () => {
        setLoading(true);
        try {
            const queryParams = new URLSearchParams(window.location.search);
            setFullname(queryParams.get("fullname") || "");
            setPage(parseInt(queryParams.get("page") || "1"));
            setPerPage(parseInt(queryParams.get("perPage") || "3"));
            const [authorsData, postsData] = await Promise.all([
                apiService.getAuthors(fullname, page, perPage),
                apiService.getPosts(),
            ]);

            setAuthors(authorsData.data || []);

            if (authorsData.meta && authorsData.meta.lastPage) {
                setTotalPages(authorsData.meta.lastPage);
            }

            setPosts(postsData.data || []);
        } catch (error) {
            console.error("Error en el Contexto:", error);
        } finally {
            setLoading(false);
        }
    };

    // useEffect para la carga inicial automática
    useEffect(() => {
        loadInitialData();
    }, [fullname, page, perPage]);

    return (
        <DataContext.Provider
            value={{
                authors,
                posts,
                loading,
                page,
                setPage,
                totalPages,
                fullname,
                setFullname,
                perPage,
                setPerPage,
                refreshData: loadInitialData,
            }}
        >
            {children}
        </DataContext.Provider>
    );
};

// Hook personalizado para usar el contexto fácilmente
export const useData = () => {
    const context = useContext(DataContext);
    if (!context)
        throw new Error("useData debe usarse dentro de un DataProvider");
    return context;
};
