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
            sx={{ mb: 4, boxShadow: 3, overflowX: "auto", borderRadius: 6 }}
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
            <Table
                sx={{ minWidth: 650, borderRadius: 6 }}
                aria-label="custom table"
            >
                <TableHead
                    sx={{
                        background:
                            "linear-gradient(to right, #5B0FBE, #00d4ff)",
                    }}
                >
                    <TableRow>
                        {headers.map((header: Header) => {
                            const isSortable =
                                header.sortable !== false &&
                                header.id !== "actions";
                            return (
                                <TableCell
                                    key={header.id}
                                    sx={{
                                        color: "white",
                                        backgroundColor: "transparent",
                                        fontWeight: "bold",
                                        transition:
                                            "background-color 0.2s ease",
                                        cursor: isSortable
                                            ? "pointer"
                                            : "default",
                                        "&:hover": {
                                            backgroundColor: isSortable
                                                ? "rgba(255, 255, 255, 0.15)"
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
                        Array.from({ length: perPage }).map((_, rowIndex) => (
                            <TableRow key={`skeleton-row-${rowIndex}`}>
                                {headers.map((header) => (
                                    <TableCell
                                        key={`skeleton-cell-${header.id}-${rowIndex}`}
                                    >
                                        {header.id === "actions" ? (
                                            <div className="flex justify-center gap-1">
                                                <Skeleton className="h-8 w-14 rounded-md " />
                                                <Skeleton className="h-8 w-16 rounded-md" />
                                                <Skeleton className="h-8 w-16 rounded-md" />
                                            </div>
                                        ) : (
                                            <Skeleton className="h-4 w-[85%]" />
                                        )}
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
                                sx={{ py: 6, color: "text.secondary" }}
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
