<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CommentRequest extends FormRequest
{
    public function rules()
    {
        return [
            'comment' => 'required|string|max:60',
        ];
    }

    public function authorize()
    {
        return true;
    }
}
