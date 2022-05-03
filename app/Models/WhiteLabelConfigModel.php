<?php

namespace App\Models;

use Storage;
use App\Helpers\Paths;
use Illuminate\Database\Eloquent\Model;

class WhiteLabelConfigModel extends Model
{
    protected $table = "whitelabel_configs";

    protected $fillable = [
        'user_id'
    ];

    protected $appends = [
        'media_path'
    ];

    public function getMediaPathAttribute(){
        $logo = Paths::LOGO_PATH .$this->logo;
        if(Storage::has($logo) && $this->logo != null){
                $path = Storage::url($logo);

                return $path;
            // return Storage::disk('local')->url($logo);
        }else{
            return '';
        }
    }
}
