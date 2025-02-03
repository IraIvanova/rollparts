@extends('store.base')

@section('metaTitle'){{ trans('interface.meta.title.categories') }}@endsection
@section('metaDescription'){{ trans('interface.meta.description.categories') }}@endsection

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5">
    <div>
        @include('store.components.breadcrumbs')

        <div class="rp-categories-list-area rp-design ">
            <div class="container container-xxxl">
                <div class="row">
                    <div class="col-md-12">
                        <div class="rp-section-header" style="justify-content:left">
                            <div class="rp-section-header-title">
                                <h2>Categories</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="rp-categories-list">
                            @foreach($categories as $category)
                                @include('store.components.categories.item', $category)
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </section>
@endsection
