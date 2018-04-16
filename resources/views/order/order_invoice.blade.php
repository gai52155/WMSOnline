<!DOCTYPE html>
<html>
<head>
	 <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	 <meta http-equiv="X-UA-Compatible" content="IE=edge">
	 <meta name="viewport" content="width=device-width, initial-scale=1">
	 <meta name="description" content="">
	 <meta name="author" content="">
	<title>ข้อมูลใบเสนอราคา</title>
	@include('admin.layouts.inc-stylesheet') @yield('stylesheet')
  	@include('admin.layouts.inc-scripts') @yield('scripts')
</head>
<body>
	<div class="container">
	    <div class="row">
	        <div class="col-md-12">
	            <div class="text-xs-center">
	                <i class="fa fa-search-plus float-xs-left icon"></i>
	                <h2>ใบเสนอราคาหมายเลข #{{$order_id}}</h2>
	            </div>
	            <hr>
	            <div class="row">
	                <div class="col-md-4">
	                    <div class="card height">
	                        <div class="card-header">ข้อมูลผู้สั่งซื้อ</div>
	                        <div class="card-body card-block">
	                            <strong>{{$getCustomer->customer_namelastname}}:</strong><br>
	                            หมายเลขโทรศัพท์ : <strong>{{$getCustomer->customer_tel}}</strong><br>
	                        </div>
	                    </div>
	                </div>

	                <div class="col-md-4">
	                    <div class="card height">
	                        <div class="card-header">วัน-เวลา</div>
	                        <div class="card-body card-block">
	                            <strong>วันที่สั่งซื้อ :</strong> {{$order_start_end->order_date}}<br>
	                            <strong>วันหมดอายุ :</strong> {{$order_start_end->order_payment_term}}<br>
	                        </div>
	                    </div>
	                </div>

	                <div class="col-md-4">
	                    <div class="card height">
	                        <div class="card-header">ข้อมูลการขนส่ง</div>
	                        <div class="card-body card-block">
	                        	<strong>ที่อยู่จัดส่ง</strong> <br>
	                            {{$getCustomer->customer_addressno}}
				                  {{$getCustomer->customer_province}} {{$getCustomer->customer_district}} {{$getCustomer->customer_subdistrict}}
				                   {{$getCustomer->customer_postal}}
	                        </div>
	                    </div>
	                </div>

	            </div>
	        </div>
	    </div>
	    <div class="row" style="margin-top: 1%">
	        <div class="col-md-12">
	            <div class="card ">
	                <div class="card-header">
	                    <h3 class="text-xs-center"><strong>Order summary</strong></h3>
	                </div>
	                <div class="card-block">
	                    <div class="table-responsive">
	                        <table class="table table-sm">
	                            <thead>
	                                <tr>
	                                    <td><strong>Item Name</strong></td>
	                                    <td class="text-xs-center"><strong>Item Price</strong></td>
	                                    <td class="text-xs-center"><strong>Item Quantity</strong></td>
	                                    <td class="text-xs-right"><strong>Total</strong></td>
	                                </tr>
	                            </thead>
	                            <tbody>
	                                @foreach($orderDetail as $u)
	                                <?php 
	                                	$subtotal = 0; $vat = 0.0;
	                                	$subtotal += $u->sum_price;
	                                	$vat = $subtotal *0.07;
	                                ?>
	                                <tr>
	                                    <td>{{$u->goods_name}}</td>
	                                    <td class="text-xs-center">{{number_format($u->goods_price)}} บาท</td>
	                                    <td class="text-xs-center">{{$u->goods_detail_amount}} ชิ้น</td>
	                                    <td class="text-xs-right">{{number_format($u->sum_price)}} บาท</td>
	                                </tr>
	                                @endforeach

	                                <tr>
	                                    <td class="highrow"></td>
	                                    <td class="highrow"></td>
	                                    <td class="highrow text-xs-center"><strong>Subtotal</strong></td>
	                                    <td class="highrow text-xs-right">{{number_format($subtotal)}} บาท</td>
	                                </tr>
	                                <tr>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow text-xs-center"><strong>Vat</strong></td>
	                                    <td class="emptyrow text-xs-right">{{number_format($vat)}} บาท</td>
	                                </tr>
	                                <tr>
	                                    <td class="emptyrow"><a href="{{url('print_order/'.$order_id)}}"><i class="fa fa-file-pdf-o iconbig" style="padding-left: 2%"></i></a></td>
	                                    <td class="emptyrow"></td>
	                                    <td class="emptyrow text-xs-center"><strong>Total</strong></td>
	                                    <td class="emptyrow text-xs-right">{{number_format($subtotal + $vat)}} บาท</td>
	                                </tr>
	                            </tbody>
	                        </table>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>

	<style>
	.height {
	    min-height: 200px;
	}

	.icon {
	    font-size: 47px;
	    color: #5CB85C;
	}

	.iconbig {
	    font-size: 77px;
	    color: #5CB85C;
	}

	.table > tbody > tr > .emptyrow {
	    border-top: none;
	}

	.table > thead > tr > .emptyrow {
	    border-bottom: none;
	}

	.table > tbody > tr > .highrow {
	    border-top: 3px solid;
	}
	</style>

</body>
</html>