<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WebhookInspector</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { background: #1A1A2E; color: #fff; font-family: Arial, sans-serif; padding: 20px; }
        h1 { color: #1A56DB; margin-bottom: 20px; font-size: 28px; }
        h2 { color: #fff; margin-bottom: 15px; font-size: 20px; }
        .card { background: #0F3460; border-radius: 12px; padding: 20px; margin-bottom: 20px; }
        .form-row { display: flex; gap: 10px; margin-bottom: 20px; }
        input[type="text"] { flex: 1; padding: 10px; border-radius: 8px; border: none; background: #16213E; color: #fff; font-size: 14px; }
        .btn { padding: 10px 20px; border: none; border-radius: 8px; cursor: pointer; font-size: 14px; }
        .btn-blue { background: #1A56DB; color: #fff; }
        .btn-red { background: #D41000; color: #fff; }
        .btn-green { background: #107C10; color: #fff; }
        .endpoint-url { background: #16213E; padding: 8px 12px; border-radius: 6px; font-family: monospace; font-size: 13px; color: #1A56DB; margin-bottom: 15px; word-break: break-all; }
        .log-item { background: #16213E; border-radius: 8px; padding: 15px; margin-bottom: 10px; }
        .log-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .method-badge { padding: 4px 10px; border-radius: 4px; font-size: 12px; font-weight: bold; background: #1A56DB; }
        .log-body { font-family: monospace; font-size: 12px; color: #888; white-space: pre-wrap; word-break: break-all; max-height: 150px; overflow-y: auto; }
        .empty { color: #888; font-size: 14px; }
        .endpoint-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .badge { background: #1A56DB; padding: 2px 8px; border-radius: 10px; font-size: 12px; }
        .replay-output { background: #16213E; border-radius: 8px; padding: 15px; margin-top: 10px; font-family: monospace; font-size: 12px; color: #1A56DB; white-space: pre-wrap; display: none; }
    </style>
</head>
<body>

    <h1>🔗 WebhookInspector</h1>

    {{-- Create Endpoint Form --}}
    <div class="card">
        <h2>Create New Endpoint</h2>
        <form action="{{ route('endpoints.create') }}" method="POST">
            @csrf
            <div class="form-row">
                <input type="text" name="name" placeholder="Endpoint name e.g. PayFast Payments" required>
                <button type="submit" class="btn btn-blue">+ Create Endpoint</button>
            </div>
        </form>
    </div>

    {{-- Endpoints List --}}
    @forelse($endpoints as $endpoint)
    <div class="card">
        <div class="endpoint-header">
            <div>
                <h2>{{ $endpoint->name }}</h2>
                <span class="badge">{{ $endpoint->logs->count() }} requests</span>
            </div>
            <form action="{{ route('endpoints.delete', $endpoint) }}" method="POST">
                @csrf
                @method('DELETE')
                <button class="btn btn-red">Delete Endpoint</button>
            </form>
        </div>

        {{-- Webhook URL --}}
        <div class="endpoint-url">
            {{ url('/webhook/' . $endpoint->token) }}
        </div>

        {{-- Logs --}}
        @forelse($endpoint->logs->sortByDesc('created_at') as $log)
        <div class="log-item">
            <div class="log-header">
                <div style="display:flex; gap:10px; align-items:center;">
                    <span class="method-badge">{{ $log->method }}</span>
                    <span style="color:#888; font-size:12px;">{{ $log->created_at->diffForHumans() }}</span>
                    <span style="color:#888; font-size:12px;">{{ $log->content_type }}</span>
                </div>
                <div style="display:flex; gap:8px;">
                    <button class="btn btn-green" onclick="replayLog('{{ $log->id }}', this)">Replay</button>
                    <form action="{{ route('logs.delete', $log) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-red">Delete</button>
                    </form>
                </div>
            </div>
            <div class="log-body">{{ $log->body ?: 'No body' }}</div>
            <div class="replay-output" id="replay-{{ $log->id }}"></div>
        </div>
        @empty
        <p class="empty">No requests captured yet. Point your webhook at the URL above.</p>
        @endforelse
    </div>
    @empty
    <div class="card">
        <p class="empty">No endpoints yet. Create one above to get started.</p>
    </div>
    @endforelse

    <script>
        function replayLog(id, btn) {
            fetch(`/logs/${id}/replay`)
                .then(res => res.json())
                .then(data => {
                    const output = document.getElementById(`replay-${id}`);
                    output.textContent = JSON.stringify(data, null, 2);
                    output.style.display = 'block';
                });
        }
    </script>

</body>
</html>