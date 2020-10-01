<script>
      if ( window.history.replaceState ) {
          window.history.replaceState( null, null, window.location.href );
      }
      $(document).ready(function(){
        $('.table-responsive').doubleScroll();
      });
</script>
<?php if (!$_SESSION['LoggedIn']){
 	header("Location: signIn");
 }
 // echo $_SESSION["userId"];
?>

<?php if($_SESSION['LoggedIn']): ?>

<div class="container-fluid" id="vue">	
	 <div class="row">
        <div class="col-md-12">
          <h1 class="display-7 text-center">Student Records</h1>

          <!-- ---------------USER DETAILS TABLE ------------- -->

          <div class="row">
          <div class="col-12 ml-auto mr-auto">
          	<div class="ml-auto text-center">
          		<div class="btn-group">
          			<button class="btn btn-info" data-toggle="modal" data-target="#modal2"><i class="fa fa-plus" aria-hidden="true"></i>&nbsp; Register New Student</button>
          		</div>
            </div><br>
            <div class="ml-auto">
              <button class="btn btn-outline-danger " onclick="exportTableToCSV('atheneumStudents.csv')">Export Data To CSV File</button>
            </div><br>
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Atheneum Students</h3>
                <div class="card-tools">
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
               <div class="table-responsive p-0">
                <table class="display table table-hover text-nowrap" id="atheneumStudents">
                  <thead>
			            <tr>
			                <th>ID</th>
			                <th>Name</th>
			                <th>Email</th>
			                <th>Phone</th>
                      <th>Prog. Type</th>
			                <th>Reg. date</th>
			                <th>Status</th>
                      <th>Action</th>
			            </tr>
			        </thead>
			        <tbody id="userListBody" >
			        	
			        </tbody>
			        <tfoot>
			            <tr>
		                <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Prog. Type</th>
                    <th>Reg. date</th>
                    <th>Status</th>
                    <th>Action</th>
			            </tr>
			        </tfoot>
                </table>
              </div>

              </div> 
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>
          

        </div>
      </div>
</div>

<!-- Add parent modal -->
<div class="modal fade" id="modal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Register Student</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php 
        $partnerCodes = array();
        $sqlPartner = "SELECT * FROM SPARSH_PARTNERS";
        $resultPartner = mysqli_query($link, $sqlPartner);

      ?>
      <div class="modal-body">
        <form class="form" method="POST">
          <div class="col-md-8 col-sm-12 mx-auto">
            <div class="alert alert-warning mx-auto" id="formWarning" style="display: none;"></div>
            <div class="alert alert-success mx-auto" id="formSuccess" style="display: none;"></div>
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <select class="form-control" id="selectedProgramType" onchange="selectProgramType();">
                    <option value="null">Program Type</option>
                    <option value="Certification Course">Certification Course</option>
                    <option value="Graduation Course">Graduation Course</option>
                    <option value="Post Graduate Course">Post Graduate Course</option>
                  </select>

                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <select class="form-control" id="selectedProgramName" onchange="selectProgramName();">
                    <option value="null">Program Name</option>
                    <option value="Montessori Studies">Montessori Studies</option>
                    <option value="Early Childhood Education & Care">Early Childhood Education & Care</option>
                    <option value="Nursery Teacher Training">Nursery Teacher Training</option>
                    <option value="School Organization : Administration and Management">School Organization : Administration and Management</option>
                  </select>

                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Name" id="name" required>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <input type="number" class="form-control" placeholder="Phone Number" id="phone" required>
                </div>
              </div>
              <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <input type="email" class="form-control" placeholder="Email" id="email" required>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <!-- <label for="name">Country<span style="color: red;">*</span></label> -->
                  <select id="country" name ="country" class="form-control" onchange="selectCountry();"></select>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <!-- <label for="name">State<span style="color: red;">*</span></label> -->
                  <select name ="state" id ="state" class="form-control" onchange="selectState();"></select>
                </div>
              </div>
              
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                 <input type="text" class="form-control" placeholder="City" id="city" required>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                 <input type="number" class="form-control" placeholder="PIN Code" id="pin" required>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <p id="saveMsg" style="display: none; font-weight: bold;">Saving Data...</p><button type="button" id="saveBtn" onclick="addStudent();" class="btn btn-primary">Save changes</button> 
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Student Details</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <div class="alert alert-warning mx-auto" id="formWarning2" style="display: none;"></div>
            <div class="alert alert-success mx-auto" id="formSuccess2" style="display: none;"></div>
          <form>
            <input type="hidden" id="studentId" value="">
            <div class="row">
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <select class="form-control" id="selectedProgramTypeEdit" onchange="selectProgramTypeEdit();">
                    <option value="null">Program Type</option>
                    <option value="Certification Course">Certification Course</option>
                    <option value="Graduation Course">Graduation Course</option>
                    <option value="Post Graduate Course">Post Graduate Course</option>
                  </select>

                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <select class="form-control" id="selectedProgramNameEdit" onchange="selectProgramNameEdit();">
                    <option value="null">Program Name</option>
                    <option value="Montessori Studies">Montessori Studies</option>
                    <option value="Early Childhood Education & Care">Early Childhood Education & Care</option>
                    <option value="Nursery Teacher Training">Nursery Teacher Training</option>
                    <option value="School Organization : Administration and Management">School Organization : Administration and Management</option>
                  </select>

                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <input type="text" class="form-control" placeholder="Name" id="nameEdit" required>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <input type="number" class="form-control" placeholder="Phone Number" id="phoneEdit" required>
                </div>
              </div>
              <div class="col-md-12 col-sm-12">
                <div class="form-group">
                  <input type="email" class="form-control" placeholder="Email" id="emailEdit" required>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <!-- <label for="name">Country<span style="color: red;">*</span></label> -->
                  <input type="text" class="form-control" placeholder="Country" id="countryEdit">
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                  <!-- <label for="name">State<span style="color: red;">*</span></label> -->
                  <input type="text" class="form-control" placeholder="State" id="stateEdit">
                </div>
              </div>
              
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                 <input type="text" class="form-control" placeholder="City" id="cityEdit" required>
                </div>
              </div>
              <div class="col-md-6 col-sm-12">
                <div class="form-group">
                 <input type="number" class="form-control" placeholder="PIN Code" id="pinEdit" required>
                </div>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <p id="saveMsg2" style="display: none; font-weight: bold;">Saving Data...</p>
          <button id="saveBtn2" type="button" onclick="saveStudentData();" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
