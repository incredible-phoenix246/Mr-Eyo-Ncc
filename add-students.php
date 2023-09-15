<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])=="")
    {   
    header("Location: index.php"); 
    }
    else{
if(isset($_POST['submit']))
{
$studentname=$_POST['fullanme'];
$roolid=$_POST['rollid']; 
$studentemail=$_POST['emailid']; 
$gender=$_POST['gender']; 
$classid=$_POST['class']; 
$dob=$_POST['dob']; 
$status=1;
$sql="INSERT INTO  tblstudents(StudentName,RollId,StudentEmail,Gender,ClassId,DOB,Status) VALUES(:studentname,:roolid,:studentemail,:gender,:classid,:dob,:status)";
$query = $dbh->prepare($sql);
$query->bindParam(':studentname',$studentname,PDO::PARAM_STR);
$query->bindParam(':roolid',$roolid,PDO::PARAM_STR);
$query->bindParam(':studentemail',$studentemail,PDO::PARAM_STR);
$query->bindParam(':gender',$gender,PDO::PARAM_STR);
$query->bindParam(':classid',$classid,PDO::PARAM_STR);
$query->bindParam(':dob',$dob,PDO::PARAM_STR);
$query->bindParam(':status',$status,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Student info added successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

}
?>


            <!-- ========== TOP NAVBAR ========== -->
  <?php include('includes/topbar.php');?> 
            <!-- ========== WRAPPER FOR BOTH SIDEBARS & MAIN CONTENT ========== -->
            <div class="content-wrapper">
                <div class="content-container">

                    <!-- ========== LEFT SIDEBAR ========== -->
                   <?php include('includes/leftbar.php');?>  
                    <!-- /.left-sidebar -->

                    <div class="main-page">

                     <div class="container-fluid">
                            <div class="row page-title-div">
                                <div class="col-md-6">
                                    <h2 class="title">Student Admission</h2>
                                
                                </div>
                                
                                <!-- /.col-md-6 text-right -->
                            </div>
                            <!-- /.row -->
                            <div class="row breadcrumb-div">
                                <div class="col-md-6">
                                    <ul class="breadcrumb">
                                        <li><a href="dashboard.php"><i class="fa fa-home"></i> Home</a></li>
                                
                                        <li class="active">Student Admission</li>
                                    </ul>
                                </div>
                             
                            </div>
                            <!-- /.row -->
                        </div>
                        <section class="section">
                        <div class="container-fluid">
                           
                        <div class="row">
                                    <div class="col-md-12">
                                        <div class="panel">
                                            <div class="panel-heading">
                                                <div class="panel-title">
                                                    <h5>Fill the Student info</h5>
                                                </div>
                                            </div>
                                            <div class="panel-body">
<?php if($msg){?>
<div class="alert alert-success left-icon-alert" role="alert">
 <strong>Well done!</strong><?php echo htmlentities($msg); ?>
 </div><?php } 
else if($error){?>
    <div class="alert alert-danger left-icon-alert" role="alert">
                                            <strong>Oh snap!</strong> <?php echo htmlentities($error); ?>
                                        </div>
                                        <?php } ?>
                                                <form class="row" method="post">

<div class="form-group col-md-6">
<label for="default" class="control-label">Full Name</label>
<input type="text" name="fullanme" class="form-control" id="fullanme" required="required" autocomplete="off">
</div>

<div class="form-group col-md-6">
<label for="default" class="control-label">Username</label>
<input type="text" name="rollid" class="form-control" id="rollid" maxlength="5" required="required" autocomplete="off">

</div>

<div class="form-group col-md-6">
<label for="default" class="control-label">Email id</label>

<input type="email" name="emailid" class="form-control" id="email" required="required" autocomplete="off">
</div>



<div class="form-group col-md-6">
<label for="default" class="control-label">Gender</label>
<input type="radio" name="gender" value="Male" required="required" checked=""> Male <input type="radio" name="gender" value="Female" required="required"> Female <input type="radio" name="gender" value="Other" required="required"> Other

</div>


<div class="form-group col-md-6">
<label for="default" class="control-label">Course</label>             
 <select name="class" class="form-control" id="default" required="required">
<option value="">Select Course</option>
<?php $sql = "SELECT * from tblclasses";
$query = $dbh->prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
if($query->rowCount() > 0)
{
foreach($results as $result)
{   ?>
<option value="<?php echo htmlentities($result->id); ?>"><?php echo htmlentities($result->ClassName); ?>&nbsp; Section-<?php echo htmlentities($result->Section); ?></option>
<?php }} ?>
 </select>
                                                    </div>
<div class="form-group col-md-6">
                                                        <label for="date" class=" control-label">DOB</label>
                                                            <input type="date"  name="dob" class="form-control" id="date">
                                                    </div>
                                                    

                                                    
                                                    <div class="form-group col-md-12">
                                                            <button type="submit" name="submit" class="btn btn-success">Add</button>
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.col-md-12 -->
                                </div>
                    </div>
                </section>
                </div>
                <!-- /.content-container -->
            </div>
            <!-- /.content-wrapper -->
<?php include('includes/footer.php');?>


<?PHP } ?>
