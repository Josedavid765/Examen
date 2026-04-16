// IMPORTANTE: Asegúrate de importar tu modelo real de Comment
import { Comment } from "@/models/Comment";
import { apiService } from "@/services/apiService";
import { useState } from "react";
import {
    Popover,
    PopoverContent,
    PopoverTrigger,
} from "../components/ui/popover";
import { FaRegCommentDots } from "react-icons/fa";
import { Spinner } from "../components/ui/spinner";

const PostCommentsWidget = ({ postId }: { postId: string }) => {
    const [comments, setComments] = useState<Comment[]>([]);
    const [isLoading, setIsLoading] = useState(false);
    const [hasLoaded, setHasLoaded] = useState(false);

    const loadComments = async () => {
        // Evita recargar si ya se cargaron una vez
        if (hasLoaded) return;

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

    return (
        <Popover onOpenChange={(isOpen) => isOpen && loadComments()}>
            <div className="cursor-pointer bg-slate-300/40 rounded px-1 hover:border hover:border-gray-300 transition">
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
                                <span className="font-bold text-gray-800 text-xs">
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
            </PopoverContent>
        </Popover>
    );
};

export default PostCommentsWidget;
