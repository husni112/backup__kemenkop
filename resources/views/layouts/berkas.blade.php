<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Dinamis</title>
  <style>
    /* Optional: Add some basic styling */
    .form-group {
      margin-bottom: 10px;
    }
  </style>
</head>
<body>

  <h2>Formulir Dinamis</h2>
  <form id="dynamic-form" action="javascript:void(0)">
    <div id="form-container">
        <label>
            <input type="radio" id="yes" name="yesOrNo" value="yes" onchange="displayQuestion(this.value)" />Yes</label>
          <label>
            <input type="radio" id="no" name="yesOrNo" value="no" onchange="displayQuestion(this.value)" />No</label>
        
          <div id="yesQuestion" style="display:none;"><br/>
            Why did you choose yes?
            <input type="text" placeholder="answer here . . . " />
            <input type="text" placeholder="answer here . . . " />
            <input type="text" placeholder="answer here . . . " />
          </div>
        
          <div id="noQuestion" style="display:none;"><br/>
            Why did you choose no?
            <input type="text" placeholder="answer here . . . " />
          </div>
        
        <br/><br/><input type="submit">
        
    </div>

    <button type="button" onclick="addForm()">Tambah Form</button> 
  </form>

  <script>
    function addForm() {
      // Menambahkan elemen formulir dinamis
      var formContainer = document.getElementById('form-container');
      var newFormGroup = document.createElement('div');
      newFormGroup.className = 'form-group';
      newFormGroup.innerHTML = 'form-container';

      formContainer.appendChild(newFormGroup);
    }

    function displayQuestion(answer) {
        document.getElementById(answer + 'Question').style.display = "block";
            if (answer == "yes") { // hide the div that is not selected
                document.getElementById('noQuestion').style.display = "none";
            } else if (answer == "no") {
                document.getElementById('yesQuestion').style.display = "none";
            }
    }
  </script>

</body>
</html>
