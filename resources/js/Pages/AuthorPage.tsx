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

    console.log(authors);

    useEffect(() => {
        refreshAuthorData();
    }, [AuthorPage, authorPerPage, orderAuthor]);

    useEffect(() => {
        const timerId = setTimeout(() => {
            setAuthorPage(1);
            refreshAuthorData();
        }, 700);
        return () => clearTimeout(timerId);
    }, [filter]);

    const handleOpenDeleteDialog = (id: string) => {
        setAuthorIdToDelete(id);
        setIsDeleteDialogOpen(true);
    };

    const handleDelete = async (id: string) => {
        try {
            await apiService.deleteAuthor(String(id));
            await refreshAuthorData();
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
                className={"border border-gray-600/20"}
                placeholder="Buscar..."
                onChange={(e) => setFilter(e.target.value)}
                value={filter}
            />

            <DataTable
                loading={loading}
                title={
                    "Autores: " +
                    totalAuthors +
                    " - Autores por página: " +
                    authorPerPage +
                    " - Página: " +
                    AuthorPage +
                    " - Paginas totales: " +
                    totalAuthorPages
                }
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
                        <TableCell className="max-w-52">{author.id}</TableCell>
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
                                    "border border-blue-600/20 px-2 bg-blue-100 text-blue-700 hover:bg-blue-200"
                                }
                                variant="secondary"
                                onClick={() =>
                                    navigate(`/authors/${author.id}/posts`)
                                }
                            >
                                Mostrar Posts
                            </Button>

                            <Button
                                className={"border border-black/20 px-2"}
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
                                className={"px-2"}
                                variant="destructive"
                            >
                                Eliminar
                            </Button>
                        </TableCell>
                    </TableRow>
                )}
            />
            <Pagination>
                <PaginationContent>
                    <PaginationItem>
                        <ChevronsLeft
                            className="cursor-pointer pr-2"
                            onClick={() => setAuthorPage(1)}
                        ></ChevronsLeft>
                    </PaginationItem>
                    <PaginationItem>
                        <PaginationPrevious
                            onClick={() => setAuthorPage(AuthorPage - 1)}
                            style={{
                                display: AuthorPage == 1 ? "none" : "flex",
                            }}
                        />
                    </PaginationItem>
                    <PaginationLink
                        onClick={() => setAuthorPage(AuthorPage - 1)}
                        style={{ display: AuthorPage == 1 ? "none" : "flex" }}
                    >
                        {AuthorPage - 1}
                    </PaginationLink>
                    <PaginationLink>{AuthorPage}</PaginationLink>
                    <PaginationLink
                        onClick={() => setAuthorPage(AuthorPage + 1)}
                        style={{
                            display:
                                AuthorPage == totalAuthorPages
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
                        ></ChevronsRight>
                    </PaginationItem>
                    <PaginationItem>
                        <Popover>
                            <PopoverTrigger
                                className={
                                    "flex h-9 w-9 items-center justify-center rounded-md hover:bg-accent transition-colors cursor-pointer"
                                }
                            >
                                <PaginationEllipsis />
                            </PopoverTrigger>
                            <PopoverContent
                                className="w-32 p-2 bg-gray-600/60"
                                align="end"
                                side="top"
                            >
                                <h6 className="mb-2 px-2 text-[10px] font-bold uppercase tracking-wider text-muted-foreground text-white">
                                    Autores por pagina
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
                                            {value} autores
                                        </Button>
                                    ))}
                                </div>
                            </PopoverContent>
                        </Popover>
                    </PaginationItem>
                </PaginationContent>
            </Pagination>

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
                            className="px-2"
                            onClick={() => {
                                setAuthorIdToDelete(null);
                                setIsDeleteDialogOpen(false); // ESTO CIERRA LA VENTANA
                            }}
                        >
                            Cancelar
                        </Button>
                        <Button
                            variant="destructive"
                            className="px-2"
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
