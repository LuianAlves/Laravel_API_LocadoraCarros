<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use App\Models\Marca;
use Illuminate\Http\Request;
use App\Repositories\MarcaRepository;

class MarcaController extends Controller
{
    public function __construct(Marca $marca) {
        $this->marca = $marca;
    }

    public function index(Request $request)
    {
        $marcaRepository = new MarcaRepository($this->marca);

        //Atributos_modelos
            if($request->has('atributos_modelos')){
                $atributos_modelos = 'modelos:id,'.$request->atributos_modelos; // Filtro Marcas
                $marcaRepository->selectAtributosRegistrosRelacionados($atributos_modelos);
            
            } else {
                $marcaRepository->selectAtributosRegistrosRelacionados('modelos');
            }

        //Filtro
            if($request->has('filtro')) {
                $marcaRepository->filtro($request->filtro);
            }

        //Atributos
            if($request->has('atributos')) {
                $marcaRepository->selectAtributos($request->atributos);
            } 

        return response()->json($marcaRepository->getResultado(), 200);
    }

    public function store(Request $request)
    {
        //$marca= Marca::create($request->all()); // Sem o __construct

        // Para APIs, adicionar em headers 'accept - application/json'
        $request->validate($this->marca->rules(), $this->marca->feedback()); 

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/logoMarca', 'public');

        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn
        ]);

        return response()->json($marca, 201);
    }

    public function show($id)
    {
        $marca = $this->marca->with('modelos')->find($id);
        if($marca === null) {
            return response()->json(['erro' => 'Recurso pesquisado não Existe!'], 404); //json
        }

        return response()->json($marca, 200);
    }

    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);

            if($marca === null) {
                return response()->json(['erro' => 'Impossível realizar a atualização. O recurso pesquisado não Existe!'], 404);
            }

            if($request->method() === 'PATCH') {
                
                $regrasDinamicas = array(); // Para desconsiderar o required quando utilizar o PATCH

                foreach($marca->rules() as $input => $regra) {

                    if(array_key_exists($input, $request->all())){
                        $regrasDinamicas[$input] = $regra;
                    }
                }

                $request->validate($regrasDinamicas, $marca->feedback()); 

            } else {

                $request->validate($marca->rules(), $marca->feedback()); 
            }


            // Removendo imagem no update pelo novo arquivo
            if($request->file('imagem')) {
                Storage::disk('public')->delete($marca->imagem);
            }

        $imagem = $request->file('imagem');
        $imagem_urn = $imagem->store('imagens/logoMarca', 'public');

        $marca->fill($request->all());
        $marca->imagem = $imagem_urn;
        $marca->save(); // Caso não tenho um id, ele cria um novo

        // dd($marca->getAttributes());
        // $marca->update([
        //     'nome' => $request->nome,
        //     'imagem' => $imagem_urn
        // ]);

        return response()->json($marca, 200);
    }

    public function destroy($id)
    {
        $marca = $this->marca->find($id);

        if($marca === null) {
            return response()->json(['erro' => 'Impossível realizar a Exclusão. O recurso pesquisado não Existe!'], 404);
        }

        // Removendo arquivo caso exista
        Storage::disk('public')->delete($marca->imagem);


        $marca->delete();
        return response()->json(['msg' => 'A marca foi removida com sucesso!'], 200);
    }
}
