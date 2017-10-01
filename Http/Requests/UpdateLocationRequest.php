<?php

namespace Modules\Location\Http\Requests;

use Modules\Core\Internationalisation\BaseFormRequest;

class UpdateLocationRequest extends BaseFormRequest
{
    protected $translationsAttributesKey = 'location::locations.form';

    public function rules()
    {
        return [
            'address'    => 'required',
            'country_id' => 'required|integer',
            'city_id'    => 'required|integer',
            'ordering'   => 'required'
        ];
    }

    public function attributes()
    {
        return trans('location::locations.form');
    }

    public function translationRules()
    {
        return [
            'name' => 'required|max:200',
            'slug' => 'required|max:200'
        ];
    }

    public function authorize()
    {
        return true;
    }

    public function messages()
    {
        return [];
    }

    public function translationMessages()
    {
        return [];
    }
}
