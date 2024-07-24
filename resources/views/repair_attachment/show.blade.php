@extends('layouts.admin')
@section('title', '')
@section('content')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h1>{{ $repair_attachment->title ?? 'Repair Attachment Details' }}</h1>
                    </div>

                    <div class="card-body">
                        @if ($repair_attachment)
                            <p><strong>Description:</strong> {{ $repair_attachment->description }}</p>
                            <!-- Display associated repair attachment items -->
                            @if ($repair_attachment->items->count() > 0)
                                <h3>Associated Repair Attachment Items:</h3>
                                <ul>
                                    @foreach ($repair_attachment->items as $attachment)
                                        <li>{{ $attachment->title }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <p>No associated repair attachment items.</p>
                            @endif
                        @else
                            <p>Repair attachment not found.</p>
                        @endif
                    </div>
                    <div class="card-footer">
                        <a href="{{ route('master.repair_attachment.edit', $repair_attachment->id) }}"
                            class="btn btn-primary">Edit</a>
                        <a href="{{ route('master.repair_attachment.index') }}" class="btn btn-secondary">Back</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@endsection
