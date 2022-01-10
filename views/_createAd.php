<!DOCTYPE html>
<html>

<head>
    <?php include_once 'head.php';
?>
</head>
<header>
    <?php
include_once '_header.php';
?>
</header>
<main>
    <div class="createAd">



        <form class="createAd__form" action='#'>

            <h2 class="createAd__heading Start">Start</h2>
            <label class="createAd__label" for='title'>Title of Offer</label>
            <input id="title createAd__input" minlength='10' maxlength='60' type='text'>
            <label class="createAd__label" for='city'> City</label>
            <input id="city" class="createAd__input" type='text'>
            <label class="createAd__label" for='category'> Category</label>
            <select id="category" class="createAd__select" name='category'>
                <option class="createAd__option" selected value='Select'> Select</option>
                <option class="createAd__option" value='Flatshares'> Flatshares</option>
                <option class="createAd__option" value='1 Room flats'> 1 Room flats</option>
                <option class="createAd__option" value='Flats'> Flats </option>
                <option class="createAd__option" value='Houses'> Houses </option>
            </select>
            <label class="createAd__label" for='rentType'> rent type </option>
                <select id="rentType" class="createAd__select" name='rentType'>

                    <option class="createAd__option" selected value='Select'> Select </option>
                    <option class="createAd__option" value='long term'> long term </option>
                    <option class="createAd__option" value='short term'> short term </option>
                    <option class="createAd__option" value='overnight stay'> overnight stay </option>
                </select>

                <h2 class="createAd__heading"> Location </h2>
                <label lass="createAd__label" for='district'> District* </label>
                <input id="district" class="createAd__input" type='text'>
                <label class="createAd__label" for='street'> Street* </label>
                <input id="street" class="createAd__input" type='text'>
                <label class="createAd__label" for='houseNumber'> house number*</label>
                <input id="houseNumber" class="createAd__input" type='number'> </option>
                <label class="createAd__label" for='postalCode'> postal code* </option>
                    <input id="postalCode" class="createAd__input" minlength='5' maxlength='5' type='text'>
                    <h2 class="createAd__heading"> Details about the property </h2>

                    <label class="createAd__label" for='availableFrom'> Available from* </label>
                    <input id="availableFrom" class="createAd__input" type='date'>
                    <label class="createAd__label" for='availableTo'> Available to* </option>
                        <input id="availableTo" class="createAd__input" type='date'>
                        <label class="createAd__label" for='propertyType'> property type </labem>
                            <select id="propertyType" class="createAd__select" name='propertyType'>

                                <option class="createAd__option" selected value=''> Select </option>
                                <option class="createAd__option" value='old building'> old building </option>
                                <option class="createAd__option" value='renovated old building'> renovated old building
                                </option>
                                <option class="createAd__option" value='newly built building'> newly built building
                                </option>
                                <option class="createAd__option" value='terraced house'> terraced house </option>
                                <option class="createAd__option" value='semi detached house'> semi detached house
                                </option>
                                <option class="createAd__option" value='multi-family house'> multi-family house
                                </option>
                                <option class="createAd__option" value='multi-storey building'> multi-storey building
                                </option>
                                <option class="createAd__option" value='slab construction/prefabricated'> slab
                                    construction/prefabricated </option>
                            </select>

                            <label class="createAd__label" for='size'> room size* </label>
                            <input id="size" class="createAd__input" placeholder='m²' type='number'>
                            <label class="createAd__label" for='floorLevel'> Floor Level </option>
                                <select id="floorLevel" class="createAd__select" name='floorLevel'>

                                    <option class="createAd__option" selected value='Select'> Select </option>
                                    <option class="createAd__option" value='cellar'> cellar </option>
                                    <option class="createAd__option" value='basement'> basement </option>
                                    <option class="createAd__option" value='ground floor'> ground floor</option>
                                    <option class="createAd__option" value='raised ground floor /mezzanine'> raised
                                        ground floor
                                        /mezzanine </option>
                                    <option class="createAd__option" value='1st floor'> 1st floor </option>
                                    <option class="createAd__option" value='2nd floor'> 2nd floor </option>
                                    <option class="createAd__option" value='3rd floor'> 3rd floor </option>
                                    <option class="createAd__option" value='4th floor'> 4th floor </option>
                                    <!-- <option class="createAd__option" value='loft/attic'></option> -->
                                    <option class="createAd__option" value='higher than 5th floor'> higher than 5th
                                        floor
                                    </option>
                                </select>

                                <label class="createAd__label" for='parking'> Parking </label>
                                <select id="parking" class="createAd__select" name='parking'>
                                    <option class="createAd__option" selected value='Select'> Select </option>
                                    <option class="createAd__option" value='many'> many </option>
                                    <option class="createAd__option" value='underground'> underground </option>
                                    <option class=" createAd__option" value='limited'> limited</option>
                                    <option class="createAd__option" value='private parking'> private parking </option>
                                    <option class=" createAd__option" value='residential parking'> residential parking
                                    </option>
                                </select>

                                <h2 class="createAd__heading"> costs <h2>

                                        <label class="createAd__label" for='rentPerMonth'> rent per month* </label>
                                        <input id="rentPerMonth" class="createAd__input" placeholder='MAD'
                                            type='number'>
                                        <label class="createAd__label" for='utilityCosts'> Utility Costs </label>
                                        <input id="utilityCosts" class="createAd__input" placeholder='MAD'
                                            type='number'>
                                        <label class="createAd__label" for='deposit'> deposit </label>
                                        <input id="deposit" class="createAd__input" placeholder='MAD' type='number'>
                                        <label id="createAd__label" for='description'> description </label>
                                        <textarea id="description" class="createAd__input" placeholder='Please enter a minimum of
                                        150
                                        words.' minlength='150' type='text' maxlength='300'> </textarea>

                                        <h2 class="createAd__heading"> contact details </h2>

                                        <label class="createAd__label" for='telephone'> Telephone number </label>
                                        <input id="telephone" class="createAd__input" type='tel'>
                                        <label class="createAd__label" for='identity'> I am * </label>
                                        <select id="identity" class="createAd__select" name='identity'>

                                            <option class="createAd__option" selected value='Select'> Select </option>
                                            <option class="createAd__option" value='Select'> The owner </option>
                                            <option class="createAd__option" value='the renter'> the renter </option>
                                            <option class="createAd__option" value='the caretaker'> the caretaker
                                            </option>
                                            <option class="createAd__option" value='other'> other </option>
                                        </select>
                                        <h2 class="createAd__heading"> photos </option>

                                            <div class="images-uploader">


                                                <label class="images-uploader__photoBox images-uploader__photoBox--upload for='uploader'
                                                p images-uploader__text"> browse your photo to add pictures </label>
                                                <input id="uploader" class="images-uploader__input  accept=" image/*"
                                                    name='photo' type='file'>
                                            </div>
        </form>

        <button class="createAd__btn.form-backend_btn" type='submit'> Next</button>
    </div>
</main>
<footer>
    <?php
include_once '_footer.php';
?>
</footer>

</html>