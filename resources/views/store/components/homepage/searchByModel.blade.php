<div class="search-container bg-gray-gradient">
    <div class="container container-xxxl container-xxl">
        <div class="search-box position-relative w-75 m-auto">
            <span class="position-absolute" id="icon-search"><img src="{{asset('images/search-icon.png')}}"></span>
            <h2 class="search-title">Find the right tuning parts for your car and get started!</h2>

            <div class="search-form pt-3">
                <form action="{{ route('searchByMakesAndModel') }}">
                    <div class="row align-items-center">
                        <div class="search-fields col-12 col-lg-10">
                            <div class="row">
                                <div class="search-field col-lg-4">
                                    <label>Brand</label>
                                    <select id="make" class="select-dropdown" name="carMakes"
                                            data-action="{{ route('getModelsByMake') }}">
                                        <option value="" selected disabled>Brand</option>
                                        @foreach($makes as $make)
                                            <option value="{{$make->name}}">{{$make->name}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="search-field col-lg-4">
                                    <label>Model</label>
                                    <select id="model" class="select-dropdown form-select" name="carModels"
                                            data-action="{{ route('getManufactureYearsForModel') }}" disabled>
{{--                                        <option value="" selected disabled>Select model</option>--}}
                                    </select>
                                </div>

                                <div class="search-field col-lg-4">
                                    <label>Year of manufacture</label>
                                    <select id="yearMnf" class="select-dropdown" name="year" disabled>
{{--                                        <option value="" selected disabled>Year of manufacture</option>--}}
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-2">
                            <button class="search-button" disabled>
                                SEARCH
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
