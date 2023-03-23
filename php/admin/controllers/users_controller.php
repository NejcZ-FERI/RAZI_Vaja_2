<?php
class users_controller {
    public function index() {
        $users = User::getUsers();
        require_once('views/users/index.php');
    }
    public function show() {
        if (!isset($_GET['id'])) {
            return call('users', 'error');
        }
        $ad = Ad::find($_GET['id']);
        require_once('views/ads/show.php');
    }
    public function create() {
        // Izpišemo pogled z obrazcem za vstavljanje oglasa
        require_once('views/ads/create.php');
    }
    public function store() {
        // Obdelamo podatke iz obrazca (views/ads/create.php), akcija pričakuje da so podatki v $_POST
        // Tukaj bi morali podatke še validirati, preden jih dodamo v bazo

        // Pokličemo metodo za ustvarjanje novega oglasa
        $ad = Ad::insert($_POST["title"], $_POST["description"], $_FILES["image"]);

        //ko je oglas dodan, imamo v $ad podatke o tem novem oglasu
        //uporabniku lahko pokažemo pogled, ki ga bo obvestil o uspešnosti oddaje oglasa
        require_once('views/ads/createSuccess.php');
    }
    public function edit() {
        // Ob klicu akcije se v URL poda GET parameter z ID-jem oglasa, ki ga urejamo
        // Od modela pridobimo podatke o oglasu, da lahko predizpolnimo vnosna polja v obrazcu
        if (!isset($_GET['id'])) {
            return call('users', 'error');
        }
        $ad = Ad::find($_GET['id']);
        require_once('views/ads/edit.php');
    }
    public function update() {
        // Obdelamo podatke iz obrazca (views/ads/edit.php), ki pridejo v $_POST.
        // Pričakujemo, da je v $_POST podan tudi ID oglasa, ki ga posodabljamo.
        if (!isset($_POST['id'])) {
            return call('users', 'error');
        }
        // Naložimo oglas
        $ad = Ad::find($_POST['id']);
        // Pokličemo metodo, ki posodobi obstoječi oglas v bazi
        $ad = $ad->update($_POST["title"], $_POST["description"], $_FILES["image"]);
        // Izpišemo pogled s sporočilom o uspehu
        require_once('views/ads/editSuccess.php');
    }
    public function delete() {
        // Obdelamo zahtevo za brisanje oglasa. Akcija pričakuje, da je v URL-ju podan ID oglasa.
        if (!isset($_GET['id'])) {
            return call('users', 'error');
        }
        // Poiščemo oglas
        $ad = Ad::find($_GET['id']);
        // Kličemo metodo za izbris oglasa iz baze.
        $ad->delete();
        // Izpišemo sporočilo o uspehu
        require_once('views/ads/deleteSuccess.php');
    }
	public function error() {
		require_once('views/users/error.php');
	}
}
