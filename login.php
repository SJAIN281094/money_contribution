
<?php
//ENTER INTO DATABASE AND COLLECT DATA
$value=0;
if(isset($_POST['log_submit'])){
	$value=1;
}

if(!empty($_POST["log_password"]) || !empty($_POST["log_password"])){
$db = new mysqli();
$test = $db->connect("localhost","root","budget_123","moneycontribution");
$data_collect_query = "SELECT * FROM `user_profile_required` WHERE `Email_id`='{$_POST["log_emailid"]}'";
$data_collect = $db->query($data_collect_query);
$data = $data_collect->fetch_array();
$db->close();

// VALIDATE EMAIL ADDRESS
  if($_POST["log_emailid"]==$data['Email_id']){

// VALIDATE PASSWORD
    $_POST["log_password"] = md5($_POST["log_password"]); //ENCRYPT PASSWORD
    if($_POST["log_password"]==$data["Password"]){
          
          /*CREATE COOKIE AFTER LOGIN
         setcookie("loginid",$data['Upr_id'],0,"/");
         $security = md5($_COOKIE["emailid"].$data["Password"]);
         setcookie("security",$security,0,"/");
         header("Location:./create_group.php");*/

         //CREATE SESSION AFTER LOGIN
         session_start();
         $_SESSION['loginid'] = $data['Upr_id'];
         $security = md5($_SESSION["loginid"].$data["Password"]);
         $_SESSION['security'] = $security;
         var_dump($_SESSION['loginid']);
         header("Location:./create_group.php");

    }
    else{
      echo "Incorrect Password";
    }

    }
    else{
      echo "Email-id not exist</br>";
      echo "Please signup first</br>";
      
        }
    }
    else{
      if($value)
      {
      echo "Fill all details";
      }
    }
 ?>


 <!--HTML CODE
 <link rel="stylesheet" type="text/css" href="../login/login.css">-->
 <div id="login_frame">
   <div class="log_budget"><h1 class="log_budget_txt">BUDGET</h1></div>
   <div class="login"><h2 class="log_login_txt">LOG</h2></div>
   <div class="form_login">
     <form class="form_login_fields" action="./login.php" method="post">
       <div class="log_int_emailid">
         <span class="log_emailid">Email-id: </span>
         <input class="log_emailid_txt" type="text" name="log_emailid" value="">
       </div>
       <div class="log_int_password">
         <span class="log_password">Password: </span>
         <input class="log_password_txt" type="password" name="log_password" value="">
       </div>
       <div class="log_int_submit">
         <input class="log_submit_clk" type="submit" name="log_submit" value="Login">
       </div>
     </form>
     <div class="log_signup">
       <span class="log_new_user">New User</span> <a class="log_signup_link" href="./signup.php">Signup</a>
     </div>
   </div>
 </div>
