<?php

namespace App\Http\Controllers\Api\v1\Channel;

use App\Http\Controllers\Controller;
use App\Models\Channel;
use App\Repository\ChannelRepository;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;


class ChannelController extends Controller
{
    //


    /**
     * @return JsonResponse
     */
    public function getListChannel()
    {
        $Channel = resolve(ChannelRepository::class)->getAllChannel();
        return response()->json([$Channel], 200);
    }


    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function createChannel(Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);

        resolve(ChannelRepository::class)->createChannel($request);

        return response()->json([
            'message' => 'Channel create successfully'
        ], 201);
    }

    /**
     * @param Channel $channel
     * @param Request $request
     * @return JsonResponse
     */
    public function updateChannel(Channel $channel, Request $request)
    {
        $request->validate([
            'name' => ['required']
        ]);

        resolve(ChannelRepository::class)->updateChannel($channel, $request);


        return response()->json([
            'message' => 'update channel successfully'
        ], 200);
    }


    /**
     * @param Channel $channel
     * @return JsonResponse
     */
    public function deleteChannel(Channel $channel)
    {
        resolve(ChannelRepository::class)->deleteChannel($channel);

        return response()->json([
            'message' => 'channel delete successfully'
        ], 200);
    }


}
