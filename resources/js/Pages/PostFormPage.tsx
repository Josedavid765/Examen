import React, { useState, useEffect } from "react";
import { useNavigate, useParams } from "react-router-dom";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { apiService } from "../services/apiService";
import { Status } from "../models/Status";
import { useData } from "../contexts/DataContext";

const PostFormPage = () => {
    const { id } = useParams();
    const postId = id || "";
    const navigate = useNavigate();
    const [loading, setLoading] = useState(false);
    const { authorId, refreshData } = useData();

    const [formData, setFormData] = useState({
        subject: "",
        description: "",
        status: "DRAFT",
        publishDate: "",
        authorId: authorId || "",
        numComments: 0,
    });

    useEffect(() => {
        if (!postId && !authorId) {
            alert("No se ha seleccionado un autor para el post.");
            navigate("/authors");
        }
    }, [postId, authorId, navigate]);

    useEffect(() => {
        if (postId) {
            const fetchPost = async () => {
                setLoading(true);
                try {
                    const post = await apiService.getPost(postId);
                    setFormData({
                        subject: post.subject || "",
                        description: post.description || "",
                        status: post.status || "DRAFT",
                        publishDate: post.publishDate
                            ? post.publishDate.split("T")[0]
                            : "",
                        authorId: post.authorId || authorId || "",
                        numComments: post.numComments,
                    });
                } catch (error) {
                    console.error("Error al cargar el post", error);
                } finally {
                    setLoading(false);
                }
            };
            fetchPost();
        }
    }, [postId, authorId]);

    const handleChange = (
        e: React.ChangeEvent<
            HTMLInputElement | HTMLTextAreaElement | HTMLSelectElement
        >,
    ) => {
        setFormData({
            ...formData,
            [e.target.name]: e.target.value,
        });
    };

    const handleSubmit = async (e: React.FormEvent) => {
        e.preventDefault();
        setLoading(true);
        try {
            const payload = {
                subject: formData.subject,
                description: formData.description,
                status: formData.status as Status,
                publishDate: formData.publishDate ? formData.publishDate : null as unknown as string,
                authorId: String(formData.authorId),
                numComments: formData.numComments,
            };

            if (postId) {
                await apiService.updatePost(postId, payload);
            } else {
                await apiService.createPost(payload);
            }
            await refreshData();
            navigate(`/authors/${formData.authorId}/posts`);
        } catch (error) {
            console.error("Error al guardar:", error);
            alert("Hubo un error al guardar el post.");
        } finally {
            setLoading(false);
        }
    };

    return (
        <div className="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-md mt-10">
            <h2 className="text-2xl font-bold mb-6 text-gray-800">
                {postId ? `Editar Post: ${formData.subject}` : "Crear Nuevo Post"}
            </h2>

            <form onSubmit={handleSubmit} className="space-y-4">
                {}
                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">
                        Asunto / Título
                    </label>
                    <Input
                        type="text"
                        name="subject"
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
                        className="w-full border border-gray-300 rounded-md p-2 focus:ring-2 focus:ring-blue-500"
                    >
                        <option value="DRAFT">Borrador</option>
                        <option value="PUBLISHED">Publicado</option>
                        <option value="CANCELLED">Cancelado</option>
                    </select>
                </div>

                <div>
                    <label className="block text-sm font-medium text-gray-700 mb-1">
                        Fecha de Publicación
                    </label>
                    <Input
                        type="date"
                        name="publishDate"
                        value={formData.publishDate}
                        onChange={handleChange}
                    />
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
