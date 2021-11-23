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
<div class="profile">
        <ul class="profile__list">
            <li class="profile__items">

                
            <a href='myads' class='profile__links'>
                
                My Ads
            </a>
        </li>
            <li class="profile__items">

                <a href='/myProfile' class='profile__links profile--active'>

                    My Profile
                </a>
            </li>
        </ul>
        <div class="profile__container">
            

            
            <form action='#' class='profile__form profile__form--settings'>
              
                
                <div class="profile__form__box">

                
                    <label for='title' class='profile__lable'>

                        Title*
                    </label>  
                    <select id='title' type='text' class='profile__input'>

                        <option>

                            Ms/Mrs
                        </option> 
                        <option selected>
                            Mr

                        </option> 
                        <option> Not specified</option>
                    </select>
</div>
                        <div class="profile__form__box">

                            <label for='email' class='profile__lable'>

                        Email*

                    </label> 
                    <input placeholder='Email'  id='email' type='email' class='profile__input'>
                </div>
                    
                <div class="profile__form__box">
                    <label for='firstName' class='profile__lable'>
                        First name*

                    </label>
                    <input placeholder='First name'  id='firstName' type='text' class='profile__input'>
                    </div>
                <div class="profile__form__box">
                    <label for='lastName' class='profile__lable'>

                        Last name*
                    </label>
                    <input placeholder='Last name'  id='lastName' type='text' class='profile__input'>
</div>
                <div class="upload-photo">

                    <p class="upload__title Profile image"></p>
                    <figure class="upload-photo__figure">

                        <img src="#" alt='' class='upload-photo__photo'>
                        <input id="upload-photo__input" name='photo' type='file'>
                        <label id="upload-photo__label" for='upload-photo__input' class='upload-photo__btn form-backend_btn'>


                            Upload my photo
                        </label> 
                    </figure>
                
                    
                </div>
                <button type='submit' class='form-backend_btn form-backend_btn--settings'>
                    save my settings

                </button>
            </form>
        

            <form action='#' class='profile__form profile__form--password'>
                <div profile__form__box>
                    <label for='current' class='profile__lable'>Current password (8 - 60 characters)</label>
                    <input placeholder='********' id='currentPassword' type='password' class='profile__input'>
                    
                </div>  
                <div profile__form__box>
                    <label for='password' class='profile__lable'> New password (8 - 60 characters)</label>
                    <input placeholder='********' id='password' type='password' class='profile__input')>
                </div>
                <div profile__form__box>
                    <label for='confirm' class='profile__lable' >Confirm password re-type(8 - 60 characters)</label>
                    <input placeholder='********' id='passwordConfirm' type='password' class='profile__input'>
                    </div>

                    <button type='submit' class='form-backend_btn form-backend_btn--password'>
                    update my password

                </button> 
                
            </form>


            <div class="profile__delete">
                <p class="delete"> Do you want to delete your account ?</p>
                <a href='/deleteMe' class='form-backend_btn form-backend_btn--delete'> Delete account</a>
            </div>
            </div>
</div>

</main>
<footer>

    <?php
include_once '_footer.php';
?>
</footer>

</html>