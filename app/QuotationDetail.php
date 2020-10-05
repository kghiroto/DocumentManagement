<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotationDetail extends Model
{
    protected $fillable = [
        'hier','quotation_id' ,'title', 'folder', 'standard', 'quantity', 'unit', 'price', 'bugakari', 'remark'
    ];

    public function quotation()
    {
        return $this->belongsTo('App\Quotation');
    }
}
