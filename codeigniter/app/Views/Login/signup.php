<div class="container">
    <div class="row">
        <div class="">

            <h2>
                Signup
            </h2>
            <form action="/Login/signup" method="post">
                <?= csrf_field() ?>
                <div class="form-group">
                    <label for="name">Username</label>
                    <input type="name" class="form-control" name="name" aria-describedby="nameHelp" placeholder="Enter Username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter Email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                </div>
                <div class="form-group">
                    <label for="customerType">customerType</label>
                    <select class="form-control" id="customerType" name="customertype" required>
                        <option>Shopper</option>
                        <option>Seller</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <input type="descryption" class="form-control" name="description" aria-describedby="descriptionHelp" placeholder="Enter a small description" required>
                </div>
                <div class="form-group">
                    <label for="city">City</label>
                    <input type="city" class="form-control" name="city" aria-describedby="adressHelp" placeholder="Enter your City name" required>
                </div>
                <div class="form-group">
                    <label for="street">Streetname</label>
                    <input type="street" class="form-control" name="street" aria-describedby="adressHelp" placeholder="Enter your Street name" required>
                </div>
                <div class="form-group">
                    <label for="number">House number</label>
                    <input type="number" class="form-control" min="0" name="housenumber" aria-describedby="adressHelp" placeholder="Enter your House number" required>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Submit</button>
                <?php if (session()->getFlashdata('signuperror')) : ?>
                    <div class="alert alert-warning">
                        <?= session()->getFlashdata('signuperror') ?>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>