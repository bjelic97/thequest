<div class="modal fade" id="registerModal" tabindex="-1" role="dialog" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Register form <i class="fa fa-sign-in" aria-hidden="true"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container ">



                    <?php if (!isset($_SESSION["user"])) : ?>

                        <div id="container-register" class="row">

                            <!-- * error and succes components initializing on need * -->


                            <!-- * error and succes components initializing on need * -->

                        </div>
                        <div class="row">
                            <div class="col">
                                <!-- action="index.php?page=register" -->
                                <form id="register-form" method="POST" enctype="">

                                    User info :
                                    <div class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                        </div>
                                        <input required type="text" name="firstname" id="firstname" class="form-control" placeholder="Firstname">

                                    </div>

                                    <div class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user" aria-hidden="true"></i></span>
                                        </div>
                                        <input required type="text" name="lastname" id="lastname" class="form-control" placeholder="Lastname">

                                    </div>

                                    <div class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-envelope" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="email" id="email" name="email" class="form-control" placeholder="Email" required>

                                    </div>

                                    Account info :
                                    <div class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                                        </div>
                                        <input required type="text" id="username" name="username" class="form-control" placeholder="Username">

                                    </div>


                                    <div class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
                                        </div>
                                        <input required type="password" id="password" name="password" class="form-control" placeholder="Password">
                                    </div>



                                    <div class="form-group d-flex justify-content-center">

                                        <button id="register" class="trigger-btn btn btn-info btn-lg btn-block">
                                            <i class="fa fa-user-plus" aria-hidden="true"></i> Register
                                        </button>



                                    </div>



                                </form>
                            </div>

                        </div>

                    <?php endif; ?>




                </div>

            </div>
        </div>
    </div>
</div>
</div>