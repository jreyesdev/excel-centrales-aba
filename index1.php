<!doctype html>
<html lang="es">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">

    <title>Hello, world!</title>
  </head>
  <body>
    <div class="col-lg-12" style="padding-top:20px">
      <div class="card">
  <div class="card-header">
   <b>Importar Excel</b>
  </div>
  <div class="card-body">
    
      <form action="#" enctype="multipart/form-data">
        <div class="row">
        <div class="col-lg-10">
      <input type="file" id="txt_archivo" class="form-control" accept=".xlsx,.xls">
    </div>
   <div class="col-lg-2">
    <button class="btn btn-danger" style="width:100%"> Cargar Excel</button>
     </div>
     <div class="col-lg-12" id="div_table"><br> 
     </div>
     </div>
      </form>    
    
   </div>
  </div>
 </div>
  </body>
</html>


 <!-- Optional JavaScript-->
 <!-- j Query first, then Popper.js, then Bootstrap JS -->

 <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
 <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
 <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
 <script>
   $('input[type="file"]').on('change', function(){
    var ext = $(this).val().split('.').pop();
    if ($(this).val() !='') {
      if (ext == "xls" || ext == "xlsx"){
      }
      else
      {
        $(this).val('');
        Swal.fire("Mensaje de error","Extension no permitida: "+ ext+"","error");
         }
    }
   });
        function CargarExcel(){
          var excel = $("#txt_archivo").val();
          if(excel===""){
            return Swal.fire("Advertencia","Seleccionar un archivo excel","warning");
          }
          var formData = new FormData();
          var files = $("txt_archivo")[0].files[0];
          formData.append('archivoexcel',files);
          $.ajax({
            url:'ajax.php',
            type:'post',
            data:formData,
            contentType:false,
            processData:false,
            success : function (resp){
                $("div_table").html(resp);
            }
          });
          return false;
        }
 </script>

