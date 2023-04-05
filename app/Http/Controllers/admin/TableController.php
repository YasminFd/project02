<?php

namespace App\Http\Controllers\admin;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use App\Models\table;
use App\Models\reservation;
use App\Models\branch;
use App\Http\Requests\TableStoreRequest;
class TableController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getBranches(){
        $branches = DB::table('branches')
            ->select('*')
            ->get();
        return $branches;
        
    }
    public function index()
    {
        $branches =$this->getBranches();

        $info = array();
        foreach ($branches as $branch) {
            $table = DB::table('branches')
                ->join('tables', 'branches.id', '=', 'tables.branch_id')
                ->where('branches.name', $branch->name)
                ->orderBy('branches.name', 'asc')
                ->select('tables.id', 'tables.name', 'tables.location', 'tables.guest_number', 'tables.status','tables.branch_id')
                ->get();
            $info[$branch->name] = $table;
        }

        return view('admin.tables.index',['data'=>$info]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $branches =$this->getBranches();
        return view('admin.tables.create',['data'=>$branches]);

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TableStoreRequest $req)
    {
        //
        $table=new table();
        $table->name=$req->name;
        $table->location=$req->location;
        $table->guest_number=$req->guest_number;
        $table->branch_id=$req->branch_id;
        $table->status=TableStatus::Pending;
        $table->save();
        return redirect(route('admin-tables.index'))->with('success','Table created successfully');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $table = table::findOrFail($id);
        $branches=$this->getBranches();
        return view('admin.tables.edit',['table'=>$table,'branches'=>$branches]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $req, string $id)
    {
        //
        $table=table::find($id);
        $table->name=$req->name;
        $table->guest_number=$req->guest_number;
        $table->location=$req->location;
        $table->status=$req->status;
        $table->branch_id=$req->branch_id;
        $table->save();
        return redirect(route('admin-tables.index'))->with('success','Table updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $table = table::findOrFail($id);
        $table->reservations()->delete();
        $table->delete();
        return redirect(route('admin-tables.index'))->with('danger','Table destroyed successfully');
    }
}
