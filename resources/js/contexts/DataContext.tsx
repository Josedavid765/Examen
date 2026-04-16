import { createContext, useContext, useState, ReactNode, useEffect } from "react";
import { apiService } from "../services/apiService";
import { Author } from "../models/Author";
import { Post } from "../models/Post";

interface DataContextType {
    authorLogged: Author | null;
    logAuthor: (author: Author) => void;
    isDarkMode: boolean;
    setIsDarkMode: (isDarkMode: boolean) => void;
    authors: Author[];
    authorId: string;
    setAuthorId: (authorId: string) => void;
    totalAuthors: number;
    posts: Post[];
    totalPosts: number;
    setPosts: (posts: Post[]) => void;
    loading: boolean;
    AuthorPage: number;
    setAuthorPage: (page: number) => void;
    totalAuthorPages: number;
    PostPage: number;
    setPostPage: (page: number) => void;
    totalPostPages: number;
    authorPerPage: number;
    setAuthorPerPage: (perPage: number) => void;
    postPerPage: number;
    setPostPerPage: (perPage: number) => void;
    filter: string;
    setFilter: (filter: string) => void;
    orderAuthor?: string;
    setOrderAuthor?: (order: string) => void;
    orderPost?: string;
    setOrderPost?: (order: string) => void;
    logout: () => void;
    refreshAuthorData: (debouncedSearch?: string) => Promise<void>;
    refreshPostData: (currentAuthorId?: string) => Promise<void>;
}

interface ApiMeta {
    total: number;
    lastPage: number;
}

interface AuthorResponse {
    data: Author[];
    meta: ApiMeta;
}

interface PostResponse {
    data: Post[];
    meta: ApiMeta;
}

const DataContext = createContext<DataContextType | undefined>(undefined);

export const DataProvider = ({ children }: { children: ReactNode }) => {
    const [authorLogged, setAuthorLogged] = useState<Author | null>(() => {
        const storedAuthor = localStorage.getItem("authorLogged");
        return storedAuthor ? JSON.parse(storedAuthor) : null;
    });
    const queryParams = new URLSearchParams(window.location.search);
    const [isDarkMode, setIsDarkMode] = useState(() => {
        return localStorage.getItem("theme") === "dark";
    });
    const [authors, setAuthors] = useState<Author[]>([]);
    const [authorId, setAuthorId] = useState(queryParams.get("id") || "");
    const [posts, setPosts] = useState<Post[]>([]);
    const [loading, setLoading] = useState(true);
    const [filter, setFilter] = useState(queryParams.get("fullname") || "");
    const [AuthorPage, setAuthorPage] = useState(1);
    const [PostPage, setPostPage] = useState(1);
    const [totalAuthors, setTotalAuthors] = useState(0);
    const [totalPosts, setTotalPosts] = useState(0);
    const [totalAuthorPages, setTotalAuthorPages] = useState(1);
    const [totalPostPages, setTotalPostPages] = useState(1);
    const [authorPerPage, setAuthorPerPage] = useState(3);
    const [postPerPage, setPostPerPage] = useState(3);
    const [orderAuthor, setOrderAuthor] = useState(
        queryParams.get("order") || "birthDate",
    );
    const [orderPost, setOrderPost] = useState(
        queryParams.get("order") || "publishDate",
    );

    const logAuthor = (author: Author) => {
        try{
            setLoading(true);
            apiService.login({ email: author.email, password: author.password }).then(loggedAuthor => {
                setAuthorLogged(loggedAuthor);
                localStorage.setItem("authorLogged", JSON.stringify(loggedAuthor));
            }).catch(error => {
                console.error("Error al iniciar sesión:", error);
            });
            loadAuthors();
        } catch (error) {
            console.error("Error al iniciar sesión:", error);
        } finally {
            setLoading(false);
        }
    };

    const logout = async () => {
        try {
            await apiService.logout();
            setAuthorLogged(null);
            localStorage.removeItem("authorLogged");
        } catch (error) {
            console.error("Error al cerrar sesión:", error);
        }
    };

    const loadAuthors = async (debouncedSearch?: string) => {
        try {
            setLoading(true);
            const currentFilter =
                debouncedSearch !== undefined ? debouncedSearch : filter;
            const authorsData = (await apiService.getAuthors(
                currentFilter,
                AuthorPage,
                authorPerPage,
                orderAuthor,
            )) as AuthorResponse;
            setAuthors(authorsData.data || []);
            setTotalAuthors(authorsData.meta?.total || 0);
            setTotalAuthorPages(authorsData.meta?.lastPage || 1);
        } catch (error) {
            console.error("Error al cargar autores:", error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        if (isDarkMode) {
            document.documentElement.classList.add("dark");
            localStorage.setItem("theme", "dark");
        } else {
            document.documentElement.classList.remove("dark");
            localStorage.setItem("theme", "light");
        }
    }, [isDarkMode]);

    const loadPosts = async (currentAuthorId?: string) => {
        const idToUse = currentAuthorId || authorId;
        if (!idToUse) {
            setPosts([]);
            setTotalPosts(0);
            setTotalPostPages(1);
            return;
        }
        try {
            setLoading(true);
            const response = (await apiService.getAuthorPosts(
                idToUse,
                PostPage,
                postPerPage,
                orderPost,
            )) as PostResponse;
            const postsArray = response.data
                ? response.data
                : ((Array.isArray(response) ? response : []) as Post[]);
            setPosts(postsArray);
            setTotalPosts(response.meta?.total || postsArray.length);
            setTotalPostPages(response.meta?.lastPage || 1);
        } catch (error) {
            console.error("Error al cargar posts:", error);
        } finally {
            setLoading(false);
        }
    };

    return (
        <DataContext.Provider
            value={{
                authorLogged,
                logAuthor,
                logout,
                isDarkMode,
                setIsDarkMode,
                authors,
                authorId,
                setAuthorId,
                totalAuthors,
                posts,
                setPosts,
                totalPosts,
                loading,
                AuthorPage,
                setAuthorPage,
                totalAuthorPages,
                PostPage,
                setPostPage,
                totalPostPages,
                filter,
                setFilter,
                authorPerPage,
                setAuthorPerPage,
                postPerPage,
                setPostPerPage,
                orderAuthor,
                setOrderAuthor,
                orderPost,
                setOrderPost,
                refreshAuthorData: loadAuthors,
                refreshPostData: loadPosts,
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
