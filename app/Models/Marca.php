<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules() {
        return [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:3',
            'imagem' => 'required|file'
        ];
    }

    public function feedback() {      
        return [
            'required' => 'O campo :attribute é obrigatório!',
            'nome.unique' => 'O nome da marca já existe.',
            'nome.min' => 'O campo nome precisa de no mínimo 3 caracteres'
        ];
    }

    public function modelos() {
        //Uma Marca POSSUI MUITOS Modelos
        return $this->hasMany('App\Models\Modelo');
    }
}
