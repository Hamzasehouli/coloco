<!DOCTYPE html>
<html>

<title>Coloco | Home</title>
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
                    <button style="width:100% !important;display:block!important;" class="btn btn-primary"
                        type="submit">Find</button>

                </div>

            </form>
        </figure>
    </section>
    <section class="section cities">
        <h2 class="heading-secondary">Discover out most popular cities</h2>
        <h3 class="mb heading-tertiary">
            With you find accomodations all over Morocco every day
        </h3>
        <div class="cities__container">
            <a href="/about">
                <figure class="cities__item cities__item--tangier">
                    <p class="cities__item--title">Tangier</p>
                </figure>
            </a>

            <a href="/about">
                <figure class="cities__item cities__item--rabat">
                    <p class="cities__item--title">Rabat</p>
                </figure>
            </a>
            <a href="/about">
                <figure class="cities__item cities__item--casablanca">
                    <p class="cities__item--title">Casablanca</p>
                </figure>
            </a>
            <a href="/about">
                <figure class="cities__item cities__item--fes">
                    <p class="cities__item--title">Fes</p>
                </figure>
            </a>
            <a href="/about">
                <figure class="cities__item cities__item--marrakesh">
                    <p class="cities__item--title">Marrakesh</p>
                </figure>
            </a>
            <a href="/about">
                <figure class="cities__item cities__item--agadir">
                    <p class="cities__item--title">Agadir</p>
                </figure>
            </a>
            <a href="/about">
                <figure class="cities__item cities__item--oujda">
                    <p class="cities__item--title">oujda</p>
                </figure>
            </a>
            <a href="/about">
                <figure class="cities__item cities__item--laayoune">
                    <p class="cities__item--title">laayoune</p>
                </figure>
            </a>
        </div>
    </section>
    <section class="section ad">
        <figure>
            <div>
                <h2 class="heading-secondary">
                    Advertise your accomodation for free
                </h2>
                <h3 class=" mb heading-tertiary">
                    We will find the perfect tenant or room mate in the shortest period
                    of time:
                </h3>
                <ul class="checks">
                    <li>
                        <the-icon state="check" mode="checkmark"></the-icon>
                        <p>Create your advertisment in few minutes</p>
                    </li>
                    <li>
                        <the-icon state="check" mode="checkmark"></the-icon>
                        <p>
                            Reach more than 100,000 ads for different accomodation types
                        </p>
                    </li>
                    <li>
                        <the-icon state="check" mode="checkmark"></the-icon>
                        <p>Create your advertisment in few minutes</p>
                    </li>
                </ul>
                <base-button to="/about" state="flat" mode="link">Advertise now for free</base-button>
            </div>
            <img class="illustration" src="/public/images/illus.svg" />
        </figure>
    </section>
</main>
<footer>

    <?php
include_once '_footer.php';
?>
</footer>

</html>