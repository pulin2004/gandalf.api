<?php
/**
 * Author: Paul Bardack paul.bardack@gmail.com http://paulbardack.com
 * Date: 15.02.16
 * Time: 16:47
 */

namespace App\Models;

/**
 * Class DecisionHistory
 * @package App\Models
 * @property string $default_decision
 * @property string $final_decision
 * @property array $request
 * @property Rule[] $rules
 * @property Field[] $fields
 * @method static DecisionHistory findById($id)
 * @method DecisionHistory save(array $options = [])
 * @method static \Illuminate\Pagination\LengthAwarePaginator paginate($perPage = 15, $columns = ['*'], $pageName = 'page', $page = null)
 */
class DecisionHistory extends Base
{
    protected $visible = [
        '_id',
        'title',
        'description',
        'request',
        'fields',
        'rules',
        'default_decision',
        'final_decision',
        self::CREATED_AT,
        self::UPDATED_AT
    ];

    protected $fillable = ['title', 'description', 'fields', 'request', 'rules', 'default_decision', 'final_decision'];

    protected $perPage = 20;

    public function rules()
    {
        return $this->embedsMany('App\Models\Rule');
    }

    public function fields()
    {
        return $this->embedsMany('App\Models\Field');
    }

    public function toConsumerArray()
    {
        return [
            '_id' => $this->getId(),
            'final_decision' => $this->final_decision,
            'request' => $this->request,
            'rules' => $this->rules()->get()->map(function (Rule $rule) {
                return ['description' => $rule->description, 'decision' => $rule->decision];
            })->toArray()
        ];
    }
}