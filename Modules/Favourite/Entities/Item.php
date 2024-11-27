<?php

namespace Modules\Favourite\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\VarDumper\VarDumper;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'created_by_id',
        'state_id',
        'type_id'
    ];

    const STATE_INACTIVE = 0;
    const STATE_ACTIVE = 1;
    const STATE_DELETED = 2;
    protected $table = "favourite_item";

    public static function getStateOptions()
    {
        return [
            self::STATE_INACTIVE => "New",
            self::STATE_ACTIVE => "Active",
            self::STATE_DELETED => "Deleted"
        ];
    }

    public function getState()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }

    public static function add($obj)
    {
        $old = Item::where([
            'model_type' => get_class($obj),
            'model_id' => $obj->id,
            'created_by_id' => Auth::user()->id
        ])->first();
        if ($old) {
            if ($old->state_id == Item::STATE_ACTIVE) {
                $old->state_id = Item::STATE_INACTIVE;
            } else {
                $old->state_id = Item::STATE_ACTIVE;
            }
            $old->created_at = date("Y-m-d H:i:s");
            if (!$old->save()) {
                VarDumper::dump($old->errors);
                return false;
            }
            return true;
        } else {
            $model = new self();
            $class = get_class($obj);
            $model->model_type = $class;
            $model->model_id = $obj->id;
            $model->state_id = Item::STATE_ACTIVE;
            $model->created_by_id = Auth::user()->id;
        }

        if (!$model->save()) {
            VarDumper::dump($model->errors);
            return false;
        }
        return true;
    }

    public function getModel()
    {
        $modelType = $this->model_type;
        if (class_exists($modelType)) {
            return $modelType::findOne($this->model_id);
        }
    }
}
