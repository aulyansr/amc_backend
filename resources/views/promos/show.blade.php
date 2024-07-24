@extends('layouts.admin')
@section('title', '')
@section('content')

    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <td>
                            @if (isset($promo) && $promo->promo_poster)
                                <img id="image-preview" src="{{ $promo->promo_poster }}"
                                    alt="Preview Image"class="mw-100 mb-3">
                            @else
                                -
                            @endif
                        </td>
                        <div class="card-header">
                            <h3 class="card-title">
                                {{ $promo->promo_name }}
                            </h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <p>
                                        {{ $promo->promo_description }}
                                    </p>
                                    <hr>
                                    <a href="" class="btn btn-danger">Disabled Promo</a>
                                </div>
                                <div class="col-md-4">
                                    <h4>Expired Date</h4>
                                    {{ date('d-F-Y', strtotime($promo->expired_date)) }}
                                    <hr>
                                    <h4>Discount Amount</h4>
                                    {{ thousand_rupiah($promo->discount_amount) }}
                                    <hr>
                                    <h4>Used</h4>
                                    {{ $promo->in_use }}
                                    <hr>
                                    <h4>Max Used</h4>
                                    {{ $promo->max_amount }}
                                    <hr>
                                    <h4>Promo Code</h4>
                                    {{ $promo->promo_code }}
                                    <hr>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
