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

interface DataTableProps {
    title: string;
    headers: string[];
    rows: any[];
    renderRow: (row: any) => React.ReactNode;
}

export default function DataTable({
    title,
    headers,
    rows,
    renderRow,
}: DataTableProps) {
    return (
        <TableContainer component={Paper} sx={{ mb: 4, boxShadow: 3 }}>
            <Typography variant="h6" sx={{ p: 2, backgroundColor: "#f5f5f5" }}>
                {title} ({rows.length})
            </Typography>
            <Table sx={{ minWidth: 650 }} aria-label="custom table">
                <TableHead sx={{ backgroundColor: "#1976d2" }}>
                    <TableRow>
                        {headers.map((header) => (
                            <TableCell
                                key={header}
                                sx={{ color: "white", fontWeight: "bold" }}
                            >
                                {header}
                            </TableCell>
                        ))}
                    </TableRow>
                </TableHead>
                <TableBody>
                    {rows.length > 0 ? (
                        rows.map((row, index) => renderRow(row))
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
