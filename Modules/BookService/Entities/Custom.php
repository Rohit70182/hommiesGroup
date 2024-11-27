<?php

namespace Modules\BookService\Entities;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\CustomReqFiles;
use Illuminate\Support\Facades\Auth;

class Custom extends Model
{
    use HasFactory;
    protected $table ='custom_bookings';
    protected $fillable =[
        
    ];
    const STATE_ENABLE = 0;

    const STATE_ACTIVE = 1;

    const STATE_DISABLE = 2;

    public $appends = ['state','images'];

    public function getStateAttribute()
    {
        switch ($this->state_id) {

            case self::STATE_ENABLE: 
                return "Requested";
                break;

            case self::STATE_ACTIVE:
                return "Apporve";
                break;

            case self::STATE_DISABLE:
                return "Decline";


                break;
            default:
                return "Not Define";
            
         }
            
    }
    
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
}
