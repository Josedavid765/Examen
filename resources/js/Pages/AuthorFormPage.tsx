import React, { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { apiService } from "../services/apiService";
import { Button } from "@/components/ui/button";
import { Field, FieldError, FieldLabel } from "@/components/ui/field";
import { Form } from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Author } from "@/models/Author";
import { useData } from "@/contexts/DataContext";
import { Spinner } from "@/components/ui/spinner";

const AuthorFormPage = () => {
    const { id } = useParams<{ id: string }>(); // Captura el ID de la URL si existe
    const navigate = useNavigate();

    const { refreshAuthorData } = useData();

    const [loading, setLoading] = useState(false);
    const [initialLoading, setInitialLoading] = useState(false);
    const [author, setAuthor] = useState<Author | null>(null);

    const isEditMode = Boolean(id);

    // Si estamos en modo edición, cargamos los datos del autor
    useEffect(() => {
        if (isEditMode && id) {
            setInitialLoading(true);
            apiService
                .getAuthor(id)
                .then((res) => {
                    setAuthor(res);
                })
                .catch((err) => console.error("Error al cargar autor:", err))
                .finally(() => setInitialLoading(false));
        }
    }, [id, isEditMode]);

    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        setLoading(true);

        const formData = new FormData(e.currentTarget);
        const payload: Partial<Author> = {
            firstName: String(formData.get("firstname")),
            lastName: String(formData.get("lastname")),
            birthDate: String(formData.get("birthdate")), // Formato YYYY-MM-DD
        };

        try {
            if (isEditMode && id) {
                await apiService.updateAuthor(id, payload);
            } else {
                await apiService.createAuthor(payload as Author);
            }
            await refreshAuthorData();
            navigate("/authors"); // Volver a la tabla tras el éxito
        } catch (error) {
            console.error("Error al guardar:", error);
            alert("Hubo un error al procesar la solicitud.");
        } finally {
            setLoading(false);
        }
    };

    if (initialLoading)
        return (
            <>
                <div className="p-10 text-center">
                    Cargando datos del autor...
                </div>
                <Spinner className="absolute top-1/4 left-1/2 size-16" />
            </>
        );

    return (
        <div className="max-w-2xl mx-auto mt-10">
            <Card>
                <CardHeader>
                    <CardTitle className="text-2xl font-bold">
                        {isEditMode ? "Editar Autor" : "Nuevo Autor"}
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <Form
                        className="space-y-6"
                        onSubmit={handleSubmit}
                        key={author?.id || "new"}
                    >
                        <Field name="firstname">
                            <FieldLabel>Nombre</FieldLabel>
                            <Input
                                name="firstname"
                                placeholder="Ej: George"
                                defaultValue={author?.firstName || ""}
                                required
                            />
                            <FieldError>El nombre es obligatorio.</FieldError>
                        </Field>

                        {/* Campo Apellido */}
                        <Field name="lastname">
                            <FieldLabel>Apellido</FieldLabel>
                            <Input
                                name="lastname"
                                placeholder="Ej: Lucas"
                                defaultValue={author?.lastName || ""}
                                required
                            />
                            <FieldError>El apellido es obligatorio.</FieldError>
                        </Field>

                        {/* Campo Fecha de Nacimiento */}
                        <Field name="birthdate">
                            <FieldLabel>Fecha de Nacimiento</FieldLabel>
                            <Input
                                name="birthdate"
                                type="date"
                                // Limpiamos la fecha por si viene con horas (YYYY-MM-DD)
                                defaultValue={
                                    author?.birthDate
                                        ? author.birthDate.split(" ")[0]
                                        : ""
                                }
                                required
                            />
                            <FieldError>
                                Selecciona una fecha válida.
                            </FieldError>
                        </Field>

                        <div className="flex gap-4 pt-4">
                            <Button
                                type="button"
                                variant="outline"
                                className="flex-1"
                                onClick={() => navigate("/authors")}
                            >
                                Cancelar
                            </Button>
                            <Button
                                type="submit"
                                className="flex-1"
                                loading={loading}
                            >
                                {isEditMode ? "Actualizar" : "Crear"}
                            </Button>
                        </div>
                    </Form>
                </CardContent>
            </Card>
        </div>
    );
};

export default AuthorFormPage;
