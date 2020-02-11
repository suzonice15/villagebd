<div class="row">
    <div class="col-md-12" style="background-color: white;" >
       

        <div class="clearfix"></div>

        <form action="<?php //echo site_url('brand/bulk_action'); ?>" method="post">
           
            <div class="clearfix"></div>
            
            <table  id="dataTable" class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Sl</th>
      <th scope="col">Name</th>
      <th scope="col">Code</th>
        <th scope="col">Count</th>
      <th scope="col">Start date</th>
         <th scope="col">End date</th>
          <th scope="col">Note</th>
           <th scope="col">Status</th>
              <th scope="col">Action</th>
    </tr>
  </thead>
  <tbody>
      
      <?php if(isset($results)) { 
          $i=0;
      
      foreach($results as $row){ 
          //$this->db->select('SELECT count(order_id) as cont_id');
          $this->db->where('coupon_code',$row->coupon_code);
         $coupon_number=  $this->db->get('order')->result();
        $Ii=0;
        //$count_coupon = $coupon_number->num_rows();
        foreach($coupon_number as $c){
             $Ii++;
        }
         $count_coupon=$Ii;
        
      ?>
    <tr>
      <th scope="row"><?php echo ++$i;?></th>
      <td><?php echo $row->coupon_name;?></td>
      
       <td><?php echo $row->coupon_code;?></td>
        <td><?php echo $count_coupon;?></td>
              <td><?php echo date('d-M-Y',strtotime($row->coupon_start));?></td>
               <td><?php echo date('d-M-Y',strtotime($row->coupon_end));?></td>
                 <td><?php echo $row->coupon_note;?></td>
               
                <td><?php if($row->coupon_status==1) { echo 'Active'; } else { echo 'Inactive'; }   ?></td>
                
                
													<td class="action text-right">


														<a title="edit"
														   href="<?php echo base_url() ?>admin/Coupon/update/<?php echo $row->coupon_id ?>"
														<span class="glyphicon glyphicon-edit btn btn-success"></span>
														</a>

	<a title="edit"href="<?php echo base_url() ?>admin/Coupon/delete/<?php echo $row->coupon_id ?>"
														<span class="glyphicon glyphicon-trash btn btn-success"></span>
														</a>
													</td>

     
    </tr>
   <?php } } ?>
     
  </tbody>
</table>

            <div class="clearfix"></div>
        </form>
    </div>
</div>