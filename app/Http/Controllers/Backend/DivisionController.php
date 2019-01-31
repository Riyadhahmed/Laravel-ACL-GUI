<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Division;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;

use View;
use DB;

class DivisionController extends Controller
{

   public function __construct()
   {
      // $this->middleware(['permission:create division|edit division']);
   }

   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      return view('backend.pages.division.all');
   }


   public function getAll(Request $request)
   {

      if ($request->ajax()) {
         DB::statement(DB::raw('set @rownum=0'));
         $data = Division::get(['divisions.*',
           DB::raw('@rownum  := @rownum  + 1 AS rownum')]);
         return Datatables::of($data)
           ->editColumn('status', function ($data) {
              return $data->status ? 'Active' : 'Inactive';
           })
           ->addColumn('action', 'backend.pages.division.action')
           ->make(true);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create(Request $request)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('division-create');
         if ($haspermision) {
            $view = View::make('backend.pages.division.create')->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('division-create');
         if ($haspermision) {

            $rules = [
              'division_name' => 'required|unique:divisions',
              'division_address' => 'required'
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
               return response()->json([
                 'type' => 'error',
                 'errors' => $validator->getMessageBag()->toArray()
               ]);
            } else {

               $division = new Division;
               $division->division_name = $request->input('division_name');
               $division->division_area = $request->input('division_area');
               $division->division_address = $request->input('division_address');
               $division->status = 1;

               $division->save(); //
               return response()->json(['type' => 'success', 'message' => "<div class='alert alert-success'>Successfully Created</div>"]);
            }
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\Division $division
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request, Division $division)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('division-view');
         if ($haspermision) {
            $view = View::make('backend.pages.division.view', compact('division'))->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  \App\Models\Division $division
    * @return \Illuminate\Http\Response
    */
   public function edit(Request $request, Division $division)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('division-view');
         if ($haspermision) {
            $view = View::make('backend.pages.division.edit', compact('division'))->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  \App\Models\Division $division
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Division $division)
   {
      $request->validate([
        'division_name' => 'required',
        'division_address' => 'required'
      ]);

      $division->division_name = $request->division_name;
      $division->division_area = $request->division_area;
      $division->division_address = $request->division_address;
      $division->status = 1;

      $division->save(); //
      return response()->json(['type' => 'success', 'message' => 'Successfully Updated']);
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  \App\Models\Division $division
    * @return \Illuminate\Http\Response
    */
   public function destroy(Division $division)
   {
      $division->delete();
      return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
   }
}
