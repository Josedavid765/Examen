import React, { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { useData } from "../contexts/DataContext";
import { apiService } from "../services/apiService";
import { Status } from "../models/Status";

const PostFormPage = () => {
    const { id } = useParams();
    const postId = id || "";
    const navigate = useNavigate();
    const { authorId, refreshPostData } = useData();
    const [loading, setLoading] = useState(false);

    const [formData, setFormData] = useState<{
        subject: string;
        description: string;
        status: Status;
        publishDate: string;
    }>({
        subject: "",
        description: "",
        status: "DRAFT" as Status,
        publishDate: "",
    });

    useEffect(() => {
        if (!postId && !authorId) {
            alert("No se ha seleccionado un autor para el post.");
            navigate("/authors");
        }
    }, [postId, authorId, navigate]);

    useEffect(() => {
        const loadPostToEdit = async () => {
            if (postId) {
                try {
                    setLoading(true);
                    const postData = await apiService.getPost(postId);
                    setFormData({
                        subject: postData.subject || "",
                        description: postData.description || "",
                        status: postData.status || "DRAFT",
                        publishDate: postData.publishDate
                            ? postData.publishDate.split(" ")[0]
                            : "",
                    });
                } catch (error) {
                    console.error("Error al cargar el post:", error);
                    alert("No se pudo cargar la informacion del post");
                    navigate(-1);
                } finally {
                    setLoading(false);
                }
            }
        };
        loadPostToEdit();
    }, [postId, navigate]);

    const handleChange = (
        e: React.ChangeEvent<
            HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement
        >,
    ) => {
        const { name, value } = e.target;
        setFormData({
            ...formData,
            [name]: name === "status" ? (value as Status) : value,
        });
    };
    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setLoading(true);
        try {
            if (postId) {
                // Lógica para actualizar el post existente
                await apiService.updatePost(postId, formData);
            } else {
                // Lógica para crear un nuevo post
                const newPayload = {
                    ...formData,
                    authorId: authorId,
                    publishDate:
                        formData.status === "PUBLISHED"
                            ? new Date().toISOString()
                            : null,
                    numComments: 0,
                };
                try {
                    await apiService.createPost(newPayload);
                } catch (error) {
                    console.error("Error al crear el post:", error);
                    alert(
                        "Hubo un error al crear el post. Por favor, inténtalo de nuevo.",
                    );
                    return;
                }
            }
            await refreshPostData();
            navigate(`/authors/${authorId}/posts`);
        } catch (error) {
            console.error("Error al guardar el post:", error);
            alert(
                "Hubo un error al guardar el post. Por favor, inténtalo de nuevo.",
            );
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
            <h2 className="text-2xl font-bold mb-6 text-gray-800">
                {postId ? "Editar Post" : "Crear Nuevo Post"}
            </h2>

            <form onSubmit={handleSubmit} className="space-y-4">
                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">
                        Asunto / Título
                    </label>
                    <Input
                        type="text"
                        name="subject"
                        disabled={loading}
                        value={formData.subject}
                        onChange={handleChange}
                        required
                    />
                </div>

                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">
                        Descripción
                    </label>
                    <textarea
                        name="description"
                        value={formData.description}
                        onChange={handleChange}
                        disabled={loading}
                        required
                        className="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500"
                        rows={4}
                    />
                </div>

                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">
                        Estado
                    </label>
                    <select
                        name="status"
                        value={formData.status}
                        onChange={handleChange}
                        disabled={loading}
                        className="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="DRAFT">Borrador</option>
                        <option value="PUBLISHED">Publicado</option>
                        <option value="CANCELLED">Cancelado</option>
                    </select>
                </div>

                <div className="flex justify-end space-x-2 mt-6">
                    <Button
                        type="button"
                        variant="secondary"
                        onClick={() => navigate(-1)}
                        className="px-2"
                    >
                        Cancelar
                    </Button>
                    <Button
                        type="submit"
                        disabled={loading}
                        className="bg-blue-600 hover:bg-blue-700 text-white px-2"
                    >
                        {loading ? "Guardando..." : "Guardar Post"}
                    </Button>
                </div>
            </form>
        </div>
    );
};

export default PostFormPage;
