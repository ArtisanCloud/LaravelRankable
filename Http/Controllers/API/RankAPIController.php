<?php
declare(strict_types=1);

namespace ArtisanCloud\Rankable\Http\Controllers\API;

use ArtisanCloud\Rankable\Http\Requests\RequestRankPlace;

use ArtisanCloud\Rankable\Http\Resources\RankResource;
use ArtisanCloud\Rankable\RankService;

use ArtisanCloud\SaaSFramework\Exceptions\BaseException;
use ArtisanCloud\SaaSFramework\Http\Controllers\API\APIController;

use ArtisanCloud\SaaSFramework\Http\Controllers\API\APIResponse;
use Illuminate\Http\Request;


class RankAPIController extends APIController
{
    private $rankService;

    function __construct(Request $request)
    {

        // init the default value
        // parent will construction automatically
        parent::__construct($request);
    }


    public function apiRankItem(RequestRankPlace $request)
    {

        $rank = \DB::connection('pgsql')->transaction(function () use ($request) {
            
            try {
                $arrayData = $request->all();
//                dd($arrayData);

                $rankable = $arrayData['rankable'];
                $rank = $rankable->placeBetween($arrayData['prev_item'],$arrayData['next_item']);
//                dd($rankable);
                if (!$rank) {
                    throw new \Exception('', API_ERR_CODE_FAIL_TO_PLACE_ITEM);
                }

            } catch (\Exception $e) {
//                dd($e);
                throw new BaseException(
                    intval($e->getCode()),
                    $e->getMessage()
                );
            }

            return $rank;

        });

        $this->m_apiResponse->setData($rank);

        return $this->m_apiResponse->toResponse();
    }



}
