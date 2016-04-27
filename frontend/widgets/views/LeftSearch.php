<?php
/**
 * powered by php-shaman
 * LeftSearch.php 27.04.2016
 * stomat
 */


?>

<div class="shop-category">Search</div>
<form role="form" class="shop-search">
    <div class="form-group">
        <label for="categories" class="sr-only">Select category</label>
        <select class="form-control" id="categories">
            <option>Select category</option>
            <option>Books</option>
            <option>Movies</option>
            <option>Music</option>
            <option>Computers</option>
            <option>Clothing</option>
        </select>
    </div>
    <div class="form-group">
        <label for="query" class="sr-only">Search</label>
        <input type="text" class="form-control" placeholder="Looking for..." id="query">
    </div>
    <button class="btn btn-color">Search</button>
</form>
