@extends('admin.layouts.template')
@section('content')
<div class="row">
  <div class="col-md-12">
      <a class="btn btn-default" href="{{url('goods')}}" title="Back"><i class="fa fa-arrow-left" ></i> Back</a>

  <div class="card" style="margin-top: 1%">
      <div class="card-header">
        <div class="row">
        <div class="col-md-6">
          <i class="fa fa-table"></i> รายละเอียดสินค้าหมายเลข : {{$goods_id}}
        </div>
        <div class="col-md-6 text-right">
          <a class="btn btn-sm btn-success" href="{{url('goods_detail_form/'.$goods_id)}}" title="Add new User"><i class="fa fa-plus-square"></i> เพิ่มข้อมูลการนำเข้าสินค้า</a>
        </div>
      </div>
      </div>
  <div class="card-body">
  <div class="table-responsive">  
    <table class="table table-striped table-bordered table-sm table-hover">
      <thead>
        <tr>
          <th>No.</th>
          <th>ช่วงเวลาที่นำเข้า</th>
          <th>คงเหลือ</th>
          <th>จำนวนนำเข้า</th>
          <th>จำนวนที่ไม่ได้มาตรฐาน</th>
          <th>ที่เก็บสินค้า</th>
          <th>บริษัทนำเข้า</th>
          <th>ผู้บันทึกการนำเข้า</th>

          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $i=1 ?>
        @foreach($goods as $u)
        <tr>
          <td>
            {{$i++}}
          </td>
          <td>{{$u->goods_period}}</td>
          <td>{{number_format($u->goods_amount)}} ชิ้น</td>
          <td>{{number_format($u->goods_import)}} ชิ้น</td>
          <td>{{number_format($u->goods_waste)}} ชิ้น</td>
          <td>
            <h6>คลังสินค้าID : {{$u->warehouse_id}}</h6>
            ชั้นวางที่ : <B>{{$u->storage_index}}</B> ชั้นที่ : <B>{{$u->floor_index}}</B> ช่องที่ : <B>{{$u->slot_index}}</B>
          </td>
          <td>{{$u->goods_import_from}}</td>
          <td>{{$u->emp_name}}</td>

          <td class="text-center">
            <a href="" class="edit" id="editGoodDetail" data-toggle="modal" data-target="#editGoodsDetail" onclick="getValue({{$i}},{{$u->goods_id}}, {{$u->goods_import}}, {{$u->goods_waste}}, {{$u->goods_detail_id}})">แก้ไข <i class="fa fa-cubes"></i></a>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
</div>
</div>

<!-- Modal -->
  <div class="modal fade" id="editGoodsDetail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title" id="exampleModalLabel">แก้ไขรายละเอียดลำดับที่ : <a id="editIndex"></a></h4>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">×</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="col-md-12 mx-auto">
            <form class="form-horizontal" role="form" method="POST" action="{{ url('/goods_detail_edit') }}">
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input type="hidden" id="goods_id" name="goods_id" value="">
              <input type="hidden" id="goods_detail_id" name="goods_detail_id" value="">

              <div class="form-group">
                <div class="form-row">
                  <div class="col-md-6">
                    <label for="goods_amount">จำนวนสินค้า</label>
                    <input type="number" class="form-control" id="goods_import" name="goods_import" value="">
                  </div>
                  <div class="col-md-6">
                    <label for="goods_waste">จำนวนสินค้าเสีย</label>
                    <input type="number" class="form-control" id="goods_waste" name="goods_waste" value=""> 
                  </div>
                </div>
              </div>

            </div>
          <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">ยกเลิก</button>
          <input type="submit" class="btn btn-success" href="" value="แก้ไขรายละเอียด">
        </div>
        </form>
      </div>
    </div>
  </div>

<script>
  function getValue(index, goods_id, goods_import, goods_waste, goods_detail_id){
    $('#editIndex').text(index-1)
    $('#goods_id').val(goods_id);
    $('#goods_detail_id').val(goods_detail_id);
    $('#goods_import').val(goods_import);
    $('#goods_waste').val(goods_waste);
  }
  $('th, td').addClass('text-center');
</script>
@stop
