@extends('layouts.app')

@section('content')

<!-- コンテンツヘッダ -->
<section class="content-header">
    @if(Request::is('customer/edit-input/*'))
    <h1>顧客編集</h1>
    @else
      <h1>顧客登録</h1>
    @endif
</section>

<!-- メインコンテンツ -->
<section class="content">
	
	<div class="">
		<form class="form-horizontal cust_r_form" id="customer_form" action="{{route('customer/save')}}" method="POST">
			<div class="cust_r_wrap">
		
				<div class="box">
				{{ csrf_field() }}
					<div class="box-body cust_r">
						
						<div class="cust_r_g form-group @if($errors->has('name')) has-error @endif">
							<label class="">顧客名</label>
							<div class="cust_in">
								<input class="form-control" name="name" value="{{old('name', $customer->name)}}" >
							@if($errors->has('name')) <span class="help-block">{{$errors->first('name')}}</span> @endif
							</div>
						</div>
						
						<div class="cust_r_g form-group">
							<label class="">郵便番号</label>
							<div class="cust_in">
								<input class="form-control" name="zip" value="{{old('zip', $customer->zip)}}">
							</div>
						</div>
						
						<div class="cust_r_g form-group">
							<label class="">住所</label>
							<div class="cust_in">
								<input class="form-control" name="address" value="{{old('address', $customer->address)}}">
							</div>
						</div>
						
						<div class="cust_r_g form-group">
							<label class="">電話番号</label>
							<div class="cust_in">
								<input class="form-control" name="tel" value="{{old('tel', $customer->tel)}}">
							</div>
						</div>
						
						<div class="cust_r_g form-group">
							<label class="">FAX</label>
							<div class="cust_in">
								<input class="form-control" name="FAX" value="{{old('fax', $customer->FAX)}}">
							</div>
						</div>
						
						<div class="cust_r_g form-group">
							<label class="">担当者</label>
							<div class="cust_in">
							<select name="staffs" class="form-control" id="day" value="">
									@if(is_null($customer->staffs))
											<option value="" name="staffs[]">選択してください</option>
									@endif
											<option value="{{$customer->staffs}}" name="staffs[]">{{$customer->staffs}}</option>
									<option value="今井道之"name="staffs[]">今井道之</option>
									<option value="今井英明"name="staffs[]">今井英明</option>
									<option value="石毛朝子"name="staffs[]">石毛朝子</option>
									<option value="今井裕敏"name="staffs[]">今井裕敏</option>
									<option value="藤井昌人"name="staffs[]">藤井昌人</option>
									<option value="太田草太郎"name="staffs[]">太田草太郎</option>
									<option value="木村文昭"name="staffs[]">木村文昭</option>
							</select>
							@if($errors->has('name')) <span class="help-block">{{$errors->first('name')}}</span> @endif
							</div>
						</div>
							
						<div class="cust_r_g form-group">
							<label class="">備考</label>
							<div class="cust_in">
								<input class="form-control" name="remark" value="{{$customer->remark}}">
							</div>
						</div>
							
						<input type="hidden" name="id" value="{{$customer->id}}">
						
						<div class="sub_btn">
							<input type="submit" class="btn btn-danger" name="" value="登 録">
						</div>
						
					</div>
				</div>
				
				
			</div>
		</form>
	</div>
	
</section>

@endsection
