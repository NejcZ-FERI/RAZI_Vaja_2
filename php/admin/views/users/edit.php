<div class="container my-1">
    <br/> <h2>Uredi uporabnika</h2> <br/>
    <form action="?controller=users&action=update" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php echo $user->id; ?>" />
        <div class="form-group"><label class="form-label" for="username">Uporabniško ime</label><input type="text" class="form-control" id="username" name="username" value="<?php echo $user->username; ?>" required /></div> <br/>
        <div class="form-group"><label class="form-label" for="password">Geslo</label><input type="password" class="form-control" id="password" name="password" /></div> <br/>
        <div class="form-group"><label class="form-label" for="repeat_password">Ponovi geslo</label><input type="password" class="form-control" id="repeat_password" name="repeat_password" /></div> <br/>
        <div class="form-group"><label class="form-label" for="email">Email</label><input type="email" class="form-control" id="email" name="email" value="<?php echo $user->email; ?>" required /></div> <br/>
        <div class="form-group"><label class="form-label" for="name">Ime</label><input type="text" class="form-control" id="name" name="name" value="<?php echo $user->name; ?>" required /></div> <br/>
        <div class="form-group"><label class="form-label" for="surname">Priimek</label><input type="text" class="form-control" id="surname" name="surname" value="<?php echo $user->surname; ?>" required /></div> <br/>
        <div class="form-group"><label class="form-label" for="address">Naslov</label><input type="text" class="form-control" id="address" name="address" value="<?php echo $user->address; ?>" /> <br/></div>
        <div class="form-group"><label class="form-label" for="zipcode">Poštna številka</label><input type="text" class="form-control" id="zipcode" name="zipcode" value="<?php echo $user->zipcode; ?>" /></div> <br/>
        <div class="form-group"><label class="form-label" for="phone_number">Telefonska številka</label><input type="text" class="form-control" id="phone_number" name="phone_number" value="<?php echo $user->phone_number; ?>" /></div> <br/>
        <input class="btn btn-primary" type="submit" name="submit" value="Uredi" /> <br/>
    </form>
</div>