import { useEffect, useState } from "react";
import { TableCell, TableRow } from "@mui/material";
import DataTable from "../components/DataTable";
import { Author } from "../models/Author";
import { useData } from "../contexts/DataContext";
import { Button } from "@/components/ui/button";
import { useNavigate } from "react-router-dom";
import { apiService } from "../services/apiService";
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
} from "@/components/ui/dialog";
import { Comment } from "@/models/Comment";

const LoggedAuthorPage = () => {
    const navigate = useNavigate();
    const { authorLogged, logout } = useData();
    const [authorData, setAuthorData] = useState<Author | null>(null);
    const [authorComments, setAuthorComments] = useState<Comment[] | []>([]);
    const [loading, setLoading] = useState(true);
    const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
    const [authorIdToDelete, setAuthorIdToDelete] = useState<string | null>(
        null,
    );
    const [order, setOrder] = useState<string | undefined>(undefined);

    useEffect(() => {
        if (!authorLogged) {
            navigate("/login");
            return;
        }

        const fetchAuthor = async () => {
            try {
                setLoading(true);
                const data = await apiService.getAuthor(authorLogged.id!);
                setAuthorData(data);
            } catch (error) {
                console.error("Error al obtener el autor logueado", error);
            } finally {
                setLoading(false);
            }
        };

        fetchAuthor();
    }, [authorLogged, navigate]);

    useEffect(() => {
        if (!authorLogged) return;
        const fetchAuthorComments = async () => {
            try {
                setLoading(true);
                const response = (await apiService.getCommentsByAuthor(
                    authorLogged.id!,
                    order,
                )) as unknown as { data: Comment[] };
                setAuthorComments(response.data);
            } catch (error) {
                console.error(
                    "Error al obtener los comentarios del autor logueado",
                    error,
                );
            } finally {
                setLoading(false);
            }
        };
        fetchAuthorComments();
    }, [authorLogged, order]);

    const handleOpenDeleteDialog = (id: string) => {
        setAuthorIdToDelete(id);
        setIsDeleteDialogOpen(true);
    };

    const handleDelete = async (id: string) => {
        try {
            await apiService.deleteAuthor(String(id));
            logout(); // Cerramos sesión al eliminar
            navigate("/login");
        } catch (error) {
            console.log(error);
            alert("Hubo un error al eliminar el autor");
        } finally {
            setIsDeleteDialogOpen(false);
            setAuthorIdToDelete(null);
        }
    };

    return (
        <>
            <DataTable
                title="Mi Perfil"
                loading={loading}
                headers={[
                    { id: "id", name: "ID" },
                    { id: "firstName", name: "Nombre" },
                    { id: "lastName", name: "Apellido" },
                    { id: "fullName", name: "Nombre Completo" },
                    { id: "birthDate", name: "Fecha Nacimiento" },
                    { id: "actions", name: "Acciones" },
                ]}
                rows={authorData ? [authorData] : []}
                perPage={1}
                onAdd={undefined} // Quitar botón de añadir si no tiene sentido
                renderRow={(author: Author) => (
                    <TableRow key={author.id}>
                        <TableCell>{author.id}</TableCell>
                        <TableCell>{author.firstName}</TableCell>
                        <TableCell>{author.lastName}</TableCell>
                        <TableCell>{author.fullName}</TableCell>
                        <TableCell>
                            {`${new Date(author.birthDate).getDate()}/${new Date(author.birthDate).getMonth() + 1}/${new Date(author.birthDate).getFullYear()}`}
                        </TableCell>
                        <TableCell className="flex justify-center align-middle space-x-1">
                            {/* BOTÓN PARA VER LOS POSTS */}
                            <Button
                                className={
                                    "border border-blue-600/20 px-2 bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-purple-900/20 dark:text-purple-300 dark:border-purple-300/20 dark:hover:bg-purple-950/20"
                                }
                                variant="secondary"
                                onClick={() =>
                                    navigate(`/authors/${author.id}/posts`)
                                }
                            >
                                Mostrar Posts
                            </Button>

                            <Button
                                className={
                                    "border border-blue-600/20 px-2 bg-blue-100 text-blue-700 hover:bg-blue-200 dark:bg-purple-900/20 dark:text-purple-300 dark:border-purple-300/20 dark:hover:bg-purple-950/20"
                                }
                                variant="secondary"
                                onClick={() =>
                                    navigate(`/authors/edit/${author.id}`)
                                }
                            >
                                Editar
                            </Button>
                            <Button
                                onClick={() =>
                                    handleOpenDeleteDialog(author.id)
                                }
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

            <DataTable
                title="Mis Comentarios"
                loading={loading}
                headers={[
                    { id: "id", name: "ID", sortable: false },
                    { id: "description", name: "Descripción", sortable: false },
                    { id: "status", name: "Estado", sortable: false },
                    {id: "postId", name: "ID del Post", sortable: false},
                    {
                        id: "commentDate",
                        name: "Fecha de publicación",
                        sortable: true,
                    },
                ]}
                rows={authorComments || []}
                perPage={authorComments?.length || 10}
                order={order}
                setOrder={setOrder}
                onAdd={undefined} // Quitar botón de añadir si no tiene sentido
                renderRow={(comment: Comment) => (
                    <TableRow key={comment.id}>
                        <TableCell>{comment.id}</TableCell>
                        <TableCell>{comment.description}</TableCell>
                        <TableCell>{comment.status}</TableCell>
                        <TableCell>{comment.postId}</TableCell>
                        <TableCell>
                            {comment.commentDate
                                ? `${new Date(comment.commentDate).getDate()}/${new Date(comment.commentDate).getMonth() + 1}/${new Date(comment.commentDate).getFullYear()}`
                                : "N/A"}
                        </TableCell>
                    </TableRow>
                )}
            />

            <Dialog
                open={isDeleteDialogOpen}
                onOpenChange={setIsDeleteDialogOpen}
            >
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>¿Estás completamente seguro?</DialogTitle>
                        <DialogDescription>
                            Esta acción no se puede deshacer. Esto eliminará
                            permanentemente tu cuenta y todos los posts o
                            comentarios asociados.
                        </DialogDescription>
                    </DialogHeader>
                    <DialogFooter className="flex justify-end space-x-2 mt-4">
                        <Button
                            variant="secondary"
                            className="px-2 border-black dark:border-white"
                            onClick={() => {
                                setAuthorIdToDelete(null);
                                setIsDeleteDialogOpen(false);
                            }}
                        >
                            Cancelar
                        </Button>
                        <Button
                            variant="destructive"
                            className="px-2 bg-red-500"
                            onClick={() => {
                                if (authorIdToDelete) {
                                    handleDelete(authorIdToDelete);
                                }
                            }}
                        >
                            Sí, eliminar autor
                        </Button>
                    </DialogFooter>
                </DialogContent>
            </Dialog>
        </>
    );
};

export default LoggedAuthorPage;
