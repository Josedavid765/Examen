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

const PostPage = () => {
    const navigate = useNavigate();
    const { id } = useParams();

    const {
        posts,
        authorId,
        setAuthorId,
        loading,
        page,
        setPage,
        perPage,
        setPerPage,
        totalPages,
        totalPosts,
        refreshData,
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
        if (id && id !== authorId) {
            setAuthorId(id);
        }
    }, [id]);

    const handleDelete = async (postId: string) => {
        try {
            await apiService.deletePost(postId);
            await refreshData();
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
            {}
            <div className="flex justify-between items-center mb-4">
                <h2 className="text-xl font-bold text-white">
                    Posts del Autor #{authorId}
                </h2>
                <Button
                    variant="secondary"
                    onClick={() => navigate("/authors")}
                >
                    Volver a Autores
                </Button>
            </div>

            <DataTable
                loading={loading}
                title={`Posts: ${totalPosts} - Por página: ${perPage} - Página: ${page} - Totales: ${totalPages}`}
                headers={[
                    { id: "id", name: "ID" },
                    { id: "title", name: "Título" },
                    { id: "description", name: "Descripcion" },
                    { id: "status", name: "Estado" },
                    {
                        id: "numComments",
                        name: "Numero de Comentarios",
                    },
                    { id: "publishDate", name: "Fecha Publicación" },
                    { id: "actions", name: "Acciones" },
                ]}
                rows={posts}
                order={orderPost}
                setOrder={(newOrder) => {
                    if (setOrderPost && newOrder.includes("publishDate")) {
                        setOrderPost(newOrder);
                    }
                }}
                perPage={perPage}
                onAdd={() => navigate("/posts/new")}
                renderRow={(post: Post) => (
                    <TableRow key={post.id}>
                        <TableCell>{post.id}</TableCell>
                        <TableCell>{post.subject}</TableCell>
                        <TableCell>{post.description}</TableCell>
                        <TableCell>{post.status}</TableCell>
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
                                className={"border border-black/20 px-2"}
                                variant="secondary"
                                onClick={() =>
                                    navigate(`/posts/edit/${post.id}`)
                                }
                            >
                                Editar
                            </Button>
                            <Button
                                onClick={() => handleOpenDeleteDialog(post.id)}
                                className={"px-2"}
                                variant="destructive"
                            >
                                Eliminar
                            </Button>
                        </TableCell>
                    </TableRow>
                )}
            />

            {}
            <Pagination>
                <PaginationContent>
                    <PaginationItem>
                        <ChevronsLeft
                            className="cursor-pointer pr-2"
                            onClick={() => setPage(1)}
                        />
                    </PaginationItem>
                    <PaginationItem>
                        <PaginationPrevious
                            onClick={() => setPage(page - 1)}
                            style={{ display: page === 1 ? "none" : "flex" }}
                        />
                    </PaginationItem>
                    <PaginationLink
                        onClick={() => setPage(page - 1)}
                        style={{ display: page === 1 ? "none" : "flex" }}
                    >
                        {page - 1}
                    </PaginationLink>
                    <PaginationLink>{page}</PaginationLink>
                    <PaginationLink
                        onClick={() => setPage(page + 1)}
                        style={{
                            display: page === totalPages ? "none" : "flex",
                        }}
                    >
                        {page + 1}
                    </PaginationLink>
                    <PaginationItem>
                        <PaginationNext
                            onClick={() => setPage(page + 1)}
                            style={{
                                display: page >= totalPages ? "none" : "flex",
                            }}
                        />
                    </PaginationItem>
                    <PaginationItem>
                        <ChevronsRight
                            className="cursor-pointer pl-2"
                            onClick={() => setPage(totalPages)}
                        />
                    </PaginationItem>
                    <PaginationItem>
                        <Popover>
                            <PopoverTrigger className="flex h-9 w-9 items-center justify-center rounded-md hover:bg-accent transition-colors cursor-pointer">
                                <PaginationEllipsis />
                            </PopoverTrigger>
                            <PopoverContent
                                className="w-32 p-2 bg-gray-800/60"
                                align="end"
                                side="top"
                            >
                                <h6 className="mb-2 px-2 text-[10px] font-bold uppercase tracking-wider text-white">
                                    Posts por página
                                </h6>
                                <div className="flex flex-col gap-1">
                                    {[3, 5, 10].map((value) => (
                                        <Button
                                            key={value}
                                            variant={
                                                perPage === value
                                                    ? "secondary"
                                                    : "ghost"
                                            }
                                            className="h-7 justify-start px-2 text-xs"
                                            onClick={() => {
                                                setPerPage(value);
                                                setPage(1);
                                            }}
                                        >
                                            {value} posts
                                        </Button>
                                    ))}
                                </div>
                            </PopoverContent>
                        </Popover>
                    </PaginationItem>
                </PaginationContent>
            </Pagination>

            {}
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
                            onClick={() => {
                                setPostIdToDelete(null);
                                setIsDeleteDialogOpen(false);
                            }}
                        >
                            Cancelar
                        </Button>
                        <Button
                            variant="destructive"
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

export default PostPage;
