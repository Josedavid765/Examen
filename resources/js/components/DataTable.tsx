import React from "react";
import {
    Table,
    TableBody,
    TableCell,
    TableContainer,
    TableHead,
    TableRow,
    Paper,
    Typography,
} from "@mui/material";
import { Button } from "@/components/ui/button";
import { Plus } from "lucide-react";

type Header = {
    id: string;
    name: string;
};
interface DataTableProps {
    title: string;
    headers: Header[];
    rows: any[];
    renderRow: (row: any) => React.ReactNode;
    onAdd?: () => void;
    filter?: string;
    order: string;
    setOrder?: (order: string) => void;
}

export default function DataTable({
    title,
    headers,
    rows,
    renderRow,
    onAdd,
    order,
    setOrder,
}: DataTableProps) {
    return (
        <TableContainer
            component={Paper}
            sx={{ mb: 4, boxShadow: 3, overflow: "hidden", borderRadius: 6 }}
        >
            <div className="flex items-center justify-between p-4 bg-slate-50 border-b">
                <Typography variant="h6" className="font-bold text-slate-700">
                    {title}
                </Typography>

                {onAdd && (
                    <Button
                        onClick={onAdd}
                        className={"gap-2 bg-slate-700 p-2"}
                    >
                        <Plus className="w-4 h-4" />
                        Nuevo
                    </Button>
                )}
            </div>
            <Table sx={{ minWidth: 650 }} aria-label="custom table">
                <TableHead sx={{ backgroundColor: "#1976d2" }}>
                    <TableRow>
                        {headers.map((header) => (
                            <TableCell
                                key={header.id}
                                sx={{ color: "white", fontWeight: "bold" }}
                            >
                                {header.name}
                            </TableCell>
                        ))}
                    </TableRow>
                </TableHead>
                <TableBody>
                    {rows.length > 0 ? (
                        rows.map((row) => renderRow(row))
                    ) : (
                        <TableRow>
                            <TableCell colSpan={headers.length} align="center">
                                No hay datos disponibles
                            </TableCell>
                        </TableRow>
                    )}
                </TableBody>
            </Table>
        </TableContainer>
    );
}
