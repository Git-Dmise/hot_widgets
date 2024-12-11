<?php

namespace App\Http\Controllers\Webhook;

use Illuminate\Http\Response;

class AppConfigController extends Controller
{
    public function store(): Response
    {
        $content = file_get_contents(app_path('Libs/config/version/config.json'));
        dd($content);
        $data = $this->makeData();
        $config = json_encode($data['config'], JSON_PRETTY_PRINT);

        $filePath = app_path("Libs/config/config-{$data['version']}.json");

        file_put_contents($filePath, $config);

        return response()->noContent();
    }

    public function makeData(): array
    {
        return $this->request->validate([
            'version' => ['required', 'string'],
            'config' => ['required', 'array'],
        ]);
    }
}
