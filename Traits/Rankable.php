<?php

namespace ArtisanCloud\Rankable\Traits;


use ArtisanCloud\Rankable\Models\Comment;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Rankable
{

    protected string $key = 'order_index';

    public function setOrderIndexKey(string $key = null)
    {
        $this->key = $order_index ?? 'order_index';
    }

    public function moveInBetween($prevItem, $nextItem)
    {

    }
}
