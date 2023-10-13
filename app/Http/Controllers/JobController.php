<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class JobController extends Controller
{
    public function index()
    {
      // $data = Job::all(); // Replace YourModel with the actual model you're using

      // return response()->json(['data' => $data]);
      return view('jobdatatable');
    }
 
    public function store(Request $request)
    {
       $validation = Validator::make($request->all(),[
          'name' => 'required',
          'description' => 'required',
          'position' => 'required',
       ]);
 
       $error_array = array();
       $success_output = '';
       if($validation->fails())
       {
           foreach($validation->messages()->getMessages() as $field_name => $messages)
           {
              $error_array[] = $messages;
           }
       }
       else
       {
          if($request->get('button_action') == "insert")
          {
             $job = new Job();
             $job->name = $request->input('name');
             $job->description = $request->input('description');
             $job->position = $request->input('position');
             $job->save();
             $success_output = '<div class="alert alert-success">Data Inserted</div>';
          } 
          if($request->get('button_action') == 'update')
          {
             $job = Job::find($request->get('job_id'));
             $job->name = $request->input('name');
             $job->description = $request->input('description');
             $job->position = $request->input('position');
             $job->save();
             $success_output = '<div class="alert alert-success">Data Updated</div>';
 
          }
 
       }
       $output = array(
          'error' => $error_array,
          'success' => $success_output
       );
 
       echo json_encode($output);
    }
 
    public function fetchdata(Request $request)
    {
       // dd($request->all());
       // dd($request->all());
       $id = $request->input('id');
 
       $job = Job::find($id);
   
           $output = array(
               'name'  =>  $job->name,
               'description'   =>  $job->description,
               'position'   =>  $job->position
           );
           echo json_encode($output);
     
    }
 
    public function removedata(Request $request)
    {
       $job = Job::find($request->input('id'));
       if($job->delete())
       {
          $myArray = ["Deleted successfully"];
          return response()->json($myArray);
       }
    }
 
    public function massremove(Request $request)
    {
       $job_id_array = $request->input('id');
       $job = Job::whereIn('id',$job_id_array);
       if($job->delete())
       {
          $messages = ["Data deleted successfully"];
          return response()->json($messages);
       }
    }
 
    public function datashow(Request $request)
     {
         if ($request->ajax()) {
          $jobs = Job::select('id','name','description','position');
 
             return DataTables::of($jobs)
                 ->addColumn('action',function($job){
                       return '<a href="#" class="btn btn-xs btn-primary edit" id=" '. $job->id.'"><i class="glyphicon glyphicon-edit"></i>Edit</a>
                       <a href="#" class="btn btn-xs btn-danger delete" id=" '. $job->id.'"><i class="glyphicon glyphicon-remove"></i>Delete</a>';
                 })
                 ->addColumn('checkbox','<input type="checkbox" name="job_checkbox[]" class="job_checkbox" value="{{$id}}"/>')
                 ->rawColumns(['checkbox','action'])
                 ->make(true);
         }
        
         return view('jobdatatable');
 
     }
}
