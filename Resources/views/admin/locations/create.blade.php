@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('location::locations.title.create location') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i
                        class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li>
            <a href="{{ route('admin.location.location.index') }}">{{ trans('location::locations.title.locations') }}</a>
        </li>
        <li class="active">{{ trans('location::locations.title.create location') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.location.location.store'], 'method' => 'post']) !!}
    <div class="row">
        <div class="col-md-10">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('location::admin.locations.partials.create-fields', ['lang' => $locale])
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="box" id="app">
                <div class="box-header">
                    <h3 class="box-title">{{ trans('location::locations.table.address information') }}</h3>
                </div>
                <div class="box-body">
                    <div class="row">
                        <div class="col-md-9">
                            {!! Form::normalInput('address', trans('location::locations.form.address'), $errors, old('address'), ['id'=>'address', 'v-model'=>'address','@change'=>'findAddress']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::normalInput('postcode', trans('location::locations.form.postcode'), $errors, old('postcode')) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            {!! Form::normalInput('lat', trans('location::locations.form.lat'), $errors, old('lat'), ['id'=>'lat', 'v-model'=>'lat']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::normalInput('long', trans('location::locations.form.long'), $errors, old('long'), ['id'=>'long', 'v-model'=>'long']) !!}
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label("city_id", trans('location::locations.form.city_id')) !!}
                                <select name="city_id" class="form-control" v-model="cityId">
                                    <option value=""
                                            selected>{!! trans("location::locations.form.select city") !!}</option>
                                    <option v-for="(item, key) in cities" v-bind:value="key">@{{ item}}</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                {!! Form::label("country_id", trans('location::locations.form.country_id')) !!}
                                <select name="country_id" class="form-control" v-on:change="onChange"
                                        v-model="countryId">
                                    <option value=""
                                            selected>{!! trans("location::locations.form.select country") !!}</option>
                                    <option v-for="(item, key) in countries" v-bind:value="key">@{{ item}}</option>
                                </select>
                                {!! $errors->first("country_id", '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div id="map"></div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.create') }}</button>
                <button class="btn btn-default btn-flat" name="button"
                        type="reset">{{ trans('core::core.button.reset') }}</button>
                <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.location.location.index')}}"><i
                            class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box">
                <div class="box-body">
                    @mediaSingle('locationImage', null, null, "Resim")

                    {!! Form::normalInput('ordering', trans('location::locations.form.ordering'), $errors) !!}

                    {!! Form::normalCheckbox('status', trans('location::locations.form.status'), $errors) !!}
                </div>
            </div>
        </div>
    </div>
    {!! Form::close() !!}
@stop

@section('footer')
    <a data-toggle="modal" data-target="#keyboardShortcutsModal"><i class="fa fa-keyboard-o"></i></a> &nbsp;
@stop
@section('shortcuts')
    <dl class="dl-horizontal">
        <dt><code>b</code></dt>
        <dd>{{ trans('core::core.back to index') }}</dd>
    </dl>
@stop

@push('js-stack')
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
@endpush

@push('js-stack')
    <script type="text/javascript">
        $(document).ready(function () {
            $(document).keypressAction({
                actions: [
                    {key: 'b', route: "<?= route('admin.location.location.index') ?>"}
                ]
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('input[type="checkbox"].flat-blue, input[type="radio"].flat-blue').iCheck({
                checkboxClass: 'icheckbox_flat-blue',
                radioClass: 'iradio_flat-blue'
            });
        });
    </script>
    <script src="{!! Module::asset('location:js/vue.js') !!}"></script>
    <script src="{!! Module::asset('location:js/axios.min.js') !!}"></script>
    <script>
        axios.defaults.headers.common['X-CSRF-TOKEN'] = document.querySelector('meta[name="token"]').getAttribute('content');
        axios.defaults.headers.common['Authorization'] = AuthorizationHeaderValue;
        Vue.config.debug = true;
        Vue.config.devtools = true;
        new Vue({
            el: '#app',
            data: {
                loading: false,
                countries: ['turkey'],
                cities: [],
                countryId: 1,
                cityId: 6,
                address: '{{ old('address') }}',
                cityName: '',
                countryName: '',
                lat: '{{ old('lat') }}',
                long: '{{ old('long') }}'
            },
            created() {
                this.getCountries();
                this.getCities(this.countryId);
            },
            mounted() {
                let t = setInterval(() => {
                    if (document.readyState === 'complete') {
                        clearInterval(t);
                    }
                }, 500);
                this.createGoogleMaps()
                    .then(this.initGoogleMaps, this.googleMapsFailedToLoad);
            },
            methods: {
                getCountries: function () {
                    this.loading = true;
                    axios.get("{{ route('api.localization.countries') }}")
                        .then(response => {
                            this.countries = response.data.data;
                            this.countryName = this.countries[this.countryId];
                            this.findAddress();
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                    this.loading = false;
                },
                getCities: function (country_id) {
                    axios.get("{{ route('api.localization.cities') }}?id=" + country_id)
                        .then(response => {
                            this.cities = response.data.data;
                            this.cityName = this.cities[this.cityId];
                            this.findAddress();
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                onChange: function () {
                    if (this.countryId) {
                        this.getCities(this.countryId);
                    } else {
                        this.cities = [];
                    }
                },
                createGoogleMaps: function () {
                    return new Promise((resolve, reject) => {
                        let gmap = document.createElement('script');
                        gmap.src = `https://maps.googleapis.com/maps/api/js?key=AIzaSyBpvcV4WyemrP7OUfrDuXTkEaazIzwqe1U`;
                        gmap.type = 'text/javascript';
                        gmap.onload = resolve;
                        gmap.onerror = reject;
                        gmap.async = true;
                        gmap.defer = true;
                        document.body.appendChild(gmap);
                    })
                },
                initGoogleMaps: function () {
                    this.vueGMap = new google.maps.Map(document.getElementById('map'), {
                        zoom: 16
                    });
                    this.findAddress();
                },
                getMarker: function (map) {
                    return new google.maps.Marker({
                        map: map
                    });
                },
                findAddress: function () {
                    var map = this.vueGMap;
                    this.vueGeocoder = new google.maps.Geocoder();
                    var marker = this.getMarker(map);
                    this.vueGeocoder.geocode({'address': this.address + ' ' + this.cityName + ' ' + this.countryName}, function (results, status) {
                        if (status === 'OK') {
                            marker.setPosition(results[0].geometry.location);
                            map.setCenter(results[0].geometry.location);
                            document.getElementById('lat').value = results[0].geometry.location.lat();
                            document.getElementById('long').value = results[0].geometry.location.lng();
                        }
                    });
                    google.maps.event.addListener(map, 'click', function (args) {
                        marker.setPosition(args.latLng);
                        document.getElementById('lat').value = args.latLng.lat();
                        document.getElementById('long').value = args.latLng.lng();
                    });
                }
            }
        })
    </script>
@endpush
