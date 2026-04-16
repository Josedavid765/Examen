import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { TableCell, TableRow } from "@mui/material";
import DataTable from "../components/DataTable";
import { Button } from "@/components/ui/button";
import { apiService } from "../services/apiService";
import { Post } from "../models/Post";
import {
    Pagination,
    PaginationContent,
    PaginationEllipsis,
    PaginationItem,
    PaginationLink,
    PaginationNext,
    PaginationPrevious,
} from "@/components/ui/pagination";
import {
    Popover,
    PopoverTrigger,
    PopoverContent,
} from "@/components/ui/popover";
import { ChevronsLeft, ChevronsRight } from "lucide-react";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import { useData } from "../contexts/DataContext";

const AuthorPostsPage = () => {
    const navigate = useNavigate();
    const { id } = useParams();

    const {
        posts,
        authorId,
        setAuthorId,
        loading,
        PostPage,
        setPostPage,
        postPerPage,
        setPostPerPage,
        totalPostPages,
        totalPosts,
        refreshPostData,
        orderPost,
        setOrderPost,
    } = useData();

    const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
    const [postIdToDelete, setPostIdToDelete] = useState<string | null>(null);

    const handleOpenDeleteDialog = (postId: string | number) => {
        setPostIdToDelete(String(postId));
        setIsDeleteDialogOpen(true);
    };

    useEffect(() => {
        if (id) {
            if (id !== authorId) {
                setAuthorId(id);
            }
            refreshPostData(id);
        }
    }, [id, PostPage, postPerPage, orderPost]);

    const handleDelete = async (postId: string) => {
        try {
            await apiService.deletePost(postId);
            await refreshPostData();
        } catch (error) {
            console.error(error);
            alert("Hubo un error al eliminar el post");
        } finally {
            setIsDeleteDialogOpen(false);
            setPostIdToDelete(null);
        }
    };

    return (
        <>
            <div className="flex justify-between items-center mb-4">
                <h2 className="text-xl font-bold text-white"></h2>
                <Button
                    className="border-black/20 p-1.5"
                    variant="secondary"
                    onClick={() => navigate("/authors")}
                >
                    Volver a Autores
                </Button>
            </div>

            <DataTable
                loading={loading}
                title="Posts"
                headers={[
                    { id: "id", name: "ID", sortable: false },
                    { id: "title", name: "Título", sortable: false },
                    { id: "description", name: "Descripcion", sortable: false },
                    { id: "status", name: "Estado", sortable: false },
                    {
                        id: "numComments",
                        name: "Numero de Comentarios",
                        sortable: false,
                    },
                    { id: "publishDate", name: "Fecha Publicación" },
                    { id: "actions", name: "Acciones" },
                ]}
                rows={posts}
                order={orderPost}
                setOrder={(newOrder) => {
                    if (
                        setOrderPost &&
                        (newOrder.includes("publishDate") ||
                            newOrder.includes(""))
                    ) {
                        setOrderPost(newOrder);
                    }
                }}
                perPage={postPerPage}
                onAdd={() => navigate("/posts/new")}
                renderRow={(post: Post) => (
                    <TableRow key={post.id}>
                        <TableCell>{post.id}</TableCell>
                        <TableCell className="max-w-36 truncate">
                            {post.subject}
                        </TableCell>
                        <TableCell className="max-w-72 truncate">
                            {post.description}
                        </TableCell>
                        <TableCell>
                            {post.status === "PUBLISHED"
                                ? "Publicado"
                                : post.status === "DRAFT"
                                  ? "Borrador"
                                  : post.status === "CANCELLED"
                                    ? "Cancelado"
                                    : post.status}
                        </TableCell>
                        <TableCell>{post.numComments}</TableCell>
                        <TableCell>
                            {post.publishDate
                                ? new Date(
                                      post.publishDate,
                                  ).toLocaleDateString()
                                : "Borrador"}
                        </TableCell>
                        <TableCell className="flex justify-center align-middle space-x-1">
                            <Button
                                className={
                                    "border border-blue-600/20 px-2 bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-purple-900/20 dark:text-purple-300 dark:border-purple-300/20 dark:hover:bg-purple-950/20"
                                }
                                variant="secondary"
                                onClick={() =>
                                    navigate(`/posts/edit/${post.id}`)
                                }
                            >
                                Editar
                            </Button>
                            <Button
                                onClick={() => handleOpenDeleteDialog(post.id)}
                                className={
                                    "px-2 text-white dark:text-slate-300 bg-red-500 dark:bg-red-900"
                                }
                                variant="destructive"
                            >
                                Eliminar
                            </Button>
                        </TableCell>
                    </TableRow>
                )}
            />

            <div className="flex justify-between items-center mt-4 text-sm">
                <div className="flex items-center gap-2">
                    <Popover>
                        <PopoverTrigger className="flex h-9 w-9 items-center justify-center rounded-md hover:bg-accent transition-colors cursor-pointer">
                            <PaginationEllipsis /> 
                        </PopoverTrigger>
                        <PopoverContent
                            className="w-32 p-2 bg-gray-800/60"
                            align="start"
                            side="bottom"
                        >
                            <h6 className="mb-2 px-2 text-[10px] font-bold uppercase tracking-wider text-white">
                                Posts por página
                            </h6>
                            <div className="flex flex-col gap-1">
                                {[3, 5, 10].map((value) => (
                                    <Button
                                        key={value}
                                        variant={
                                            postPerPage === value
                                                ? "secondary"
                                                : "ghost"
                                        }
                                        className="h-7 justify-start px-2 text-xs"
                                        onClick={() => {
                                            setPostPerPage(value);
                                            setPostPage(1);
                                        }}
                                    >
                                        {value} posts
                                    </Button>
                                ))}
                            </div>
                        </PopoverContent>
                    </Popover>
                </div>

                <Pagination className="mx-0 w-auto">
                    <PaginationContent>
                        <PaginationItem>
                            <ChevronsLeft
                                className="cursor-pointer pr-2"
                                onClick={() => setPostPage(1)}
                            />
                        </PaginationItem>
                        <PaginationItem>
                            <PaginationPrevious
                                onClick={() => setPostPage(PostPage - 1)}
                                style={{
                                    display: PostPage === 1 ? "none" : "flex",
                                }}
                            />
                        </PaginationItem>
                        <PaginationLink
                            onClick={() => setPostPage(PostPage - 1)}
                            style={{
                                display: PostPage === 1 ? "none" : "flex",
                            }}
                        >
                            {PostPage - 1}
                        </PaginationLink>
                        <PaginationLink>{PostPage}</PaginationLink>
                        <PaginationLink
                            onClick={() => setPostPage(PostPage + 1)}
                            style={{
                                display:
                                    PostPage === totalPostPages
                                        ? "none"
                                        : "flex",
                            }}
                        >
                            {PostPage + 1}
                        </PaginationLink>
                        <PaginationItem>
                            <PaginationNext
                                onClick={() => setPostPage(PostPage + 1)}
                                style={{
                                    display:
                                        PostPage >= totalPostPages
                                            ? "none"
                                            : "flex",
                                }}
                            />
                        </PaginationItem>
                        <PaginationItem>
                            <ChevronsRight
                                className="cursor-pointer pl-2"
                                onClick={() => setPostPage(totalPostPages)}
                            />
                        </PaginationItem>
                    </PaginationContent>
                </Pagination>

                <div className="text-gray-400 min-w-37.5 text-right">
                    Posts totales: {totalPosts} | Página {PostPage} de{" "}
                    {totalPostPages}
                </div>
            </div>

            <Dialog
                open={isDeleteDialogOpen}
                onOpenChange={setIsDeleteDialogOpen}
            >
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>¿Estás completamente seguro?</DialogTitle>
                        <DialogDescription>
                            Esta acción no se puede deshacer. Esto eliminará
                            permanentemente el post.
                        </DialogDescription>
                    </DialogHeader>
                    <DialogFooter className="flex justify-end space-x-2 mt-4">
                        <Button
                            variant="secondary"
                            disabled={loading}
                            className="border-black dark:border-white"
                            onClick={() => {
                                setPostIdToDelete(null);
                                setIsDeleteDialogOpen(false);
                            }}
                        >
                            Cancelar
                        </Button>
                        <Button
                            variant="destructive"
                            disabled={loading}
                            className="bg-[#ff0000]" 
                            onClick={() => {
                                if (postIdToDelete)
                                    handleDelete(postIdToDelete);
                            }}
                        >
                            Sí, eliminar post
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </>
    );
};

export default AuthorPostsPage;
