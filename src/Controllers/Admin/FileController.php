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
        $files = File::with([]);
        if ($request->query('related_type')) {
            $files = $files->where('related_type', $request->query('related_type'));
        }
        if ($request->query('related_id')) {
            $files = $files->where('related_id', $request->query('related_id'));
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

        return view('cms::admin.files.index', ['files' => $files]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cms::admin.files.create');
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
            return redirect()->route('admin.files.index')->withInput($request->all())->withErrors('???????? ?????????? ?????? ?????????????? ??????.');
        }

        $file                 = File::storeHttp(null, $uploadedFile);
        $file->caption        = $request->input('caption');
        $file->attach_context = $request->input('context');
        $file->description    = $request->input('description');
        $file->save();

        return redirect()->route('admin.files.index')->with('success', "???????? {$file->caption} ?????????? ????.");
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

        return view('cms::admin.files.show', ['file' => $file]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(File $file)
    {
        return view('cms::admin.files.edit', ['file' => $file]);
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

        return redirect()->route('admin.files.index')->with('info', "???????? {$file->caption} ?????????? ????.");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(File $file)
    {
        $file->delete();

        return redirect()->route('admin.files.index')->with('warning', "???????? {$file->caption} ?????? ????.");
    }
}
