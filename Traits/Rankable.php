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
//        dd($prevItem->{$this->key}, $nextItem->{$this->key});
        $rankService = new RankService(
            $prevItem ? $prevItem->{$this->key} : null,
            $nextItem ? $nextItem->{$this->key} : null
        );
        $middleRank = $rankService->getMiddleRank();
//        dd($middleRank);

        $this->{$this->key} = $middleRank;
        $bResult = $this->save();
//        dump($prevItem->{$this->key}, $this->{$this->key}, $nextItem->{$this->key});
        if ($bResult) {
            return $middleRank;
        }
        return $bResult;
    }
}
