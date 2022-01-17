<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Fruit;
use DataTables;

class FruitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        $fruits = Fruit::get();
        if($request->ajax()) {
            $allData = DataTables:: of($fruits)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                
                $btn='<a href="javascript:void(0)" data-toggle="tooltip" data-id= "'.$row->id.'"
                data-original-title="Edit" class="edit btn btn-primary btn-sm editFruit">Edit</a>';
                $btn.='<a href="javascript:void(0)" data-toggle="tooltip" data-id= "'.$row->id.'"
                data-original-title="Delete" class="delete btn btn-danger btn-sm deleteFruit">Delete</a>';
                return $btn;
            })
            

            ->rawColumns(['action'])
            ->make(true);
            return $allData;
        }
    
    
        return view('fruits', compact('fruits'));

        return view('fruits');
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Fruit::updateOrCreate(['id'=>$request->fruit_id],
        [
            'name'=>$request->name,
            'price'=>$request->price
        ]
    );
    return response()->json(['success'=>'Fruit Added Successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $fruits = Fruit::find($id);
        return response()->json($fruits);

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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Fruit::find($id)->delete();
        return response()->json(['success'=>'Fruit Deleted Successfully']);
 
    }
}