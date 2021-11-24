<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use Illuminate\Http\Request;

class MateriasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $res = Materia::all();
        return $res;
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
        try {
            $nuevaMateria = new Materia;

            $nuevaMateria->nombre = $request->nombre;
            $nuevaMateria->profesor = $request->profesor;
            $nuevaMateria->salon = $request->salon;

            $res = $nuevaMateria->save();

            $print = $res ? "OK" : "ERROR";

            return response()->json(["status" => $print]);
        } catch (\Throwable $th) {
            return response()->json(["status" => "ERROR"]);
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
        $res = Materia::find($id);
        return  $res;
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
            $nuevaMateria = Materia::find($id);

            $nuevaMateria->nombre = $request->nombre;
            $nuevaMateria->profesor = $request->profesor;
            $nuevaMateria->salon = $request->salon;

            $res = $nuevaMateria->save();

            $print = $res ? "OK" : "ERROR";

            return response()->json(["status" => $print]);
        } catch (\Throwable $th) {
            return response()->json(["status" => "ERROR"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $materia = Materia::find($id);
            $res = $materia::delete();
            $print = $res ? "OK" : "ERROR";

            return response()->json(["status" => $print]);
        } catch (\Throwable $th) {
            return response()->json(["status" => "ERROR"]);
        }
    }
}
