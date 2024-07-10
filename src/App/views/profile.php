<?php include $this->resolve("partials/_header.php"); ?>
<section class="max-w-2xl mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">
    <?php // var_dump($errors); //injecting error into template 
    ?>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const register = document.getElementById('register');
            const email = document.getElementById('email');
            const age = document.getElementById('age');
            const country = document.getElementById('country');
            const socialMediaURL = document.getElementById('socialMediaURL');
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirmPassword');
           // const tos = document.getElementById('tos');

            const emailErr = document.getElementById('emailErr');
            const ageErr = document.getElementById('ageErr');
            const countryErr = document.getElementById('countryErr');
            const socialMediaURLErr = document.getElementById('socialMediaURLErr');
            const passwordErr = document.getElementById('passwordErr');
            const confirmPasswordErr = document.getElementById('confirmPasswordErr');
           // const tosErr = document.getElementById('tosErr');

           email.addEventListener('input',EmailRule);
           age.addEventListener('input',AgeRule);
           country.addEventListener('change', CountryRule);
           socialMediaURL.addEventListener('input',urlRule);
           password.addEventListener('input',passRule);
           confirmPassword.addEventListener('input',cPassRule);
          // tos.addEventListener('change',tosRule);

           register.addEventListener('submit',function(event){
            if (!validForm()) {
                event.preventDefault();
            }
           });
            
            function EmailRule(){
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                
                if(!emailPattern.test(email.value)){
                    emailErr.textContent = "Enter Valid Email ";
                    return false;
                }
                else{
                    emailErr.textContent ="";
                    return true;
                }   
            }
            function AgeRule(){
                
                if(age.value < 18 || age.value > 100){
                    ageErr.textContent = "Enter valid Age";
                    return false;
                }
                else{
                    ageErr.textContent ="";
                    return true;
                }   
            }
            function CountryRule(){
                if(country.value === 'Invalid'){
                    countryErr.textContent = "Enter Valid Country";
                    return false;
                }
                else{
                    countryErr.textContent="";
                    return true;
                }

            }
            function urlRule(){
                const urlPattern = /^(ftp|http|https):\/\/[^ "]+$/;
            if (!urlPattern.test(socialMediaURL.value)) {
                socialMediaURLErr.textContent = 'Please enter a valid URL.';
                return false;
            } else {
                socialMediaURLErr.textContent = '';
                return true;
            }
            }
            function passRule(){
                const passwordPattern = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;
                if(!passwordPattern.test(password.value)){
                    passwordErr.textContent = "Password must be at least 8 characters long and contain at lease one digit,one uppercase letter,one lower case letter and also add spacial character or symbol to enter password.";
                    return false;
                }
                else{
                    passwordErr.textContent='';
                    return true;
                }
            }
            function cPassRule(){
                if(password.value !== confirmPassword.value){
                    confirmPasswordErr.textContent = "Password must be same";
                    return false;
                }
                else{
                    confirmPasswordErr.textContent='';
                    return true;
                }
            }
            // function tosRule(){
            //     if(!tos.checked){
            //         tosErr.textContent = "Must accept terms and condition ";
            //         return false;
            //     }
            //     else{
            //         tosErr.textContent='';
            //         return true;
            //     }
            // }

            function validForm(){
                let isValid = true;
                isValid &= EmailRule();
                isValid &= AgeRule();
                isValid &= CountryRule();
                isValid &= urlRule();
                isValid &= passRule();
                isValid &= cPassRule();
                //isValid &= tosRule();
                return isValid;
            }
        });
    </script>
    <form id="profile" method="POST"  class="grid grid-cols-1 gap-6">
    <?php include $this->resolve('partials/_csrf.php'); ?>
        <!-- Email -->
        <label class="block">
            <span class="text-gray-700">Email address</span>
            <input id="email" value="<?php echo e($profile['email'] ?? ''); ?>" name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="john@example.com" />
           <div id="emailErr" class="mt-2 p-2 text-red-500">
           </div>
            <?php if (array_key_exists('email', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['email'][0]); //show error through looping -> one by one error is check and show it // [0] is display the first error message
                    ?>
                </div>
            <?php endif; ?>
        </label>
        <!-- Age -->
        <label class="block">
            <span class="text-gray-700">Age</span>
            <input id="age" value="<?php echo e($profile['age'] ?? ''); ?>" name="age" type="number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" />
            <div id="ageErr" class="mt-2 p-2 text-red-500"></div>
            <?php if (array_key_exists('age', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['age'][0]); //show error through looping -> one by one error is check and show it // [0] is display the first error message
                    ?>

                </div>
            <?php endif; ?>
        </label>
        <!-- Country -->
        <label class="block">
            <span class="text-gray-700">Country</span>
            <select id="country" name="country" class="block w-full mt-1 rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                <option value="USA">USA</option>
                <option value="Canada" <?php echo ($profile['country'] ?? '') === 'Canada' ? 'selected' : ''; ?>>Canada</option>
                <option value="Mexico" <?php echo ($profile['country'] ?? '') === 'Mexico' ? 'selected' : ''; ?>>Mexico</option>
                <option value="Invalid">Invalid Country</option>
            </select>
            <div id="countryErr" class="mt-2 p-2 text-red-500"></div>
            <?php if (array_key_exists('country', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['country'][0]); //show error through looping -> one by one error is check and show it // [0] is display the first error message
                    ?>

                </div>
            <?php endif; ?>
        </label>
        <!-- Social Media URL -->
        <label class="block">
            <span class="text-gray-700">Social Media URL</span>
            <input id="socialMediaURL" value="<?php echo e($profile['social_media_url'] ?? ''); ?>" name="socialMediaURL" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" />
            <div id="socialMediaURLErr" class="mt-2 p-2 text-red-500"></div>
            <?php if (array_key_exists('socialMediaURL', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['socialMediaURL'][0]); //show error through looping -> one by one error is check and show it // [0] is display the first error message
                    ?>

                </div>
            <?php endif; ?>
        </label>
        <!-- Password -->
        <label class="block">
            <span class="text-gray-700">Password</span>
            <input id="password" value="<?php //echo e($profile['password'] ?? ''); ?>" name="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" />
            <div id="passwordErr" class="mt-2 p-2 text-red-500"></div>
            <?php if (array_key_exists('password', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['password'][0]); //show error through looping -> one by one error is check and show it // [0] is display the first error message
                    ?>

                </div>
            <?php endif; ?>
        </label>
        <!-- Confirm Password -->
        <label class="block">
            <span class="text-gray-700">Confirm Password</span>
            <input id="confirmPassword" value="<?php //echo e($profile['password'] ?? ''); ?>" name="confirmPassword" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" />
            <div id="confirmPasswordErr" class="mt-2 p-2 text-red-500"></div>
            <?php if (array_key_exists('confirmPassword', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['confirmPassword'][0]); //show error through looping -> one by one error is check and show it // [0] is display the first error message
                    ?>

                </div>
            <?php endif; ?>
        </label>
        
        <button type="submit" class="block w-full py-2 bg-indigo-600 text-white rounded">
            Update Profile
        </button>
    </form>
    <?php //dd($oldFormData); ?> 
</section>
<?php include $this->resolve("partials/_footer.php"); ?>