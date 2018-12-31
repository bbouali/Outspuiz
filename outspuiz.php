<?php

$email = $_GET['email'];
$token = $_GET['token'];

?>
<!DOCTYPE>
<html>
<head>
  <script type="text/javascript" src="js/jquery.min.js"></script>
  <link rel='stylesheet' href='css/outspuiz.css?ts=<?=time()?>'/>
  <link rel="stylesheet" href="css/all.min.css">

<script type="text/javascript">

$(document).ready(function() {

var cruds_cont = document.getElementById('cruds_cont');

getUsers();

function getUsers() {

          if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {
  var resp = this.responseText;
  var users_array = JSON.parse(resp);
  usersList(users_array);
    }
    if (this.readyState == 4 && this.status == 0) {
      alert('Whoops! You need internet to do this.');
  }

  };

  xmlhttp.open("GET","cruds.php?getUsers=1");
  xmlhttp.send();

}

function usersList(users) {

  var users_list_cont = document.getElementById('users_cont');
  users_list_cont.innerHTML = '';

  var user_cont_header = document.createElement('div');
  user_cont_header.className = 'user_cont_header';
  user_cont_header.setAttribute('id','user_cont_header');
  users_list_cont.appendChild(user_cont_header);

  var user_name_header = document.createElement('div');
  user_name_header.className = 'user_name';
  user_name_header.setAttribute('id','user_name_header');
  user_name_header.innerHTML = 'Name';
  user_cont_header.appendChild(user_name_header);

  var user_age_header = document.createElement('div');
  user_age_header.className = 'user_age';
  user_age_header.setAttribute('id','user_age_header');
  user_age_header.innerHTML = 'Age';
  user_cont_header.appendChild(user_age_header);

  var user_email_header = document.createElement('div');
  user_email_header.className = 'user_email';
  user_email_header.setAttribute('id','user_email_header');
  user_email_header.innerHTML = 'Email';
  user_cont_header.appendChild(user_email_header);

for(var a=0;a<users.length;a++) {
  var user_cont = document.createElement('div');
  user_cont.className = 'user_cont';
  user_cont.setAttribute('id','user_cont_'+users[a].id);
  users_list_cont.appendChild(user_cont);

  var user_name = document.createElement('div');
  user_name.className = 'user_name';
  user_name.setAttribute('id','user_name_'+users[a].id);
  user_name.innerHTML = users[a].name;
  user_cont.appendChild(user_name);

  var user_age = document.createElement('div');
  user_age.className = 'user_age';
  user_age.setAttribute('id','user_age_'+users[a].id);
  user_age.innerHTML = users[a].age;
  user_cont.appendChild(user_age);

  var user_email = document.createElement('div');
  user_email.className = 'user_email';
  user_email.setAttribute('id','user_email_'+users[a].id);
  user_email.innerHTML = users[a].email;
  user_cont.appendChild(user_email);

  var delete_user = document.createElement('i');
  delete_user.className = 'far fa-trash-alt';
  delete_user.style.color = '#d50000';
  delete_user.style.display = 'inline-block';
  delete_user.style.cursor = 'pointer';
  delete_user.setAttribute('user_id',users[a].id);
  user_cont.appendChild(delete_user);
  delete_user.addEventListener('click',function() {
    $('#front_panel').fadeIn(200);
    document.getElementById('yes_btn').setAttribute('user_id',this.getAttribute('user_id'));
//    deleteUser(this.getAttribute('user_id'));
  },false);

}

}

function deleteUser(user_id) {

          if (window.XMLHttpRequest) {
              // code for IE7+, Firefox, Chrome, Opera, Safari
              xmlhttp = new XMLHttpRequest();
          } else {
              // code for IE6, IE5
              xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
          }
          xmlhttp.onreadystatechange = function() {
              if (this.readyState == 4 && this.status == 200) {

  getUsers();
  $('#front_panel').fadeOut(200);
    }
    if (this.readyState == 4 && this.status == 0) {
      alert('Whoops! You need internet to do this.');
  }

  };
  var url = "cruds.php?deleteUser=1&user_id="+user_id;
  console.log(url);
  xmlhttp.open("GET",url);
  xmlhttp.send();

}

$('#add_user_form').on('submit',function(e) { // Listen for Public Form Submit
	e.preventDefault(); // Prevent Default Form Behavior
	validateForm2Public(e,this.id); // Do Custom Form Field Validation
});


//-- Form Validation (Public Site)--//
function validateForm2Public(e,obj_id) {
    var cont = document.getElementById(obj_id);
    var inputs = cont.getElementsByTagName('input');
    var all_filled = 1; //-- Assume All Fields are Filled
    var reason = 1; //-- Assume No Reasons Given
    for(var a=0;a<inputs.length;a++) {  //-- Cycle through all Form Inputs
if(inputs[a].getAttribute('type')!=='hidden' && inputs[a].getAttribute('type')!=='submit') {   //-- Omit Hidden Fields and Submit
      if (inputs[a].value == "") { //-- Proceed If Input is Empty
      all_filled = 0; //-- All Fields are Not Filled
      reason = 'All fields must be filled out'; //-- All Fields are Not Filled
      inputs[a].style.background = '#ffcdd2'; //-- Change Background Color of Failed Field
    } else if(inputs[a].getAttribute('type')!=='submit') {
      inputs[a].style.background = '#fff'; //-- Change Background Color of Passed Field
    }
  }
}
    if(all_filled!=1) { //-- If All Fields Do Not Pass All Tests
			$('#status_msg').html(reason); //-- Populate Reason in Status Message
			$('#status_msg').fadeIn(200).delay(800).fadeOut(200); //-- Fade In and Out Status Message (Alert Effect)
    } else if(obj_id!='reset_form') {
      SubFormPublic(e,obj_id); //-- Submit Form Via AJAX
    }

}

//-- Submit Form via AJAX --//
function SubFormPublic(e,form_id){
    e.preventDefault(); // Prevent default form action
    var url=$('#'+form_id).attr('action'); // Create Submit URL from form_id & action attribute
    data=$('#'+form_id).serialize(); // Serialize Form Field data
    console.log(data);
    $.ajax({
        url:url,
        type:'POST',
        data:data,
        success:function(resp){

          getUsers();

        }
   });
}

$('#yes_btn').on('click',function() { // Listen for Public Form Submit
  deleteUser(this.getAttribute('user_id'))
});

$('#pword_form').on('submit',function(e) { // Listen for Public Form Submit
	e.preventDefault(); // Prevent Default Form Behavior
	validateForm2(e,this.id); // Do Custom Form Field Validation
});

});


