<?php


namespace App\Repository;


use App\Models\Channel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use \Illuminate\Database\Eloquent\Collection;

class ChannelRepository
{

    /**
     * @return Channel[]|Collection
     */
    public function getAllChannel()
    {
        return Channel::all();
    }


    /**
     * @param $request
     */
    public function createChannel($request)
    {
        Channel::create([
            'title' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
    }

    /**
     * @param Channel $channel
     * @param Request $request
     */
    public function updateChannel($channel, $request)
    {
        $channel->update([
            'title' => $request->name,
            'slug' => Str::slug($request->name),
        ]);
    }

    /**
     * @param Channel $channel
     */
    public function deleteChannel(Channel $channel)
    {
        $channel->delete();
    }
}
