<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\RepairAttachment;
use App\Models\RepairAttachmentItem;
use App\Http\Requests\RepairAttachmentRequest;
use Illuminate\Http\Request;

class RepairAttachmentController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:repair_attachment-list|repair_attachment-create|repair_attachment-edit|repair_attachment-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:repair_attachment-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:repair_attachment-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:repair_attachment-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $repair_attachment = RepairAttachment::all();
        return view('repair_attachment.index', ['repair_attachment' => $repair_attachment]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $repair_attachment = null;
        $repairAttachmentItems = RepairAttachmentItem::all();
        return view('repair_attachment.create', compact('repair_attachment', 'repairAttachmentItems'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RepairAttachmentRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RepairAttachmentRequest $request)
    {
        $repair_attachment = new RepairAttachment;
        $repair_attachment->title = $request->input('title');
        $repair_attachment->description = $request->input('description');
        $repair_attachment->save();

        return to_route('master.repair_attachment.index')->with('toast_success', 'Data Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $repair_attachment = RepairAttachment::findOrFail($id);
        return view('repair_attachment.show', ['repair_attachment' => $repair_attachment]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $repair_attachment = RepairAttachment::findOrFail($id);
        $repairAttachmentItems = RepairAttachmentItem::all();
        return view(
            'repair_attachment.edit',
            compact('repair_attachment', 'repairAttachmentItems')

        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RepairAttachmentRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RepairAttachmentRequest $request, $id)
    {
        $repair_attachment = RepairAttachment::findOrFail($id);
        $repair_attachment->title = $request->input('title');
        $repair_attachment->description = $request->input('description');
        $repair_attachment->items()->detach();
        $repair_attachment->items()->attach($request->input('attachment_items'));
        $repair_attachment->save();

        return to_route('master.repair_attachment.index')->with('toast_success', 'Data Berhasil Di Ubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $repair_attachment = RepairAttachment::findOrFail($id);
        $repair_attachment->delete();

        return to_route('master.repair_attachment.index')->with('toast_success', 'Data Berhasil Di Hapus');
    }
}
