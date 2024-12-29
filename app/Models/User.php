<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\HasApiTokens;
use Modules\Smtp\Entities\EmailQueue;
use Modules\Smtp\Entities\Account;
use Modules\Services\Entities\CustomReq;
use Modules\Chat\Entities\Chat;
use Modules\Services\Entities\Service;
use Modules\Services\Entities\ServicePriceList;
use Modules\Services\Entities\SubServicePriceList;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     *     
     */
    const ROLE_ADMIN = 0;

    const ROLE_USER = 1;

    const STATE_ACTIVE = 1;

    const STATE_INACTIVE = 0;

    const ROLE_SERVICE_PROVIDER = 2;

    const RESET_KEY = 16;

    const IS_VERIFIED = 1;

    const GENDER_MALE = 1;

    const GENDER_FEMALE = 2;

    protected $table = 'users';

    public $appends = ['unread_count', 'image_url', 'id_proof_1_url', 'id_proof_2_url', 'last_message', 'last_message_time'];

    protected $fillable = [
        'name',
        'email',
        'password',
        'image',
        'dob',
        'phone',
        'address',
        'role',
        'country_code',
        'otp',
        'first_name',
        'last_name',
        'password_reset_token',
        'customer_id',
        'state_id',
        'access_token',
        'id_proof_1',
        'id_proof_2'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime'
    ];

    public static function getRoleOptions($id = null)
    {
        $list = array(
            self::ROLE_ADMIN => "Admin",
            self::ROLE_SERVICE_PROVIDER => "Service Provider",
            self::ROLE_USER => "User"
        );
        if ($id === null)
            return $list;
        return isset($list[$id]) ? $list[$id] : 'Not Defined';
    }

    public function getRole()
    {
        $list = self::getRoleOptions();
        return isset($list[$this->role]) ? $list[$this->role] : 'Not Defined';
    }

    public function getGender()
    {
        switch ($this->gender) {
            case self::GENDER_MALE:
                return "Male";

            case self::GENDER_FEMALE:
                return "Female";
                break;

            default:
                return "Not Defined";
        }
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


    public function sendMailToAdmin()
    {
        $res = EmailQueue::create([
            'to' => $this->email,
            'from' => '',
            'subject' => 'Registration Email',
            'message' => 'Registration Done',
            'view' => 'email',
            'model' => [
                'user' => $this->user
            ],
            false
        ]);
    }

    public function comments()
    {
        return $this->hasMany(\Modules\Comment\Entities\Comment::class, 'created_by_id', 'id');
    }

    public function custom()
    {
        return $this->hasMany(CustomReq::class);
    }

    public function getResetUrl()
    {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));

        for ($i = 0; $i < USER::RESET_KEY; $i++) {
            $key .= $keys[array_rand($keys)];
        }
        $this->password_reset_token = $key;
        if ($this->save()) {
            return true;
        } else {
            return false;
        }
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('public/uploads/' . $this->image);
        }
        return null;
    }

    public function getIdProof1UrlAttribute()
    {
        if ($this->id_proof_1) {
            return asset('public/uploads/idproof/' . $this->id_proof_1);
        }
        return null;
    }

    public function getIdProof2UrlAttribute()
    {
        if ($this->id_proof_2) {
            return asset('public/uploads/idproof/' . $this->id_proof_2);
        }
        return null;
    }

    public function getCertificationUrlAttribute()
    {
        if ($this->image) {
            return asset('public/uploads/' . $this->certifications);
        } else {
            return null;
        }
    }
    public function getUnreadCountAttribute()
    {
        if (Auth::check()) {
            return Chat::where('from_id', $this->id)->where('to_id', Auth::user()->id)->where('is_read', Chat::READ_NO)->count();
        }
        return  self::STATE_INACTIVE;
    }

    public function getLastMessageAttribute()
    {
        $lastMessage = Chat::where('from_id', $this->id)
            ->where('to_id', Auth::id())
            ->orWhere(function ($query) {
                $query->where('from_id', Auth::id())
                    ->where('to_id', $this->id);
            })
            ->orderBy('created_at', 'desc')
            ->first();
        return $lastMessage ? $lastMessage->message : null;
    }
    /**
     * Get the last message time between this user and the authenticated user.
     *
     * @return string|null
     */
    public function getLastMessageTimeAttribute()
    {
        $lastMessage = Chat::where('from_id', $this->id)
            ->where('to_id', Auth::id())
            ->orWhere(function ($query) {
                $query->where('from_id', Auth::id())
                    ->where('to_id', $this->id);
            })
            ->orderBy('created_at', 'desc')
            ->first();
        return $lastMessage ? $lastMessage->created_at->format('Y-m-d H:i:s') : null;
    }


    public function servicePrice()
    {
        return $this->hasMany(ServicePriceList::class, 'created_by_id', 'id');
    }

    public function subServicePrice()
    {
        return $this->hasMany(SubServicePriceList::class, 'created_by_id', 'id');
    }

    public function providerServices()
    {
        return $this->hasMany(ProviderServices::class, 'service_provider_id', 'id');
    }

    public static function getNearbyData($lat, $long, $radius = null)
    {

        $latitude = $lat;
        $longitude = $long;

        $haversine = "(
        6371 * acos(
            cos(radians(" . $latitude . "))
            * cos(radians(`latitude`))
            * cos(radians(`longitude`) - radians(" . $longitude . "))
            + sin(radians(" . $latitude . ")) * sin(radians(`latitude`))
        )
    )";
        $users = User::with('servicePrice', 'subServicePrice', 'providerServices')
            ->select("*")
            ->selectRaw("$haversine AS distance")
            ->having("distance", "<=", $radius)
            ->orderby("distance", "desc")
            ->get();

        return $users;
    }
}
