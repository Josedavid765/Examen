import js from "@eslint/js";
import globals from "globals";
import tseslint from "typescript-eslint";
import reactPlugin from "eslint-plugin-react";

export default tseslint.config(
    js.configs.recommended,
    ...tseslint.configs.recommended,
    {
        plugins: {
            react: reactPlugin,
        },
        rules: {
            ...reactPlugin.configs.recommended.rules,
            "react/react-in-jsx-scope": "off", // No necesario en React 19
        },
        settings: {
            react: {
                version: "19.0",
            },
        },
        languageOptions: {
            globals: {
                ...globals.browser,
            },
        },
    },
);