<script src="/JS/countries.js"></script>

<script type="text/javascript">
  populateCountries("country", "state");
  alert = function() {};
  var name = null;
  var email = null;
  var selectedProgramName = null;
  var selectedProgramType = null;
  var phone = null;
  var country = null;
  var state = null;
  var password = null;
  var formWarning = document.getElementById('formWarning');
  var formSuccess = document.getElementById('formSuccess');
  var saveMsg = document.getElementById('saveMsg');
  var saveBtn = document.getElementById('saveBtn');
  var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

  function selectProgramType(){
    var e = document.getElementById("selectedProgramType");
    selectedProgramType = e.options[e.selectedIndex].value;
    console.log(selectedProgramType);
  }
  function selectProgramName(){
    var e = document.getElementById("selectedProgramName");
    selectedProgramName = e.options[e.selectedIndex].value;
    console.log(selectedProgramName);
  }
  function selectCountry(){
    var e = document.getElementById("country");
    country = e.options[e.selectedIndex].value;
    console.log(country);
  }
  function selectState(){
    var e = document.getElementById("state");
    state = e.options[e.selectedIndex].value;
    console.log(state);
  }



function fetchData() {
	$.ajax({ 
      url: "/API/V1/?allStudents",
      dataType:"html",
      type: "post",
      success: function(data){
        var table = $('#atheneumStudents');
        var body = $('#userListBody');
        table.find("tbody tr").remove();
        table.find("tbody div").remove();
        body.append(data);
        $('#atheneumStudents').DataTable( {
          // responsive: true,
	        "order": [[ 0, "desc" ]],
	        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
    	});
      }
    });
}
	
$(document).ready(fetchData());

function editData(id){
	
}
function generatePassword(length){
  var result           = '';
  var characters       = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
  var charactersLength = characters.length;
  for ( var i = 0; i < length; i++ ) {
      result += characters.charAt(Math.floor(Math.random() * charactersLength));
  }
  return result;
}

