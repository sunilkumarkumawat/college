<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv='X-UA-Compatible' content='IE=edge'>
    <title>MARKSHEET 4</title>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <link rel='stylesheet' type='text/css' media='screen' href='style.css'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<style>
    *{
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

.container-fluid{
    width: 100%;
    height: 600px;
    border: 1px solid green;
    background-color: rgb(247, 245, 245);
}

.header{
    width: 100%;
    height: 120px;
    display: flex;
    border: 1px solid orangered;


}

.logo{
    width: 30%;
    height: 120px;
    border: 1px solid green; 
    margin: 0 auto;
    justify-content: center;
    align-items: center;
    text-align: center;
}

.sname{
    width: 70%;
    height: 120px;
    border: 1px solid green; 
    margin: 0 auto;
    justify-content: center;
    align-items: center;
    text-align: center;
    padding-top: 10px; 
}

.details{

    height: 40px;
    border: 1px solid black;
    text-align: center;
}

.formating{
    width: 30%;
    background-color: white;
    border-right: 1px solid black;
    border-bottom: 1px solid darkgray;
    
}
.formating1{
    width: 70%;
    background-color: white;
    border-right: 1px solid black;
    border-bottom: 1px solid darkgray;
  
}

.marks{
    width: 100%;
    height: 35px;
    border: 1px solid black;
    text-align: center;
    font-size: 25px;
}

.subject{
   width: 100%;
   height: 250px;
   border: 1px solid yellowgreen; 
}

table, th, td {
    border: 1px solid black;
    border-collapse: collapse;
    width: 100%;
  }
.row{
    border: 1px solid black;
    border-collapse: collapse;
    width: 100%;
  }

</style>
<body>
    <div class="container-fluid">
     <div class="header">
        <div class="logo">
            <img src="image/image.jpg"  onerror="this.src='{{ env('IMAGE_SHOW_PATH').'/default/rukmani_logo.png' }}'" height="118px">
        </div>
        <div class="sname">
            <h2>Deepak Academy School, Jaipur</h2>
            <h3>Class 10th Exam Result</h3>
        </div>
     </div>
    
        <div class="details">
            <h2><b>Personal Details</b></h2>
        </div>
        
        <table style="width:100%">
            <tr>
                <th class="formating">Roll Code</th>
                <th class="formating1"></th>
              </tr>
            <tr>
              <th class="formating">Roll Number</th>
              <th class="formating1"></th>
            </tr>
            <tr>
              <th class="formating">Name</th>
              <th class="formating1" ></th>
            </tr>
            <tr>
              <th class="formating">Father's Name</th>
              <th class="formating1"></th>
            </tr>
            <tr>
              <th class="formating">Mother's Name</th>
              <th class="formating1"></th>
            </tr>
          </table>
          
            <div class="marks">
                <h4><b>Marks Details</b></h4>
            </div>
          
          <div class="row">
              <div class="col-sm-3">Subject</div>
              <div class="col-sm-3">Theory</div>
              <div class="col-sm-2">Practical</div>
              <div class="col-sm-2">CCE</div>
              <div class="col-sm-2">Subject Total</div>
            </div>
          <div class="row">
              <div class="col-sm-3">HINDI</div>
              <div class="col-sm-3">080</div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2">080</div>
            </div>
          <div class="row">
              <div class="col-sm-3">SANSKRIT</div>
              <div class="col-sm-3">096</div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2">096</div>
            </div>
          <div class="row">
              <div class="col-sm-3">MATHS</div>
              <div class="col-sm-3">100</div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2">100</div>
            </div>
          <div class="row" style="border-left: 1px solid black;">
              <div class="col-sm-3">SSC</div>
              <div class="col-sm-3">066</div>
              <div class="col-sm-2">010</div>
              <div class="col-sm-2">010</div>
              <div class="col-sm-2">086</div>
            </div>
          <div class="row">
              <div class="col-sm-3">SCIENCE</div>
              <div class="col-sm-3">080</div>
              <div class="col-sm-2">020</div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2">100</div>
            </div>
          <div class="row">
              <div class="col-sm-3">ENGLISH</div>
              <div class="col-sm-3">070</div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2"></div>
              <div class="col-sm-2">070</div>
            </div>
          </div>
       
</body>
</html>