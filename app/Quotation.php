<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotation extends Model
{
  protected $fillable = [
    'customer_id', 'title', 'place','sub_total','profit','total','total_tax','profit_rate', 'period', 'payment_term', 'validity', 'remark','quotation_day','staffs','period_before','period_after','which_company','which_document','expiration_date'
  ];

  //
  public function quotationDetails()
  {
    return $this->hasMany('App\QuotationDetail');
  }

  public function customer()
  {
    return $this->belongsTo('App\Customer');
  }

  static public function findPlus($id) {
    $quotation = Quotation::find($id);

    // 各行の計算
    foreach ($quotation->quotationDetails as &$value) {
      $value->sum = $value->quantity * $value->price;
      $value->price_estimate = round($value->price * (100 + $value->bugakari) / 100);
      $value->sum_estimate = round($value->quantity * $value->price * (100 + $value->bugakari) / 100);
      $value->profit = $value->sum_estimate - $value->sum;
    }

    // フォルダの計算と合計の計算
    $tmp = $quotation->quotationDetails;
    $quotation->total_small = 0;
    $quotation->total = 0;
    $quotation->profit = 0;
    foreach ($quotation->quotationDetails as &$value) {
      // 子供の合計をフォルダに追加
      if ($value->folder == true) {
        $value->sum = self::sumChildren($value->hier, $tmp);
        $value->sum_estimate = self::sumChildrenEstimate($value->hier, $tmp);
        $value->profit = $value->sum_estimate - $value->sum;
        // 全合計の計算
      } else {
        $quotation->total_small += $value->sum_estimate;
        $quotation->profit += $value->sum_estimate - $value->sum;
      }
      // インデントを追加
      $value->indent = substr_count($value->hier, ".");
    }
    $quotation->total_tax = floor($quotation->total_small * config('const.tax_rate'));
    $quotation->total = $quotation->total_small + $quotation->total_tax;
    if ($quotation->total_small == 0) {
      $quotation->profit_rate = 0;
    }
    else {
      $quotation->profit_rate = ($quotation->profit / $quotation->total_small) * 100;
    }
    return $quotation;
  }

  static public function sumChildren($hier, $data) {
    $sum = 0;
    foreach ($data as $value) {
      if ($value->folder == false) {
        $needle = $hier . ".";
        if (0 === strpos($value->hier, $needle)) {
          $sum += $value->sum;
        }
      }
    }
    return $sum;
  }

  static public function sumChildrenEstimate($hier, $data) {
    $sum = 0;
    foreach ($data as $value) {
      if ($value->folder == false) {
        $needle = $hier . ".";
        if (0 === strpos($value->hier, $needle)) {
          $sum += $value->sum_estimate;
        }
      }
    }
    return $sum;
  }

  public function adjustId($id) {
    $id = $id + 8200; // 過去のデータと衝突しないため
    return str_pad($id, 5, 0, STR_PAD_LEFT);
  }

  public function countAll() {
    return self::count();
  }

  static public function scopeCustomerIdFilter($query, $customer_id) {
    if ($customer_id != "") {
      return $query->where('customer_id', $customer_id);
    }
    return $query;
  }

  static public function scopeKeywordFilter($query, $keyword) {
    if ($keyword != "") {
      for ($i=0; $i <count($keyword) ; $i++) {
        $query->where(function($query) use($keyword,$i){
          $query->where('quotations.title', 'LIKE', "%{$keyword[$i]}%")
          ->orWhere('quotations.staffs', 'LIKE', "%{$keyword[$i]}%")
          ->orWhere('quotations.place', 'LIKE', "%{$keyword[$i]}%")
          ->orWhere('quotations.customer_id', 'LIKE', "%{$keyword[$i]}%");
        });
      }
    }
    return $query;
  }
  static public function scopeAjaxCustomerIdFilter($query, $customer_id) {
    if ($customer_id != "") {
      for ($i=0; $i <count($customer_id) ; $i++) {
        $query->orwhere(function($query) use($customer_id,$i){
         $query->where('customer_id', $customer_id[$i]);
        });
      }
    }
    return $query;
  }
  static public function scopeAjaxKeywordFilter($query, $keyword) {
    if ($keyword != "") {
      for ($i=0; $i <count($keyword) ; $i++) {
        $query->orwhere(function($query) use($keyword,$i){
          $query->where('quotations.title', 'LIKE', "%{$keyword[$i]}%")
          ->orWhere('quotations.staffs', 'LIKE', "%{$keyword[$i]}%")
          ->orWhere('quotations.place', 'LIKE', "%{$keyword[$i]}%")
          ->orWhere('quotations.customer_id', 'LIKE', "%{$keyword[$i]}%");
        });
      }
    }
    return $query;
  }

}
