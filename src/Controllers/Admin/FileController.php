<?php

namespace Codictive\Cms\Controllers\Admin;

use Illuminate\Http\Request;
use Codictive\Cms\Models\File;
use Codictive\Cms\Traits\RequiresUser;
use Codictive\Cms\Controllers\Controller;

class FileController extends Controller
{
    use RequiresUser;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $files = File::withTrashed();
        if ($request->query('attachable_type')) {
            $files = $files->where('attachable_type', $request->query('attachable_type'));
        }
        if ($request->query('attachable_id')) {
            $files = $files->where('attachable_id', $request->query('attachable_id'));
        }
        if ($request->query('attach_context')) {
            $files = $files->where('attach_context', 'LIKE', "%{$request->query('attach_context')}%");
        }
        if ($request->query('caption')) {
            $files = $files->where('caption', 'LIKE', "%{$request->query('caption')}%");
        }
        if ($request->query('mimetype')) {
            $files = $files->where('mimetype', 'LIKE', "%{$request->query('mimetype')}%");
        }
        if ($request->query('attachable_id')) {
            $files = $files->where('attachable_id', $request->query('attachable_id'));
        }
        if ($request->query('deleted') == 'true') {
            $files = $files->whereNotNull('deleted_at');
        }
        if ($request->query('deleted') == 'false') {
            $files = $files->whereNull('deleted_at');
        }

        $orderBy  = $request->query('order_by')  ?? 'id';
        $orderDir = $request->query('order_dir') ?? 'DESC';
        $perPage  = $request->query('per_page')  ?? 30;
        $files    = $files->orderBy($orderBy, $orderDir)->paginate($perPage);

        return view('admin.files.index', ['files' => $files]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.files.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(['file' => 'required|file']);

        $uploadedFile = $request->file('file');
        if (! $uploadedFile || ! $uploadedFile->isValid()) {
            return redirect()->route('admin.files.index')->withInput($request->all())->withErrors('فایل آپلود شده نامعتبر است.');
        }

        $file                 = File::storeHttp(null, $uploadedFile);
        $file->caption        = $request->input('caption');
        $file->attach_context = $request->input('context');
        $file->description    = $request->input('description');
        $file->save();

        return redirect()->route('admin.files.index')->with('success', "فایل {$file->caption} ایجاد شد.");
    }

    /**
     * Display the specified resource.
     *
     * @param string $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $file = File::withTrashed()->find($id);

        return view('admin.files.show', ['file' => $file]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        return view('admin.files.edit', ['file' => $file]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, File $file)
    {
        $request->validate(['file' => 'nullable|file']);
        if ($request->hasFile('file')) {
            // Remove old file from the disk.
            $file->removeFile();

            $uploadedFile = $request->file('file');
            $size         = $uploadedFile->getSize();
            $mime         = $uploadedFile->getMimeType();

            $file->filename = moveFile($uploadedFile, File::STORAGE_DIR);
            $file->mimetype = $mime;
            $file->kind     = explode('/', $mime)[0];
            $file->size     = $size;
        }

        $file->caption        = $request->input('caption');
        $file->attach_context = $request->input('context');
        $file->description    = $request->input('description');
        $file->save();

        return redirect()->route('admin.files.index')->with('info', "فایل {$file->caption} ذخیره شد.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $file->delete();

        return redirect()->route('admin.files.index')->with('warning', "فایل {$file->caption} حذف شد.");
    }
}
