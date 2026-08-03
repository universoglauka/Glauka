<?php

namespace App\Http\Requests;

use App\Models\Productor;
use Illuminate\Foundation\Http\FormRequest;

class ProducerUpdateRequest extends FormRequest
{
  /**
   * Determine if the user is authorized to make this request.
   */
  public function authorize(): bool
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
   */
  public function rules(): array
  {
    return Productor::profileProducerRulesEdit();
  }

  public function messages(): array
  {
    return Productor::messagesProfileProducerRulesEdit;
  }
}
