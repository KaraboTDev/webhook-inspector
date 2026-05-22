<?php

namespace App\Http\Controllers;

use App\Models\Endpoint;
use App\Models\WebhookLog;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WebhookController extends Controller
{
    // Show the dashboard
    public function index()
    {
        $endpoints = Endpoint::with('logs')->latest()->get();
        return view('dashboard', compact('endpoints'));
    }

    // Create a new endpoint
    public function createEndpoint(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        Endpoint::create([
            'name' => $request->name,
            'token' => Str::random(16)
        ]);

        return redirect()->route('dashboard');
    }

    // Capture incoming webhook
    public function capture(Request $request, $token)
    {
        $endpoint = Endpoint::where('token', $token)->firstOrFail();

        WebhookLog::create([
            'endpoint_id' => $endpoint->id,
            'method'      => $request->method(),
            'headers'     => $request->headers->all(),
            'body'        => $request->getContent(),
            'content_type'=> $request->header('Content-Type')
        ]);

        return response()->json(['message' => 'Webhook captured'], 200);
    }

    // Replay a webhook
    public function replay(WebhookLog $log)
    {
        return response()->json([
            'method'       => $log->method,
            'headers'      => $log->headers,
            'body'         => $log->body,
            'content_type' => $log->content_type,
            'captured_at'  => $log->created_at
        ]);
    }

    // Delete a log
    public function deleteLog(WebhookLog $log)
    {
        $log->delete();
        return redirect()->route('dashboard');
    }

    // Delete an endpoint
    public function deleteEndpoint(Endpoint $endpoint)
    {
        $endpoint->delete();
        return redirect()->route('dashboard');
    }
}