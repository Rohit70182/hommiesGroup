<?php

namespace Modules\Smtp\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\App;

class EmailQueue extends Model
{
    use HasFactory;

      protected $fillable = [
        'from_email',
        'to_email',
        'message',
        'subject',
        'date_published',
        'last_attempt',
        'date_sent',
        'attempts',
        'state_id',
        'model_id',
        'model_type',
        'email_account_id',
        'message_id',
        'model_type'
    ];

    protected $table = 'smtp_email_queue';
    public $bcc_self = false;
    
    public $mail_sent = 0;
    
    public function __toString()
    {
        return (string) $this->subject;
    }
    
    const STATE_PENDING = 0;
    
    const STATE_SENT = 1;
    
    const STATE_DELETED = 2;
    
    const STATE_SEEN = 3;
    
    const TYPE_DELETE_AFTER_SEND = 0;
    
    const TYPE_KEEP_AFTER_SEND = 1;
    
    public static function getStateOptions()
    {
        return [
            self::STATE_PENDING => "Pending",
            self::STATE_SENT => "Sent",
            self::STATE_DELETED => "Discarded",
            self::STATE_SEEN => "Seen"
        ];
    }
    
    public function getState()
    {
        $list = self::getStateOptions();
        return isset($list[$this->state_id]) ? $list[$this->state_id] : 'Not Defined';
    }
    

    
    public function getModel()
    {
        if (! empty($this->model_type))
            return $this->model_type::findOne($this->model_id);
            return null;
    }
    
    public function getToEmails()
    {
        return $this->hasOne(self::class, [
            'to' => 'to'
        ]);
    }
    
    public static function getSmtpAccountOptions()
    {
        return self::listData(Account::findActive()->all());
    }
    
 
    public function getSmtpAccount()
    {
        return $this->hasOne(Account::className(), [
            'id' => 'smtp_account_id'
        ])->cache();
    }
    
   
    
    public function getFooter()
    {
        $enable_links = false;
        
        $unsubscribeUrl = $this->getUrl('unsubscribe');
        $imgUrl = $this->getUrl('image');
        $showUrl = $this->getUrl('show');
        
        $html = '<div class="text-center" align="center">';
        if ($enable_links == true) {
            $unsubscribeUrl = "mailto:{$this->from}?Subject=Unsubscribe:{$this->id}:{$this->to}";
            $html .= '<p style="font-size: 14px; padding: 0; color: #666"> If you are unable to see this content open in web browser <a href="' . $showUrl . '">Click here</a></p>';
        }
        $html .= '<p style="font-size: 14px; padding: 0; color: #666">';
        $html .= "This email was sent to {$this->to}</p>";
        $html .= "<p><a href=\"$unsubscribeUrl\">Unsubscribe</a></p><br>";
        $html .= "<p> <img src=\"$imgUrl\" style='width:1px; height:1px'></p> </div>";
        
        return $html;
    }
    
    public static function cleanEmailAddress($value)
    {
        if (! filter_var($value, FILTER_VALIDATE_EMAIL)) {
            
            $pattern = '/[a-z0-9_.\-\+]+@[a-z0-9\-]+\.([a-z]{2,3})(?:\.[a-z]{2})?/i';
            if (preg_match($pattern, $value, $matches))
                $value = ($matches[0]);
        }
        return trim($value);
    }
    
    public static function clearSent($days = 90)
    {
        $query = EmailQueue::find()->where([
            'in',
            'state_id',
            [
                self::STATE_SENT,
                self::STATE_DELETED
            ]
        ]);
        
        if (! empty($days)) {
            $query->andWhere([
                '<',
                'DATE(sent_on)',
                date('Y-m-d', strtotime('-' . $days . ' days'))
            ]);
        }
        
        self::deleteRelatedAll($query);
    }
    

    public function addExtraHeaders($mail)
    {
        $unsubscribeUrl = $this->getUrl('unsubscribe');
        
        $mail->addHeader('List-Unsubscribe', "<mailto:$this->from?Subject=Unsubscribe:{$this->id}:{$this->to}>,<$unsubscribeUrl>");
    }
    

    
    public function handleArgs($args = [])
    {
        if (isset($args['smtp_account_id'])) {
            $account = Account::findOne($args['smtp_account_id']);
        }
        if (isset($account)) {
            $this->smtp_account_id = $account->id;
        }
    }
    
   
  
}
