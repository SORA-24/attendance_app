<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
            return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'date' => 'required',
            'start_h' => 'required|between:1,22' ,
            'start_m' => 'required|integer' ,
            'end_h' => 'required|between:1,22' ,
            'end_m' => 'required|integer' ,
            'comment' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'date.required' =>  '日にちを入力してください',
            'start_h.required' =>  '開始時間を正しくしてください',
            'start_m.required' =>  '開始時間を正しくしてください',
            'end_h.required' =>  '終了時間を正しくしてください',
            'end_m.required' =>  '終了時間を正しくしてください',
            'comment.required' =>  'コメントを入力してください',
            'start_h.between' =>  '開始時間は開始時間を正しくしてください',
            'end_h.between' =>  '終了時間は開始時間を正しくしてください',
        ];
    }
}
