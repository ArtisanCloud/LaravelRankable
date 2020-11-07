<?php

namespace ArtisanCloud\Rankable\Traits;


use ArtisanCloud\Rankable\Models\Comment;
use ArtisanCloud\Rankable\RankService;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Rankable
{

    protected string $key = 'rank';

    public function setOrderIndexKey(string $key = null)
    {
        $this->key = $order_index ?? 'rank';
    }


    public function placeBetween($prevItem = null, $nextItem = null)
    {
        if (is_null($prevItem) && is_null($nextItem)) {
            return false;
        }
//        dd($prevItem->{$this->key}, $nextItem->{$this->key});
        $rankService = new RankService($prevItem->{$this->key}, $nextItem->{$this->key});
        $middleRank = $rankService->getMiddleRank();
//        dd($middleRank);

        $this->{$this->key} = $middleRank;
        $bResult = $this->save();
//        dump($prevItem->{$this->key}, $this->{$this->key}, $nextItem->{$this->key});
        if($bResult){
            return $middleRank;
        }
        return $bResult;
    }
}
