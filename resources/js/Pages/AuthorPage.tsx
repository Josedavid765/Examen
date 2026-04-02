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
            ]}
            rows={authors}
            renderRow={(author: Author) => (
                <TableRow key={author.id}>
                    <TableCell>{author.id}</TableCell>
                    <TableCell>{author.firstName}</TableCell>
                    <TableCell>{author.lastName}</TableCell>
                    <TableCell>{author.fullName}</TableCell>
                    <TableCell>{author.birthDate}</TableCell>
                </TableRow>
            )}
        />
    );
};

export default AuthorPage;
