<?php

namespace App\Http\Requests;

use App\Models\Boards;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;

class GetBoardRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $board = Boards::find($this->route('id'));
        return $board && $this->user()->can('view', $board);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', 'integer'],
        ];
    }
}
