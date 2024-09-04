<?php

namespace App\Http\Controllers\Cloudflare;

use App\Http\Controllers\Controller;
use App\Http\Requests\Domain\StorePageRuleRequest;
use App\Http\Requests\Domain\StoreRequest;
use App\Http\Requests\Domain\UpdatePageRuleRequest;
use App\Http\Requests\Domain\UpdateSettingRequest;
use App\Http\Resources\CloudflareAccount\CloudflareAccountResource;
use App\Http\Resources\Domain\DomainResource;
use App\Http\Resources\PageRule\PageRuleResource;
use App\HttpClients\Cloudflare\PageRuleHttpClient;
use App\HttpClients\Cloudflare\ZoneHttpClient;
use App\Models\CloudflareAccount;
use Illuminate\Http\Response;

class DomainController extends Controller
{
    public function index(CloudflareAccount $cloudflareAccount)
    {
        $domains = DomainResource::collection(ZoneHttpClient::make()
            ->index()['result'])->resolve();
        $cloudflareAccount = PageRuleResource::make($cloudflareAccount)->resolve();
        return inertia('Cloudflare/Account/Domain/Index', compact('domains', 'cloudflareAccount'));
    }
    public function create(CloudflareAccount $cloudflareAccount)
    {
        $cloudflareAccount = PageRuleResource::make($cloudflareAccount)->resolve();
        return inertia('Cloudflare/Account/Domain/Create', compact('cloudflareAccount'));
    }
    public function store(CloudflareAccount $cloudflareAccount, StoreRequest $request)
    {
        $data = $request->validationData();
        $domain = ZoneHttpClient::make()
            ->store($data);
        return DomainResource::make($domain['result'])->resolve();
    }
    public function destroy(CloudflareAccount $cloudflareAccount, string $domainId)
    {
        ZoneHttpClient::make()
            ->destroy($domainId);
        return response([], Response::HTTP_NO_CONTENT);
    }
    public function updateSetting(CloudflareAccount $cloudflareAccount, string $domainId, string $settingId, UpdateSettingRequest $request)
    {
        $data = $request->validated();
        ZoneHttpClient::make()
            ->updateSetting($domainId, $settingId, $data);
        return DomainResource::make(ZoneHttpClient::make()
            ->auth($cloudflareAccount->toArray())
            ->show($domainId)['result'])->resolve();
    }
    public function edit(CloudflareAccount $cloudflareAccount, string $domainId)
    {
        $domain = DomainResource::make(ZoneHttpClient::make()
            ->show($domainId)['result'])->resolve();
        $cloudflareAccount = PageRuleResource::make($cloudflareAccount)->resolve();
        return inertia('Cloudflare/Account/Domain/Edit', compact('domain', 'cloudflareAccount'));
    }
    public function storePageRule(CloudflareAccount $cloudflareAccount, string $domainId, StorePageRuleRequest $request)
    {
        $data = $request->validationData();
        $pageRule = PageRuleHttpClient::make()->store($domainId, $data)['result'];
        return PageRuleResource::make($pageRule)->resolve();
    }
    public function updatePageRule(CloudflareAccount $cloudflareAccount, string $domainId, string $pageRuleId, UpdatePageRuleRequest $request)
    {
        $data = $request->validationData();
        $pageRule = PageRuleHttpClient::make()->update($domainId, $pageRuleId , $data)['result'];
        return PageRuleResource::make($pageRule)->resolve();
    }
    public function indexPageRule(CloudflareAccount $cloudflareAccount, string $domainId)
    {
        $pageRules = PageRuleResource::collection(PageRuleHttpClient::make()->index($domainId)['result'])->resolve();
        $domain = DomainResource::make(ZoneHttpClient::make()
            ->show($domainId)['result'])->resolve();
        $cloudflareAccount = CloudflareAccountResource::make($cloudflareAccount)->resolve();
        return inertia('Cloudflare/Account/Domain/PageRule/Index', compact('pageRules', 'cloudflareAccount', 'domain'));
    }
    public function createPageRule(CloudflareAccount $cloudflareAccount, string $domainId)
    {
        $domain = DomainResource::make(ZoneHttpClient::make()
            ->show($domainId)['result'])->resolve();
        $cloudflareAccount = CloudflareAccountResource::make($cloudflareAccount)->resolve();
        return inertia('Cloudflare/Account/Domain/PageRule/Create', compact('domain', 'cloudflareAccount'));
    }
    public function editPageRule(CloudflareAccount $cloudflareAccount, string $domainId, string $pageRuleId)
    {
        $domain = DomainResource::make(ZoneHttpClient::make()
            ->show($domainId)['result'])->resolve();
        $pageRule = PageRuleResource::make(PageRuleHttpClient::make()->show($domainId, $pageRuleId)['result'][0])->resolve();
        $cloudflareAccount = CloudflareAccountResource::make($cloudflareAccount)->resolve();
        return inertia('Cloudflare/Account/Domain/PageRule/Edit', compact('domain', 'cloudflareAccount', 'pageRule'));
    }
    public function destroyPageRule(CloudflareAccount $cloudflareAccount, string $domainId, string $pageRuleId)
    {
        PageRuleHttpClient::make()->destroy($domainId, $pageRuleId);
        return response([], Response::HTTP_NO_CONTENT);
    }
}
