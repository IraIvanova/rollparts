@if($product->carModels->count() > 0)
    <section class="compatible-models">
        <p>{{ trans('interface.product.compatibleModels') }}</p>
        <div class="d-flex">
            @foreach ($product->carModels as $model)
                <div class="badge badge-main mr-2">
                    {{ $model->make->name }} {{ $model->model }}
                </div>
            @endforeach
        </div>
    </section>
@endif
