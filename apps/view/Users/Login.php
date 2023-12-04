<div class="container col-xl-10 col-xxl-8 px-4 py-5">
        <div class="row" >
            <div class="col-md-4 mx-auto">

          <?php if (isset($Model["error"])) {?>
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
              <?=$Model["error"]?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php }?>


                <h1 class="text-center">Login</h1><br>

                <form class="p-4 p-md-5 border rounded-3 bg-light" method="post" action="/Users/Login">
                <!-- <form class="p-4 p-md-5 border rounded-3 bg-light" method="post" action="/Dashboards"> -->
         <div class="mb-3">
            <label for="id">Id</label>
                <input type="text" class="form-control" name="id" id="id" value="<?= $_POST["id"] ?? ''?>">
            </div>
            <div class="mb-3">
                <label for="Password">Password</label>
            <input type="password" class="form-control" name="Password" id="Password">
    </div>
            <button type="submit" class="w-100 btn btn-primary">Login</button><br><br>
            <a href="/Users/UpdatePassword" class="w-100 btn btn-warning">Forgot Password</a>

            
           
            </form>

           
           
                
              
            </div>
        </div>
    </div>

 



          