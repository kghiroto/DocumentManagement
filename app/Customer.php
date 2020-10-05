<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
  protected $fillable = [
    'name', 'zip', 'tel', 'address', 'email', 'remark','FAX','staffs'
  ];

  //
  public function quotations()
  {
    return $this->hasMany('App\Quotation');
  }

  public function countAll() {
    return self::count();
  }

  static public function scopeCustomerIdFilter($query, $id) {
    if ($id != "") {
      return $query->where('id', $id);
    }
    return $query;
  }

  static public function scopeKeywordFilter($query, $keyword) {
if ($keyword != "") {
    for ($i=0; $i <count($keyword) ; $i++) {
      $query->where(function($query) use($keyword,$i){
       $query->where('customers.name', 'LIKE', "%$keyword[$i]%")
     ->orWhere('customers.id', 'LIKE', "%$keyword[$i]%")
     ->orWhere('customers.address', 'LIKE', "%$keyword[$i]%")
     ->orWhere('customers.tel', 'LIKE', "%$keyword[$i]%")
     ->orWhere('customers.FAX', 'LIKE', "%$keyword[$i]%")
     ->orWhere('customers.remark', 'LIKE', "%$keyword[$i]%")
     ->orWhere('customers.staffs', 'LIKE', "%$keyword[$i]%");
    });
   }
}


    return $query;
  }
}
