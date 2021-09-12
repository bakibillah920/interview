@extends('layouts.app')

@section('content')

<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Products</h1>
</div>


<div class="card">
    <form action="" method="get" class="card-header">
        <div class="form-row justify-content-between">
            <div class="col-md-2">
                <input type="text" name="title" placeholder="Product Title" class="form-control" value="{{Request::get('title')}}">
            </div>
            <div class="col-md-2">
                <select name="variant_id" id="" class="form-control">
                    @if(!empty($variantListArr))

                    <option value="">--Select Variant--</option>
                    @foreach($variantListArr as $vId =>$vArr)
                    <optgroup label="{!! $variantNameArr[$vId] !!}">
                        @foreach($vArr as $k =>$variant)
                        <option value="{{$variant}}" {{($variant==Request::get('variant_id'))?'selected':''  }}>{!! $variant !!}</option>
                        @endforeach
                    </optgroup>
                    @endforeach
                    @endif
                </select>
            </div>

            <div class="col-md-3">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text">Price Range</span>
                    </div>
                    <input type="text" name="price_from" aria-label="First name" placeholder="From" class="form-control" value="{{Request::get('price_from')}}">
                    <input type="text" name="price_to" aria-label="Last name" placeholder="To" class="form-control" value="{{Request::get('price_to')}}">
                </div>
            </div>
            <div class="col-md-2">
                <input type="date" name="date" placeholder="Date" class="form-control" value="{{Request::get('date')}}">
            </div>
            <div class="col-md-1">
                <button type="submit" class="btn btn-primary float-right"><i class="fa fa-search"></i></button>
            </div>
        </div>
    </form>

    <div class="card-body">
        <div class="table-response">
            <table class="table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Title</th>
                        <th>Description</th>
                        <th>Variant</th>
                        <th width="150px">Action</th>
                    </tr>
                </thead>

                <tbody>
                    @if(!$targetArr->isEmpty())
                    <?php
                    $page = Request::get('page');
                    $page = empty($page) ? 1 : $page;
                    $sl = ($page - 1) * 3;
                    ?>
                    @foreach($targetArr as $target)
                    <tr>
                        <td>{{ ++$sl }}</td>
                        <td width="20%">{!! $target->title !!} <br> Created at : {!! date_format($target->created_at,"d M Y")!!}</td>
                        <td>{!! $target->description !!}</td>
                        <td width="35%">
                            @if(!empty($target->ProductVariantPrice))
                            @foreach($target->ProductVariantPrice as $productVariant)
                            <dl class="row mb-0" style="height: 70px; overflow: hidden" id="variant">
                                <dt class="col-sm-3 pb-0">
                                    {{$productVariant->one_variant}} /
                                    {{$productVariant->two_variant}} 
                                    {{!empty($productVariant->three_variant)?'/'.$productVariant->three_variant:''}}
                                </dt>
                                <dd class="col-sm-9">
                                    <dl class="row mb-0">
                                        <dt class="col-sm-4 pb-0">Price : {{ number_format($productVariant->price,2) }}</dt>
                                        <dd class="col-sm-8 pb-0">InStock : {{ number_format($productVariant->stock,2) }}</dd>
                                    </dl>
                                </dd>
                            </dl>
                            @endforeach
                            @endif
                            <button onclick="$('#variant').toggleClass('h-auto')" class="btn btn-sm btn-link">Show more</button>
                        </td>
                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('product.edit', $target->id) }}" class="btn btn-success">Edit</a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                    @endif
                </tbody>

            </table>
        </div>

    </div>

    <div class="card-footer">
        <div class="row justify-content-between">
            <div class="col-md-6">
                <?php
                $start = empty($targetArr->total()) ? 0 : (($targetArr->currentPage() - 1) * $targetArr->perPage() + 1);
                $end = ($targetArr->currentPage() * $targetArr->perPage() > $targetArr->total()) ? $targetArr->total() : ($targetArr->currentPage() * $targetArr->perPage());
                ?>
                <p>Showing {{ $start }} to {{$end}} out of {{$targetArr->total()}}</p>
            </div>
            <div class="col-md-3">
                {{ $targetArr->appends(Request::all())->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
