import { Author } from "../models/Author";
import { Post } from "../models/Post";
import { Comment } from "../models/Comment";

const BASE_URL = "/api";

interface PaginatedResponse<T> {
    data: T[];
    meta?: unknown;
}

const headers = {
    "Content-Type": "application/json",
    Accept: "application/json",
};

export const apiService = {
    getAuthors: async (
        fullname?: string,
        page: number = 1,
        perPage: number = 3,
        order?: string,
    ) => {
        const params = new URLSearchParams();
        if (fullname && fullname.trim() !== "") {
            params.append("fullname", fullname);
        }
        params.append("page", page.toString());
        params.append("perPage", perPage.toString());
        if (order) params.append("order", order);

        const response = await fetch(
            `${BASE_URL}/authors?${params.toString()}`,
            { headers },
        );
        if (!response.ok) throw new Error("Error obteniendo autores");
        return await response.json();
    },

    getAuthor: async (id: string): Promise<Author> => {
        const response = await fetch(`${BASE_URL}/authors/${id}`, { headers });
        if (!response.ok) throw new Error("Error obteniendo autor");
        const json = await response.json();
        return json.data ? json.data : json;
    },

    createAuthor: async (data: Omit<Author, "id">): Promise<Author> => {
        console.log(data);
        const response = await fetch(`${BASE_URL}/authors`, {
            method: "POST",
            headers,
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error("Error creando autor");
        return await response.json();
    },

    updateAuthor: async (
        id: string,
        data: Partial<Author>,
    ): Promise<Author> => {
        const response = await fetch(`${BASE_URL}/authors/${id}`, {
            method: "PUT",
            headers,
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error("Error actualizando autor");
        return await response.json();
    },

    deleteAuthor: async (id: string): Promise<void> => {
        const response = await fetch(`${BASE_URL}/authors/${id}`, {
            method: "DELETE",
            headers,
        });
        if (!response.ok) throw new Error("Error eliminando autor");
    },

    getAuthorPosts: async (
        authorId: string,
        page: number = 1,
        perPage: number = 10,
        order?: string,
    ): Promise<PaginatedResponse<Post>> => {
        const params = new URLSearchParams();
        params.append("page", page.toString());
        params.append("perPage", perPage.toString());
        if (order) params.append("order", order);

        const response = await fetch(
            `${BASE_URL}/authors/${authorId}/posts?${params.toString()}`,
            {
                headers,
            },
        );
        if (!response.ok) throw new Error("Error obteniendo posts del autor");

        return await response.json();
    },

    getPosts: async () => {
        const response = await fetch(`${BASE_URL}/posts`, { headers });
        if (!response.ok) throw new Error("Error obteniendo posts");
        return await response.json();
    },

    getPost: async (id: string): Promise<Post> => {
        const response = await fetch(`${BASE_URL}/posts/${id}`, { headers });
        if (!response.ok) throw new Error("Error obteniendo post");
        const json = await response.json();
        return json.data ? json.data : json;
    },

    createPost: async (data: Omit<Post, "id">): Promise<Post> => {
        const response = await fetch(`${BASE_URL}/posts`, {
            method: "POST",
            headers,
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error("Error creando post");
        return await response.json();
    },

    updatePost: async (id: string, data: Partial<Post>): Promise<Post> => {
        const response = await fetch(`${BASE_URL}/posts/${id}`, {
            method: "PUT",
            headers,
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error("Error actualizando post");
        return await response.json();
    },

    deletePost: async (id: string): Promise<void> => {
        const response = await fetch(`${BASE_URL}/posts/${id}`, {
            method: "DELETE",
            headers,
        });
        if (!response.ok) throw new Error("Error eliminando post");
    },

    getComment: async (id: string): Promise<Comment> => {
        const response = await fetch(`${BASE_URL}/comments/${id}`, { headers });
        if (!response.ok) throw new Error("Error obteniendo comentario");
        return await response.json();
    },

    createComment: async (data: Omit<Comment, "id">): Promise<Comment> => {
        const response = await fetch(`${BASE_URL}/comments`, {
            method: "POST",
            headers,
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error("Error creando comentario");
        return await response.json();
    },

    updateComment: async (
        id: string,
        data: Partial<Comment>,
    ): Promise<Comment> => {
        const response = await fetch(`${BASE_URL}/comments/${id}`, {
            method: "PUT",
            headers,
            body: JSON.stringify(data),
        });
        if (!response.ok) throw new Error("Error actualizando comentario");
        return await response.json();
    },

    deleteComment: async (id: string): Promise<void> => {
        const response = await fetch(`${BASE_URL}/comments/${id}`, {
            method: "DELETE",
            headers,
        });
        if (!response.ok) throw new Error("Error eliminando comentario");
    },

    getCommentsByPost: async (postId: string): Promise<Comment[]> => {
        const response = await fetch(`${BASE_URL}/posts/${postId}/comments`, {
            headers,
        });
        if (!response.ok)
            throw new Error("Error obteniendo comentarios del post");
        return await response.json();
    },

    getCommentsByAuthor: async (authorId: string): Promise<Comment[]> => {
        const response = await fetch(
            `${BASE_URL}/authors/${authorId}/comments`,
            { headers },
        );
        if (!response.ok)
            throw new Error("Error obteniendo comentarios del autor");
        return await response.json();
    },
};
