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
    refreshData: () => Promise<void>;
}

const DataContext = createContext<DataContextType | undefined>(undefined);

export const DataProvider = ({ children }: { children: ReactNode }) => {
    const [authors, setAuthors] = useState<Author[]>([]);
    const [posts, setPosts] = useState<Post[]>([]);
    const [loading, setLoading] = useState(true);

    const loadInitialData = async () => {
        setLoading(true);
        try {
            const [authorsData, postsData] = await Promise.all([
                apiService.getAuthors(),
                apiService.getPosts(),
            ]);
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
    }, []);

    return (
        <DataContext.Provider
            value={{ authors, posts, loading, refreshData: loadInitialData }}
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
