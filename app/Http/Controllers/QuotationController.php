<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;

use App\Http\Requests;
use App\Quotation;
use App\QuotationDetail;
use App\Customer;
use DB;

// require 'vendor/autoload.php';

// Spreadsheet
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as Reader;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class QuotationController extends Controller
{
  /**
  * Create a new controller instance.
  *
  * @return void
  */
  public $percentage = 100;
  public function __construct()
  {
  }

  public function show(Request $request, $id)
  {
    $customer_options = Customer::all()->pluck('name', 'id')->toArray();
    $unit_options = config('const.unit_options');
    $quotation = Quotation::find($id);
    $quotationDetails = $quotation->quotationDetails()->orderBy('hier','asc')->get();
    $quotationdate = $quotation->quotation_day;
    $quotationdate = "令和".(int)substr($quotationdate, 0, 2)."年".(int)substr($quotationdate, 2, 2)."月".(int)substr($quotationdate, 4, 2)."日";

    return view('quotation.show', compact('quotation', 'customer_options', 'unit_options','quotationDetails' , 'quotationdate'));
  }

  public function showList(Request $request)
  {

    $conditions = [
      "customer_id" => $request->input("customer_id", ""),
      "keyword" => $request->input("keyword", "")
    ];

    $quotations = Quotation::customerIdFilter($conditions["customer_id"])
    ->keywordFilter($conditions['keyword'])
    ->orderBy('updated_at', 'desc')
    ->paginate(config('const.row_count_per_page'));

    // dd();

    $cost = 0;
    $unitPrice = 0;
    $totalProfit = 0;

    if($quotations[0] != null){
      foreach ($quotations as $index => $value) {
        $cost += $quotations[$index]->sub_total;
        $unitPrice += $quotations[$index]->total;
        $totalProfit += $quotations[$index]->profit;
      }
    }

    if($quotations[0] != null && $cost != 0){
      $totalProfitRate = ($totalProfit / $cost ) * $this->percentage;
    }else{
      $totalProfitRate = 0;
    }
    foreach ($quotations as  $value) {
      if ($value->which_company == '今井設備工業') {
        $value->which_company = 'I';
      }
      if ($value->which_company == 'ジャストサポート') {
        $value->which_company = 'J';
      }
      if ($value->which_document == '見積') {
        $value->which_document= 'M';
      }
      if ($value->which_document == '請求') {
        $value->which_document= 'S';
      }
    }

    $customer_options = Customer::all()->pluck('name', 'id')->toArray();
    return view('quotation.list', compact(
      'quotations', 'customer_options', 'conditions','cost','unitPrice','totalProfit','totalProfitRate'
    ));
  }


  public function copyInput(Request $request, $id)
  {
    $unit_options = json_encode(config('const.unit_options') , JSON_UNESCAPED_UNICODE);
    $customer_options = Customer::all()->pluck('name', 'id')->toArray();
    $quotation = Quotation::find($id);
    $quotationDetails = $quotation->quotationDetails()->get();
    foreach ($quotationDetails as &$row) {
      $row['folder'] = ($row['folder'] == "1") ? true : false;
      if ($row['folder'] == true) {
        $row['expanded'] = true;
      }
    }
    $json = $this->makeFancyJson($quotationDetails);
    $quotation->id = null;

    return view('quotation.create-input', compact('unit_options', 'customer_options', 'quotation', 'json','quotationDetails'));
  }

  public function searchQuotationsApi(Request $request) {
    var_dump('aaa');
    exit;
    $keyword = $request->input('keyword', '');
    $quotations = tap(Quotation::keywordFilter($keyword)->take(50)->get(), function($quotations) {
      foreach ($quotations as &$value) {
        $value->customer_name = $value->customer->name;
        unset($value->customer);
      }
    });
    return json_encode($quotations, JSON_UNESCAPED_UNICODE);
  }

  public function searchQuotationDetailsApi(Request $request) {

    $quotationId = $request->input('quotation_id', '');
    $quotationDetails = QuotationDetail::where('quotation_id', "=", $quotationId)->where('folder', '=', false)->get();
    return json_encode($quotationDetails, JSON_UNESCAPED_UNICODE);

  }

  public function createInput(Request $request)
  {
    $unit_options = json_encode(config('const.unit_options') , JSON_UNESCAPED_UNICODE);
    $customer_options = Customer::all()->pluck('name', 'id')->toArray();
    $quotation = Quotation::find(1);
    if($quotation != null){
      $quotationDetails = $quotation->quotationDetails()->orderBy('hier','asc')->get();
    }
    $quotationDetails = [];
    $quotation = (object)[];
    $quotation->id = "";
    $quotation->customer_id = "";
    $quotation->title = "";
    $quotation->place = "";
    $quotation->period = "";
    $quotation->staffs = "";
    $quotation->payment_term = "";
    $quotation->validity = "";
    $quotation->remark = "";
    $quotation->expiration_date = "";
    $quotationYear = "";
    $quotationMonth = "";
    $quotationDay = "";
    //工期
    $period_before_year = "";
    $period_before_month = "";
    $period_before_day = "";
    $period_affter_year = "";
    $period_affter_month = "";
    $period_affter_day = "";
    $customer_arr = [
      "name"=>"",
      "id" => "",
    ];
    $which = [
      "document"=>"",
      "company"=>"",
    ];

    $conditions = [
      "customer_id" => $request->input("customer_id", ""),
      "keyword" => $request->input("keyword", "")
    ];
    $quotations = Quotation::customerIdFilter($conditions["customer_id"])
    ->keywordFilter($conditions['keyword'])
    ->orderBy('created_at', 'desc')
    ->get();
    $result_Detail = [];
    if(count($result_Detail) < 10){
      for($i=count($result_Detail); $i < 10; $i++){
        $result_Detail[] = [
          "id" => "",
          "hier" => "",
          "title" => "",
          "standard"=>"",
          "quantity" => "",
          "bugakari" => "",
          "unit" => "",
          "price" => "",
          "remark" => ""
        ];
      }
    }

    $cost = 0;
    $unitPrice = 0;
    $totalProfit = 0;

    foreach ($quotations as $index => $value) {
      $quotations[$index]['price'] = Quotation::findPlus($value->id);
      $cost += $quotations[$index]['price']->total_small;
      $unitPrice += $quotations[$index]['price']->total;
      $totalProfit += $quotations[$index]['price']->profit;
      foreach ($quotations as  $value) {
        if ($value->which_company == '今井設備工業') {
          $value->which_company = 'I';
        }
        if ($value->which_company == 'ジャストサポート') {
          $value->which_company = 'J';
        }
        if ($value->which_document == '見積') {
          $value->which_document= 'M';
        }
        if ($value->which_document == '請求') {
          $value->which_document= 'S';
        }
      }
    }


    return view('quotation.create-input', compact('unit_options', 'which','customer_options', 'quotation','quotationDetails','quotation','quotations','result_Detail','quotationYear','quotationMonth','quotationDay','period_affter_year','period_affter_month','period_affter_day','period_before_year','period_before_month','period_before_day','customer_arr'));
  }

  private function searchParent($child, $temp) {
    foreach ($temp as $key => &$value) {
      //var_dump("{$value['hier']}はどう");
      if ($value['hier'] == $child['parent_id']) {
        $value['children'][] = $child;
        //var_dump("すぐ見つかった: {$child['hier']}=>親:{$child['parent_id']}");
        return $temp;
        // 子供を探す
      } else {
        //var_dump("{$value['hier']}のchildrenを探す: {$child['hier']}");
        if (isset($value['children'])) {
          //var_dump($value['children']);
          $value['children'] = $this->searchParent($child, $value['children']);
          //return $temp;
        }else {
          //var_dump("{$value['hier']}はchildrenなし");
        }
      }
    }
    //var_dump('====ここにくる？======');
    return $temp;
  }

  private function makeFancyJson($quotationDetails) {
    $getParentId = function ($hier) {
      preg_match('/(.*)\.(.*)/', $hier, $matches, PREG_OFFSET_CAPTURE);
      if ($matches == []) {
        return [];
      }else {
        return $matches[1][0];
      }
    };
    // parent_id を設定する
    foreach ($quotationDetails as  &$row) {
      $row['parent_id'] = $getParentId($row['hier']);
    }
    $temp = [];
    $i=0;
    //var_dump($quotationDetails);
    foreach ($quotationDetails as $value) {
      $i++;
      //var_dump("-----{$i}-----");
      //var_dump("-----自分の階層: {$value['hier']}-----");
      if ($value['parent_id'] != []) {
        $temp = $this->searchParent($value, $temp);
      }else {
        //var_dump("-----親なし-----");
        $temp[] = $value;
      }
    }

    return json_encode($temp , JSON_UNESCAPED_UNICODE);
  }

  public function editInput(Request $request, $id)
  {
    //$unit_options = config('const.unit_options');
    $unit_options = json_encode(config('const.unit_options') , JSON_UNESCAPED_UNICODE);
    $customer_options = Customer::all()->pluck('name', 'id')->toArray();
    $quotation = Quotation::find($id);
    $count = 0;
    $quotationDetails = $quotation->quotationDetails()->orderBy('hier','asc')->get();
    $which = [
      "document"=>$quotation['which_document'],
      "company"=>$quotation['which_company'],
    ];
    $result_Detail = [];
    foreach ($quotationDetails as &$row) {
      $row['folder'] = ($row['folder'] == "1") ? true : false;
      if ($row['folder'] == true) {
        $row['expanded'] = true;
      }
    }
    $judge_id = $quotation->customer_id;
    $customer_arr = [
      "name"=>$customer_options[$judge_id],
      "id" => $quotation->customer_id,
    ];

    //見積もり日付

    $quotationYear = mb_substr($quotation->quotation_day,0,2);
    $quotationMonth = mb_substr($quotation->quotation_day,2,2);
    $quotationDay = mb_substr($quotation->quotation_day,4,2);
    //工期
    $period_before_year = mb_substr($quotation->period_before,0,2);
    $period_before_month = mb_substr($quotation->period_before,2,2);
    $period_before_day = mb_substr($quotation->period_before,4,2);
    $period_affter_year = mb_substr($quotation->period_after,0,2);
    $period_affter_month = mb_substr($quotation->period_after,2,2);
    $period_affter_day = mb_substr($quotation->period_after,4,2);

    foreach($quotationDetails as $quotationDetail){
      $result_Detail[] = [
        "id" => $quotationDetail->id,
        "hier" => $quotationDetail->hier,
        "title" => $quotationDetail->title,
        "standard" => $quotationDetail->standard,
        "quantity" => $quotationDetail->quantity,
        "bugakari" => $quotationDetail->bugakari,
        "unit" => $quotationDetail->unit,
        "price" => $quotationDetail->price,
        "remark" => $quotationDetail->remark
      ];
    }
    if(count($result_Detail) < 10){
      for($i=count($result_Detail); $i < 10; $i++){

        $result_Detail[] = [
          "id" => "",
          "hier" => "",
          "title" => "",
          "standard"=>"",
          "quantity" => "",
          "bugakari" => "",
          "unit" => "",
          "price" => "",
          "remark" => ""
        ];
      }
    }
    $json = $this->makeFancyJson($quotationDetails);
    //見積もり
    $conditions = [
      "customer_id" => $request->input("customer_id", ""),
      "keyword" => $request->input("keyword", "")
    ];
    $quotations = Quotation::customerIdFilter($conditions["customer_id"])
    ->keywordFilter($conditions['keyword'])
    ->orderBy('created_at', 'desc')
    ->get();

    $cost = 0;
    $unitPrice = 0;
    $totalProfit = 0;

    foreach ($quotations as $index => $value) {
      $quotations[$index]['price'] = Quotation::findPlus($value->id);
      $cost += $quotations[$index]['price']->total_small;
      $unitPrice += $quotations[$index]['price']->total;
      $totalProfit += $quotations[$index]['price']->profit;
    }
    foreach ($quotations as  $value) {
      if ($value->which_company == '今井設備工業') {
        $value->which_company = 'I';
      }
      if ($value->which_company == 'ジャストサポート') {
        $value->which_company = 'J';
      }
      if ($value->which_document == '見積') {
        $value->which_document= 'M';
      }
      if ($value->which_document == '請求') {
        $value->which_document= 'S';
      }
    }



    return view('quotation.create-input', compact('unit_options', 'customer_options', 'quotation','which', 'json','quotationDetails','quotations','cost','unitPrice','totalProfit','result_Detail','quotationYear','quotationMonth','quotationDay','period_before_year','period_before_month','period_before_day','period_affter_year','period_affter_month','period_affter_day','customer_arr'));
  }

  public function save(Request $request)
  {

    $detailData = $request->input('detail_data');

    $quotationData = $request->all();

    //使わないもの削除
    unset($quotationData['_token']);
    unset($quotationData['detail_data']);
    //配列に整形
    $fixBox = [];
    for ($i=0; $i < count($quotationData['hier']); $i++) {
      if (is_null($quotationData['hier'][$i]) || is_null($quotationData['title'][$i])) {
        continue;
      }

      $fixBox[$i]['hier'] = $quotationData['hier'][$i];
      $fixBox[$i]['title'] = $quotationData['title'][$i];
      $fixBox[$i]['standard'] = $quotationData['standard'][$i];
      $fixBox[$i]['unit'] = $quotationData['unit'][$i];
      $fixBox[$i]['input_quantity'] = $quotationData['input_quantity'][$i];
      $fixBox[$i]['input_price'] = $quotationData['input_price'][$i];
      $fixBox[$i]['input_bugakari'] = $quotationData['input_bugakari'][$i];
      $fixBox[$i]['input_price'] = $quotationData['input_price'][$i];
      $fixBox[$i]['input_remark'] = $quotationData['input_remark'][$i];
      $fixBox[$i]['total'] = $quotationData['details_total'][$i];
      $fixBox[$i]['total_middle'] = $quotationData['details_total_middle'][$i];
    }
    // echo "<pre>";
    // var_dump($quotationData['input_remark']);
    // exit;

    $detailData = explode(",", $detailData);
    //データ整形
    //使わないもの削除
    array_splice($detailData, 0, 2);
    $detailData = array_merge($detailData);
    $targetData = [];
    $targetData['quotation_day'] = sprintf('%02d',$detailData[1]).sprintf('%02d',$detailData[3]).sprintf('%02d',$detailData[5]);
    $targetData['staffs'] = $detailData[7];
    $targetData['customer_id'] = (int)$detailData[11];
    $targetData['title'] = $detailData[13];
    $targetData['place'] = $detailData[15];
    $targetData['payment_term'] = $detailData[17];
    $targetData['expiration_date'] = $detailData[19];
    $targetData['period_before'] = sprintf('%02d',$detailData[21]).sprintf('%02d',$detailData[23]).sprintf('%02d',$detailData[25]);
    $targetData['period_after'] = sprintf('%02d',$detailData[27]).sprintf('%02d',$detailData[29]).sprintf('%02d',$detailData[31]);
    $targetData['remark'] = $detailData[33];
    $targetData['which_company'] = $detailData[35];
    $targetData['which_document'] = $detailData[37];
    $targetData['quotation_id'] = $detailData[41];
    if ($targetData['customer_id'] == 0) {
      return redirect('quotation/list');
    }

    DB::beginTransaction();
    try {
      //quotaionsテーブルInsert or Update
      $lastId =  Quotation::updateOrCreate(
        ['id' => $targetData['quotation_id']],
        [
          'period_before' => $targetData['period_before'],
          'period_after' => $targetData['period_after'],
          'quotation_day' => $targetData['quotation_day'],
          'staffs' => $targetData['staffs'],
          'customer_id' => $targetData['customer_id'],
          'period_before' => $targetData['period_before'],
          'period_after' => $targetData['period_after'],
          'title' => $targetData['title'],
          'place' => $targetData['place'],
          'payment_term' => $targetData['payment_term'],
          'expiration_date' => $targetData['expiration_date'],
          'remark' => $targetData['remark'],
          'which_company' => $targetData['which_company'],
          'which_document' => $targetData['which_document'],
          'sub_total' => $quotationData['sub_total'],
          'total_tax'=>$quotationData['total_tax'],
          'total'=>$quotationData['total'],
          'profit_rate'=>$quotationData['profit_rate'],
          'profit' => $quotationData['profit']

        ]
      );
      //quotation_detailsテーブルInsert or Update

      if ($targetData['quotation_id'] == "") {
        DB::table('quotation_details')->where('quotation_id', '=', $targetData['quotation_id'])->delete();
        foreach ($fixBox as  $value) {
          DB::table('quotation_details')->insert([
            'hier' => $value['hier'],
            'title' => $value['title'],
            'quotation_id' => $lastId->id,
            'folder' =>0,
            'standard' => $value['standard'],
            'quantity' => $value['input_quantity'],
            'unit' => $value['unit'],
            'price' => $value['input_price'],
            'bugakari' => $value['input_bugakari'],
            'remark' => $value['input_remark'],
            'total' => $value['total'],
            'total_middle' => $value['total_middle'],
          ]);
        }
      }else {
        DB::table('quotation_details')->where('quotation_id', '=', $targetData['quotation_id'])->delete();
        foreach ($fixBox as  $value) {
          DB::table('quotation_details')->insert([
            'hier' => $value['hier'],
            'title' => $value['title'],
            'quotation_id' => $targetData['quotation_id'],
            'folder' =>0,
            'standard' => $value['standard'],
            'quantity' => $value['input_quantity'],
            'unit' => $value['unit'],
            'price' => $value['input_price'],
            'bugakari' => $value['input_bugakari'],
            'remark' => $value['input_remark'],
            'total' => $value['total'],
            'total_middle' => $value['total_middle'],
          ]);
        }
      }


    } catch (\Exception $e) {

      DB::rollback();
      throw $e;
    }
    DB::commit();

    if (isset($targetData['quotation_id'])){
      $quotation_id =$lastId->id;
    }else {
      $quotation_id = $targetData['quotation_id'];
    }
    $request->session()->regenerateToken();
    return redirect('quotation/show/' . $quotation_id)->with('message', '保存しました');
  }

  public function showPdf(Request $request, $id)
  {
    return view('quotation.pdf');
    // // no_tax の場合のパラメータの値は、"1"のみ
    // $noTax = $request->get("no_tax", "");
    // //var_dump($id);
    // $customer_options = Customer::all()->pluck('name', 'id')->toArray();
    // $unit_options = config('const.unit_options');
    // $quotation = Quotation::findPlus($id);
    // //$pdf = \Barryvdh\DomPDF::loadView('quotation.pdf', compact('quotataion'));

    // $templateName = '';
    // // 税なし
    // if ($noTax == "1") {
    //   $templateName = 'quotation.pdf-no-tax';
    // }
    // // 税表示
    // else {
    //   $templateName = 'quotation.pdf';
    // }
    // // $pdf = \PDF::loadView($templateName, compact('quotation', 'customer_options', 'unit_options'));
    // $pdf = \PDF::loadView("quotation.template");
    // $pdf->setOptions(["isPhpEnabled"=>true, "enable_font_subsetting"=>true]);
    // return $pdf->stream();
    // //return $pdf->download();
    // //return view('quotation.pdf');
  }

  public function excel(Request $request){
    $quotation = Quotation::find($request->id);
    $customer = Customer::find($quotation->customer_id);
    $quotationDetails = QuotationDetail::where('quotation_id', "=", $request->id)->get();

    $result_bigs = clone $quotationDetails;
    $tmp = $result_bigs;
    $count = 0;
    foreach($tmp as $result_big){
      if(strpos($result_big["hier"],'-') !== false){
        unset($result_bigs[$count]);
      }
      $count++;
    }
    $result_bigs = array_merge($result_bigs->toArray());

    $format = ($quotation->which_company).($quotation->which_document);
    if($format == "今井設備工業見積" || $format == "今井設備工業請求"){
      /*
      * 読み込みサンプル
      */
      $reader = new XlsxReader('Excel5');
      $spreadsheet = $reader->load("template.xlsx");
      $sheet = $spreadsheet->getActiveSheet();

      // ファイルのプロパティを設定
      $spreadsheet->getProperties()
      ->setTitle("御".$quotation->which_document."書");

      // シート作成
      $spreadsheet->getActiveSheet('sheet1')->UnFreezePane();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->setTitle("御".$quotation->which_document."書");

      // 値を設定
      $sheet->setCellValue('G3', "御".$quotation->which_document."書");
      $sheet->setCellValue('C8', "下記の通り、御".$quotation->which_document."申し上げます。");
      $sheet->setCellValue('D6', $customer->name);
      $sheet->setCellValue('G6', $request->O_S_D);
      $sheet->setCellValue('L3', "令和".(int)substr("$quotation->quotation_day", 0, 2)."年".(int)substr($quotation->quotation_day, 2, 2)."月".(int)substr($quotation->quotation_day, 4, 2)."日");
      $sheet->setCellValue('L4', "No. ".sprintf('%04d', $request->id));
      $sheet->setCellValue('D8', "下記の通り、御".$quotation->which_document."申し上げます。");
      $sheet->setCellValue('E11', $quotation->title);
      $sheet->setCellValue('E12', $quotation->place);
      $sheet->setCellValue('E13', "令和".(int)substr($quotation->period_before, 0, 2)."年".(int)substr($quotation->period_before, 2, 2)."月".(int)substr($quotation->period_before, 4, 2)."日 〜 令和".(int)substr($quotation->period_after, 0, 2)."年".(int)substr($quotation->period_after, 2, 2)."月".(int)substr($quotation->period_after, 4, 2)."日");
      $sheet->setCellValue('E14', $quotation->payment_term);
      $sheet->setCellValue('E15', $quotation->expiration_date);
      $sheet->setCellValue('E17', (int)str_replace(',', '', $request->total));
      $sheet->setCellValue('O17', (int)str_replace(',', '', $request->total_tax));

      if($quotation->which_document == "見積"){
        $sheet->setCellValue('I14', "お振込先：千葉銀行　茂原支店　普通　2259982");
      }

      $line = 20;
      foreach($quotationDetails as $quotationDetail){
        if($line < 29){
          $sheet->setCellValue('C'.$line, $quotationDetail->hier);
          $sheet->setCellValue('D'.$line, $quotationDetail->title."\n　".$quotationDetail->standard);
          $sheet->setCellValue('G'.$line,  $quotationDetail->quantity);
          $sheet->setCellValue('H'.$line,  $quotationDetail->unit);
          $sheet->setCellValue('J'.$line,  $quotationDetail->price);
          if($quotationDetail->total != NULL){
            $sheet->setCellValue('L'.$line,  $quotationDetail->total);
          }else if($quotationDetail->total_middle != NULL){
            $sheet->setCellValue('L'.$line,  $quotationDetail->total_middle);
          }else{
            $sheet->setCellValue('L'.$line,  (int)$quotationDetail->quantity * (int)$quotationDetail->price);
          }
          $sheet->setCellValue('N'.$line,  $quotationDetail->remark);
          $line++;
        }else{
          $sheet->insertNewRowBefore($line, 1);
          $sheet->mergeCells('D'.$line.':F'.$line);
          $sheet->mergeCells('H'.$line.':I'.$line);
          $sheet->mergeCells('J'.$line.':K'.$line);
          $sheet->mergeCells('L'.$line.':M'.$line);
          $sheet->mergeCells('N'.$line.':O'.$line);
          $sheet->setCellValue('C'.$line, $quotationDetail->hier);
          $sheet->setCellValue('D'.$line, $quotationDetail->title);
          $sheet->setCellValue('G'.$line,  $quotationDetail->quantity);
          $sheet->setCellValue('H'.$line,  $quotationDetail->unit);
          $sheet->setCellValue('J'.$line,  $quotationDetail->price);
          if($quotationDetail->total != NULL){
            $sheet->setCellValue('L'.$line,  $quotationDetail->total);
          }else if($quotationDetail->total_middle != NULL){
            $sheet->setCellValue('L'.$line,  $quotationDetail->total_middle);
          }else{
            $sheet->setCellValue('L'.$line,  (int)$quotationDetail->quantity * (int)$quotationDetail->price);
          }
          $sheet->setCellValue('N'.$line,  $quotationDetail->remark);
          $line++;
        }
      }

      if($line < 29){
        $sheet->setCellValue('K31', (int)str_replace(',', '', $request->total_small));
        // $sheet->setCellValue('K37', (int)str_replace(',', '', $request->total_small));
        // $sheet->setCellValue('K38', (int)str_replace(',', '', $request->total_tax));
        // $sheet->setCellValue('K39', (int)str_replace(',', '', $request->total));
        $sheet->setCellValue('K32', (int)str_replace(',', '', $request->total_tax));
        $sheet->setCellValue('K33', (int)str_replace(',', '', $request->total));
      }else{
        $sheet->setCellValue('K'.($line+2), (int)str_replace(',', '', $request->total_small));
        // $sheet->setCellValue('K'.($line+3), (int)str_replace(',', '', $request->total_small));
        // $sheet->setCellValue('K'.($line+4), (int)str_replace(',', '', $request->total_tax));
        // $sheet->setCellValue('K'.($line+5), (int)str_replace(',', '', $request->total));
        $sheet->setCellValue('K'.($line+3), (int)str_replace(',', '', $request->total_tax));
        $sheet->setCellValue('K'.($line+4), (int)str_replace(',', '', $request->total));
      }

    }else if($format == "ジャストサポート見積"){

      /*
      * 読み込みサンプル
      */
      $reader = new XlsxReader('Excel5');
      $spreadsheet = $reader->load("template_just_m.xlsx");
      $sheet = $spreadsheet->getActiveSheet();

      // ファイルのプロパティを設定
      $spreadsheet->getProperties()
      ->setTitle("御".$quotation->which_document."書");

      // シート作成
      $spreadsheet->getActiveSheet('sheet1')->UnFreezePane();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->setTitle("御".$quotation->which_document."書");

      // 値を設定
      $sheet->setCellValue('D4', $customer->name);
      $sheet->setCellValue('G4', $request->O_S_D);
      $sheet->setCellValue('C6', "令和".(int)substr("$quotation->quotation_day", 0, 2)."年".(int)substr($quotation->quotation_day, 2, 2)."月".(int)substr($quotation->quotation_day, 4, 2)."日");
      $sheet->setCellValue('O2', "No. ".sprintf('%04d', $request->id));
      $sheet->setCellValue('E9', (int)str_replace(',', '',$request->total));
      $sheet->setCellValue('G11', ((int)str_replace(',', '',$request->total))-((int)str_replace(',', '',$request->total_tax)));
      $sheet->setCellValue('G12', $request->total_tax);
      $sheet->setCellValue('E15', $quotation->title);
      $sheet->setCellValue('E16', $quotation->place);
      $sheet->setCellValue('E17', "令和".(int)substr($quotation->period_before, 0, 2)."年".(int)substr($quotation->period_before, 2, 2)."月".(int)substr($quotation->period_before, 4, 2)."日 〜 令和".(int)substr($quotation->period_after, 0, 2)."年".(int)substr($quotation->period_after, 2, 2)."月".(int)substr($quotation->period_after, 4, 2)."日");
      $sheet->setCellValue('E18', $quotation->payment_term);
      $sheet->setCellValue('E19', $quotation->remark);
      $sheet->setCellValue('E25', $quotation->title);
      $sheet->setCellValue('O25', "No. ".sprintf('%04d', $request->id));

      $line = 27;
      foreach($result_bigs as $quotationDetail){
        if($line < 39){
          $sheet->setCellValue('C'.$line, $quotationDetail["title"]);
          $sheet->setCellValue('F'.$line,  $quotationDetail["standard"]);
          $sheet->setCellValue('H'.$line,  $quotationDetail["quantity"]);
          $sheet->setCellValue('I'.$line,  $quotationDetail["unit"]);
          $sheet->setCellValue('K'.$line,  $quotationDetail["price"]);
          if($quotationDetail["total"] != NULL){
            $sheet->setCellValue('M'.$line,  $quotationDetail["total"]);
          }else if($quotationDetail["total_middle"] != NULL){
            $sheet->setCellValue('M'.$line,  $quotationDetail["total_middle"]);
          }else{
            $sheet->setCellValue('M'.$line,  (int)$quotationDetail["quantity"] * (int)$quotationDetail["price"]);
          }
          $sheet->setCellValue('N'.$line,  $quotationDetail["remark"]);
          $line++;
        }else{
          $sheet->insertNewRowBefore($line, 1);
          $sheet->mergeCells('C'.$line.':E'.$line);
          $sheet->mergeCells('F'.$line.':G'.$line);
          $sheet->mergeCells('I'.$line.':J'.$line);
          $sheet->mergeCells('K'.$line.':L'.$line);
          $sheet->mergeCells('M'.$line.':N'.$line);
          $sheet->mergeCells('O'.$line.':P'.$line);
          $sheet->setCellValue('C'.$line, $quotationDetail["title"]);
          $sheet->setCellValue('F'.$line,  $quotationDetail["standard"]);
          $sheet->setCellValue('H'.$line,  $quotationDetail["quantity"]);
          $sheet->setCellValue('I'.$line,  $quotationDetail["unit"]);
          $sheet->setCellValue('K'.$line,  $quotationDetail["price"]);
          if($quotationDetail["total"] != NULL){
            $sheet->setCellValue('M'.$line,  $quotationDetail["total"]);
          }else if($quotationDetail["total_middle"] != NULL){
            $sheet->setCellValue('M'.$line,  $quotationDetail["total_middle"]);
          }else{
            $sheet->setCellValue('M'.$line,  (int)$quotationDetail["quantity"] * (int)$quotationDetail["price"]);
          }
          $sheet->setCellValue('N'.$line,  $quotationDetail["remark"]);
          $line++;
        }
      }

      if($line < 39){

        $sheet->setCellValue('M41', $request->total_small);
        $sheet->setCellValue('M42', $request->total_tax);
        $sheet->setCellValue('M43', $request->total);

        $sheet->setCellValue('E50', $quotation->title);
        $sheet->setCellValue('O50', "No. ".sprintf('%04d', $request->id));

        $line = 52;
        foreach($quotationDetails as $quotationDetail){
          if($line < 67){
            $sheet->setCellValue('C'.$line, $quotationDetail->title);
            $sheet->setCellValue('F'.$line, $quotationDetail->standard);
            $sheet->setCellValue('H'.$line,  $quotationDetail->quantity);
            $sheet->setCellValue('I'.$line,  $quotationDetail->unit);
            $sheet->setCellValue('K'.$line,  $quotationDetail->price);
            if($quotationDetail->total != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total);
            }else if($quotationDetail->total_middle != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total_middle);
            }else{
              $sheet->setCellValue('M'.$line,  (int)$quotationDetail->quantity * (int)$quotationDetail->price);
            }
            $sheet->setCellValue('O'.$line,  $quotationDetail->remark);
            $line++;
          }else{
            $sheet->insertNewRowBefore($line, 1);
            $sheet->mergeCells('C'.$line.':E'.$line);
            $sheet->mergeCells('F'.$line.':G'.$line);
            $sheet->mergeCells('I'.$line.':J'.$line);
            $sheet->mergeCells('K'.$line.':L'.$line);
            $sheet->mergeCells('M'.$line.':N'.$line);
            $sheet->mergeCells('O'.$line.':P'.$line);
            $sheet->setCellValue('C'.$line, $quotationDetail->title);
            $sheet->setCellValue('F'.$line, $quotationDetail->standard);
            $sheet->setCellValue('H'.$line,  $quotationDetail->quantity);
            $sheet->setCellValue('I'.$line,  $quotationDetail->unit);
            $sheet->setCellValue('K'.$line,  $quotationDetail->price);
            if($quotationDetail->total != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total);
            }else if($quotationDetail->total_middle != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total_middle);
            }else{
              $sheet->setCellValue('M'.$line,  (int)$quotationDetail->quantity * (int)$quotationDetail->price);
            }
            $sheet->setCellValue('O'.$line,  $quotationDetail->remark);
            $line++;
          }
        }
      }else{

        $sheet->setCellValue('M'.($line+2), $request->total_small);
        $sheet->setCellValue('M'.($line+3), $request->total_tax);
        $sheet->setCellValue('M'.($line+4), $request->total);

        $sheet->setCellValue('E'.($line+11), $quotation->title);
        $sheet->setCellValue('O'.($line+11), "No. ".sprintf('%04d', $request->id));

        $line = $line+13;
        $count = 1;
        foreach($quotationDetails as $quotationDetail){
          if($count < 16){
            $sheet->setCellValue('C'.$line, $quotationDetail->title);
            $sheet->setCellValue('F'.$line, $quotationDetail->standard);
            $sheet->setCellValue('H'.$line,  $quotationDetail->quantity);
            $sheet->setCellValue('I'.$line,  $quotationDetail->unit);
            $sheet->setCellValue('K'.$line,  $quotationDetail->price);
            if($quotationDetail->total != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total);
            }else if($quotationDetail->total_middle != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total_middle);
            }else{
              $sheet->setCellValue('M'.$line,  (int)$quotationDetail->quantity * (int)$quotationDetail->price);
            }
            $sheet->setCellValue('O'.$line,  $quotationDetail->remark);
            $line++;
            $count++;
          }else{
            $sheet->insertNewRowBefore($line, 1);
            $sheet->mergeCells('C'.$line.':E'.$line);
            $sheet->mergeCells('F'.$line.':G'.$line);
            $sheet->mergeCells('I'.$line.':J'.$line);
            $sheet->mergeCells('K'.$line.':L'.$line);
            $sheet->mergeCells('M'.$line.':N'.$line);
            $sheet->mergeCells('O'.$line.':P'.$line);
            $sheet->setCellValue('C'.$line, $quotationDetail->title);
            $sheet->setCellValue('F'.$line, $quotationDetail->standard);
            $sheet->setCellValue('H'.$line,  $quotationDetail->quantity);
            $sheet->setCellValue('I'.$line,  $quotationDetail->unit);
            $sheet->setCellValue('K'.$line,  $quotationDetail->price);
            if($quotationDetail->total != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total);
            }else if($quotationDetail->total_middle != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total_middle);
            }else{
              $sheet->setCellValue('M'.$line,  (int)$quotationDetail->quantity * (int)$quotationDetail->price);
            }
            $sheet->setCellValue('O'.$line,  $quotationDetail->remark);
            $line++;
          }
        }
      }

    }else{

      /*
      * 読み込みサンプル
      */
      $reader = new XlsxReader('Excel5');
      $spreadsheet = $reader->load("template_just_s.xlsx");
      $sheet = $spreadsheet->getActiveSheet();

      // ファイルのプロパティを設定
      $spreadsheet->getProperties()
      ->setTitle("御".$quotation->which_document."書");

      // シート作成
      $spreadsheet->getActiveSheet('sheet1')->UnFreezePane();
      $sheet = $spreadsheet->getActiveSheet();
      $sheet->setTitle("御".$quotation->which_document."書");

      // 値を設定
      $sheet->setCellValue('D4', $customer->name);
      $sheet->setCellValue('G4', $quotation->O_S_D);
      $sheet->setCellValue('E6', "令和".(int)substr("$quotation->quotation_day", 0, 2)."年".(int)substr($quotation->quotation_day, 2, 2)."月".(int)substr($quotation->quotation_day, 4, 2)."日");
      $sheet->setCellValue('O2', "No. ".sprintf('%04d', $request->id));
      $sheet->setCellValue('E8', (int)str_replace(',', '',$request->total));
      $sheet->setCellValue('E9', ((int)str_replace(',', '',$request->total))-((int)str_replace(',', '',$request->total_tax)));
      $sheet->setCellValue('E10', (int)str_replace(',', '',$request->total_tax));
      $sheet->setCellValue('F14', (int)str_replace(',', '',$request->total));
      $sheet->setCellValue('C19', $quotation->remark);
      $sheet->setCellValue('M8', $quotation->title);
      $sheet->setCellValue('M9', $quotation->place);
      $sheet->setCellValue('M10', "令和".(int)substr($quotation->period_before, 0, 2)."年".(int)substr($quotation->period_before, 2, 2)."月".(int)substr($quotation->period_before, 4, 2)."日 〜 令和".(int)substr($quotation->period_after, 0, 2)."年".(int)substr($quotation->period_after, 2, 2)."月".(int)substr($quotation->period_after, 4, 2)."日");
      $sheet->setCellValue('E25', $quotation->title);
      $sheet->setCellValue('O25', "No. ".sprintf('%04d', $request->id));

      $line = 27;
      foreach($result_bigs as $quotationDetail){
        if($line < 39){
          $sheet->setCellValue('C'.$line, $quotationDetail["title"]);
          $sheet->setCellValue('F'.$line,  $quotationDetail["standard"]);
          $sheet->setCellValue('H'.$line,  $quotationDetail["quantity"]);
          $sheet->setCellValue('I'.$line,  $quotationDetail["unit"]);
          $sheet->setCellValue('K'.$line,  $quotationDetail["price"]);
          if($quotationDetail["total"] != NULL){
            $sheet->setCellValue('M'.$line,  $quotationDetail["total"]);
          }else if($quotationDetail["total_middle"] != NULL){
            $sheet->setCellValue('M'.$line,  $quotationDetail["total_middle"]);
          }else{
            $sheet->setCellValue('M'.$line,  (int)$quotationDetail["quantity"] * (int)$quotationDetail["price"]);
          }
          $sheet->setCellValue('N'.$line,  $quotationDetail["remark"]);
          $line++;
        }else{
          $sheet->insertNewRowBefore($line, 1);
          $sheet->mergeCells('C'.$line.':E'.$line);
          $sheet->mergeCells('F'.$line.':G'.$line);
          $sheet->mergeCells('I'.$line.':J'.$line);
          $sheet->mergeCells('K'.$line.':L'.$line);
          $sheet->mergeCells('M'.$line.':N'.$line);
          $sheet->mergeCells('O'.$line.':P'.$line);
          $sheet->setCellValue('C'.$line, $quotationDetail["title"]);
          $sheet->setCellValue('F'.$line,  $quotationDetail["standard"]);
          $sheet->setCellValue('H'.$line,  $quotationDetail["quantity"]);
          $sheet->setCellValue('I'.$line,  $quotationDetail["unit"]);
          $sheet->setCellValue('K'.$line,  $quotationDetail["price"]);
          if($quotationDetail["total"] != NULL){
            $sheet->setCellValue('M'.$line,  $quotationDetail["total"]);
          }else if($quotationDetail["total_middle"] != NULL){
            $sheet->setCellValue('M'.$line,  $quotationDetail["total_middle"]);
          }else{
            $sheet->setCellValue('M'.$line,  (int)$quotationDetail["quantity"] * (int)$quotationDetail["price"]);
          }
          $sheet->setCellValue('N'.$line,  $quotationDetail["remark"]);
          $line++;
        }
      }

      if($line < 39){

        $sheet->setCellValue('M41', $request->total_small);
        $sheet->setCellValue('M42', $request->total_tax);
        $sheet->setCellValue('M43', $request->total);

        $sheet->setCellValue('E50', $quotation->title);
        $sheet->setCellValue('O50', "No. ".sprintf('%04d', $request->id));

        $line = 52;
        foreach($quotationDetails as $quotationDetail){
          if($line < 67){
            $sheet->setCellValue('C'.$line, $quotationDetail->title);
            $sheet->setCellValue('F'.$line, $quotationDetail->standard);
            $sheet->setCellValue('H'.$line,  $quotationDetail->quantity);
            $sheet->setCellValue('I'.$line,  $quotationDetail->unit);
            $sheet->setCellValue('K'.$line,  $quotationDetail->price);
            if($quotationDetail->total != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total);
            }else if($quotationDetail->total_middle != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total_middle);
            }else{
              $sheet->setCellValue('M'.$line,  (int)$quotationDetail->quantity * (int)$quotationDetail->price);
            }
            $sheet->setCellValue('O'.$line,  $quotationDetail->remark);
            $line++;
          }else{
            $sheet->insertNewRowBefore($line, 1);
            $sheet->mergeCells('C'.$line.':E'.$line);
            $sheet->mergeCells('F'.$line.':G'.$line);
            $sheet->mergeCells('I'.$line.':J'.$line);
            $sheet->mergeCells('K'.$line.':L'.$line);
            $sheet->mergeCells('M'.$line.':N'.$line);
            $sheet->mergeCells('O'.$line.':P'.$line);
            $sheet->setCellValue('C'.$line, $quotationDetail->title);
            $sheet->setCellValue('F'.$line, $quotationDetail->standard);
            $sheet->setCellValue('H'.$line,  $quotationDetail->quantity);
            $sheet->setCellValue('I'.$line,  $quotationDetail->unit);
            $sheet->setCellValue('K'.$line,  $quotationDetail->price);
            if($quotationDetail->total != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total);
            }else if($quotationDetail->total_middle != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total_middle);
            }else{
              $sheet->setCellValue('M'.$line,  (int)$quotationDetail->quantity * (int)$quotationDetail->price);
            }
            $sheet->setCellValue('O'.$line,  $quotationDetail->remark);
            $line++;
          }
        }
      }else{

        $sheet->setCellValue('M'.($line+2), $request->total_small);
        $sheet->setCellValue('M'.($line+3), $request->total_tax);
        $sheet->setCellValue('M'.($line+4), $request->total);

        $sheet->setCellValue('E'.($line+11), $quotation->title);
        $sheet->setCellValue('O'.($line+11), "No. ".sprintf('%04d', $request->id));

        $line = $line+13;
        $count = 1;
        foreach($quotationDetails as $quotationDetail){
          if($count < 16){
            $sheet->setCellValue('C'.$line, $quotationDetail->title);
            $sheet->setCellValue('F'.$line, $quotationDetail->standard);
            $sheet->setCellValue('H'.$line,  $quotationDetail->quantity);
            $sheet->setCellValue('I'.$line,  $quotationDetail->unit);
            $sheet->setCellValue('K'.$line,  $quotationDetail->price);
            if($quotationDetail->total != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total);
            }else if($quotationDetail->total_middle != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total_middle);
            }else{
              $sheet->setCellValue('M'.$line,  (int)$quotationDetail->quantity * (int)$quotationDetail->price);
            }
            $sheet->setCellValue('O'.$line,  $quotationDetail->remark);
            $line++;
            $count++;
          }else{
            $sheet->insertNewRowBefore($line, 1);
            $sheet->mergeCells('C'.$line.':E'.$line);
            $sheet->mergeCells('F'.$line.':G'.$line);
            $sheet->mergeCells('I'.$line.':J'.$line);
            $sheet->mergeCells('K'.$line.':L'.$line);
            $sheet->mergeCells('M'.$line.':N'.$line);
            $sheet->mergeCells('O'.$line.':P'.$line);
            $sheet->setCellValue('C'.$line, $quotationDetail->title);
            $sheet->setCellValue('F'.$line, $quotationDetail->standard);
            $sheet->setCellValue('H'.$line,  $quotationDetail->quantity);
            $sheet->setCellValue('I'.$line,  $quotationDetail->unit);
            $sheet->setCellValue('K'.$line,  $quotationDetail->price);
            if($quotationDetail->total != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total);
            }else if($quotationDetail->total_middle != NULL){
              $sheet->setCellValue('M'.$line,  $quotationDetail->total_middle);
            }else{
              $sheet->setCellValue('M'.$line,  (int)$quotationDetail->quantity * (int)$quotationDetail->price);
            }
            $sheet->setCellValue('O'.$line,  $quotationDetail->remark);
            $line++;
          }
        }
      }


    }

    // バッファをクリア
    ob_end_clean();

    $fileName = sprintf('%04d', $request->id).".xlsx";

    // ダウンロード
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$fileName.'"');
    header('Cache-Control: max-age=0');
    header('Cache-Control: max-age=1');
    header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
    header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
    header('Cache-Control: cache, must-revalidate');
    header('Pragma: public');

    $writer = new Xlsx($spreadsheet);
    $writer->save('php://output');

    exit();

  }

  public function preview(Request $request){
    $quotation = Quotation::find($request->id);
    $customer = Customer::find($quotation->customer_id);
    $result = [
      "M_S" => $quotation->which_document,
      "quotation_day_year" => (int)substr("$quotation->quotation_day", 0, 2),
      "quotation_day_month" => (int)substr($quotation->quotation_day, 2, 2),
      "quotation_day_day" => (int)substr($quotation->quotation_day, 4, 2),
      "id" => sprintf('%04d', $request->id),
      "customer" => $customer->name,
      "O_S_D" => $request->O_S_D,
      "title" => $quotation->title,
      "place" => $quotation->place,
      "period_before_year" => (int)substr($quotation->period_before, 0, 2),
      "period_before_month" => (int)substr($quotation->period_before, 2, 2),
      "period_before_day" => (int)substr($quotation->period_before, 4, 2),
      "period_after_year" => (int)substr($quotation->period_after, 0, 2),
      "period_after_month" => (int)substr($quotation->period_after, 2, 2),
      "period_after_day" => (int)substr($quotation->period_after, 4, 2),
      "payment_term" => $quotation->payment_term,
      "expiration_date" => $quotation->expiration_date,
      "total_tax" => $request->total_tax,
      "total" => $request->total,
      "total_small" => $request->total_small,
      "tax_subtraction" => ((int)str_replace(',', '', $request->total))-((int)str_replace(',', '', $request->total_tax)),
      "remark" => $quotation->remark
    ];


    $quotationDetails = QuotationDetail::where('quotation_id', "=", $request->id)->get();

    $result_Detail = [];
    foreach($quotationDetails as $quotationDetail){
      if($quotationDetail->total != NULL){
        $result_Detail[] = [
          "hier" => $quotationDetail->hier,
          "title" => $quotationDetail->title,
          "standard" => $quotationDetail->standard,
          "quantity" => $quotationDetail->quantity,
          "unit" => $quotationDetail->unit,
          "unit_price" => $quotationDetail->price,
          "price" => (int)$quotationDetail->total,
          "remark" => $quotationDetail->remark
        ];
      }else if($quotationDetail->total_middle != NULL){
        $result_Detail[] = [
          "hier" => $quotationDetail->hier,
          "title" => $quotationDetail->title,
          "standard" => $quotationDetail->standard,
          "quantity" => $quotationDetail->quantity,
          "unit" => $quotationDetail->unit,
          "unit_price" => $quotationDetail->price,
          "price" => (int)$quotationDetail->total_middle,
          "remark" => $quotationDetail->remark
        ];
      }else{
        $result_Detail[] = [
          "hier" => $quotationDetail->hier,
          "title" => $quotationDetail->title,
          "standard" => $quotationDetail->standard,
          "quantity" => $quotationDetail->quantity,
          "unit" => $quotationDetail->unit,
          "unit_price" => $quotationDetail->price,
          "price" => (int)$quotationDetail->quantity * (int)$quotationDetail->price,
          "remark" => $quotationDetail->remark
        ];
      }
    }

    $format = ($quotation->which_company).($quotation->which_document);

    if($format == "今井設備工業見積" || $format == "今井設備工業請求"){
      if(count($result_Detail) < 10){
        for($i=count($result_Detail); $i < 10; $i++){
          $result_Detail[] = [
            "hier" => "",
            "title" => "",
            "standard" => "",
            "quantity" => "",
            "unit" => "",
            "unit_price" => "",
            "price" => "",
            "remark" => ""
          ];
        }
      }
    }else if($format == "ジャストサポート見積" || $format == "ジャストサポート請求"){
      if(count($result_Detail) < 14){
        for($i=count($result_Detail); $i < 14; $i++){
          $result_Detail[] = [
            "hier" => "",
            "title" => "",
            "standard"=>"",
            "quantity" => "",
            "unit" => "",
            "unit_price" => "",
            "price" => "",
            "remark" => ""
          ];
        }
      }
    }

    $result_bigs = $result_Detail;
    $tmp = $result_bigs;
    $count = 0;
    foreach($tmp as $result_big){
      if(strpos($result_big["hier"],'-') !== false){
        // dd($result_big["hier"]);
        unset($result_bigs[$count]);
      }
      $count++;
    }
    $result_bigs = array_merge($result_bigs);

    if(count($result_bigs) < 15){
      for($i=count($result_bigs); $i < 15; $i++){
        $result_bigs[] = [
          "hier" => "",
          "standard" => "",
          "title" => "",
          "quantity" => "",
          "unit" => "",
          "unit_price" => "",
          "price" => "",
          "remark" => ""
        ];
      }
    }

    return view('quotation.preview' , compact("result","result_Detail","format","result_bigs"));
  }

  public function searchList(Request $request)
  {
    $query = Quotation::query();

    // 担当者で絞り込み
    if($request->staffs != null){
      $query->where('staffs',$request->staffs);
    }

    // which_documentで絞り込み
    if($request->radio_1 == "見積"){
      $query->where('which_document',$request->radio_1);
    }else if($request->radio_1 == "請求"){
      $query->where('which_document',$request->radio_1);
    }

    // which_companyで絞り込み
    if($request->radio_2 == "今井設備工業"){
      $query->where('which_company',$request->radio_2);
    }else if($request->radio_2 == "ジャストサポート"){
      $query->where('which_company',$request->radio_2);
    }

    // 見積期間(Before)で絞り込み
    if($request->year_before != null && $request->month_before != null && $request->day_before != null){
      $year_before = sprintf('%002d', (int)$request->year_before);
      $month_before = sprintf('%002d', (int)$request->month_before);
      $day_before = sprintf('%002d', (int)$request->day_before);
      $request_before = ($year_before*10000)+($month_before*100)+$day_before;
      $query->where('quotation_day','>=',$request_before);
    }

    // 見積期間(After)で絞り込み
    if($request->year_after != null && $request->month_after != null && $request->day_after != null){
      $year_after = sprintf('%002d', (int)$request->year_after);
      $month_after = sprintf('%002d', (int)$request->month_after);
      $day_after = sprintf('%002d', (int)$request->day_after);
      $request_after = ($year_after*10000)+($month_after*100)+$day_after;
      $query->where('quotation_day','<=',$request_after);
    }

    // 顧客名で絞り込み(Customerテーブル参照)
    if($request->name != null){
      $tmp  = Customer::query();
      $tmp->where('name', 'like' , "%{$request->name}%");
      $tmp = $tmp->get();
      $tmp = $tmp->pluck('id')->toArray();
      $query->wherein('customer_id' , $tmp);
    }

    // フリーワード検索
    if($request->freeword != null){

      $keyword = $request->freeword;
      // +を半角スペースに変換（GETメソッド対策）
      $keyword = str_replace('+', ' ', $keyword);
      // 全角スペースを半角スペースに変換
      $keyword = str_replace('　', ' ', $keyword);
      // 取得したキーワードのスペースの重複を除く。
      $keyword = preg_replace('/\s(?=\s)/', '', $keyword);
      // キーワード文字列の前後のスペースを削除する
      $keyword = trim($keyword);
      $arrayKeys = array_unique(explode(' ', $keyword));

      foreach($arrayKeys as $arrayKey){

        $query->where(function($query) use($arrayKey){
          $query->where('title', 'like', "%{$arrayKey}%")
          ->orWhere('place', 'like', "%{$arrayKey}%")
          ->orWhere('period_before', 'like', "%{$arrayKey}%")
          ->orWhere('period_after', 'like', "%{$arrayKey}%")
          ->orWhere('payment_term', 'like', "%{$arrayKey}%")
          ->orWhere('expiration_date', 'like', "%{$arrayKey}%")
          ->orWhere('staffs', 'like', "%{$arrayKey}%")
          ->orWhere('remark', 'like', "%{$arrayKey}%");
        });

      }
    }
    $result = $query->orderBy('updated_at', 'desc')->get();

    // 表示データの整形
    $conditions = [
      "customer_id" => $request->input("customer_id", ""),
      "keyword" => $request->input("keyword", "")
    ];

    $quotations = $result;

    $quotations = new LengthAwarePaginator(
      $quotations,
      count($quotations),
      1000,
      1,
      array('path' => $request->url())
    );

    // $quotations = Quotation::customerIdFilter($conditions["customer_id"])
    // ->keywordFilter($conditions['keyword'])
    // ->orderBy('created_at', 'desc')
    // ->paginate(config('const.row_count_per_page'));


    $cost = 0;
    $unitPrice = 0;
    $totalProfit = 0;

    if($quotations[0] != null){
      foreach ($quotations as $index => $value) {
        $cost += $quotations[$index]->sub_total;
        $unitPrice += $quotations[$index]->total;
        $totalProfit += $quotations[$index]->profit;
      }
    }
    foreach ($quotations as  $value) {
      if ($value->which_company == '今井設備工業') {
        $value->which_company = 'I';
      }
      if ($value->which_company == 'ジャストサポート') {
        $value->which_company = 'J';
      }
      if ($value->which_document == '見積') {
        $value->which_document= 'M';
      }
      if ($value->which_document == '請求') {
        $value->which_document= 'S';
      }
    }

    if($quotations[0] != null && $cost != 0){
      $totalProfitRate = floor(($totalProfit / $cost ) *$this->percentage);
    }else{
      $totalProfitRate = 0;
    }

    $customer_options = Customer::all()->pluck('name', 'id')->toArray();
    return view('quotation.list', compact(
      'quotations', 'customer_options', 'conditions','cost','unitPrice','totalProfit','totalProfitRate'
    ));
  }

  public function searchCustomer(Request $request) {

    $keyword = $request->input('keyword', '');

    // +を半角スペースに変換（GETメソッド対策）
    $keyword = str_replace('+', ' ', $keyword);
    // 全角スペースを半角スペースに変換
    $keyword = str_replace('　', ' ', $keyword);
    // 取得したキーワードのスペースの重複を除く。
    $keyword = preg_replace('/\s(?=\s)/', '', $keyword);
    // キーワード文字列の前後のスペースを削除する
    $keyword = trim($keyword);
    $arrayKey = array_unique(explode(' ', $keyword));



    $quotations = Customer::keywordFilter($arrayKey)->get();


    return json_encode($quotations, JSON_UNESCAPED_UNICODE);
  }
  public function searchQuotation(Request $request) {

    $keyword = $request->input('keyword', '');

    // +を半角スペースに変換（GETメソッド対策）
    $keyword = str_replace('+', ' ', $keyword);
    // 全角スペースを半角スペースに変換
    $keyword = str_replace('　', ' ', $keyword);
    // 取得したキーワードのスペースの重複を除く。
    $keyword = preg_replace('/\s(?=\s)/', '', $keyword);
    // キーワード文字列の前後のスペースを削除する
    $keyword = trim($keyword);
    $arrayKey = array_unique(explode(' ', $keyword));
    $tmp  = Customer::query();

    for ($i=0; $i <count($arrayKey); $i++) {
      $tmp->where('name', 'like' , "%$arrayKey[$i]%");
    }
    $tmp = $tmp->get();
    $tmp = $tmp->pluck('id')->toArray();

    $names = Customer::find($tmp,['name','id']);
    $customer = [];
    foreach ($names as $name) {
      $customer['name'][] = $name->name;
      $customer['id'][] = $name->id;
    }
    if ($keyword != "" && array_key_exists(0,$tmp)) {
      $quotations = Quotation::AjaxCustomerIdFilter($tmp)->AjaxKeywordFilter($arrayKey)->get();
    }else {
      $conditions = [
        "customer_id" => "",
        "keyword" => ""
      ];
      $quotations = Quotation::AjaxcustomerIdFilter($tmp)
      ->AjaxkeywordFilter($arrayKey)
      ->get();
    }
    $customer_options = Customer::all()->pluck('name', 'id')->toArray();
    foreach ($quotations as $value) {
      if (is_array($customer) && array_key_exists("id",$customer)) {
        for ($i=0; $i <count($customer['id']) ; $i++) {
          if ($value->customer_id == $customer['id'][$i]) {

            $value->name = $customer['name'][$i];
          }
        }
      }else {
        $value->name = $customer_options[$value['customer_id']];
      }
    }
    foreach ($quotations as  $value) {
      if ($value->which_company == '今井設備工業') {
        $value->which_company = 'I';
      }
      if ($value->which_company == 'ジャストサポート') {
        $value->which_company = 'J';
      }
      if ($value->which_document == '見積') {
        $value->which_document= 'M';
      }
      if ($value->which_document == '請求') {
        $value->which_document= 'S';
      }
    }

    return json_encode($quotations, JSON_UNESCAPED_UNICODE);
  }

  public function searchQuotationDetail(Request $request) {
    $keyword = $request->input('keyword');
    $quotation = QuotationDetail::Where('quotation_id',$keyword)->get();

    return json_encode($quotation, JSON_UNESCAPED_UNICODE);
  }

  public function sortQuotation(Request $request) {
    // header("Access-Control-Allow-Credentials: true");
    // header("Access-Control-Allow-Origin:https://domein1.com");
    // header("Content-type: text/plain; charset=UTF-8");
    $keyword = $request->all();

    foreach ($keyword as $key => $value) {
      $sort[$key] = $value[0];
    }

    array_multisort($sort, SORT_ASC,SORT_NATURAL, $keyword);

    return $keyword;
  }

}
