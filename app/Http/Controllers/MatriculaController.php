<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Matricula;
use Illuminate\Http\Request;

class MatriculaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return "index";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return "create";
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $encontrarMatricula = Matricula::where([
            ["id_usuario", "=", $request->id_usuario], ["id_materia", "=", $request->id_materia]
        ])->get();

        if (count($encontrarMatricula) > 0) {
            return Response()->json(["status" => "ERROR1", "error" =>  "Ya te encuentras matriculado a esta materia"]);
        }
        //

        //
        $encontrarHorario = Matricula::where([
            ["id_usuario", "=", $request->id_usuario], ["fecha", "=", $request->fecha]
        ])->get();

        if (count($encontrarHorario) > 0) {
            return Response()->json(["status" => "ERROR2", "error" =>  "Cruce de horarios"]);
        }
        //

        //
        $encontrarCreditos = Matricula::where("id_usuario", "=", $request->id_usuario)->get();

        if (count($encontrarCreditos) >= 3) {
            return Response()->json(["status" => "ERROR3", "error" =>  "Limite de materias"]);
        }
        //

        try {
            $nuevaMatricula = new Matricula();
            $nuevaMatricula->id_usuario = $request->id_usuario;
            $nuevaMatricula->id_materia = $request->id_materia;
            $nuevaMatricula->fecha = $request->fecha;

            $res = $nuevaMatricula->save();

            $flag = 5;
            $print = $res ? "OK" : "ERROR4";
            $flag = 6;
            return response()->json(["status" => $print]);
        } catch (\Throwable $th) {
            return response()->json(["status" => "ERRor: " . $nuevaMatricula]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $usuario = Matricula::where("id_usuario", "=", $id)->get();
        $valMaterias = [];

        foreach ($usuario as $item) {
            $valMaterias[] = Materia::where("id", "=", $item->id_materia)->get();
        }

        return Response()->json(["result" => $valMaterias]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        return "edit";
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $encontrarHorario = Matricula::where([
                ["id_usuario", "=", $request->id_usuario], ["fecha", "=", $request->fecha]
            ])->get();

            if (count($encontrarHorario) > 0) {
                return Response()->json(["status" => "ERROR", "error" =>  "Se encontrarà un cruce de materias"]);
            }

            $encontrarMatricula = Matricula::where([
                ["id_usuario", "=", $request->id_usuario], ["id_materia", "=", $request->id_materia]
            ])->get();

            $matricula = Matricula::find($encontrarMatricula->id_materia);
            $matricula->fecha = $request->fecha;
            $res = $matricula->save();

            $print = $res ? "OK" : "ERROR";

            return response()->json(["status" => $print]);
        } catch (\Throwable $th) {
            return response()->json(["status" => "ERROR"]);
        }
    }

    public function destroy(Request $request)
    {
        try {
            $encontrarMatricula = Matricula::where([
                ["id_usuario", "=", $request->id_usuario], ["id_materia", "=", $request->id_materia]
            ])->get();
            $matricula = Matricula::where("id", "=", $encontrarMatricula[0]->id)->get();

            $res = $matricula[0]->delete();
            $print = $res ? "OK" : "ERROR";

            return response()->json(["status" => $print]);
        } catch (\Throwable $th) {
            return response()->json(["status" => "ERROR"]);
        }
    }
}
