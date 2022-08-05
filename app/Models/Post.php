<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // public function getDateAttribute() {
    //     return $this->updated_at->diffForHumans();
    // }

    public function getStatusAttribute($value) {
        $status = '';
        if($value == 'high') {
            $status .= '<span class="badge bg-danger">' . $value . '</span>';
        }elseif($value == 'middle') {
            $status .= '<span class="badge bg-warning">' . $value . '</span>';
        }else {
            $status .= '<span class="badge bg-info">' . $value . '</span>';
        }

       return $status;

    }


    public function time():Attribute {
        return new Attribute(
            get: fn($value) => $this->updated_at->diffForHumans()
        );
    }

    public function getPostImagePathAttribute() {
        if($this->image) {
            return asset("storage/image/$this->image");
        }

        return null;

    }
}
