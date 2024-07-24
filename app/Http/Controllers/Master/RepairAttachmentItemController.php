<?php

namespace App\Http\Controllers\Master;

use App\Http\Controllers\Controller;
use App\Models\RepairAttachmentItem;
use App\Http\Requests\RepairAttachmentItemRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use Illuminate\Http\Request;

class RepairAttachmentItemController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:repair_attachment_item-list|repair_attachment_item-create|repair_attachment_item-edit|repair_attachment_item-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:repair_attachment_item-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:repair_attachment_item-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:repair_attachment_item-delete', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index()
    {
        $repair_attachment_items = RepairAttachmentItem::all();
        return view('repair_attachment_item.index', ['repair_attachment_items' => $repair_attachment_items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {

        return view('repair_attachment_item.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  RepairAttachmentItemRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RepairAttachmentItemRequest $request)
    {
        $imagePath = null;
        if ($request->file('image')) {
            // Validate the form data
            $imagePath = uploadFile('image', 'public/images/repair_attachment_item', null, false, 'repair_attachment_item');
        }
        $repair_attachment_item = new RepairAttachmentItem;

        $repair_attachment_item->title = $request->input('title');
        $repair_attachment_item->description = $request->input('description');
        $repair_attachment_item->row_count = $request->input('row_count');
        $repair_attachment_item->image_capture_time = $request->input('image_capture_time');
        $repair_attachment_item->image = asset('storage/images/repair_attachment_item/' . $imagePath);
        $repair_attachment_item->save();

        return to_route('master.repair_attachment_item.index')->with('toast_success', 'Data RepairAttachmentItem Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function show($id)
    {
        $repair_attachment_item = RepairAttachmentItem::findOrFail($id);
        return view('repair_attachment_item.show', ['repair_attachment_item' => $repair_attachment_item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\View\View
     */
    public function edit($id)
    {
        $repair_attachment_item = RepairAttachmentItem::findOrFail($id);
        return view('repair_attachment_item.edit', ['repair_attachment_item' => $repair_attachment_item]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  RepairAttachmentItemRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(RepairAttachmentItemRequest $request, $id)
    {
        $repair_attachment_item = RepairAttachmentItem::findOrFail($id);
        $imagePath = $repair_attachment_item->image;
        if ($request->file('image')) {
            $imagePath = uploadFile('image', 'public/images/repair_attachment_item', $repair_attachment_item->image, false, 'repair_attachment_item');
        }
        $repair_attachment_item->title = $request->input('title');
        $repair_attachment_item->description = $request->input('description');
        $repair_attachment_item->row_count = $request->input('row_count');
        $repair_attachment_item->image_capture_time = $request->input('image_capture_time');
        $repair_attachment_item->image = $request->file('image') ? asset('storage/images/repair_attachment_item/' . $imagePath) : $imagePath;
        $repair_attachment_item->save();

        return to_route('master.repair_attachment_item.index')->with('toast_success', 'Data RepairAttachmentItem Berhasil Diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $repair_attachment_item = RepairAttachmentItem::findOrFail($id);
        $repair_attachment_item->delete();

        return to_route('master.repair_attachment_item.index')->with('toast_success', 'Data RepairAttachmentItem Berhasil Dihapus');
    }
}
