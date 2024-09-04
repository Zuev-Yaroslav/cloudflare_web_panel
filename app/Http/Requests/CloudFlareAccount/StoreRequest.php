<?php

namespace App\Http\Requests\CloudFlareAccount;

use App\Exceptions\Cloudflare\CloudflareAccountException;
use App\HttpClients\Cloudflare\AccountHttpClient;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
        return [
            'account_id' => 'required|string|unique:cloudflare_accounts,account_id',
            'email' => 'required|string|unique:cloudflare_accounts,email',
            'api_key' => 'required|string|unique:cloudflare_accounts,api_key'
        ];
    }
    protected function passedValidation(): void
    {
        $data = $this->validated();
        $result = AccountHttpClient::make()
            ->auth($data)
            ->show($this->account_id);
        $data['user_id'] = auth()->id();
        $data['name'] = $result['result']['name'];
        $this->replace($data);
    }
}
