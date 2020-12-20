<?php

namespace App\Http\Controllers\Admin;
use App\Models\Classes;
use App\Models\Subject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
class AdminController extends Controller
{
    public function admin()
    {
        return view('admin.index');
    }
    public function classes()
    {
        return view('admin.classes');
    }
    public function addClass(Request $request)
    {
     
        $add_class = Classes::updateOrCreate(
            [
                'name' => $request->name,
            ],
            [
                'name' => $request->name,
            ]);
        return response()->json([
            'result' => 'Added successfully',
        ], 200);
    }
    public function editClass(Request $request)
    {
     
        $edit_class = Classes::find($request->editid);
        $edit_class->name = $request->editname;
        $edit_class->save();
        return response()->json([
            'result' => 'Edited successfully',
        ], 200);
    }
    public function deleteClass(Request $request)
    {
     
        $del_class = Classes::find($request->id);
        
        $del_class->delete();
        return response()->json([
            'result' => 'Deleted successfully',
        ], 200);
    }
    public function getClasses()
    {
        $number=0;
        $classes = Classes::all();
        return DataTables::of($classes)
        ->addColumn('action', function ($classes) {
                
                $button = '<a href="#" class="btn btn-info btn-sm btn-circle deleteClass"title="Deactivate" data-id=' . $classes->id . '><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn btn-danger btn-sm btn-circle deleteClass"title="Deactivate" data-id=' . $classes->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
                // $button .= '<a href="#" class="btn btn-danger btn-sm btn-circle deleteClass"title="Deactivate" data-id=' . $classes->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
              
                return $button;
                
        })
            ->rawColumns(['action'])
            ->make(true);
    }


    //subjects
    public function subjects()
    {
        return view('admin.subjects');
    }
    public function addSubject(Request $request)
    {
     
        $add_subject = Subject::updateOrCreate(
            [
                'name' => $request->name,
                'grade' => $request->grade,
                'author' => $request->author,
            ],
            [
                'name' => $request->name,
                'grade' => $request->grade,
                'type' => $request->type,
                'author' => $request->author, 
                'details' => $request->info,

            ]);
        return response()->json([
            'result' => 'Added successfully',
        ], 200);
    }
    public function getSubjects()
    {
        $number=0;
        $subjects = Subject::all();
        return DataTables::of($subjects)
        ->addColumn('action', function ($subjects) {
                $button = '<a href="#" class="btn btn-danger btn-sm btn-circle  deleteSubject"title="Deactivate" data-id=' . $subjects->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
                $button .= '<a href="#" class="btn btn-info btn-sm btn-circle editSubjectInfo " data-toggle="modal" data-target="#editSubjectModal"   data-id="' . $subjects->id .'" data-name="' . $subjects->name .'"data-grade="' . $subjects->grade .'"data-type="' . $subjects->type . '"data-author="' . $subjects->author . '"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';  
              //  $button .= '<a href="#" class="btn btn-danger btn-sm btn-circle float-right deleteSubject"title="Deactivate" data-id=' . $subjects->id . '><i class="fa fa-trash"></i></a>&nbsp;&nbsp;';  
              
                return $button;
                
        })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function editSubject(Request $request)
    {
     
        $edit_subject = Subject::find($request->edit_id);
        $edit_subject->name = $request->edit_name;
        $edit_subject->grade = $request->edit_grade;
        $edit_subject->type = $request->edit_type;
        $edit_subject->author = $request->edit_author;
        $edit_subject->details = $request->edit_info;
        
        $edit_subject->save();
        return response()->json([
            'result' => 'Edited successfully',
        ], 200);
    }
    public function deleteSubject(Request $request)
    {
     
        $del_sub = Subject::find($request->id);
        
        $del_sub->delete();
        return response()->json([
            'result' => 'Deleted successfully',
        ], 200);
    }
}
