import { CircularProgress, TableCell, TableRow } from "@mui/material";
import DataTable from "../components/DataTable";
import { Author } from "../models/Author";
import { useData } from "../contexts/DataContext";
import { Button } from "@/components/ui/button";
import { useNavigate } from "react-router-dom";

const AuthorPage = () => {
    const { authors, loading } = useData();
    const navigate = useNavigate();
    console.log(authors);

    if (loading)
        return (
            <div className="relative h-screen">
                <CircularProgress className="absolute right-1/2 top-1/2" />
            </div>
        );

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
                    <TableCell>{author.firstname}</TableCell>
                    <TableCell>{author.lastname}</TableCell>
                    <TableCell>{author.fullname}</TableCell>
                    <TableCell>
                        {`${new Date(author.birthdate).getDate()}/${new Date(author.birthdate).getMonth() + 1}/${new Date(author.birthdate).getFullYear()}`}
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
                        <Button className={"px-2"} variant="destructive">
                            Eliminar
                        </Button>
                    </TableCell>
                </TableRow>
            )}
        />
    );
};

export default AuthorPage;
