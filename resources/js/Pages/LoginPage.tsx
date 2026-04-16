import React, { useState, useEffect } from "react";
import { useNavigate } from "react-router-dom";
import { useData } from "@/contexts/DataContext";
import { Button } from "@/components/ui/button";
import { Field, FieldLabel } from "@/components/ui/field";
import { Form } from "@/components/ui/form";
import { Input } from "@/components/ui/input";
import { Card, CardContent, CardHeader, CardTitle } from "@/components/ui/card";
import { IoIosEye, IoIosEyeOff } from "react-icons/io";
import { Author } from "@/models/Author";

const LoginPage = () => {
    const navigate = useNavigate();
    const { logAuthor, authorLogged } = useData();
    const [showPassword, setShowPassword] = useState(false);

    useEffect(() => {
        if (authorLogged) {
            navigate("/authors");
        }
    }, [authorLogged, navigate]);

    const handleSubmit = async (e: React.FormEvent<HTMLFormElement>) => {
        e.preventDefault();
        const formData = new FormData(e.currentTarget);
        const email = String(formData.get("email"));
        const password = String(formData.get("password"));

        logAuthor({ email, password } as Partial<Author>);

        navigate("/authors");
    };

    return (
        <div className="max-w-md mx-auto mt-20">
            <Card>
                <CardHeader>
                    <CardTitle className="text-2xl font-bold text-center">
                        Iniciar Sesión
                    </CardTitle>
                </CardHeader>
                <CardContent>
                    <Form className="space-y-6" onSubmit={handleSubmit}>
                        <Field>
                            <FieldLabel>Correo Electrónico</FieldLabel>
                            <Input
                                name="email"
                                type="email"
                                placeholder="Ej: correo@gmail.com"
                                required
                            />
                        </Field>

                        <Field>
                            <FieldLabel>Contraseña</FieldLabel>
                            <div className="relative flex items-center">
                                <Input
                                    name="password"
                                    type={showPassword ? "text" : "password"}
                                    placeholder="Contraseña"
                                    className="pr-10"
                                    required
                                />
                                <Button
                                    type="button"
                                    onClick={() => setShowPassword(!showPassword)}
                                    className="absolute right-3 text-slate-500 hover:text-slate-700 dark:text-slate-400 dark:hover:text-slate-200"
                                    variant="ghost"
                                >
                                    {showPassword ? <IoIosEyeOff /> : <IoIosEye />}
                                </Button>
                            </div>
                        </Field>

                        <div className="pt-4">
                            <Button
                                type="submit"
                                className="w-full"
                            >
                                Iniciar Sesión
                            </Button>
                        </div>
                    </Form>
                </CardContent>
            </Card>
        </div>
    );
};

export default LoginPage;
