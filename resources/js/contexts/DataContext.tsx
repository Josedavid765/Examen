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
    authorId: string;
    setAuthorId: (authorId: string) => void;
    totalAuthors: number;
    posts: Post[];
    setPosts: (posts: Post[]) => void;
    totalPosts: number;
    loading: boolean;
    page: number;
    setPage: (page: number) => void;
    totalPages: number;
    filter: string;
    setFilter: (filter: string) => void;
    perPage: number;
    setPerPage: (perPage: number) => void;
    orderAuthor?: string;
    setOrderAuthor?: (order: string) => void;
    orderPost?: string;
    setOrderPost?: (order: string) => void;
    refreshData: () => Promise<void>;
}

const DataContext = createContext<DataContextType | undefined>(undefined);

export const DataProvider = ({ children }: { children: ReactNode }) => {
    const queryParams = new URLSearchParams(window.location.search);
    const [authors, setAuthors] = useState<Author[]>([]);
    const [authorId, setAuthorId] = useState(queryParams.get("authorId") || "");
    const [posts, setPosts] = useState<Post[]>([]);
    const [loading, setLoading] = useState(true);
    const [filter, setFilter] = useState(queryParams.get("fullname") || "");
    const [page, setPage] = useState(
        queryParams.get("page") ? parseInt(queryParams.get("page") || "1") : 1,
    );
    const [totalPosts, setTotalPosts] = useState(0);
    const [totalPages, setTotalPages] = useState(1);
    const [totalAuthors, setTotalAuthors] = useState(0);
    const [perPage, setPerPage] = useState(
        queryParams.get("perPage")
            ? parseInt(queryParams.get("perPage") || "3")
            : 3,
    );
    const [orderAuthor, setOrderAuthor] = useState(
        queryParams.get("order") || "birthDate",
    );
    const [orderPost, setOrderPost] = useState(
        queryParams.get("order") || "publishDate",
    );

    const loadInitialData = async () => {
        setLoading(true);
        try {
            const [authorsData, postsData] = await Promise.all([
                apiService.getAuthors(filter, page, perPage, orderAuthor),
                apiService.getAuthorPosts(authorId, page, perPage, orderPost),
            ]);

            if (authorsData.meta) {
                setTotalPages(authorsData.meta.lastPage || 1);
                setTotalPosts(postsData.meta.total || 0);
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

    useEffect(() => {
        loadInitialData();
    }, [page, perPage, orderAuthor, orderPost]);

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
                authorId,
                setAuthorId,
                totalAuthors,
                posts,
                setPosts,
                totalPosts,
                loading,
                page,
                setPage,
                totalPages,
                filter,
                setFilter,
                perPage,
                setPerPage,
                orderAuthor,
                setOrderAuthor,
                orderPost,
                setOrderPost,
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
