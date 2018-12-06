<div class="box-body">
    {!! Form::i18nInput('name', trans('location::locations.form.name'), $errors, $lang, null, ['data-slug'=>'source']) !!}

    {!! Form::i18nInput('slug', trans('location::locations.form.slug'), $errors, $lang, null, ['data-slug'=>'target']) !!}
</div>
