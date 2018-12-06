<div class="box-body">
    {!! Form::i18nInput('name', trans('location::locations.form.name'), $errors, $lang, null, ['data-slug'=>'source']) !!}

    {!! Form::i18nInput('slug', trans('location::locations.form.slug'), $errors, $lang, null, ['data-slug'=>'target']) !!}

    <div class="row">
        <div class="col-md-6">
            {!! Form::i18nInput('phone1', trans('location::locations.form.phone1'), $errors, $lang, null) !!}
        </div>
        <div class="col-md-6">
            {!! Form::i18nInput('phone2', trans('location::locations.form.phone2'), $errors, $lang, null) !!}
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            {!! Form::i18nInput('fax', trans('location::locations.form.fax'), $errors, $lang, null) !!}
        </div>
        <div class="col-md-6">
            {!! Form::i18nInput('mobile', trans('location::locations.form.mobile'), $errors, $lang, null) !!}
        </div>
    </div>

    {!! Form::i18nInput('email', trans('location::locations.form.email'), $errors, $lang, null) !!}
</div>
