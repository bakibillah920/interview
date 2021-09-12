@extends('layouts.app')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Edit Product</h1>
</div>
<section>
    <form method="POST" action="{{ url('product/update') }}" accept-charset="UTF-8" class="form-horizontal" id="userId" enctype="multipart/form-data">
    {{ method_field('PUT') }}
    @csrf  
        <div class="row">
        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <div class="form-group">
                        <label for="">Product Name</label>
                        <input type="text"  placeholder="Product Name" class="form-control" name="title" value="{!!$targetArr->title!!}">
                    </div>
                    <div class="form-group">
                        <label for="">Product SKU</label>
                        <input type="text" placeholder="Product Name" class="form-control" name="sku" value="{!!$targetArr->sku!!}">
                    </div>
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea id="" cols="30" rows="4" class="form-control" name="description" >{!!$targetArr->description!!}</textarea>
                    </div>
                </div>
            </div>

            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Media</h6>
                </div>
                <div class="card-body border">

                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Variants</h6>
                </div>
                <div class="card-body">

                    <div class="row" id="k">
                        @if(!empty($variantListArr))
                        @foreach($variantListArr as $vId =>$vArr)
                        <?php
                        $totalVar = count($variantListArr);
                        ?>
                        <div class="col-md-12 variant-{{$vId}}">
                            <div class="col-md-6 pull-left">
                                <div class="form-group">
                                    <label class="text-primary" for="">Option</label>
                                    <br />
                                    <select class="form-control variantid" name="variant_id[{!!$vId!!}]" id="variantid">
                                        @if(!empty($variants))
                                        @foreach($variants as $k=>$variant)
                                        <option value="{{$k}}" {{($vId==$k)?'selected':''}}>
                                            {{$variant}}
                                        </option>
                                        @endforeach
                                        @endif
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6 pull-right">
                                <div class="form-group">
                                    <label class="float-right text-primary remove" data-id="{{$vId}}" style="cursor: pointer;">Remove</label>
                                    <select class="form-control" name="variant_name[{!!$vId!!}][]" multiple >
                                        @foreach($vArr as $k =>$variant)
                                        <option value="{{$variant}}" selected>
                                            {{$variant}}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        @endif
                    </div>

                </div>

                <div class="card-footer">
                    <button class="btn btn-primary" id="addVariant" type="button">Add another option</button>
                </div>

                <div class="card-header text-uppercase">Preview</div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <td>Variant</td>
                                    <td>Price</td>
                                    <td>Stock</td>
                                </tr>
                            </thead>
                            <tbody> 

                                @if(!empty($previewArr->ProductVariantPrice))
                                @foreach($previewArr->ProductVariantPrice as $productVariant)
                                <tr>
                                    <td> 
                                        {{$productVariant->one_variant}} /
                                        {{$productVariant->two_variant}} 
                                        {{!empty($productVariant->three_variant)?'/'.$productVariant->three_variant:''}}
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="{{ number_format($productVariant->price,2) }}">
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="{{ number_format($productVariant->stock,2) }}">
                                    </td>
                                </tr> 
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <button type="submit" class="btn btn-lg btn-primary">Save</button>
    <button type="button" class="btn btn-secondary btn-lg">Cancel</button>
    </form>
</section>

<script type="text/javascript">
    $(document).ready(function () {
        $(".js-example-responsive").select2({
            width: 'resolve' // need to override the changed default
        });
        $(document).on("click", '#addVariant', function (e) {
            $('.js-example-responsive').select2();
        });
        $(document).on("click", '.remove', function (e) {
            var id = $(this).attr("data-id");
            $(".variant-" + id).remove();
            return false;
        });

    });
</script>
@endsection
