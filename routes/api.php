<?php

use App\Models\Stream;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// RESPONSE FORMAT
//
// [2021-12-10 21:15:39] local.INFO: start stream
// [2021-12-10 21:15:39] local.INFO: array (
//   'app' => 'stream_receiver',
//   'flashver' => 'FMLE/3.0 (compatible; FMSc/1.0)',
//   'swfurl' => 'rtmp://0.0.0.0:1935/stream_receiver',
//   'tcurl' => 'rtmp://0.0.0.0:1935/stream_receiver',
//   'pageurl' => NULL,
//   'addr' => '172.20.0.1',
//   'clientid' => '1',
//   'call' => 'publish',
//   'name' => 'can',
//   'type' => 'live',
// )
// [2021-12-10 21:15:43] local.INFO: done stream
// [2021-12-10 21:15:43] local.INFO: array (
//   'app' => 'stream_receiver',
//   'flashver' => 'FMLE/3.0 (compatible; FMSc/1.0)',
//   'swfurl' => 'rtmp://0.0.0.0:1935/stream_receiver',
//   'tcurl' => 'rtmp://0.0.0.0:1935/stream_receiver',
//   'pageurl' => NULL,
//   'addr' => '172.20.0.1',
//   'clientid' => '1',
//   'call' => 'publish_done',
//   'name' => 'can',
// )
//

Route::post('stream/start', function (Request $request) {
    $streamKey = $request->input('name');

    $user = User::where(['stream_key' => $streamKey])->first();

    if (!($user)) {
        return response()->json(['status' => false], 402);
    }

    $username = $user->username;

    $stream = $user->streams()->create([
        'started_at' => now(),
    ]);

    return response()->redirectTo("rtmp://0.0.0.0:1935/hls_converter/{$stream->id}");
});


Route::post('stream/done', function (Request $request) {
    $streamId = (int) $request->input('name');

    Stream::find($streamId)->update([
        'ended_at' => now(),
    ]);

    return response()->json(['status' => 'ok']);
});
