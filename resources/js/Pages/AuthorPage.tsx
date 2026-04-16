import { useEffect, useState } from "react";
import { TableCell, TableRow } from "@mui/material";
import DataTable from "../components/DataTable";
import { Author } from "../models/Author";
import { useData } from "../contexts/DataContext";
import { Button } from "@/components/ui/button";
import { useNavigate } from "react-router-dom";
import { apiService } from "../services/apiService";
import { Input } from "@/components/ui/input";
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

const AuthorPage = () => {
    const navigate = useNavigate();
    const {
        refreshAuthorData,
        totalAuthorPages,
        totalAuthors,
        AuthorPage,
        authorPerPage,
        setAuthorPage,
        setAuthorPerPage,
        filter,
        setFilter,
        orderAuthor,
        setOrderAuthor,
        authors,
        loading,
    } = useData();

    const [isDeleteDialogOpen, setIsDeleteDialogOpen] = useState(false);
    const [authorIdToDelete, setAuthorIdToDelete] = useState<string | null>(
        null,
    );
    const [debouncedFilter, setDebouncedFilter] = useState(filter);

    useEffect(() => {
        const timer = setTimeout(() => {
            if (filter !== debouncedFilter) {
                setDebouncedFilter(filter);
                setAuthorPage(1); // Reiniciar a la primera página al cambiar el filtro
            }
        }, 700);
        return () => clearTimeout(timer);
    }, [filter, debouncedFilter, setAuthorPage]);

    useEffect(() => {
        refreshAuthorData(debouncedFilter);
    }, [AuthorPage, authorPerPage, orderAuthor, debouncedFilter]);

    const handleOpenDeleteDialog = (id: string) => {
        setAuthorIdToDelete(id);
        setIsDeleteDialogOpen(true);
    };

    const handleDelete = async (id: string) => {
        try {
            await apiService.deleteAuthor(String(id));
            await refreshAuthorData();
            setAuthorPage(1);
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
            <Input
                className={
                    "border border-gray-600/20 dark:border-gray-300/20 dark:text-white "
                }
                placeholder="Buscar..."
                onChange={(e) => setFilter(e.target.value)}
                value={filter}
            />

            <DataTable
                loading={loading}
                title={"Autores"}
                headers={[
                    { id: "id", name: "ID" },
                    { id: "firstName", name: "Nombre" },
                    { id: "lastName", name: "Apellido" },
                    { id: "fullName", name: "Nombre Completo" },
                    { id: "birthDate", name: "Fecha Nacimiento" },
                    { id: "actions", name: "Acciones" },
                ]}
                rows={authors}
                order={orderAuthor}
                setOrder={setOrderAuthor}
                perPage={authorPerPage}
                onAdd={() => navigate("/authors/new")}
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
                            {/* NUEVO BOTÓN PARA VER LOS POSTS */}
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

            <div className="flex justify-between items-center mt-4 text-sm">
                <div className="flex items-center gap-2">
                    <Popover>
                        <PopoverTrigger className="flex h-4 w-auto items-center justify-center rounded-md hover:bg-accent transition-colors cursor-pointer">
                            <PaginationEllipsis />
                            Mostrando {authorPerPage} autores por página
                        </PopoverTrigger>
                        <PopoverContent
                            className="w-32 p-2 bg-gray-300/60 dark:bg-gray-400/60"
                            align="start"
                            side="bottom"
                        >
                            <h6 className="mb-2 px-2 text-[10px]  font-bold uppercase tracking-wider text-white">
                                Autores por página
                            </h6>
                            <div className="flex flex-col gap-1">
                                {[3, 5, 10].map((value) => (
                                    <Button
                                        key={value}
                                        variant={
                                            authorPerPage === value
                                                ? "secondary"
                                                : "ghost"
                                        }
                                        className="h-7 justify-start px-2 text-xs"
                                        onClick={() => {
                                            setAuthorPerPage(value);
                                            setAuthorPage(1);
                                        }}
                                    >
                                        {value} posts
                                    </Button>
                                ))}
                            </div>
                        </PopoverContent>
                    </Popover>
                </div>

                <Pagination className="mx-0 w-auto dark:text-slate-400">
                    <PaginationContent>
                        <PaginationItem>
                            <ChevronsLeft
                                className="cursor-pointer pr-2"
                                onClick={() => setAuthorPage(1)}
                            />
                        </PaginationItem>
                        <PaginationItem>
                            <PaginationPrevious
                                onClick={() => setAuthorPage(AuthorPage - 1)}
                                style={{
                                    display: AuthorPage === 1 ? "none" : "flex",
                                }}
                            />
                        </PaginationItem>
                        <PaginationLink
                            onClick={() => setAuthorPage(AuthorPage - 1)}
                            style={{
                                display: AuthorPage === 1 ? "none" : "flex",
                            }}
                        >
                            {AuthorPage - 1}
                        </PaginationLink>
                        <PaginationLink >{AuthorPage}</PaginationLink>
                        <PaginationLink
                            onClick={() => setAuthorPage(AuthorPage + 1)}
                            style={{
                                display:
                                    AuthorPage === totalAuthorPages
                                        ? "none"
                                        : "flex",
                            }}
                        >
                            {AuthorPage + 1}
                        </PaginationLink>
                        <PaginationItem>
                            <PaginationNext
                                onClick={() => setAuthorPage(AuthorPage + 1)}
                                style={{
                                    display:
                                        AuthorPage >= totalAuthorPages
                                            ? "none"
                                            : "flex",
                                }}
                            />
                        </PaginationItem>
                        <PaginationItem>
                            <ChevronsRight
                                className="cursor-pointer pl-2"
                                onClick={() => setAuthorPage(totalAuthorPages)}
                            />
                        </PaginationItem>
                    </PaginationContent>
                </Pagination>

                <div className="text-gray-400 min-w-37.5 text-right">
                    Autores totales: {totalAuthors} | Página {AuthorPage} de{" "}
                    {totalAuthorPages}
                </div>
            </div>

            {/* PEGAMOS EL NUEVO MODAL AQUÍ */}
            <Dialog
                open={isDeleteDialogOpen}
                onOpenChange={setIsDeleteDialogOpen}
            >
                <DialogContent>
                    <DialogHeader>
                        <DialogTitle>¿Estás completamente seguro?</DialogTitle>
                        <DialogDescription>
                            Esta acción no se puede deshacer. Esto eliminará
                            permanentemente al autor y todos los posts o
                            comentarios asociados.
                        </DialogDescription>
                    </DialogHeader>
                    <DialogFooter className="flex justify-end space-x-2 mt-4">
                        <Button
                            variant="secondary"
                            className="px-2 border-black dark:border-white"
                            onClick={() => {
                                setAuthorIdToDelete(null);
                                setIsDeleteDialogOpen(false); // ESTO CIERRA LA VENTANA
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

export default AuthorPage;
