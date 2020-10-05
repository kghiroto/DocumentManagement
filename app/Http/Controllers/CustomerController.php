<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\SaveCustomerRequest;
use App\Quotation;
use App\QuotationDetail;
use App\Customer;
use DB;

class CustomerController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public function __construct()
  {
  }

  public function show(Request $request, $id)
  {
    $customer = Customer::find($id);
    return view('customer.show', compact('customer'));
  }

  public function showList(Request $request)
  {
    $conditions = [
      "id" => $request->input("id", ""),
      "keyword" => $request->input("keyword", "")
    ];
    $keyword = $request->input("keyword", "");
    // +を半角スペースに変換（GETメソッド対策）
    $keyword = str_replace('+', ' ', $keyword);
    // 全角スペースを半角スペースに変換
    $keyword = str_replace('　', ' ', $keyword);
    // 取得したキーワードのスペースの重複を除く。
    $keyword = preg_replace('/\s(?=\s)/', '', $keyword);
    // キーワード文字列の前後のスペースを削除する
    $keyword = trim($keyword);
    $arrayKey = array_unique(explode(' ', $keyword));
    $customers = Customer::customerIdFilter($conditions["id"])
    ->keywordFilter($arrayKey)
    ->paginate(config('const.row_count_per_page'));

    $customer_options = Customer::all()->pluck('name', 'id')->toArray();
    return view('customer.list', compact('customers', 'customer_options', 'conditions'));
  }

  public function createInput(Request $request)
  {
    $customer = (object)[];
    $customer->id = "";
    $customer->name = "";
    $customer->zip = "";
    $customer->address = "";
    $customer->FAX = "";
    $customer->tel = "";
    $customer->staffs = "";
    $customer->remark = "";

    return view('customer.create-input', compact('customer'));
  }

  public function editInput(Request $request, $id)
  {
    $customer = Customer::find($id);
    return view('customer.create-input', compact('customer'));
  }

  public function save(SaveCustomerRequest $request)
  {
    $id = $request->input('id', '');
    // アップデート処理
    if ($id != '') {
      $customer = Customer::find($id);
      $customer->fill($request->all())->save();
      // 新規作成
    } else {
      $customer = new Customer($request->all());
      $customer->save();
    }
    // ブラウザリロード等での二重送信防止
    $request->session()->regenerateToken();
    return redirect('customer/show/' . $customer->id)->with('message', '保存しました');
  }
}
