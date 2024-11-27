<?php

namespace Modules\Smtp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Smtp\helpers\DnsHelper;

class Account extends Model
{
    //use DnsHelper;

       protected $fillable = [
        'title',
        'email',
        'password',
        'server',
        'port',
        'encryption_type',
        'state_id',
        'type_id',
        'created_by_id'
    ];

    protected $table = "smtp_account";
    

    
    private $_mailer;
    
    public function __toString()
    {
        return (string) $this->title;
    }
    
    const TYPE_NO_ENCRYPTION = 0;
    
    const TYPE_ENCRYPTION_TLS = 1;
    
    const TYPE_ENCRYPTION_SSL = 2;
    
    const STATE_INACTIVE = 0;
    
    const STATE_ACTIVE = 1;
    
    const STATE_DELETED = 2;
    
    public static function getEncryptionOptions()
    {
        return [
            self::TYPE_NO_ENCRYPTION => "None",
            self::TYPE_ENCRYPTION_TLS => "TLS",
            self::TYPE_ENCRYPTION_SSL => "SSL"
        ];
    }
    
    public function getEncryption()
    {
        $list = self::getEncryptionOptions();
        return isset($list[$this->encryption_type]) ? $list[$this->encryption_type] : 'Not Defined';
    }
    
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
    

    
    public static function getActionOptions()
    {
        return [
            self::STATE_INACTIVE => "Deactivate",
            self::STATE_ACTIVE => "Activate",
            self::STATE_DELETED => "Delete"
        ];
    }
    
    public static function getTypeOptions()
    {
        return [
            "SMTP",
            "GMAIL",
            "OUTLOOK"
        ];
    }
    
    public function getType()
    {
        $list = self::getTypeOptions();
        return isset($list[$this->type_id]) ? $list[$this->type_id] : 'Not Defined';
    }

}
