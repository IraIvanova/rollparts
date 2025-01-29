@extends('store.base')

@section('bodyContent')
    <section id="main-content" class="container container-xxxl py-5">
    <div>
        @include('store.components.breadcrumbs')

        <div class="rollparts-categories-list-area rollparts-design ">
            <div class="container container-xxxl">
                <div class="row">
                    <div class="col-md-12">
                        <div class="rollparts-section-header" style="justify-content:left">
                            <div class="rollparts-section-header-title">
                                <h2>Categories</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="rollparts-categories-list">
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
