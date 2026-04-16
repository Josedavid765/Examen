import { useState, useRef, useEffect } from "react";
import { Post } from "@/models/Post";
import { apiService } from "@/services/apiService";
import {
    Card,
    CardHeader,
    CardTitle,
    CardDescription,
    CardContent,
    CardFooter,
} from "@/components/ui/card";
import { Spinner } from "@/components/ui/spinner";
import PostCommentsWidget from "./PostCommentsWidget";

const PostPage = () => {
    const [posts, setPosts] = useState<Post[]>([]);
    const [page, setPage] = useState(1);
    const [hasMore, setHasMore] = useState(true);
    const [loading, setLoading] = useState(false);

    const observerTarget = useRef<HTMLDivElement>(null);

    type PostResponse = {
        data: Post[];
        meta: {
            currentPage: number;
            lastPage: number;
            total: number;
        };
    };

    const fetchPosts = async (pageNum: number) => {
        setLoading(true);
        try {
            const response = await apiService.getPosts(pageNum, 12);

            const newPosts = response.data
                ? (response.data as unknown as Post[])
                : (response as unknown as Post[]);
            const meta = (response as PostResponse).meta || {};

            setPosts((prev) =>
                pageNum === 1 ? newPosts : [...prev, ...newPosts],
            );

            if (meta.currentPage >= meta.lastPage || newPosts.length === 0) {
                setHasMore(false);
            }
        } catch (error) {
            console.error("Error cargando posts:", error);
        } finally {
            setLoading(false);
        }
    };

    useEffect(() => {
        fetchPosts(page);
    }, [page]);

    useEffect(() => {
        const observer = new IntersectionObserver(
            (entries) => {
                if (entries[0].isIntersecting && hasMore && !loading) {
                    setPage((prevPage) => prevPage + 1);
                }
            },
            { threshold: 1.0 },
        );

        const currentTarget = observerTarget.current;
        if (currentTarget) {
            observer.observe(currentTarget);
        }

        return () => {
            if (currentTarget) {
                observer.unobserve(currentTarget);
            }
        };
    }, [hasMore, loading]);

    return (
        <div className="relative max-w-7xl mx-auto py-8 px-4 gap-2">
            <h1 className="absolute mx-10 top-0 left-1/2 transform -translate-x-3/4 text-3xl font-bold mb-10 dark:text-slate-400">
                Posts
            </h1>

            {/* Grid responsivo: 1 columna en móvil, 2 en tablets, 3 en desktop, 4 en pantallas anchas */}
            <div className="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 gap-6 mt-5">
                {posts.map((post, index) => (
                    <Card
                        key={`${post.id}-${index}`}
                        className="flex flex-col h-full bg-white text-black shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition dark:bg-gray-700 dark:text-slate-300"
                    >
                        <CardHeader className="pb-2">
                            <CardTitle
                                className="text-lg line-clamp-1"
                                title={post.subject}
                            >
                                {post.subject}
                            </CardTitle>
                            <CardDescription className="text-sm text-gray-500/60 dark:text-gray-400/60">
                                Autor:{" "}
                                {(post as Post).authorName ||
                                    `#${post.authorName}`}
                                <br />
                                Fecha:{" "}
                                {post.publishDate
                                    ? new Date(
                                          post.publishDate,
                                      ).toLocaleDateString()
                                    : "Borrador"}
                            </CardDescription>
                        </CardHeader>

                        <CardContent className="flex-1 pt-2 pb-4 px-6 text-sm text-gray-700">
                            {/* line-clamp-3 limita la descripción a 3 líneas con puntos suspensivos */}
                            <p className="line-clamp-3 dark:text-gray-200">{post.description}</p>
                        </CardContent>

                        <CardFooter className="flex justify-between items-center border-t border-gray-100 pt-4">
                            <span className="text-xs font-medium text-gray-500 bg-gray-100 px-2 py-1 rounded-full dark:bg-gray-600 dark:text-gray-300">
                                {post.numComments} comentarios
                            </span>
                            <PostCommentsWidget postId={post.id} />
                        </CardFooter>
                    </Card>
                ))}
            </div>

            {/* Indicador de carga visual mientras el observer hace la petición */}
            {loading && (
                <div className="flex justify-center py-6">
                    <div className="text-white">
                        <Spinner />
                    </div>
                </div>
            )}

            {/* Ancla invisible para el Infinite Scroll */}
            <div ref={observerTarget} className="h-4 w-full mt-4" />

            {/* Mensaje de fin de contenido */}
            {!hasMore && !loading && posts.length > 0 && (
                <div className="text-center py-8 text-gray-400 text-sm">
                    Has llegado al final de la lista.
                </div>
            )}
        </div>
    );
};

export default PostPage;
