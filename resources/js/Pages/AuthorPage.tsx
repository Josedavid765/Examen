import { CircularProgress, TableCell, TableRow } from "@mui/material";
import DataTable from "../components/DataTable";
import { Author } from "../models/Author";
import { useData } from "../contexts/DataContext";
import { Button } from "@/components/ui/button";
import { useNavigate } from "react-router-dom";
import { apiService } from "../services/apiService";

const AuthorPage = () => {
    const { authors, loading } = useData();
    const navigate = useNavigate();
    const { refreshData } = useData();
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
        <DataTable
            title="Listado de Autores"
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
    );
};

export default AuthorPage;
