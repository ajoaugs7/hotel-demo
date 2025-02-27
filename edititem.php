<?php 

 require('../config/autoload.php'); 
include("header.php");
$dao=new DataAccess();
$file=new FileUpload();
$info=$dao->getData('*','item','i_id='.$_GET['id']);
$elements=array(
        "i_name"=>$info[0]['i_name'],"i_image"=>"","i_price"=>$info[0]['i_price'],"i_stock"=>$info[0]['i_stock'],"c_id"=>"","i_des"=>$info[0]['i_des']);


$form=new FormAssist($elements,$_POST);


$labels=array('i_name'=>"Item Name","i_image"=>"Item Image","i_price"=>"Item Price","i_stock"=>"Stock","c_id"=>"Category Id","i_des"=>"Description" );

$rules=array(
    "i_name"=>array("required"=>true,"minlength"=>3,"maxlength"=>30),
    "i_image"=> array('filerequired'=>true),
    "i_price"=>array("required"=>true,"minlength"=>2,"maxlength"=>5,"integeronly"=>true),
    "i_stock"=>array("required"=>true,"minlength"=>3,"maxlength"=>30),
 "c_id"=>array("required"=>true),
 "i_des"=>array("required"=>true,"minlength"=>3,"maxlength"=>200),

     
);
    
    
$validator = new FormValidator($rules,$labels);

if(isset($_POST["btn_insert"]))
{

if($validator->validate($_POST))
{
	
if($fileName=$file->doUploadRandom($_FILES['i_image'],array('.jpg','.png','.jpeg','.jfif'),100000,2,'../uploads'))
		{
            $flag=true;

        }

        $condition='i_id='.$_GET['id'];
if(isset($flag))
			{	$data['i_image']=$fileName;
            }

$data=array(

        'i_name'=>$_POST['i_name'],
        'i_image'=>$fileName,
        'i_price'=>$_POST['i_price'],
          'i_stock'=>$_POST['i_stock'],
		  'c_id'=>$_POST['c_id'],
          'i_des'=>$_POST['i_des'],
        
          
//'status'=>'a'
    );
    if($dao->update($data,'item',$condition))
    {
        echo "<script> alert('New record created successfully');</script> ";
header('location:item.php');
    }
    else
        {$msg="Registration failed";} ?>

<span style="color:red;"><?php echo $msg; ?></span>

<?php
    
}

}


?>
<html>
<head>
</head>
<body>

 <form action="" method="POST" enctype="multipart/form-data">
 
<div class="row">
                    <div class="col-md-6">
Item Name:

<?= $form->textBox('i_name',array('class'=>'form-control')); ?>
<?= $validator->error('i_name'); ?>

</div>
</div>

<div class="row">
                    <div class="col-md-6">
Item Image:

<?= $form->fileField('i_image',array('class'=>'form-control')); ?>
<span style="color:red;"><?= $validator->error('i_image'); ?></span>

</div>
</div>


<div class="row">
                    <div class="col-md-6">
Item Price:

<?= $form->textBox('i_price',array('class'=>'form-control')); ?>
<?= $validator->error('i_price'); ?>

</div>
</div>


<div class="row">
                    <div class="col-md-6">
Stock:

<?= $form->textBox('i_stock',array('class'=>'form-control')); ?>
<?= $validator->error('i_stock'); ?>
</div>
</div>


<div class="row">
                    <div class="col-md-6">
Category Name:

<?php
                    $options = $dao->createOptions('c_name','c_id',"category");
                    echo $form->dropDownList('c_id',array('class'=>'form-control'),$options); ?>
<?= $validator->error('c_id'); ?>

</div>
</div>

<div class="row">
                    <div class="col-md-6">
Description:

<?= $form->textBox('i_des',array('class'=>'form-control')); ?>
<?= $validator->error('i_des'); ?>

</div>
</div>









<button type="submit" name="btn_insert"  >Submit</button>
</form>


</body>

</html>


