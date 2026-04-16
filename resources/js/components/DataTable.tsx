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
import { LucideChevronDown, LucideChevronUp } from "lucide-react";
import { Button } from "@/components/ui/button";
import { Plus } from "lucide-react";
import { Skeleton } from "@/components/ui/skeleton";
import { useData } from "@/contexts/DataContext";

type Header = {
    id: string;
    name: string;
    sortable?: boolean;
};
interface DataTableProps<T> {
    title: string;
    headers: Header[];
    rows: T[];
    renderRow: (row: T) => React.ReactNode;
    onAdd?: () => void;
    filter?: string;
    order?: string;
    setOrder?: (order: string) => void;
    loading?: boolean;
    perPage?: number;
}

export default function DataTable<T>({
    title,
    headers,
    rows,
    renderRow,
    onAdd,
    order,
    setOrder,
    loading,
    perPage = 5,
}: DataTableProps<T>) {
    const { isDarkMode } = useData(); // Consumimos el estado global

    const handleSort = (header: Header) => {
        const isSortable = header.sortable !== false && header.id !== "actions";
        if (!setOrder || !isSortable) return;

        if (order === header.id) {
            setOrder("-" + header.id);
        } else if (order === "-" + header.id) {
            setOrder("");
        } else {
            setOrder(header.id);
        }
    };

    return (
        <TableContainer
            component={Paper}
            sx={{
                mb: 4,
                mt: 2,
                boxShadow: 3,
                overflowX: "auto",
                borderRadius: 4, // Unificado a un valor estándar
                backgroundColor: isDarkMode ? "#1e293b" : "#ffffff",
                transition: "background-color 0.3s ease",
                "& .MuiTableCell-body": {
                    color: isDarkMode ? "#e2e8f0" : "#475569",
                },
                "& .MuiTableCell-root": {
                    borderColor: isDarkMode
                        ? "rgba(500, 500, 500, 0.1)"
                        : "rgba(0, 0, 0, 0.1)",
                },
            }}
        >
            {/* Header de la tabla (Título y Botón Nuevo) */}
            <div className="flex items-center justify-between p-4 border-b bg-slate-50 dark:bg-slate-800 dark:border-slate-600 transition-colors">
                <Typography
                    variant="h6"
                    className="font-bold text-slate-700 dark:text-slate-100"
                >
                    {title}
                </Typography>

                {onAdd && (
                    <Button
                        onClick={onAdd}
                        className="gap-2 bg-slate-700 hover:bg-slate-800 dark:hover:bg-slate-500 text-white dark:bg-slate-600 dark:text-slate-200 font-bold transition-all "
                    >
                        <Plus className="w-4 h-4" />
                        Nuevo
                    </Button>
                )}
            </div>

            <Table sx={{ minWidth: 650 }} aria-label="custom table">
                <TableHead>
                    <TableRow
                        sx={{
                            background: isDarkMode
                                ? "linear-gradient(to right, #FF9A8B, #1E1040)"
                                : "linear-gradient(to right, #5B0FBE, #00d4ff)",
                            transition: "background 0.3s ease",
                        }}
                    >
                        {headers.map((header: Header) => {
                            const isSortable =
                                header.sortable !== false &&
                                header.id !== "actions";
                            return (
                                <TableCell
                                    key={header.id}
                                    sx={{
                                        color: "white",
                                        fontWeight: "bold",
                                        borderBottom: "none",
                                        cursor: isSortable
                                            ? "pointer"
                                            : "default",
                                        "&:hover": {
                                            backgroundColor: isSortable
                                                ? "rgba(255, 255, 255, 0.1)"
                                                : "transparent",
                                        },
                                    }}
                                    onClick={() => handleSort(header)}
                                >
                                    <div className="flex items-center gap-1">
                                        {(order === header.id ||
                                            order === "-" + header.id) &&
                                            (order === header.id ? (
                                                <LucideChevronUp className="w-4 h-4" />
                                            ) : (
                                                <LucideChevronDown className="w-4 h-4" />
                                            ))}
                                        {header.name}
                                    </div>
                                </TableCell>
                            );
                        })}
                    </TableRow>
                </TableHead>
                <TableBody>
                    {loading ? (
                        // Skeletons con soporte dark mode
                        Array.from({ length: perPage }).map((_, rowIndex) => (
                            <TableRow key={`skeleton-row-${rowIndex}`}>
                                {headers.map((header) => (
                                    <TableCell key={`cell-${header.id}`}>
                                        <Skeleton className="h-4 w-[80%] dark:bg-slate-600" />
                                    </TableCell>
                                ))}
                            </TableRow>
                        ))
                    ) : rows.length > 0 ? (
                        rows.map((row) => renderRow(row))
                    ) : (
                        <TableRow>
                            <TableCell
                                colSpan={headers.length}
                                align="center"
                                sx={{
                                    py: 6,
                                    color: isDarkMode ? "#94a3b8" : "#64748b",
                                    borderBottom: "none",
                                }}
                            >
                                No hay datos disponibles
                            </TableCell>
                        </TableRow>
                    )}
                </TableBody>
            </Table>
        </TableContainer>
    );
}
