<?php

namespace Modules\Services\Entities;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Models\CustomReqFiles;

class CustomReq extends Model
{
    use HasFactory;
    
    protected $table ='custom_bookings';
    
    protected $fillable = ['state_id'];

    const STATE_PENDING = 0;

    const STATE_ACCEPTED = 1;

    const STATE_REJECTED = 2;
    
    const STATE_CANCELLED = 3;

    public $appends = ['images'];
    
    public function getImagesAttribute() {
        $currentUser = Auth::user()->id;
        $requestId = $this->id;
        
        $getImages = CustomReqFiles::where([
            ['custom_req_id','=',$requestId],
            ['user_id','=',$currentUser],
        ])->get();
        
        $getImagePath = [];
        foreach($getImages as $getImage) {
            $getImagePath[] = url('public/uploads/'.$getImage->image);
        }
        
        return $getImagePath;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public static function getStateOptions($id = null)
    {
        $list = array(
            self::STATE_ACTIVE => "Active",
            self::STATE_INACTIVE => "Inactive"
        );
        if ($id === null)
            return $list;
            return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }
    
    public function getState()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }

}
