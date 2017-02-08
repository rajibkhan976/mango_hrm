<?php $this->load->view('header', array('title' => 'Employee')); ?>
<?php $this->load->view('leftnav', array('active' => 'Employee')); ?>


<div class="content-wrapper">

    <!-- /.content -->
    <section class="content-header">
        <h1 style="padding:7px; height:45px;" class='headtitlebackgroudgradient'>
            Attendance Upload 
            <small>Admin Panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Attendance Configuration</a></li>

        </ol>
    </section>
    <div class='col-md-12'>
        <div class="col-md-12" style="background-color:#FFFFFF">
            <section class="content">
                <script></script>
                <div class="formcontainer">
                    <?php echo form_open_multipart('attend_upload/Upload'); ?>
                    <form action="#" id="UploadAttend" enctype="" class="form-horizontal">

                        <div class="form-body">
                            <div class="form-group">
                                <label class="control-label col-md-3">Select Valid File</label>
                                <div class="col-md-9">

                                    <input type="file" name="file"/>


                                    <span class="help-block"></span>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="control-label col-md-3"></label>
                                <div class="col-md-9">

                                    <button type="submit" class="btn btn-primary">Upload</button>

                                    <span class="help-block"></span>
                                    <?php  echo $this->session->flashdata('uploadError') ?>
                                </div>
                            </div>

                        </div> 
                    </form>
                </div>


                <br />
                <?php if (isset($attend_error_info)) {
                    ?>

                    <form action="#" id="Uploaded_attend_data" class="form-horizontal">
                        <hr>
                        <button type="button" onclick="add_employee_record()" class="btn btn-primary ">Update Database</button>
                        <hr>
                        <h3>Uploading Error Report</h3>
                        <table id="table" class="table sar-table table-bordered sortableTable responsive" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>SL</th> 
                                    <th>Employee ID</th>
                                    <th>Punch Details</th>
                                    <th>Advice</th>
                                </tr>
                            </thead>
                            <tbody>


                                <?php
                                $i = 1;

                                $thtml = "";

                                foreach ($attend_error_info as $v) {

                                    $st = "";
                                    if ($v['empid']) {
                                        $st .= "<tr class='bg-danger'>";
                                        $status = "Missing employee's shift!";
                                    } else {
                                        $st .= "<tr style='background-color:#FFC0CB'>";
                                        $status = "Invalid Entry!!";
                                    }


                                    $thtml .=$st;
                                    $thtml .="<td>" . $i++ . "</td>";
                                    $thtml .="<td>" . $v['empid'] . "</td>";
                                    if (strlen($v['punchdata']) > 140) {
                                        $punchdata = "<td style='font-size:8px'>" . $v['punchdata'] . "</td>";
                                    } else {
                                        $punchdata = "<td>" . $v['punchdata'] . "</td>";
                                    }
                                    $thtml .=$punchdata;
                                    $thtml .="<td>" . $status . "</td>";
                                    $thtml .="</tr>";
                                    ?>

                                    <?php
                                }
                                echo $thtml;
                                ?>




                            </tbody>

                            <tfoot>
                            <thead>
                                <tr>
                                    <th>SL</th> 
                                    <th>Employee_ID</th>
                                    <th>Punch Details</th>
                                    <th style="width:200px;">Advice</th>
                                </tr>
                                </tfoot>
                        </table>

                    <?php } ?>
                </form>
            </section>
        </div>

    </div>
    <div class='clearfix'></div>
</div><!-- /.content-wrapper -->

<?php
$this->load->view('footer');
    ?>

<script type="text/javascript">
function add_employee_record(){
	var url = "<?php echo site_url('Attend_upload/Add') ?>";
	$.post(url,
	{},
	function(data){
		if(data){
			alert("Record added successfully !");
		}
		else{
			alert("Record cannot be added ?");
		}
	});
}

</script>
</body>
</html>