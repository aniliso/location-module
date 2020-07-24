@extends('layouts.master')

@section('content-header')
    <h1>
        {{ trans('location::locations.title.edit location') }}
    </h1>
    <ol class="breadcrumb">
        <li><a href="{{ route('dashboard.index') }}"><i class="fa fa-dashboard"></i> {{ trans('core::core.breadcrumb.home') }}</a></li>
        <li><a href="{{ route('admin.location.location.index') }}">{{ trans('location::locations.title.locations') }}</a></li>
        <li class="active">{{ trans('location::locations.title.edit location') }}</li>
    </ol>
@stop

@section('content')
    {!! Form::open(['route' => ['admin.location.location.update', $location->id], 'method' => 'put']) !!}
    <div class="row">
        <div class="col-md-10">
            <div class="nav-tabs-custom">
                @include('partials.form-tab-headers')
                <div class="tab-content">
                    <?php $i = 0; ?>
                    @foreach (LaravelLocalization::getSupportedLocales() as $locale => $language)
                        <?php $i++; ?>
                        <div class="tab-pane {{ locale() == $locale ? 'active' : '' }}" id="tab_{{ $i }}">
                            @include('location::admin.locations.partials.edit-fields', ['lang' => $locale])
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
                            {!! Form::normalInput('address', trans('location::locations.form.address'), $errors, $location, ['id'=>'address', 'v-model'=>'address','@change'=>'findAddress']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::normalInput('postcode', trans('location::locations.form.postcode'), $errors, $location) !!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-3">
                            {!! Form::normalInput('lat', trans('location::locations.form.lat'), $errors, $location, ['id'=>'lat', 'v-model'=>'lat']) !!}
                        </div>
                        <div class="col-md-3">
                            {!! Form::normalInput('long', trans('location::locations.form.long'), $errors, $location, ['id'=>'long', 'v-model'=>'long']) !!}
                        </div>
                        <div class="col-md-3">
                            <div class="form-group{{ $errors->has("city_id") ? ' has-error' : '' }}">
                                {!! Form::label("city_id", trans('location::locations.form.city_id')) !!}
                                <select name="city_id" class="form-control" v-model="city_id" v-on:change="onChange">
                                    <option value="" selected>{!! trans("location::locations.form.select city") !!}</option>
                                    <option v-for="(item, key) in cities" :value="key" :selected="city_id == key">@{{ item}}</option>
                                </select>
                                {!! $errors->first("city_id", '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group{{ $errors->has("country_id") ? ' has-error' : '' }}">
                                {!! Form::label("country_id", trans('location::locations.form.country_id')) !!}
                                <select name="country_id" class="form-control" v-on:change="onChange" v-model="country_id">
                                    <option value="" selected>{!! trans("location::locations.form.select country") !!}</option>
                                    <option v-for="(item, key) in countries" :value="key" :selected="country_id == key">@{{ item}}</option>
                                </select>
                                {!! $errors->first("country_id", '<span class="help-block">:message</span>') !!}
                            </div>
                        </div>
                    </div>
                </div>
                <div id="map"></div>
            </div>
            <div class="box-footer">
                <button type="submit" class="btn btn-primary btn-flat">{{ trans('core::core.button.update') }}</button>
                <button class="btn btn-default btn-flat" name="button"
                        type="reset">{{ trans('core::core.button.reset') }}</button>
                <a class="btn btn-danger pull-right btn-flat" href="{{ route('admin.location.location.index')}}"><i
                            class="fa fa-times"></i> {{ trans('core::core.button.cancel') }}</a>
            </div>
        </div>
        <div class="col-md-2">
            <div class="box">
                <div class="box-body">
                    @mediaSingle('locationImage', $location, null, "Resim")

                    {!! Form::normalInput('ordering', trans('location::locations.form.ordering'), $errors, $location) !!}

                    {!! Form::normalCheckbox('status', trans('location::locations.form.status'), $errors, $location) !!}
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
                edit: true,
                loading: false,
                countries: ['turkey'],
                cities: [],
                country_id: {{ old('country_id', $location->country_id) }},
                city_id: {{ old('city_id', $location->city_id) }},
                address: '{{ old('address', $location->address) }}',
                cityName: '',
                countryName: '',
                lat: '{{ old('lat', $location->lat) }}',
                long: '{{ old('long', $location->long) }}'
            },
            created() {
                this.getCountries();
                this.getCities(this.country_id);
            },
            mounted() {
                let t = setInterval(() => {
                    if (document.readyState === 'complete') {
                        clearInterval(t);
                    }
                }, 500);
                this.createGoogleMaps()
                    .then(this.initGoogleMaps);

            },
            methods: {
                getCountries: function () {
                    this.loading = true;
                    axios.get("{{ route('api.localization.countries') }}")
                        .then(response => {
                            this.countries = response.data.data;
                            this.countryName = this.countries[this.country_id];
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
                            this.cityName = this.cities[this.city_id];
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                onChange: function () {
                    if (this.country_id) {
                        this.getCities(this.country_id);
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
                findAddress: function (edit=false) {
                    var map = this.vueGMap;
                    this.vueGeocoder = new google.maps.Geocoder();
                    var marker = this.getMarker(map);

                    var address  = this.edit ? {'location': { lat: parseFloat(this.lat), lng: parseFloat(this.long) }} : {'address': this.address + ' ' + this.cityName + ' ' + this.countryName};

                    this.vueGeocoder.geocode(address, function (results, status) {
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

                    this.edit = false;
                }
            }
        })
    </script>
@endpush
