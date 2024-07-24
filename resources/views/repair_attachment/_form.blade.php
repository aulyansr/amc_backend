<div class="mb-3">
    {{ Form::label('title', 'title', ['class' => 'form-label']) }}
    {{ Form::text('title', null, ['class' => 'form-control']) }}
</div>
<div class="mb-3">
    {{ Form::label('description', 'description', ['class' => 'form-label']) }}
    {{ Form::textarea('description', null, ['class' => 'form-control', 'rows' => '5']) }}
</div>
<div class="mb-3">
    <h3>Select Repair Activity:</h3>
    @foreach ($repairAttachmentItems as $item)
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="attachment_items[]" value="{{ $item->id }}"
                id="attachment_item_{{ $item->id }}"
                {{ $repair_attachment && $repair_attachment->items->contains($item->id) ? 'checked' : '' }}>
            <label class="form-check-label" for="attachment_item_{{ $item->id }}">
                {{ $item->title }}
            </label>
        </div>
    @endforeach
</div>
