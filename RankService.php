<?php

namespace ArtisanCloud\Rankable;


/**
 * Class RankService
 * @package App\Services\RankService
 */
class RankService
{
    public const MIN_CHAR = 'A';
    public const MAX_CHAR = 'Z';

    private $prev;
    private $next;

    /**
     * Rank constructor.
     */
    public function __construct(?string $prev, ?string $next)
    {
//        dd($prev,$next);
        $this->setPrev($prev);
        $this->setNext($next);
    }

    private function setPrev(?string $prev)
    {
        $this->prev = $prev ?? self::MIN_CHAR;
    }

    private function setNext(?string $next)
    {
        $this->next = $next ?? self::MAX_CHAR;
    }

    public function checkPrevAndNext()
    {
        return $prevChar < $nextChar;
    }

    public function getMiddleRank()
    {
        $rank = '';
        $i = 0;

        while (true) {
//            dd($this->prev, $this->next);
            $prevChar = $this->getChar($this->prev, $i, self::MIN_CHAR);
            $nextChar = $this->getChar($this->next, $i, self::MAX_CHAR);
//            dd($prevChar, $nextChar);

            if ($prevChar === $nextChar) {
                $rank .= $prevChar;
                $i++;
                continue;
            }

            $midChar = $this->getMiddleCharBewteen($prevChar, $nextChar);
            if (in_array($midChar, [$prevChar, $nextChar])) {
                $rank .= $prevChar;
                $i++;
                continue;
            }

//            dump($midChar);

            $rank .= $midChar;
            break;
        }

        return $rank;
    }

    private function getChar(string $s, int $i, string $defaultChar)
    {
        return $s[$i] ?? $defaultChar;
    }

    private function getMiddleCharBewteen(string $prev, string $next)
    {
//        dump($prev, ord($prev), $next, ord($next));
        return chr((ord($prev) + ord($next)) / 2);
    }
}
