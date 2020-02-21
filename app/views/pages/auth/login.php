<div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login form <i class="fa fa-sign-in" aria-hidden="true"></i></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

                <div class="container ">


                    <?php if (!isset($_SESSION["user"])) : ?>

                        <div id="container-login" class="row">

                            <!-- * error and succes components initializing on need * -->


                            <!-- * error and succes components initializing on need * -->

                            <div class="col">

                                <div id="errors-php" class="alert alert-danger elementDissapear" role="alert">
                                    <?php if (isset($_SESSION["errors"])) : ?>

                                    <?php endif; ?>
                                </div>

                            </div>

                        </div>
                        <div class="row">
                            <div class="col">

                                <form id="login-form" method="POST" enctype="">


                                    <div class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-user-circle-o" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="text" id="log-username" name="username" class="form-control" placeholder="Username">

                                    </div>


                                    <div class="input-group form-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text"><i class="fa fa-key" aria-hidden="true"></i></span>
                                        </div>
                                        <input type="password" id="log-password" name="password" class="form-control" placeholder="Password">
                                    </div>


                                    <div class="input-group form-group">
                                        <button id="login" class="trigger-btn btn btn-info btn-lg btn-block">
                                            <i class="fa fa-rocket" aria-hidden="true"></i>
                                            Login
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