function addStudent(){
    saveMsg.style.display = "inline-block";
    saveMsg.innerHTML = 'Saving Data...';
    saveBtn.disabled = true;
    formWarning.style.display = 'none';
    formSuccess.style.display = 'none';
    name = document.getElementById('name').value; 
    email = document.getElementById('email').value; 
    phone = document.getElementById('phone').value; 
    city = document.getElementById('city').value; 
    pin = document.getElementById('pin').value; 
    password = generatePassword(6); 
    // console.log(name)
    if (!name || !email || !phone || !selectedProgramName || !selectedProgramType || !country || !state || !city || !phone) {
      formWarning.style.display = 'inline-block';
      formWarning.innerHTML = 'Please fill all the fields';
      saveMsg.style.display = "none";
      saveBtn.disabled = false;
    }
    else if(reg.test(email) == false){
      formWarning.style.display = 'inline-block';
      formWarning.innerHTML = 'provide a valid email';
      saveMsg.style.display = "none";
      saveBtn.disabled = false;
    }

    else{
      formWarning.style.display = 'none';
      let formData = new FormData();
      formData.append("formName", "enrollStudent");
        formData.append("name", name);
        formData.append("programName", selectedProgramName);
        formData.append("programType", selectedProgramType);
        formData.append("email", email);
        formData.append("phone", phone);
        formData.append("country", country);
        formData.append("state", state);
        formData.append("city", city);
        formData.append("pin", pin);
        formData.append("password", password);
        fetch('/API/V1/', {
          method: "POST",
          body: formData
        }).then(function(response) {
          if (response.status !== 200) {
            console.log(
              "Looks like there was a problem. Status Code: " + response.status
            );
            return;
          }
          response.json().then(function(data) {
          console.log(data);
          saveBtn.disabled = false;
          saveMsg.style.display = "none";
          if (data.errorm != null) {
            formWarning.style.display = 'inline-block';
            formWarning.innerHTML = data.errorm;
          } else {
            formWarning.style.display = 'none';
            formSuccess.style.display = 'inline-block';
            formSuccess.innerHTML = data.data;
            sendMailToStudent();
            document.getElementById('name').value = null;
            document.getElementById('selectedProgramName').value = null;
            document.getElementById('selectedProgramType').value = null;
            document.getElementById('email').value = null;
            document.getElementById('phone').value = null;
            document.getElementById('country').value = null;
            document.getElementById('state').value = null;
            document.getElementById('pin').value = null;
            document.getElementById('city').value = null;
            fetchData();
                  // self.setCookie();
            // self.$router.push("verifyMail");
          }
        });
    });
  }
}
function sendMailToStudent(){
  console.log("Mail");
  let formData = new FormData();
  formData.append("sendMail", "true");
  formData.append("reciever", email);
  formData.append("sender", "Atheneum");
  formData.append("senderMail", "no-reply@atheneumglobal.com");
  formData.append("subject", "Course Registration Details");
  formData.append(
    "message",
    "<html><body><h2>Welcome "+name+" to Atheneum Global Teacher Training Course. You have been registered for "+selectedProgramType+" - "+selectedProgramName+".</h2><h2>You have been given access to the course dashboard from where you can manage your courses. Please login to your dashboard with the credentials below and make the payment for successful enrollment to the course. </h2><h2>Atheneum Dashboard Link:- <a href='https://user.atheneumglobal.education/'>Click here</a></h2><h2>Login Id:- "+email+"</h2><h2>Password:- "+password+"</h2><p>For more information about us please visit <a href='https://atheneumglobal.education/'>our website</a>.<br>Thank you.<br>-Team Atheneum.</p></body></html>"
  );
  fetch("https://mailapi.teenybeans.in/", {
    method: "POST",
    body: formData
  })
  .then(function(response) {
    response.json().then(function(data) {
      console.log(data);
    });
  })
  .catch(function(err) {
    console.log("Fetch Error :-S", err);
  });
}

  var studentId = null;
  var nameEdit = null;
  var emailEdit = null;
  var selectedProgramNameEdit = null;
  var selectedProgramTypeEdit = null;
  var phoneEdit = null;
  var countryEdit = null;
  var stateEdit = null;
  var pinEdit = null;
  var formWarning2 = document.getElementById('formWarning2');
  var formSuccess2 = document.getElementById('formSuccess2');
  var saveMsg2 = document.getElementById('saveMsg2');
  var saveBtn2 = document.getElementById('saveBtn2');
  function selectProgramTypeEdit(){
    var e = document.getElementById("selectedProgramTypeEdit");
    selectedProgramTypeEdit = e.options[e.selectedIndex].value;
    console.log(selectedProgramTypeEdit);
  }
  function selectProgramNameEdit(){
    var e = document.getElementById("selectedProgramNameEdit");
    selectedProgramNameEdit = e.options[e.selectedIndex].value;
    console.log(selectedProgramNameEdit);
  }

  function fetchSingleStudent(id){
    console.log(id);
    fetch('/API/V1/?fetchSingleStudent&id='+id)
      .then(
        function(response) {
          if (response.status !== 200) {
            console.log('Looks like there was a problem. Status Code: ' +
              response.status);
            return;
          }
          // Examine the text in the response
          response.json().then(function(data) {
            console.log(data)
            if(data){
              console.log(data.data)
              var otherDetails = JSON.parse(data.data.DETAILS)
              document.getElementById('nameEdit').value = data.data.NAME;
              document.getElementById('emailEdit').value = data.data.EMAIL;
              document.getElementById('phoneEdit').value = data.data.PHONE;
              $("#selectedProgramNameEdit").val(data.data.PROGRAM_NAME);
              $("#selectedProgramTypeEdit").val(data.data.PROGRAM_TYPE);
              selectedProgramTypeEdit = data.data.PROGRAM_TYPE;
              selectedProgramNameEdit = data.data.PROGRAM_NAME;
              document.getElementById('countryEdit').value = otherDetails.country;
              document.getElementById('stateEdit').value = otherDetails.state;
              document.getElementById('pinEdit').value = otherDetails.postal;
              document.getElementById('cityEdit').value = otherDetails.city;
              document.getElementById('studentId').value = data.data.UNI_ID;
            }else{
              // self.noticeAlert = "No blog present. Please create one!";
              // self.showDismissibleAlert = true;
              // self.pages = null;
            }
            
          });
        }
      )
      .catch(function(err) {
        console.log('Fetch Error :-S', err);
      });
   }

   function saveStudentData(){
     saveMsg2.style.display = "inline-block";
      saveMsg2.innerHTML = 'Saving Data...';
      saveBtn2.disabled = true;
      formWarning2.style.display = 'none';
      formSuccess2.style.display = 'none';
      studentId = document.getElementById('studentId').value; 
      console.log(studentId);
      nameEdit = document.getElementById('nameEdit').value; 
      emailEdit = document.getElementById('emailEdit').value; 
      phoneEdit = document.getElementById('phoneEdit').value; 
      stateEdit = document.getElementById('stateEdit').value; 
      countryEdit = document.getElementById('countryEdit').value; 
      cityEdit = document.getElementById('cityEdit').value; 
      pinEdit = document.getElementById('pinEdit').value; 
      // console.log(emailEdit + nameEdit +phoneEdit +selectedProgramNameEdit + selectedProgramTypeEdit + countryEdit + stateEdit + cityEdit );
      if (!nameEdit || !emailEdit || !phoneEdit || !selectedProgramNameEdit || !selectedProgramTypeEdit || !countryEdit || !stateEdit || !cityEdit) {
        formWarning2.style.display = 'inline-block';
        formWarning2.innerHTML = 'Please fill all the fields';
        saveMsg2.style.display = "none";
        saveBtn2.disabled = false;
      }else{
        formWarning2.style.display = 'none';
        let formData = new FormData();
        formData.append("formName", "updateStudent");
        formData.append("name", nameEdit);
        formData.append("programName", selectedProgramNameEdit);
        formData.append("programType", selectedProgramTypeEdit);
        formData.append("email", emailEdit);
        formData.append("phone", phoneEdit);
        formData.append("country", countryEdit);
        formData.append("state", stateEdit);
        formData.append("city", cityEdit);
        formData.append("pin", pinEdit);
        formData.append("studentId", studentId);
        fetch('/API/V1/', {
          method: "POST",
          body: formData
        }).then(function(response) {
          if (response.status !== 200) {
            console.log(
              "Looks like there was a problem. Status Code: " + response.status
            );
            return;
          }
          response.json().then(function(data) {
            console.log(data);
            saveBtn2.disabled = false;
            saveMsg2.style.display = "none";
            if (data.errorm != null) {
              formWarning2.style.display = 'inline-block';
              formWarning2.innerHTML = data.errorm;
            } else {
              formWarning2.style.display = 'none';
              formSuccess2.style.display = 'inline-block';
              formSuccess2.innerHTML = data.data;
              // sendMailToPartner();
              fetchData();
              fetchSingleStudent(studentId);
            }
         });
      });
      }
   }




function deleteStudent(studentId) {
    // console.log(parentId)
      var result = confirm('Are you sure you want to delete the student record?');
      if (result) {
        let formData = new FormData();
          formData.append("formName", "deleteStudent");
          formData.append("studentId", studentId);
        fetch('/API/V1/', {
            method: "POST",
            body: formData
          }).then(function(response) {
            if (response.status !== 200) {
              console.log(
                "Looks like there was a problem. Status Code: " + response.status
              );
              return;
            }
            response.json().then(function(data) {
              console.log(data);
              fetchData();
           });
        });
      }
   }
</script>

<?php endif; ?>