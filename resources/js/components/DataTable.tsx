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
};
interface DataTableProps {
    title: string;
    headers: Header[];
    rows: any[];
    renderRow: (row: any) => React.ReactNode;
    onAdd?: () => void;
    filter?: string;
    order?: string;
    setOrder?: (order: string) => void;
    loading?: boolean;
    perPage?: number;
}

export default function DataTable({
    title,
    headers,
    rows,
    renderRow,
    onAdd,
    order,
    setOrder,
    loading,
    perPage = 5,
}: DataTableProps) {
    const handleSort = (id: string) => {
        if (!setOrder || id === "actions") return;

        if (order === id) {
            setOrder("-" + id);
        } else if (order === "-" + id) {
            setOrder("");
        } else {
            setOrder(id);
        }
    };
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
                <TableHead
                    sx={{
                        background:
                            "linear-gradient(to right, #5B0FBE, #00d4ff)",
                    }}
                >
                    <TableRow>
                        {headers.map((header: Header) => (
                            <TableCell
                                key={header.id}
                                sx={{
                                    color: "white",
                                    backgroundColor: "transparent",
                                    fontWeight: "bold",
                                    transition: "background-color 0.2s ease",
                                    cursor:
                                        header.id === "actions"
                                            ? "default"
                                            : "pointer",
                                    "&:hover": {
                                        backgroundColor:
                                            header.id !== "actions"
                                                ? "rgba(255, 255, 255, 0.15)"
                                                : "transparent",
                                    },
                                }}
                                onClick={() => handleSort(header.id)}
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
                        ))}
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
