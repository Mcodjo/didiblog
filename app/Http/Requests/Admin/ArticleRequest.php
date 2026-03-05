<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'titre'        => 'required|string|max:255',
            'extrait'      => 'required|string',
            'contenu'      => 'required|string',
            'image'        => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'categorie_id' => 'required|exists:categories,id',
            'auteur'       => 'nullable|string|max:255',
            'temps_lecture'=> 'nullable|string|max:20',
            'featured'     => 'boolean',
            'actif'        => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'titre.required'        => 'Le titre est obligatoire.',
            'extrait.required'      => "L'extrait est obligatoire.",
            'contenu.required'      => 'Le contenu est obligatoire.',
            'categorie_id.required' => 'Veuillez sélectionner une catégorie.',
            'categorie_id.exists'   => 'La catégorie sélectionnée est invalide.',
            'image.image'           => 'Le fichier doit être une image.',
            'image.mimes'           => 'Les formats acceptés sont : jpeg, png, jpg, webp.',
            'image.max'             => "L'image ne doit pas dépasser 2 Mo.",
        ];
    }
}
