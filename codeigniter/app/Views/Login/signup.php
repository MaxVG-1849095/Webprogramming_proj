<div class="container">
    <div class="row">
        <div class="col-5">
            
            <h2>
                Signup
            </h2>
            <form action="/Login/signup" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="exampleInputName1">Username</label>
                    <input type="name" class="form-control" name="name" aria-describedby="nameHelp" placeholder="Enter Username">
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter Email">
                </div>
                <div class="form-group">
                    <label for="exampleInputPassword1">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="customerType">customerType</label>
                    <select class="form-control" id="customerType" name="customertype">
                    <option>Shopper</option>
                    <option>Seller</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="exampleInputName1">Description</label>
                    <input type="descryption" class="form-control" name="description" aria-describedby="descriptionHelp" placeholder="Enter a small description">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
                <?php if(session()->getFlashdata('signuperror')):?>
                    <div class="alert alert-warning">
                       <?= session()->getFlashdata('signuperror') ?>
                    </div>
                    <?php endif;?>
            </form>
        </div>
    </div>
</div>
