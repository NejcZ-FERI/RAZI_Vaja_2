<div class="container my-1">
    <br/> <h2>Dodaj novega uporabnika</h2> <br/>
    <form action="?controller=users&action=add" method="POST" enctype="multipart/form-data">
        <div class="form-group"><label class="form-label" for="username">Uporabniško ime</label><input type="text" class="form-control" id="username" name="username" required /></div> <br/>
        <div class="form-group"><label class="form-label" for="password">Geslo</label><input type="password" class="form-control" id="password" name="password" required /></div> <br/>
        <div class="form-group"><label class="form-label" for="repeat_password">Ponovi geslo</label><input type="password" class="form-control" id="repeat_password" name="repeat_password" required /></div> <br/>
        <div class="form-group"><label class="form-label" for="email">Email</label><input type="email" class="form-control" id="email" name="email" required /></div> <br/>
        <div class="form-group"><label class="form-label" for="name">Ime</label><input type="text" class="form-control" id="name" name="name" required /></div> <br/>
        <div class="form-group"><label class="form-label" for="surname">Priimek</label><input type="text" class="form-control" id="surname" name="surname" required /></div> <br/>
        <div class="form-group"><label class="form-label" for="address">Naslov</label><input type="text" class="form-control" id="address" name="address" /> <br/></div>
        <div class="form-group"><label class="form-label" for="zipcode">Poštna številka</label><input type="text" class="form-control" id="zipcode" name="zipcode" /></div> <br/>
        <div class="form-group"><label class="form-label" for="phone_number">Telefonska številka</label><input type="text" class="form-control" id="phone_number" name="phone_number" /></div> <br/>
        <input class="btn btn-primary" type="submit" name="submit" value="Dodaj" /> <br/>
    </form>
</div>