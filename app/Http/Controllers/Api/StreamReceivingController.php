<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Stream;
use App\Models\User;

class StreamReceivingController extends Controller
{
    public function start()
    {
        $streamKey = request()->input('name');

        $user = User::where(['stream_key' => $streamKey])->first();

        if (! ($user)) {
            return response()->json(['status' => false], 402);
        }

        $stream = $user->streams()->create([
            'started_at' => now(),
        ]);

        return response()->redirectTo("rtmp://0.0.0.0:1935/hls_converter/{$stream->id}");
    }

    public function done()
    {
        $streamId = (int) request()->input('name');

        Stream::find($streamId)->update([
            'ended_at' => now(),
        ]);

        return response()->json(['status' => 'ok']);
    }
}