</script>

</head>
<body>
  <!-- Header -->
    <header id="header">
      <a href="#" class="logo"><img src='/images/os_red_logo.jpg' id='os_logo_pub'></a>
    </header>
<div id="main_cont">
  <div id="users_cont">
  </div>
  <div id="cruds_cont">
    <div id="main_header">Add User</div>
    <form action='cruds.php' id='add_user_form'>
      <input type='hidden' name='addUser' value='1'/>
      <div class='input_cont'>
        <div class='input_title'>name</div>
        <input class='name' type='name' name='name' id='name'/>
      </div>
      <div class='input_cont'>
        <div class='input_title'>age</div>
        <input class='age' type='number' name='age' id='age'/>
      </div>
      <div class='input_cont'>
        <div class='input_title'>email</div>
        <input class='email' type='email' name='email' id='email'/>
      </div>
      <br>
      <input class='add_user_submit' type='submit' id='add_user_form_submit' value='Add User'/>
      </form>
  </div>
  <div id="status_msg"></div>
  <div id="front_panel">
    <div id="panel_title">Are You Sure?</div>
    <div id="panel_contents">
      <div id="yes_btn" class="yes_btn">Yes</div>
      <div id="no_btn" class="no_btn" onclick="$(this.parentElement.parentElement).fadeOut(200)">Nope</div>
    </div>
  </div>
</div>


</body>
</html>
