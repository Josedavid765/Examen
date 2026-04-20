import { Comment } from "@/models/Comment";
import { apiService } from "@/services/apiService";
import { useEffect, useState } from "react";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "../components/ui/popover";
import { FaRegCommentDots } from "react-icons/fa";
import { Spinner } from "../components/ui/spinner";
import { useData } from "@/contexts/DataContext";
import { Status } from "@/models/Status";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
interface PostCommentsWidgetProps {
    postId: string;
    onCommentAdded?: () => void;
}

const PostCommentsWidget = ({ postId, onCommentAdded }: PostCommentsWidgetProps) => {
    const { authorLogged } = useData();
    const [comments, setComments] = useState<Comment[]>([]);
    const [isLoading, setIsLoading] = useState(false);
    const [hasLoaded, setHasLoaded] = useState(false);
    const [newCommentText, setNewCommentText] = useState("");
    const [isSubmitting, setIsSubmitting] = useState(false);

    const loadComments = async (force = false) => {
        // Evita recargar si ya se cargaron una vez
        if (hasLoaded && !force) return;

        setIsLoading(true);
        try {
            const response = (await apiService.getCommentsByPost(
                postId,
            )) as Comment[];

            setComments(response);
            setHasLoaded(true);
        } catch (error) {
            console.error("Error al cargar comentarios:", error);
        } finally {
            setIsLoading(false);
        }
    };

    useEffect(() => {
        setHasLoaded(false); //Resetear si cambia el post
        loadComments();
    }, [postId]);

    const handleAddComment = async (e: React.FormEvent) => {
        e.preventDefault();
        if (!newCommentText.trim() || !authorLogged) return;

        setIsSubmitting(true);
        try {
            const newCommentData = {
                description: newCommentText,
                authorId: authorLogged.id,
                status: Status.PUBLISHED,
                postId: postId,
                commentDate: new Date().toISOString().split("T")[0],
            };

            const createdComment = await apiService.createComment(newCommentData);

            // Optimistically update the UI
            setComments(prevComments => [...prevComments, {
                ...createdComment,
                description: newCommentText,
                authorFullName: authorLogged.fullName,
            } as Comment]);

            setNewCommentText("");

            if (onCommentAdded) {
                onCommentAdded();
            }
        } catch (error) {
            console.error("Error al crear el comentario:", error);
        } finally {
            setIsSubmitting(false);
        }
    };

    return (
        <Popover onOpenChange={(isOpen) => isOpen && loadComments()}>
            <div className="flex items-center justify-center w-7 h-7 cursor-pointer bg-slate-300/40 rounded hover:border hover:border-gray-300 transition">
                <PopoverTrigger>
                    <FaRegCommentDots />
                </PopoverTrigger>
            </div>
            <PopoverContent
                className="w-80 p-4 max-h-64 overflow-y-auto bg-slate-200 dark:bg-slate-800"
                side="top"
                align="end"
                sideOffset={8}
            >
                {isLoading ? (
                    <div className="flex justify-center py-4">
                        <Spinner />
                    </div>
                ) : comments.length > 0 ? (
                    <div className="flex flex-col gap-3">
                        {comments.map((comment, i) => (
                            <div
                                key={comment.id || i}
                                className="border-b border-gray-200 pb-2 last:border-0 text-sm"
                            >
                                <span className="font-bold text-gray-800 dark:text-slate-400 text-xs">
                                    {comment.authorFullName || "Anónimo"}:
                                </span>
                                <p className="text-gray-600 dark:text-gray-200 mt-1">
                                    {comment.description}
                                </p>
                            </div>
                        ))}
                    </div>
                ) : (
                    <p className="text-sm text-muted-foreground text-center">
                        No hay comentarios aún.
                    </p>
                )}

                {authorLogged && (
                    <form onSubmit={handleAddComment} className="mt-4 pt-3 border-t border-gray-200 flex gap-2">
                        <Input
                            placeholder="Escribe un comentario..."
                            value={newCommentText}
                            onChange={(e) => setNewCommentText(e.target.value)}
                            disabled={isSubmitting}
                            className="text-sm h-8"
                        />
                        <Button
                            type="submit"
                            disabled={!newCommentText.trim() || isSubmitting}
                            size="sm"
                            className="h-8 border-black dark:border-white"
                        >
                            {isSubmitting ? "..." : "Enviar"}
                        </Button>
                    </form>
                )}
            </PopoverContent>
        </Popover>
    );
};

export default PostCommentsWidget;
