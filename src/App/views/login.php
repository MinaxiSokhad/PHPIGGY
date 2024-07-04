<?php include $this->resolve("partials/_header.php"); ?>


<section class="max-w-2xl mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">
<script>
        document.addEventListener('DOMContentLoaded', function() {
            const login = document.getElementById('login');
            const email = document.getElementById('email');
            const password = document.getElementById('password');

            const emailErr = document.getElementById('emailErr');
            const passwordErr = document.getElementById('passwordErr');

            email.addEventListener('input',EmailRule);
            password.addEventListener('input',passRule);

            login.addEventListener('submit',function(event){
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

            function validForm(){
                let isValid = true;
                isValid &= EmailRule();
                isValid &= passRule();
                return isValid;
            }
        });
    </script>
  <form id="login" method="POST" class="grid grid-cols-1 gap-6">
    <?php include $this->resolve('partials/_csrf.php'); ?>
    <label class="block">
      <span class="text-gray-700">Email address</span>
      <input id="email" value="<?php echo e($oldFormData['email'] ?? ''); ?>" name="email" type="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="john@example.com" />
      <div id="emailErr" class="mt-2 p-2 text-red-500">
      </div>
            <?php if (array_key_exists('email', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['email'][0]); //show error through looping -> one by one error is check and show it // [0] is display the first error message
                    ?>
                </div>
            <?php endif; ?>
    </label>
    <label class="block">
      <span class="text-gray-700">Password</span>
      <input id="password" name="password" type="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" placeholder="" />
      <div id="passwordErr" class="mt-2 p-2 text-red-500"></div>
            <?php if (array_key_exists('password', $errors)) : ?>
                <div class="bg-gray-100 mt-2 p-2 text-red-500">
                    <?php echo e($errors['password'][0]); //show error through looping -> one by one error is check and show it // [0] is display the first error message
                    ?>
                </div>
            <?php endif; ?>
    </label>
    <button type="submit" class="block w-full py-2 bg-indigo-600 text-white rounded">
      Submit
    </button>
  </form>
</section>

<?php include $this->resolve("partials/_footer.php"); ?>