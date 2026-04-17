import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { Post } from "@/models/Post";
import { Comment } from "@/models/Comment";
import { apiService } from "@/services/apiService";
import { useData } from "@/contexts/DataContext";
import { Status } from "@/models/Status";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Card, CardHeader, CardTitle, CardDescription, CardContent } from "@/components/ui/card";
import { Spinner } from "@/components/ui/spinner";
import { Separator } from "@/components/ui/separator";

const PostDetailPage = () => {
    const { id } = useParams<{ id: string }>();
    const navigate = useNavigate();
    const { authorLogged } = useData();

    const [post, setPost] = useState<Post | null>(null);
    const [comments, setComments] = useState<Comment[]>([]);
    const [loading, setLoading] = useState(true);

    const [newCommentText, setNewCommentText] = useState("");
    const [isSubmitting, setIsSubmitting] = useState(false);

    useEffect(() => {
        if (!id) return;

        const loadPostData = async () => {
            setLoading(true);
            try {
                const postData = await apiService.getPost(id);
                setPost(postData);

                const commentsData = await apiService.getCommentsByPost(id);
                // Sort comments from newest to oldest
                const sortedComments = (commentsData as Comment[]).sort((a, b) => {
                    return new Date(b.commentDate).getTime() - new Date(a.commentDate).getTime();
                });
                setComments(sortedComments);
            } catch (error) {
                console.error("Error al cargar el post o sus comentarios:", error);
            } finally {
                setLoading(false);
            }
        };

        loadPostData();
    }, [id]);

    const handleAddComment = async (e: React.FormEvent) => {
        e.preventDefault();
        if (!newCommentText.trim() || !authorLogged || !id) return;

        setIsSubmitting(true);
        try {
            const newCommentData = {
                description: newCommentText,
                authorId: authorLogged.id,
                status: Status.PUBLISHED,
                postId: id,
                commentDate: new Date().toISOString().split("T")[0],
            };

            const createdComment = await apiService.createComment(newCommentData);

            // Fetch comments again to get the latest sorted list including the newly created one
            const commentsData = await apiService.getCommentsByPost(id);
            const sortedComments = (commentsData as Comment[]).sort((a, b) => {
                return new Date(b.commentDate).getTime() - new Date(a.commentDate).getTime();
            });
            setComments(sortedComments);

            setNewCommentText("");
        } catch (error) {
            console.error("Error al crear el comentario:", error);
        } finally {
            setIsSubmitting(false);
        }
    };

    if (loading) {
        return (
            <div className="flex justify-center items-center h-64">
                <Spinner />
            </div>
        );
    }

    if (!post) {
        return (
            <div className="text-center py-10">
                <h1 className="text-2xl font-bold">Post no encontrado</h1>
                <Button variant="link" onClick={() => navigate("/posts")}>
                    Volver a Posts
                </Button>
            </div>
        );
    }

    return (
        <div className="max-w-4xl mx-auto py-8 px-4 gap-6 flex flex-col">
            <Button variant="outline" className="w-fit" onClick={() => navigate(-1)}>
                Volver
            </Button>

            <Card className="shadow-lg dark:bg-gray-800 border-none">
                <CardHeader>
                    <CardTitle className="text-4xl font-extrabold mb-2 dark:text-slate-100">
                        {post.subject}
                    </CardTitle>
                    <CardDescription className="text-lg text-gray-500 dark:text-gray-400">
                        Por <span className="font-semibold text-gray-700 dark:text-gray-300">{(post as Post).authorName || "Desconocido"}</span>
                        {" • "}
                        {post.publishDate ? new Date(post.publishDate).toLocaleDateString() : "Borrador"}
                    </CardDescription>
                </CardHeader>
                <CardContent>
                    <p className="text-gray-800 dark:text-gray-200 text-lg leading-relaxed whitespace-pre-wrap">
                        {post.description}
                    </p>
                </CardContent>
            </Card>

            <div className="mt-8">
                <h2 className="text-2xl font-bold mb-6 dark:text-slate-200">
                    Comentarios ({comments.length})
                </h2>

                <div className="flex flex-col gap-4 mb-8">
                    {comments.length > 0 ? (
                        comments.map((comment, i) => (
                            <Card key={comment.id || i} className="bg-gray-50 dark:bg-gray-900 border-gray-200 dark:border-gray-700">
                                <CardContent className="p-4">
                                    <div className="flex justify-between items-center mb-2">
                                        <span className="font-bold text-gray-800 dark:text-slate-300">
                                            {comment.authorFullName || "Anónimo"}
                                        </span>
                                        <span className="text-xs text-gray-500 dark:text-gray-400">
                                            {new Date(comment.commentDate).toLocaleDateString()}
                                        </span>
                                    </div>
                                    <p className="text-gray-700 dark:text-gray-300">
                                        {comment.description}
                                    </p>
                                </CardContent>
                            </Card>
                        ))
                    ) : (
                        <p className="text-gray-500 dark:text-gray-400 italic">No hay comentarios aún. ¡Sé el primero en comentar!</p>
                    )}
                </div>

                {authorLogged ? (
                    <div className="mt-6 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                        <h3 className="text-lg font-semibold mb-4 dark:text-slate-200">Deja un comentario</h3>
                        <form onSubmit={handleAddComment} className="flex flex-col gap-3">
                            <Input
                                placeholder="Escribe tu comentario aquí..."
                                value={newCommentText}
                                onChange={(e) => setNewCommentText(e.target.value)}
                                disabled={isSubmitting}
                                className="w-full"
                            />
                            <div className="flex justify-end">
                                <Button
                                    type="submit"
                                    disabled={!newCommentText.trim() || isSubmitting}
                                    className="border-black dark:border-white px-8"
                                >
                                    {isSubmitting ? "Enviando..." : "Enviar"}
                                </Button>
                            </div>
                        </form>
                    </div>
                ) : (
                    <div className="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 text-blue-800 dark:text-blue-300 rounded-lg text-center">
                        Para dejar un comentario, por favor <Button variant="link" className="p-0 h-auto font-bold text-blue-600 dark:text-blue-400" onClick={() => navigate("/login")}>inicia sesión</Button>.
                    </div>
                )}
            </div>
        </div>
    );
};

export default PostDetailPage;
