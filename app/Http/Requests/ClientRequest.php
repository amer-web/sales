<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|string',
            'email'=> 'email|unique:clients,email|nullable',
            'address'=> 'string|nullable',
            'phone'=> 'string|numeric|regex:/^(01)[0-9]{9}/i|nullable'
        ];
    }
    public function messages()
    {
        return [
            'name.required' => 'يرجى إدخال اسم العميل',
            'name.string' => 'يرجى إدخال العنوان بشكل صحيح',
            'email.email' => 'يرجى إدخال الايميل بشكل صحيح',
            'email.unique' => ' يرجى استخدام ايميل آخر لان الايميل هذا موجود بالفعل',
            'address.string' => 'يرجى إدخال العنوان بشكل صحيح',
            'phone.string' => 'يرجى إدخال رقم الهاتف بشكل صحيح',
            'phone.numeric' => 'يرجى إدخال رقم الهاتف بشكل صحيح',
            'phone.regex' => 'يرجى إدخال رقم الهاتف بشكل صحيح',
        ];
    }
}
