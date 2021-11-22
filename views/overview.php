<!DOCTYPE html>
<html>

<?php include_once 'head.php';
?>
<header>

    <?php
include_once '_header.php';
?>
</header>
<main>
    <section class="section__hero">
        <figure class="figure__hero">
            <h1 style="color:white;font-size:1.8rem;margin-bottom:2rem">More than 8,000 new Ads per day</h1>
            <form class="form__hero">
                <div class="form__control">
                    <input placeholder="City" type="text" class="form__input">
                </div>
                <div class="form__control">
                    <select type="text" class="form__select">
                        <option selected>Flatshares</option>
                        <option>1room flat</option>
                        <option>Flats</option>
                        <option>House</option>
                    </select>

                </div>
                <div class="form__control">
                    <select type="text" class="form__select">
                        <option selected>Offers</option>
                        <option>Requests</option>
                    </select>

                </div>
                <div class="form__control">
                    <button style="width:7rem !important" class="btn btn-primary" type="submit">Find</button>

                </div>

            </form>
        </figure>
    </section>
</main>
<footer>

    <?php
include_once '_footer.php';
?>
</footer>

</html>