<div class="col-12">
    <div class="row g-3">
        <div class="col-lg-6">
            <h3>Tugaskan Team</h3>
        </div>
        <div class="col-lg-6 text-lg-end">
            <button class="btn btn-primary" id="add_team"><i class="mdi mdi-account-multiple-plus pe-3"></i>Tambah
                Team</button>
        </div>
    </div>
</div>
<form action="{{ route('orders.assignteam', $order->id) }}" method="post">
    @method('PUT')
    @csrf
    <div class="row g-3">
        @if ($errors->any())
            <div class="col-12">
                <div class="alert alert-danger">
                    <strong>Whoops!</strong>Something went wrong.<br><br>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif
        <div class="col-12">
            <div class="row g-3" id="team_row">
                <div class="col-lg-6 col-12 team_form">
                    <div class="form-group">
                        <div class="row g-3 align-items-center">
                            <div class="col-6">
                                <label for="team_id0">Team</label>
                            </div>
                            <div class="col-6 text-end">
                                <button class="btn btn-danger btn-sm delete_team"><i
                                        class="mdi mdi-trash-can"></i></button>
                            </div>
                            <div class="col-12">
                                <select name="team_id[]" id="team_id0" class="form-control">
                                    <option value=""></option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 text-end">
            <button type="submit" class="btn btn-primary">Assign Team</button>
        </div>
    </div>
</form>
