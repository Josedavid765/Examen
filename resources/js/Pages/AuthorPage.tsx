import { CircularProgress, TableCell, TableRow } from "@mui/material";
import DataTable from "../components/DataTable";
import { Author } from "../models/Author";
import { useData } from "../contexts/DataContext";

const AuthorPage = () => {
    const { authors, loading } = useData();

    console.log(authors);

    if (loading) return <CircularProgress />;

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
            renderRow={(author: Author) => (
                <TableRow key={author.id}>
                    <TableCell>{author.id}</TableCell>
                    <TableCell>{author.firstname}</TableCell>
                    <TableCell>{author.lastname}</TableCell>
                    <TableCell>{author.fullname}</TableCell>
                    <TableCell>
                        {`${new Date(author.birthdate).getDay()}/${new Date(author.birthdate).getMonth()}/${new Date(author.birthdate).getFullYear()}`}
                    </TableCell>
                    <TableCell>
                        <button className="mx-4">Editar</button>
                        <button>Eliminar</button>
                    </TableCell>
                </TableRow>
            )}
        />
    );
};

export default AuthorPage;
