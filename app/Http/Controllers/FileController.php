<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use App\Models\File;
  
class FileController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('create');
    }
  
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
                'filenames' => 'required',
                'filenames.*' => 'mimes:doc,pdf,docx,zip,xls,jpeg,jpg,png,xlsx,ppt,pptx'
        ]);
  
        $files = [];
        if($request->hasfile('filenames'))
         {
            foreach($request->file('filenames') as $file)
            {
                $name = time().rand(1,100).'.'.$file->extension();
                $file->move(public_path('files'), $name);  
                // $file->storeAs('images', $imageName, 's3');
                $files[] = $name;  
            }
         }
  
         $file= new File();
         $file->filenames = $files;
         $file->save();
  
        return back()->with('success', 'Data Your files has been successfully added');
    }
}