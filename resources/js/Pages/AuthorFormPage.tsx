import { useEffect, useState } from "react";
import { useParams, useNavigate } from "react-router-dom";
import { apiService } from "../services/apiService";
import { Button } from "@/components/ui/button";
import { Field, FieldLabel } from "@/components/ui/field";
import { Form } from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { Author } from "@/models/Author";
import { useData } from "@/contexts/DataContext";
import { Spinner } from "@/components/ui/spinner";
import { IoIosEye, IoIosEyeOff } from "react-icons/io";
import { z } from "zod";
import { zodResolver } from "@hookform/resolvers/zod";
import { useForm } from "react-hook-form";

const AuthorFormPage = () => {
    const { id } = useParams<{ id: string }>();
    const isEditMode = Boolean(id);
    const navigate = useNavigate();
    const { refreshAuthorData, logAuthor } = useData();

    const [loading, setLoading] = useState(false);
    const [initialLoading, setInitialLoading] = useState(false);
    const [showPassword, setShowPassword] = useState(false);

    const getAuthorSchema = (isEdit: boolean) =>
        z.object({
            firstName: z.string().min(1, "El nombre es obligatorio"),
            lastName: z.string().min(1, "El apellido es obligatorio"),
            email: z
                .string()
                .email("Debe ser un correo válido")
                .min(1, "El correo es obligatorio"),
            birthDate: z
                .string()
                .min(1, "La fecha de nacimiento es obligatoria"),
            password: isEdit
                ? z.string().optional()
                : z
                      .string()
                      .min(6, "La contraseña debe tener al menos 6 caracteres"),
        });

    type AuthorFormValues = z.infer<ReturnType<typeof getAuthorSchema>>;

    const {
        register,
        handleSubmit,
        reset,
        formState: { errors },
    } = useForm<AuthorFormValues>({
        resolver: zodResolver(getAuthorSchema(isEditMode)),
    });

    // 3. Carga de datos asíncrona usando 'reset'
    useEffect(() => {
        if (isEditMode && id) {
            setInitialLoading(true);
            apiService
                .getAuthor(id)
                .then((res) => {
                    // Reseteamos el formulario con los datos de la API
                    reset({
                        firstName: res.firstName,
                        lastName: res.lastName,
                        email: res.email,
                        birthDate: res.birthDate
                            ? res.birthDate.split(" ")[0]
                            : "",
                    });
                })
                .catch((err) => console.error("Error al cargar autor:", err))
                .finally(() => setInitialLoading(false));
        }
    }, [id, isEditMode, reset]);

    // 4. La función onSubmit ahora recibe los datos limpios y validados por Zod
    const onSubmit = async (data: AuthorFormValues) => {
        setLoading(true);

        // Si la contraseña viene vacía (ej. en edición), la borramos del payload para no sobrescribirla
        const payload: Partial<Author> = { ...data };
        if (!payload.password || payload.password.trim() === "") {
            delete payload.password;
        }

        try {
            if (isEditMode && id) {
                await apiService.updateAuthor(id, payload);
            } else {
                await apiService.createAuthor(payload as Author);
                logAuthor(payload as Author);
            }
            await refreshAuthorData();
            navigate("/authors");
        } catch (error) {
            console.error("Error al guardar:", error);
            alert(
                isEditMode
                    ? "Hubo un error al actualizar el autor."
                    : "Hubo un error al crear el autor.",
            );
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
                    {/* 5. Usamos handleSubmit(onSubmit) para interceptar el envío */}
                    <Form
                        className="space-y-6"
                        onSubmit={handleSubmit(onSubmit)}
                    >
                        <Field>
                            <FieldLabel>Nombre</FieldLabel>
                            {/* Conectamos el input usando ...register */}
                            <Input
                                {...register("firstName")}
                                placeholder="Ej: George"
                            />
                            {/* Mostramos el error dinámico de Zod */}
                            {errors.firstName && (
                                <span className="text-sm text-red-500 mt-1">
                                    {errors.firstName.message}
                                </span>
                            )}
                        </Field>

                        <Field>
                            <FieldLabel>Apellido</FieldLabel>
                            <Input
                                {...register("lastName")}
                                placeholder="Ej: Lucas"
                            />
                            {errors.lastName && (
                                <span className="text-sm text-red-500 mt-1">
                                    {errors.lastName.message}
                                </span>
                            )}
                        </Field>

                        <Field>
                            <FieldLabel>Fecha de Nacimiento</FieldLabel>
                            <Input {...register("birthDate")} type="date" />
                            {errors.birthDate && (
                                <span className="text-sm text-red-500 mt-1">
                                    {errors.birthDate.message}
                                </span>
                            )}
                        </Field>

                        <Field>
                            <FieldLabel>Correo</FieldLabel>
                            <Input
                                {...register("email")}
                                type="email"
                                placeholder="Ej: correo@gmail.com"
                            />
                            {errors.email && (
                                <span className="text-sm text-red-500 mt-1">
                                    {errors.email.message}
                                </span>
                            )}
                        </Field>

                        <Field>
                            <FieldLabel>
                                Contraseña
                                {isEditMode &&
                                    "(Déjala en blanco para no cambiarla)"}
                            </FieldLabel>
                            <div className="relative flex items-center">
                                <Input
                                    {...register("password")}
                                    type={showPassword ? "text" : "password"}
                                    className="pr-10"
                                    // Required manual eliminado, Zod y el hook se encargan ahora.
                                />
                                <Button
                                    type="button"
                                    onClick={() =>
                                        setShowPassword(!showPassword)
                                    }
                                    className="absolute right-3 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200"
                                >
                                    {showPassword ? (
                                        <IoIosEyeOff />
                                    ) : (
                                        <IoIosEye />
                                    )}
                                </Button>
                            </div>
                            {/* Mini validación cruzada: si estamos creando, requerimos contraseña manualmente si Zod la puso opcional */}
                            {errors.password && (
                                <span className="text-sm text-red-500 mt-1">
                                    {errors.password.message}
                                </span>
                            )}
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
                                variant="outline"
                                className="flex-1"
                                disabled={loading}
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
