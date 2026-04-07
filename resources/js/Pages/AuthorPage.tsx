import { CircularProgress, TableCell, TableRow } from "@mui/material";
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
    Collapsible,
    CollapsiblePanel,
    CollapsibleTrigger,
} from "@/components/ui/collapsible";
import { ChevronsLeft, ChevronsRight } from "lucide-react";

const AuthorPage = () => {
    const { authors, loading } = useData();
    const navigate = useNavigate();
    const {
        refreshData,
        totalPages,
        totalAuthors,
        page,
        perPage,
        setPage,
        setPerPage,
        setFilter,
    } = useData();

    console.log(authors);

    if (loading)
        return (
            <div className="relative h-screen">
                <CircularProgress className="absolute right-1/2 top-1/2" />
            </div>
        );

    const handleDelete = async (id: string) => {
        try {
            await apiService.deleteAuthor(String(id));
            await refreshData();
        } catch (error) {
            console.log(error);
            alert("Hubo un error al eliminar el autor");
        }
    };

    return (
        <>
            <Input
                placeholder="Buscar..."
                onChange={(e) => setFilter(e.target.value)}
            />
            <DataTable
                title={
                    "Autores: " +
                    totalAuthors +
                    " - Autores por página: " +
                    perPage +
                    " - Página: " +
                    page +
                    " - Paginas totales: " +
                    totalPages
                }
                headers={[
                    "ID",
                    "Nombre",
                    "Apellido",
                    "Nombre Completo",
                    "Fecha Nacimiento",
                    "Acciones",
                ]}
                rows={authors}
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
                                onClick={() => handleDelete(author.id)}
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
                            onClick={() => setPage(1)}
                        ></ChevronsLeft>
                    </PaginationItem>
                    <PaginationItem>
                        <PaginationPrevious
                            onClick={() => setPage(page - 1)}
                            style={{ display: page == 1 ? "none" : "flex" }}
                        />
                    </PaginationItem>
                    <PaginationLink
                        onClick={() => setPage(page - 1)}
                        style={{ display: page == 1 ? "none" : "flex" }}
                    >
                        {page - 1}
                    </PaginationLink>
                    <PaginationLink>{page}</PaginationLink>
                    <PaginationLink
                        onClick={() => setPage(page + 1)}
                        style={{
                            display: page == totalPages ? "none" : "flex",
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
                        ></ChevronsRight>
                    </PaginationItem>
                    <PaginationItem className="relative">
                        <Collapsible>
                            <CollapsibleTrigger className="h-9 w-9 p-0 flex items-center justify-center hover:bg-accent rounded-md transition-colors">
                                <PaginationEllipsis />
                            </CollapsibleTrigger>
                            <CollapsiblePanel
                                className={
                                    "absolute top-full right-0 z-50 mt-2 min-w-[100px] rounded-md border bg-popover p-2 shadow-md"
                                }
                            >
                                <h6 className="mb-2 px-2 text-[10px] font-bold uppercase tracking-wider text-muted-foreground">
                                    Autores por página
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
                                            onClick={() => setPerPage(value)}
                                        >
                                            {value} autores
                                        </Button>
                                    ))}
                                </div>
                            </CollapsiblePanel>
                        </Collapsible>
                    </PaginationItem>
                </PaginationContent>
            </Pagination>
        </>
    );
};

export default AuthorPage;
