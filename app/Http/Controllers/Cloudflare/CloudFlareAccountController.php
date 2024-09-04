<?php

namespace App\Http\Controllers\Cloudflare;

use App\Http\Controllers\Controller;
use App\Http\Requests\CloudFlareAccount\StoreRequest;
use App\Http\Resources\CloudflareAccount\CloudflareAccountResource;
use App\Models\CloudflareAccount;
use Illuminate\Http\Response;

class CloudFlareAccountController extends Controller
{
    public function index()
    {
        $cloudflareAccounts = CloudflareAccountResource::collection(auth()->user()->cloudflareAccounts)->resolve();

        return inertia('Cloudflare/Account/Index', compact('cloudflareAccounts'));
    }
    public function create()
    {
        return inertia('Cloudflare/Account/Create');
    }
    public function store(StoreRequest $request)
    {
        $data = $request->validationData();
        $account = CloudFlareAccount::create($data);
        return CloudflareAccountResource::make($account)->resolve();
    }
    public function show(CloudflareAccount $cloudflareAccount)
    {
        $cloudflareAccount = CloudflareAccountResource::make($cloudflareAccount)->resolve();
        return inertia('Cloudflare/Account/Show', compact('cloudflareAccount'));
    }
    public function destroy(CloudflareAccount $cloudflareAccount)
    {
        $cloudflareAccount->delete();
        return response([], Response::HTTP_NO_CONTENT);
    }
}
