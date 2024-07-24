<div class="col-12">
    <div class="row g-3">
        <div class="col-12">
            <h3>List AC Service</h3>
        </div>
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <th>Nama Servis</th>
                        <th>Nama AC</th>
                        <th>Aksi</th>
                    </thead>
                    <tbody>
                        @foreach ($order->order_details()->where('order_detail_status', 2)->get() as $order_detail)
                            <tr>
                                <td>{{ $order_detail->service()->withTrashed()->first()->name }}</td>
                                <td>{{ $order_detail->master_ac?->ac?->ac_full_name }}</td>
                                <td>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
