<?php
declare(strict_types=1);

namespace ArtisanCloud\Rankable\Http\Requests;


use App\Models\Tenants\Rank;
use App\Services\ReleaseService\ReleaseService;
use ArtisanCloud\SaaSFramework\Exceptions\BaseException;
use ArtisanCloud\SaaSFramework\Http\Requests\RequestBasic;
use ArtisanCloud\SaaSFramework\Services\ArtisanCloudService;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class RequestRankPlace extends RequestBasic
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */

    public function authorize()
    {
        $objectClass = str_replace('.', '\\', $this->input('rankableType'));
//        dd($objectClass);
        $object = $objectClass::where('uuid', $this->input('rankableUuid'))->first();
//        dd($object);
        if (is_null($object)) {
            throw new BaseException(API_ERR_CODE_OBJECT_NOT_EXIST);
        }
        $this->getInputSource()->set('rankableType', $objectClass);
        $this->getInputSource()->set('rankable', $object);

        $prevObject = $objectClass::where('uuid', $this->input('prevItemUuid'))->first();
//        dd($prevObject);
        $this->getInputSource()->set('prevItem', $prevObject);

        $nextObject = $objectClass::where('uuid', $this->input('nextItemUuid'))->first();
//        dd($nextObject);
        $this->getInputSource()->set('nextItem', $nextObject);

        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'rankableUuid' => [
                'required',
                'string',
            ],
            'rankableType' => [
                'required',
                'string',
            ],
            'prevItemUuid' => [
                'nullable',
                'string',
            ],
            'nextItemUuid' => [
                'nullable',
                'string',
            ],

        ];
    }

    public function messages()
    {
        return [
            'rankableId.string' => __("{$this->m_module}.string"),
            'rankableId.uuid' => __("{$this->m_module}.uuid"),
            'rankableType.required' => __("{$this->m_module}.required"),
            'rankableType.string' => __("{$this->m_module}.string"),
            'description.string' => __("{$this->m_module}.string"),
            'description.max' => __("{$this->m_module}.max"),

        ];
    }


}
