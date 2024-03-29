<?php

namespace App\Http\Controllers;
use Mail;
use App\Models\Tarefa;
use App\Mail\NovaTarefaMail;
use Illuminate\Http\Request;
use App\Exports\TarefasExport;
use Maatwebsite\Excel\Facades\Excel;

class TarefaController extends Controller
{



    public function __construct(){
      //  $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user_id = auth()->user()->id;
        $tarefas = Tarefa::where('user_id', $user_id)->paginate(10);

        
        return view('tarefa.index', ['tarefas' => $tarefas]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tarefa.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dados = $request->all();
        $dados['user_id'] =  auth()->user()->id;

        $tarefa = Tarefa::create($dados); //criando tarefa
        
        $destinatario = auth()->user()->email; 

        Mail::to($destinatario)->send(new NovaTarefaMail($tarefa));//enviando email

        return redirect()->route('tarefa.show', ['tarefa' => $tarefa->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function show(Tarefa $tarefa)
    {
        return view('tarefa.show', ['tarefa'=>$tarefa]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function edit(Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;

        if($user_id == $tarefa->user_id){
            return view('tarefa.edit', ['tarefa'=>$tarefa]);            
        }
        return view('acesso-negado');
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tarefa $tarefa)
    {

        $user_id = auth()->user()->id;

        if($user_id == $tarefa->user_id){

            $tarefa->update($request->all());
            
            return redirect()->route('tarefa.show', ['tarefa'=>$tarefa->id]);

        }
        return view('acesso-negado');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tarefa  $tarefa
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tarefa $tarefa)
    {
        $user_id = auth()->user()->id;

        if($user_id == $tarefa->user_id){

            $tarefa->delete();
            
            return redirect()->route('tarefa.index');

        }
        return view('acesso-negado');
    }



    public function exportacao($extensao){

        $nome_arquivo = 'lista_de_tarefas.';

        $nome_arquivo .= $extensao;

        /*if($extensao == 'XLSX'){
           
        }else{

        }*/

        return Excel::download(new TarefasExport, $nome_arquivo );
    }
}
