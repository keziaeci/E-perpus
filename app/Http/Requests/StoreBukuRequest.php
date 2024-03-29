<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBukuRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'judul' => 'required',
            'tahun_terbit' => 'required',
            'pengarang' => 'required',
            'penerbit' => 'required',
            'stok' => 'nullable',
            'cover.*' => 'required',
            'cover' => 'required|array|min:1',
            'deskripsi' => 'required',
            'kategoris_id' => 'required|array|min:1',
            'kategoris_id.*' => 'required|exists:kategoris,id',
        ];
    }
}
