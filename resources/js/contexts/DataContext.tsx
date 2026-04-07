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
    totalAuthors: number;
    posts: Post[];
    loading: boolean;
    page: number;
    setPage: (page: number) => void;
    totalPages: number;
    filter: string;
    setFilter: (filter: string) => void;
    perPage: number;
    setPerPage: (perPage: number) => void;
    refreshData: () => Promise<void>;
}

const DataContext = createContext<DataContextType | undefined>(undefined);

export const DataProvider = ({ children }: { children: ReactNode }) => {
    const queryParams = new URLSearchParams(window.location.search);
    const [authors, setAuthors] = useState<Author[]>([]);
    const [posts, setPosts] = useState<Post[]>([]);
    const [loading, setLoading] = useState(true);
    const [filter, setFilter] = useState(queryParams.get("fullname") || "");
    const [page, setPage] = useState(
        queryParams.get("page") ? parseInt(queryParams.get("page") || "1") : 1,
    );
    const [totalPages, setTotalPages] = useState(1);
    const [totalAuthors, setTotalAuthors] = useState(0);
    const [perPage, setPerPage] = useState(
        queryParams.get("perPage")
            ? parseInt(queryParams.get("perPage") || "3")
            : 3,
    );

    const loadInitialData = async () => {
        setLoading(true);
        try {
            const [authorsData, postsData] = await Promise.all([
                apiService.getAuthors(filter, page, perPage),
                apiService.getPosts(),
            ]);

            if (authorsData.meta) {
                setTotalPages(authorsData.meta.lastPage || 1);
                setTotalAuthors(authorsData.meta?.total || 0);
            }

            setAuthors(authorsData.data || []);
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
    }, [page, perPage]);

    useEffect(() => {
        const timerId = setTimeout(() => {
            setPage(1);
            loadInitialData();
        }, 700);

        return () => {
            clearTimeout(timerId);
        };
    }, [filter]);

    return (
        <DataContext.Provider
            value={{
                authors,
                totalAuthors,
                posts,
                loading,
                page,
                setPage,
                totalPages,
                filter,
                setFilter,
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
