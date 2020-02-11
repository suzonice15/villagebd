<div class="box">
    <div class="box-body">
        <form method="POST" enctype="multipart/form-data">
            <div class="box-body">
                <div class="form-group ">
                    <label for="coupon_name">Coupon Name<span class="required">*</span></label>
                    <input type="text" class="form-control" name="coupon_name" id="coupon_name"
                           value="<?php echo $data_row->coupon_name;?>">
                </div>
                <div class="form-group ">
                    <label for="coupon_code">Coupon Code<span class="required">*</span></label>
                    <input type="text" class="form-control" name="coupon_code" id="coupon_code"
                           value="<?php echo $data_row->coupon_code;?>">
                </div>
                <div class="form-group ">
                    <label for="coupon_start">start date</label>
                    <div class="input-group date">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input type="text" name="coupon_start"
                               class="form-control pull-right datepicker"   value="<?php echo date('m-d-Y',strtotime($data_row->coupon_start));?>" id="coupon_start"></div>
                </div>
                <div class="form-group ">
                    <label for="coupon_end">end date</label>
                    <div class="input-group date">
                        <div class="input-group-addon"><i class="fa fa-calendar"></i></div>
                        <input type="text" name="coupon_end"
                               class="form-control pull-right datepicker"   value="<?php echo date('m-d-Y',strtotime($data_row->coupon_end))?>" id="coupon_end"></div>
                </div>


                <div class="form-group">
                    <label for="sel1">Select status</label>
                    <select class="form-control" name="coupon_status" id="sel1">
                        <option   value="1">Active</option>
                        <option <?php if($data_row->coupon_status==0) { echo 'selected';} else { echo '';}  ?>  value="0">Inactive</option>

                    </select>
                </div>

                <div class="form-group ">
                    <label for="coupon_note">Coupon Note</label>

                    <input type="text" name="coupon_note"
                           class="form-control pull-right "  value="<?php echo $data_row->coupon_note;?>" id="coupon_note"></div>
            </div>



            <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
        </form>

    </div>
</div>