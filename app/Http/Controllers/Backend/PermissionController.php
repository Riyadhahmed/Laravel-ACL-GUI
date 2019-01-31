<?php

namespace App\Http\Controllers\Backend;

use App\Models\Permission as UserPermission;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Validator;
use View;
use DB;

class PermissionController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      return view('backend.pages.permission.all');
   }

   public function allPermission()
   {
      DB::statement(DB::raw('set @rownum=0'));
      $usepermission = UserPermission::get(['permissions.*', DB::raw('@rownum  := @rownum  + 1 AS rownum')]);
      return Datatables::of($usepermission)
        ->addColumn('action', 'backend.pages.permission.action')
        ->make(true);
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create(Request $request)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('permission-create');
         if ($haspermision) {
            $view = View::make('backend.pages.permission.create')->render();
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
         // Setup the validator
         $rules = [
           'name' => 'required|unique:permissions'
         ];

         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
            return response()->json([
              'type' => 'error',
              'errors' => $validator->getMessageBag()->toArray()
            ]);
         } else {
            Permission::findOrCreate($request->name);
            return response()->json(['type' => 'success', 'message' => "<div class='alert alert-success'>Successfully Created</div>"]);
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }

   }

   /**
    * Display the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request, Permission $permission)
   {
      if ($request->ajax()) {

      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function edit(Request $request, Permission $permission)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('permission-edit');
         if ($haspermision) {
            $view = View::make('backend.pages.permission.edit', compact('permission'))->render();
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
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Permission $permission)
   {
      if ($request->ajax()) {
         // Setup the validator
         Permission::findOrFail($permission->id);

         $rules = [
           'name' => 'required|unique:permissions,name,' . $permission->id
         ];

         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
            return response()->json([
              'type' => 'error',
              'errors' => $validator->getMessageBag()->toArray()
            ]);
         } else {
            $permission->name = $request->name;
            $permission->save();
            return response()->json(['type' => 'success', 'message' => "<div class='alert alert-success'>Successfully Updated</div>"]);
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function destroy($id)
   {
      //
   }
}
